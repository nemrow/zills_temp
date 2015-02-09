<?php
require_once('DataClasses/order.php');
require_once('DataClasses/account.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/product.php');
require_once('DataClasses/referer.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/recipientRequest.php');
require_once('Amazon/CBUI/CBUIRecipientTokenPipeline.php');

class bandadminsales extends pageBase {
    private $sales;
    private $message;
    private $mySales;
    private $i;
    private $artistName;
    private $paypalEmail;
    private $address;
    private $state;
    private $city;
    private $zip;
    private $errorMessage;
    private $website;
    private $recipientRegToken;
    private $findArtistSale;


    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Band Admin Sales";
        $this->currentPage = 'bandadminsales';
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminSales');
        }
        if(parent::userAccountType()!='manager') {
            parent::redirect('fanAdminSettings');
        }
        $myArtist = new artist($this->db);
        $myAccount = new account($this->db);
        $myAccount->read(parent::userId());
        $myArtist->readByManagerId(parent::userId());


        if(isset($data) && count($data)>0) {

            if(!array_key_exists('artistName', $data) || strlen($data['artistName'])==0) {
                $this->errorMessage = "Please specify an artist name";
            }

            if(!isset($data['bandURL'])) {
                $this->errorMessage = "Please specify a website";
            }


            if(!isset($this->errorMessage) && strlen($this->errorMessage)==0) {
                try {
                    $myArtist->setArtistName($data['artistName']);
                    $myArtist->setWebsite($data['bandURL']);

                    $myArtist->save();
                } catch (Exception $e) {
                    $this->errorMessage = $e->getMessage();

                }
            }
        }

        $this->website = (isset($data['bandURL']) ? $data['bandURL'] : $myArtist->getWebsite());
        $this->artistName = (isset($data['artistName']) ? $data['artistName']  :  $myArtist->getArtistName());
        $this->address = (isset($data['address']) ? $data['address'] : $myArtist->getAddress());
        $this->city = (isset($data['city']) ? $data['city'] : $myArtist->getCity());
        $this->state = (isset($data['state']) ? $data['state'] : $myArtist->getState());
        $this->zip = (isset($data['zip']) ? $data['zip'] : $myArtist->getZip());
        $this->paypalEmail = (isset($data['paypalEmail']) ? $data['paypalEmail'] : $myArtist->getPaypal());
        $this->recipientRegToken = $this->getRecipientTokenCount($myAccount->getId());
        $this->findArtistSale = $this->findArtistSale($myArtist->getId());
           
        if (!$this->getRecipientTokenCount($myAccount->getId()) > 0){//!$this->hasActiveAmazonAccount) { // need to make CBUI call to create link

            $myRecipientRequest = new recipientRequest($this->db);
            $myRecipientRequest->setUserId(parent::userId());
            $myRecipientRequest->save();
            $myRecipientRequest->newCallerRef();
            $myRecipientRequest->newRefundId();
            
            $pipeline = new Amazon_FPS_CBUIRecipientTokenPipeline(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
            
            if(stripos($_SERVER['SERVER_NAME'], 'www')===FALSE) {
               $domain = str_replace('www.', '', DOMAIN); 
	    } else {
                $domain = DOMAIN;
	    }
            
            if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
                $domain = str_replace('http://', 'https://', DOMAIN);
            }
            
            $pipeline->setMandatoryParameters($myRecipientRequest->getCallerRef(),
                    $domain . "/index.php?page=completeregister&id=$this->findArtistSale", 0, 0, "TRUE");
            $pipeline->addParameter('callerReferenceRefund', $myRecipientRequest->getRefundToken());
           
            $pipeline->addParameter("cobrandingUrl", "https://zillionears.com/images/zillionearsLogoCoBrandAamazon.jpg");
            $pipeline->addParameter("cobrandingStyle", "logo");


            $this->amazonLink = $pipeline->getUrl();
        }


        $sale = new sale($this->db);
        $orderSaleIdList = $sale->getSaleIdsByManager(parent::userId());

        $this->currentTime = time();
        if($orderSaleIdList != null) {
            foreach($orderSaleIdList as $ids) {
                $mySale = new sale($this->db);
                $myProduct = new product($this->db);
                $mySale->read($ids);
                $myReferer = new referer($this->db);

                $myProduct->read($mySale->getProductId());
                $this->mySales[$this->i]['saleId'] = $mySale->getId();
                $this->mySales[$this->i]['saleURL'] = 'socialsale&amp;id='.$mySale->getId();
                $this->mySales[$this->i]['fullURL'] = 'Zillionears.com/socialsale&amp;id='.$mySale->getId();
                $this->mySales[$this->i]['type'] = $myProduct->getProductType();
                $this->mySales[$this->i]['img'] = $myProduct->getProductImg();
                $this->mySales[$this->i]['currentPrice'] = number_format($mySale->getCurrentPrice(),2);
                $this->mySales[$this->i]['startPrice'] = $mySale->getStartPrice();
                $this->mySales[$this->i]['basePrice'] = $mySale->getLowPrice();
                $this->mySales[$this->i]['purchases'] = $mySale->getNumBuyins();
                $this->mySales[$this->i]['decStructure'] = number_format($mySale->getDecrement(),4);
                $this->mySales[$this->i]['saleEnds'] = $mySale->getSaleEndForCountdown();
                $this->mySales[$this->i]['views'] = $myReferer->getPageViewCounts('socialsale', $mySale->getId());
                $this->mySales[$this->i]['refTable'] = $this->getRefTable($myReferer, $mySale->getId());
                $this->mySales[$this->i]['fanTable'] = $this->getFanTable($mySale, $mySale->getId());
                $this->mySales[$this->i]['message'] = $mySale->getEmailMessage();
                $this->mySales[$this->i]['saleTitle'] = $myProduct->getName();
                //$this->mySales[$this->i]['buyinPrice'] = $myOrder->getMaxPrice();
                if($mySale->getSaleEnd() < $this->currentTime) {
                    $this->mySales[$this->i]['saleCompleted'] = true;
                } else {
                    $this->mySales[$this->i]['saleCompleted'] = false;
                }
                $this->i++;
            }
        } else {
            $this->message = "<br/><h2><img src=\"images/billymad3.jpg\"/></h2>";
        }
        return true;
    }

    public function header() {

        require_once('templates/header.html');

        return true;
    }

    public function footer() {
        require_once('templates/footer.html');
        return true;
    }

    public function body() {
        require_once('templates/bandAdminSales.html');
        return true;
    }

    private function getSales() {
        if($this->mySales != null) {
                $i=0;
                foreach($this->mySales as $sale) {
                    extract($sale);
                    require('templates/bandAdminSale.html');
                    $i++;
                }
        }
    }

    private function getRefTable($myReferer, $saleId) {
        $return = '<table class="refTable">';
        $refList = $myReferer->getRefList('socialsale', $saleId);

        for($i=0; $i<sizeof($refList); $i++) {
            $return .= '<tr>';
            $return .= "<td class=\"refL\">{$refList[$i][0]}</td><td class=\"refR\">{$refList[$i][1]}</td>";
            $return .= '</tr>';
        }

        $return .= '</table>';
        return $return;
    }
    private function getFanTable($mySale, $saleId) {
        $return = '<table class="finsDigList"><tr><td class="finsDigListName finsDigListHeaders">Name</td><td class="finsDigListEmail finsDigListHeaders">Email</td><td class="finsDigListEmail finsDigListHeaders">Zip</td><td class="finsDigListPrice finsDigListHeaders">In At</td></tr>';
        $refList = $mySale->getFanList($saleId);

        for($i=0; $i<sizeof($refList); $i++) {
            $return .= '<tr>';
            $return .= "<td class=\"finsDigListName\">{$refList[$i][0]}</td><td class=\"finsDigListEmail\">{$refList[$i][1]}</td><td class=\"finsDigListEmail\">{$refList[$i][3]}</td><td class=\"finsDigListPrice\">\${$refList[$i][2]}</td>";
            $return .= '</tr>';
        }

        $return .= '</table>';
        return $return;
    }
    
    public function getRecipientTokenCount($userid) {
            $query = "SELECT count(rr.tokenid)
            FROM `recipientrequest` rr
            WHERE rr.userid = '$userid'
            AND rr.status = 'SR'";
            $result = $this->db->queryCount($query);
            
            return $result;
    }
    
    public function findArtistSale($artistId){
        $query = "SELECT s.id
            FROM `sale` s
            INNER JOIN `artist` art ON art.id = s.artistid
            WHERE art.id = $artistId";
        $row = mysql_fetch_row(mysql_query($query));
            return $row[0];
    }

}

?>
