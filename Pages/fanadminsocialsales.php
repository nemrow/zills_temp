<?php
require_once('DataClasses/order.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/product.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/account.php');

class fanadminsocialsales extends pageBase {
    private $mySales;
    private $myProducts;
    private $i;
    private $currentTime;
    private $message;


    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Fan Admin Social Sales";
        $this->currentPage = 'fanadminsocialsales';
        if(parent::userId()<=0) {
            parent::redirect('login&action=fanAdminSocialSales');
        }
        $sale = new sale($this->db);

        $this->i = 0;
        
        $myAccount = new account($this->db);
        $myAccount->read(parent::userId());
        $this->userEmailAddress = $myAccount->getEmail();
        

        $orderSaleIdList = $sale->getSaleIdsByUser(parent::userId());

        $this->currentTime = time();
        if($orderSaleIdList != null) {
            foreach($orderSaleIdList as $ids) {
                $mySale = new sale($this->db);
                $myProduct = new product($this->db);
                $mySale->read($ids[1]);
				$myArtist = new artist($this->db);
				$myArtist->read($mySale->getArtistId());
                $myOrder = new order($this->db);
                $myOrder->read($ids[0]);
                $myProduct->read($mySale->getProductId());
                $this->mySales[$this->i]['orderId'] = $myOrder->getId();
                $this->mySales[$this->i]['saleURL'] = 'socialsale&amp;id='.$mySale->getId();
                $this->mySales[$this->i]['fullURL'] = 'Zillionears.com/socialsale&amp;id='.$mySale->getId();
                $this->mySales[$this->i]['type'] = $myProduct->getProductType();
                $this->mySales[$this->i]['img'] = $myProduct->getProductImg();
                $this->mySales[$this->i]['currentPrice'] = number_format($mySale->getCurrentPrice(),2);
                $this->mySales[$this->i]['startPrice'] = $mySale->getStartPrice();
                $this->mySales[$this->i]['saleEnds'] = $mySale->getSaleEndForCountdown();
                $this->mySales[$this->i]['buyinPrice'] = number_format($myOrder->getMaxPrice(),2);
				$this->mySales[$this->i]['openingprice'] = number_format($mySale->getStartPrice(),2);
				$this->mySales[$this->i]['lowestprice'] = number_format($mySale->getLowPrice(),2);
				$this->mySales[$this->i]['numbuyins'] = number_format($mySale->getNumBuyins(),0);
                                $this->mySales[$this->i]['decStructure'] = number_format($mySale->getDecrement(),4);
				$this->mySales[$this->i]['artistName'] = $myArtist->getArtistName(); 
				$this->mySales[$this->i]['productName'] = $myProduct->getName();
                                $this->mySales[$this->i]['colorAccent'] = $mySale->getAccentColor();
                                $this->mySales[$this->i]['albumPath'] = $myProduct->getAlbumPath();
                                $this->mySales[$this->i]['saleId'] = $mySale->getId();
                                $this->mySales[$this->i]['paymentStatus'] = $myOrder->getStatus();
                                $this->mySales[$this->i]['shareCount'] = $mySale->getShareCount();
                if($mySale->getSaleEnd() < $this->currentTime) {
                    $this->mySales[$this->i]['saleCompleted'] = true;
                } else {
                    $this->mySales[$this->i]['saleCompleted'] = false;
                }
                $this->i++;
            }
        } else {
            $this->message = "<br/><div class=\"billyMadisonPix\"><h3>You haven't participated in any!!</h3><br/><img src=\"images/billymad3.png\"/></div>";
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
        require_once('templates/fanAdminSocialSales.html');
        return true;
    }

    private function displaySales() {
        if($this->mySales != null) {
                for($i=0; $i< count($this->mySales);$i++) {
                    extract($this->mySales[$i]);
                    require('templates/fanAdminSocialSale.html');
                }
        }
    }

}

?>
