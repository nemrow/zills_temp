<?php
require_once('DatabaseBase.php');
require_once('MySQLDB.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/cbRequest.php');
require_once('DataClasses/fpsResponse.php');
require_once('DataClasses/fpsResponseHistory.php');
require_once('Amazon/FPS/Model.php');
require_once('Amazon/FPS/Mock.php');
require_once('Amazon/FPS/Client.php');
require_once('Amazon/FPS/Model/PayRequest.php');
require_once('Amazon/FPS/Model/Amount.php');
require_once('Amazon/FPS/Model/GetTransactionStatusRequest.php');

class CaptureSalesHelper {
    private $db;

    public function __construct ($db = null) {
        if($db==null) {
            $this->db = new MySQLDB();
        } else {
            $this->db = $db;
        }
        //$this->captureSale(12);
        //$this->getLatestStatus(1);
    }

    public function getTotalAccounts() {
        $sql = "SELECT count(id) FROM account";
        return $this->db->queryCount($sql);
    }

    public function getTotalFans() {
        $sql = "SELECT count(id) FROM account WHERE accountType='customer'";
        return $this->db->queryCount($sql);
    }

    public function getTotalBands() {
        $sql = "SELECT count(id) FROM account WHERE accountType='manager'";
        return $this->db->queryCount($sql);
    }

    public function getTotalSales() {
        $sql = "SELECT count(id) FROM sale";
        return $this->db->queryCount($sql);
    }

    public function getTotalActiveSales() {
        $sql = "SELECT count(id) FROM sale WHERE saleEnd<UNIX_TIMESTAMP()";
        return $this->db->queryCount($sql);
    }

    public function getTotalExpiredSales() {
        $sql = "SELECT count(id) FROM sale WHERE saleEnd>UNIX_TIMESTAMP()";
        return $this->db->queryCount($sql);
    }

    public function getTotalTransactions() {
        $sql = "SELECT count(id) FROM `order`";
        return $this->db->queryCount($sql);
    }

    public function getTotalGrossRevenue() {
        $sql = "SELECT sum(finalPrice) FROM `order` WHERE finalPrice IS NOT NULL";
        return $this->db->queryCount($sql);
    }

    public function getTotalAmazonFees() {
        $sql = "SELECT sum(finalPrice) FROM `order` WHERE finalPrice IS NOT NULL";
        return $this->db->queryCount($sql)*.025;
    }

    public function getTotalBandCuts() {
        $sql = "SELECT sum(finalPrice) FROM `order` WHERE finalPrice IS NOT NULL";
        return $this->db->queryCount($sql)*.95;
    }

    public function getTotalZillsCuts() {
        $sql = "SELECT sum(finalPrice) FROM `order` WHERE finalPrice IS NOT NULL";
        return $this->db->queryCount($sql)*.05;
    }

