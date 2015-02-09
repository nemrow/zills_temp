<?php
require_once('DatabaseBase.php');
require_once('MySQLDB.php');
require_once('DataClasses/account.php');
require_once('DataClasses/order.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/cbRequest.php');
require_once('DataClasses/fpsResponse.php');
require_once('DataClasses/recipientRequest.php');
require_once('DataClasses/fpsResponseHistory.php');
require_once('Amazon/FPS/Model.php');
require_once('Amazon/FPS/Mock.php');
require_once('Amazon/FPS/Client.php');
require_once('Amazon/FPS/Model/PayRequest.php');
require_once('Amazon/FPS/Model/Amount.php');
require_once('Amazon/FPS/Model/GetTransactionStatusRequest.php');
require_once('Includes/emailTemplates.php');


class CaptureSalesHelper {
    private $db;
    private $myRecipientRequest;

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
    
    public function getNumFanInSale($saleId){
        $sql = "SELECT o.userId, a.firstName, a.lastName, o.dtCreated, o.maxPrice, o.status FROM `order` o INNER JOIN `account` a ON a.id = o.userId WHERE o.saleID=".$saleId;
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
    
    public function incrementShareCount($saleId){
        $mySale = new sale($this->db);
        $mySale->read($saleId);
        $currentCount = $mySale->getShareCount();
        if($currentCount != NULL){
            $currentCount++;
        }else{
            $currentCount = 1;
        }
        $mySale->setShareCount($currentCount);
        $mySale->save();
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
    
    public function getUncapturedOrdersFromYesterday() {
        $sql = "SELECT o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, o.status, art.artistName, s.startPrice ";
        $sql .= "FROM `order` o ";
        $sql .= "INNER JOIN `sale` s ON s.id = o.saleId ";
        $sql .= "INNER JOIN `account` a ON a.id = o.userid ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON art.id = s.artistId ";
        $sql .= "WHERE ";
        $sql .= "saleEnd < UNIX_TIMESTAMP() AND ";
        $sql .= "o.status != 'CAPTURED' AND ";
        $sql .= "s.saleEnd > (UNIX_TIMESTAMP()-(86400)) "; // 86400

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
            $return[$i][10] = $line[10];
            $return[$i][11] = $line[11];
        }
        return $return;
    }
    
    public function getFinishedSalesFromYesterday() {
        $sql = "SELECT s.id, p.name, a.email ";
        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON art.id = s.artistId ";
        $sql .= "INNER JOIN `account` a ON a.id = art.accountId ";
        $sql .= "WHERE ";
        $sql .= "saleEnd < UNIX_TIMESTAMP() AND ";
        $sql .= "s.saleEnd > (UNIX_TIMESTAMP()-(86400)) "; // 86400

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
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
        $sql = "SELECT o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, fpsr.status, o.finalPrice ";
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
            $return[$i][10] = $line[10];
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
     
     public function getSalesFor24HourAlert() {
        $sql = "SELECT s.id, p.name, a.email, art.artistName, s.lowPrice ";
        $sql .= "FROM `sale` s ";
        $sql .= "INNER JOIN `product` p ON p.id = s.productId ";
        $sql .= "INNER JOIN `artist` art ON art.id = s.artistId ";
        $sql .= "INNER JOIN `account` a ON a.id = art.accountId ";
        $sql .= "WHERE ";
        $sql .= "saleEnd > (UNIX_TIMESTAMP()+(76400)) AND "; // 86400
        $sql .= "s.saleEnd < (UNIX_TIMESTAMP()+(152800)) "; // 172800

        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
        }
        return $return;
    }
    
    public function sendFan24HourMailFromSaleId($saleId, $artistName, $currentPrice, $lowPrice){
        $emailTemplates = new emailTemplates;
        $mySale = new sale($this->db);
        $mySale->read($saleId);
        $fanList = $mySale->getFanList($saleId);
        for($i=0;$i<count($fanList);$i++){
            try{
                $emailTemplates->sendMail_Fan_24Hours($fanList[$i][1], $artistName, $currentPrice, $lowPrice, $saleId);
            }catch (Exception $e){

            }
        }
        // (a.firstName,\" \",a.LastName), a.email, o.maxPrice, cbr.zip
    }
     
     public function send24HourAlertMail(){
        $grabSales = $this->getSalesFor24HourAlert();
        $mailTemples = new emailTemplates;
        for($i=0; $i<count($grabSales); $i++) {
            try{
                $mailTemples->sendMail_Band_24Hours($grabSales[$i][2], $grabSales[$i][1], $grabSales[$i][0]);
                $mySale = new sale($this->db);
                $mySale->read($grabSales[$i][0]);
                $this->sendFan24HourMailFromSaleId($grabSales[$i][0], $grabSales[$i][3], $mySale->getCurrentPrice(), $mySale->getLowPrice());
                // s.id, p.name, a.email, art.artistName, s.lowPrice
            }catch (Exception $e){
                
            }
         }        
    }
     
     public function captureSalesFromYesterday() {
         $numErrors = 0;
         $orderLog = '';
         $emailTemplates = new emailTemplates;
         $orders = $this->getUncapturedOrdersFromYesterday();
         for($i=0; $i<count($orders); $i++) {
                try{   
                    $this->captureSale($orders[$i][0]);
                    $myOrder = new order($this->db);
                    $myOrder->read($orders[$i][0]);
                    $mySale = new sale($this->db);
                    $mySale->read($orders[$i][1]);
                    $newStatus = $myOrder->getStatus();
                    $emailTemplates->sendMail_Fan_SaleOver_Success($orders[$i][8], $orders[$i][10], $orders[$i][11], $orders[$i][3], number_format(($mySale->getCurrentPrice()),2)); // email should be $orders[$i][8]
                }catch (Exception $e){ 
                    $start = strripos($e, '<Code>')+6;
                    $stop = stripos($e, '</Code>');
                    $length = number_format($stop) - (number_format($start));
                    $errorCode = substr($e, $start, $length);
                    $start = strripos($e, '<Message>')+9;
                    $stop = stripos($e, '</Message>');
                    $length = number_format($stop) - (number_format($start));
                    $errorMessage = substr($e, $start, $length);
                    $start = strripos($e, '<RequestID>')+11;
                    $stop = stripos($e, '</RequestID>');
                    $length = number_format($stop) - (number_format($start));
                    $errorID = substr($e, $start, $length);
                    $myOrder = new order($this->db);
                    $myOrder->read($orders[$i][0]);
                    $mySale = new sale($this->db);
                    $mySale->read($orders[$i][1]);
                    if($myOrder->getError() != $errorCode){
                        $myOrder->setError($errorCode);
                        $myOrder->save();
                    }
                    $newStatus = $myOrder->getStatus();
                    $error = 'Code: '.$errorCode.'<br/>Message: '.$errorMessage.'<br/>ID: '.$errorID.'<br>';
                    $emailTemplates->sendMail_Fan_SaleOver_Fail($orders[$i][8], $orders[$i][10], number_format(($mySale->getCurrentPrice()),2), $errorMessage);
                    $numErrors++;
                } 
            $orderLog .= '<tr><td>'.$orders[$i][0].'</td><td>'.$orders[$i][1].'</td><td>'.$orders[$i][5].'</td><td>'.$orders[$i][6].'</td><td>'.$newStatus.'</td><td>'.$error.'</td></tr>';
            $error = '';
            $errorCode = '';
            $errorMessage = '';
            $errorID = '';
            $newStatus = '';
            //query order is: o.id, s.id, p.name, o.maxPrice, o.dtcreated, a.firstName, a.lastName, s.saleend, a.email, o.status, art.artistName, s.startPrice
         }
         $artistTotalErrorLog = '';
         $artists = $this->getFinishedSalesFromYesterday();
         for($i=0;$i<count($artists);$i++){
            try {
                $mySale = new sale($this->db);
                $mySale->read($artists[$i][0]);
                $emailTemplates->sendMail_Band_SaleOver($artists[$i][2], $artists[$i][1], $mySale->getCurrentPrice(), $mySale->getNumBuyins(), $mySale->getNumSuccessfulCaptures()); // email will be $artists[$i][2]
            }catch (Exception $e){
                $artistTotalErrorLog .= 'Sale Id '.$artists[$i][0].' did not get their final band email sent to them.<br />';
            }
         }
         // query is s.id, p.name, a.email
         $emailReport = 'Email Report<br/>';
         $emailReport .= 'Total number of captures attempted: '.count($orders).'<br>';
         $emailReport .= 'Total number of successful captures: '.(count($orders)-$numErrors).'<br>';
         $emailReport .= 'Total number of errors: '.$numErrors.'<br>';
         $emailReport .= '<table><tr><td>Order ID</td><td>Sale ID</td><td>First Name</td><td>Last Name</td><td>Status</td><td>Problem</td></tr>';
         $emailReport .= $orderLog;
         $emailReport .= '</table>';
         $emailReport .= 'Artist Errors:<br />';
         $emailReport .= $artistTotalErrorLog;
         // $emailTemplates->sendSingleEmail('master@zillionears.com', 'staff@zillionears.com', 'Daily Capturing', 'Hello Sexy', 'Heres your money', $emailReport, 'Your bitch');
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
         
         $myRecipientRequest = new recipientRequest($this->db);
         $recipientTokenId = $myRecipientRequest->readArtistIdForRR($mySale->getArtistId());

         $service = new Amazon_FPS_Client(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
         //$service = new Amazon_FPS_Mock();
         $request =  new Amazon_FPS_Model_PayRequest();

         $request->setSenderTokenId($myCbRequest->getTokenId());//set the proper senderToken here.
         $amount = new Amazon_FPS_Model_Amount();
         $amount->setCurrencyCode("USD");
         $amount->setValue($mySale->getCurrentPrice()); //set the transaction amount here;
         $request->setRecipientTokenId($recipientTokenId);
         $request->setTransactionAmount($amount);
         //$request->setRecipientTokenId($value)
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
            //$error = "Caught Exception: " . $ex->getMessage() . "\n";
            //$error .= "Response Status Code: " . $ex->getStatusCode() . "\n";
            //$error .= "Error Code: " . $ex->getErrorCode() . "\n";
            //$error .= "Error Type: " . $ex->getErrorType() . "\n";
            //$error .= "Request ID: " . $ex->getRequestId() . "\n";
            $error = "XML: " . $ex->getXML();
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