    public function getSocialSales($show) {
        $sql = "SELECT s.id, p.name, art.artistName, count(o.id), s.startPrice, s.lowprice, s.startPrice - (s.lowprice*s.decrement*count(o.id)), CASE WHEN UNIX_TIMESTAMP() < s.saleEnd THEN 'Active' ELSE 'Expired' END, a.path ";

        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON p.artistId = art.id ";
        $sql .= "LEFT OUTER JOIN `order` o ON o.saleId = s.id ";
	$sql .= "LEFT OUTER JOIN `attachment` a on a.id = p.imageId ";
        $sql .= "WHERE 1=1 ";
        if($show=='expired') {
            $sql .= "AND s.saleEnd < UNIX_TIMESTAMP() ";
        } else if($show=='active') {
            $sql .= "AND s.saleEnd > UNIX_TIMESTAMP() ";
        }

        $sql .= "GROUP BY s.id, p.name, art.artistname, s.startPrice, s.saleEnd, a.path";
        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
            $return[$i][8] = $line[8];
        }
        return $return;
    }

    public function getSocialSalesForFan( $accountId) {
        $sql = "SELECT s.id, p.name, art.artistName, count(o.id), s.startPrice, s.lowprice, s.startPrice - (s.lowprice*s.decrement*count(o.id)), CASE WHEN UNIX_TIMESTAMP() < s.saleEnd THEN 'Active' ELSE 'Expired' END ";

        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON p.artistId = art.id ";
        $sql .= "LEFT OUTER JOIN `order` o ON o.saleId = s.id ";
        $sql .= "WHERE 1=1 ";

        if(isset($accountId) && is_numeric($accountId) && $accountId>0) {
            $sql .= "AND o.userid = ".(int)$accountId." ";
        }
        $sql .= "GROUP BY s.id, p.name, art.artistname, s.startPrice, s.saleEnd";
        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
        }
        return $return;
    }

    public function getSocialSalesForBand( $accountId) {
        $sql = "SELECT s.id, p.name, art.artistName, count(o.id), s.startPrice, s.lowprice, s.startPrice - (s.lowprice*s.decrement*count(o.id)), CASE WHEN UNIX_TIMESTAMP() < s.saleEnd THEN 'Active' ELSE 'Expired' END ";

        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON p.artistId = art.id ";
        $sql .= "LEFT OUTER JOIN `order` o ON o.saleId = s.id ";
        $sql .= "WHERE 1=1 ";

        if(isset($accountId) && is_numeric($accountId) && $accountId>0) {
            $sql .= "AND art.accountid = ".(int)$accountId." ";
        }
        $sql .= "GROUP BY s.id, p.name, art.artistname, s.startPrice, s.saleEnd";
        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
        }
        return $return;
    }

    public function getAccounts($show) {
        $sql = "SELECT a.id, a.email, a.firstName, a.lastName, a.dtCreated, a.accountType, count(o.id) ";
        $sql .= "FROM `account` a ";
        $sql .= "LEFT OUTER JOIN `order` o ON o.userid = a.id ";
        $sql .= "WHERE 1=1 ";
        if($show=='fans') {
            $sql .= "AND a.accountType=\"customer\" ";
        } else if($show=='bands') {
            $sql .= "AND a.accountType=\"manager\" ";
        }
        $sql .= "GROUP BY a.id, a.email, a.firstName, a.lastName, a.dtCreated, a.accountType";
        //echo $sql;
        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
        }
        return $return;
    }

    public function getCompletedSales() {
        $sql = "SELECT s.id, p.name, p.type, s.dtCreated, s.saleEnd, COUNT(o.id) ";
        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "LEFT OUTER JOIN `order` o ON o.saleId = s.id ";
        $sql .= "WHERE ";
        $sql .= "s.saleEnd < UNIX_TIMESTAMP() ";
        $sql .= "GROUP BY s.id, p.name, p.type, s.dtcreated, s.saleEnd";

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
        }
        return $return;
    }

    public function getUncapturedOrders() {
        $sql = "SELECT o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, o.status ";
        $sql .= "FROM `order` o ";
        $sql .= "INNER JOIN `sale` s ON s.id = o.saleId ";
        $sql .= "INNER JOIN `account` a ON a.id = o.userid ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "WHERE ";
        $sql .= "saleEnd < UNIX_TIMESTAMP() AND ";
        $sql .= "o.status != 'CAPTURED' ";

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
            $return[$i][8] = $line[8];
            $return[$i][9] = $line[9];
        }
        return $return;
    }

    public function getPendingOrders() {
        $sql = "SELECT o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, fpsr.status ";
        $sql .= "FROM `order` o ";
        $sql .= "INNER JOIN `sale` s ON s.id = o.saleId ";
        $sql .= "INNER JOIN `account` a ON a.id = o.userid ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN  `cbrequest` cbr ON cbr.orderId = o.id ";
        $sql .= "INNER JOIN  `fpsresponse` fpsr ON fpsr.cbrequestid = cbr.id ";
        $sql .= "WHERE ";
        $sql .= "saleEnd < UNIX_TIMESTAMP() AND ";
        $sql .= "fpsr.status = 'PENDING' ";

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
            $return[$i][8] = $line[8];
            $return[$i][9] = $line[9];
        }
        return $return;
    }

    public function getCompletedOrders() {
        $sql = "SELECT o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, fpsr.status ";
        $sql .= "FROM `order` o ";
        $sql .= "INNER JOIN `sale` s ON s.id = o.saleId ";
        $sql .= "INNER JOIN `account` a ON a.id = o.userid ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN  `cbrequest` cbr ON cbr.saleid = s.id AND cbr.userid = a.id ";
        $sql .= "INNER JOIN  `fpsresponse` fpsr ON fpsr.cbrequestid = cbr.id ";
        $sql .= "WHERE ";
        $sql .= "saleEnd < UNIX_TIMESTAMP() AND ";
        $sql .= "fpsr.status = 'SUCCESS' ";

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
            $return[$i][8] = $line[8];
            $return[$i][9] = $line[9];
        }
        return $return;
    }

     public function captureSales() {
         $orders = $this->getUncapturedOrders();
         for($i=0; $i<count($orders); $i++) {
             $this->captureSale($orders[$i][0]);
         }
         return $i;
     }

    public function captureSale($orderId) {
         $myOrder = new order($this->db);
         $myOrder->read($orderId);
         $myCbRequest = new cbRequest($this->db);
         $myCbRequest->read($myOrder->getPaymentId());

         $mySale = new sale($this->db);
         $mySale->read($myCbRequest->getSaleId());
         if(!$mySale->getSaleOver()) {
             throw new Exception('Sale not expired!');
         }
         $myResponse = new fpsResponse($this->db);
         if($myOrder->getStatus()!='AUTHORIZED') {
             throw new Exception("Sale not in authorized status");
         }
         if($myCbRequest->getStatus()!='SC') {
             throw new Exception("Amazon CB request does not have a SC status");
         }
         if($myResponse->responseExists($myCbRequest->getId())) {
             throw new Exception("Already captured!");
         }

         $myOrder->setFinalPrice($mySale->getCurrentPrice());
         $myOrder->save();


         $service = new Amazon_FPS_Client(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
         //$service = new Amazon_FPS_Mock();
         $request =  new Amazon_FPS_Model_PayRequest();

         $request->setSenderTokenId($myCbRequest->getTokenId());//set the proper senderToken here.
         $amount = new Amazon_FPS_Model_Amount();
         $amount->setCurrencyCode("USD");
         $amount->setValue($mySale->getCurrentPrice()); //set the transaction amount here;
         $request->setTransactionAmount($amount);
         $request->setCallerReference($myCbRequest->getCallerRef()); //set the unique caller reference here.
         try {
             $response = $service->pay($request);

             $myResponse->setcbRequestId($myCbRequest->getId());
             if ($response->isSetPayResult()) {
                 $payResult = $response->getPayResult();
                 if ($payResult->isSetTransactionId()) {
                     $myResponse->setTransactionId($payResult->getTransactionId());
                 }
                 if ($payResult->isSetTransactionStatus()) {
                     $myResponse->setStatus($payResult->getTransactionStatus());
                 }
              }
              if ($response->isSetResponseMetadata()) {
                  $responseMetadata = $response->getResponseMetadata();
                  if ($responseMetadata->isSetRequestId())  {
                      $myResponse->setRequestId($responseMetadata->getRequestId());
                  }
              }
              $myResponse->save();
              if(true) {
                  $myOrder->setStatus('CAPTURED');
                  $myOrder->save();
              }

        } catch (Amazon_FPS_Exception $ex) {
            $error = "Caught Exception: " . $ex->getMessage() . "\n";
            $error .= "Response Status Code: " . $ex->getStatusCode() . "\n";
            $error .= "Error Code: " . $ex->getErrorCode() . "\n";
            $error .= "Error Type: " . $ex->getErrorType() . "\n";
            $error .= "Request ID: " . $ex->getRequestId() . "\n";
            $error .= "XML: " . $ex->getXML() . "\n";
            throw new Exception($error);
        }
    }

    public function updateAllStatuses() {
        $orders = $this->getPendingOrders();
         for($i=0; $i<count($orders); $i++) {
             $this->getLatestStatus($orders[$i][0]);
         }
         return $i;
    }

    public function getLatestStatus($orderId) {
        $service = new Amazon_FPS_Client(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
        $request = new Amazon_FPS_Model_GetTransactionStatusRequest();

        $myResponse = new fpsResponse($this->db);
        $myResponse->readByOrderId($orderId);

        $request->setTransactionId($myResponse->getTransactionId());
        $response = $service->getTransactionStatus($request);
        $myResponseHistory = new fpsResponseHistory($this->db);
        $myResponseHistory->setFpsResposneId($myResponse->getRequestId());

        $myResponseHistory->setcbRequestId($myResponse->getcbRequestId());
        if ($response->isSetGetTransactionStatusResult()) {
            $getTransactionStatusResult = $response->getGetTransactionStatusResult();
            if ($getTransactionStatusResult->isSetTransactionId()) {
                if($myResponse->getTransactionId()!=$getTransactionStatusResult->getTransactionId()) {
                    throw new Exception("Transaction Id mismatch!");
                }
                $myResponseHistory->setTransactionId($getTransactionStatusResult->getTransactionId());
            }
            if ($getTransactionStatusResult->isSetTransactionStatus()) {
                $myResponseHistory->setTransactionStatus($getTransactionStatusResult->getTransactionStatus());
                $myResponse->setTransactionStatus($getTransactionStatusResult->getTransactionStatus());
            }

            if ($getTransactionStatusResult->isSetStatusCode()) {
                $myResponseHistory->setStatus($getTransactionStatusResult->getStatusCode());
                $myResponse->setStatus($getTransactionStatusResult->getStatusCode());
            }
            if ($getTransactionStatusResult->isSetStatusMessage()) {
                $myResponseHistory->setStatusMessage($getTransactionStatusResult->getStatusMessage());
                $myResponse->setStatusMessage($getTransactionStatusResult->getStatusMessage());
            }
        }
        if ($response->isSetResponseMetadata()) {
            $responseMetadata = $response->getResponseMetadata();
            if ($responseMetadata->isSetRequestId()) {
                $myResponseHistory->setRequestId($responseMetadata->getRequestId());
                $myResponse->setRequestId($responseMetadata->getRequestId());
            }
        }
        $myResponseHistory->save();
        $myResponse->save();

    }
}

?>
