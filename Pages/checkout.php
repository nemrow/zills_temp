<?php
require_once('DataClasses/sale.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/product.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/cbRequest.php');
require_once('DataClasses/account.php');
require_once('DataClasses/recipientRequest.php');
require_once('Amazon/CBUI/CBUIMultiUsePipeline.php');

class checkout extends pageBase {
    private $mySale;
    private $myArtist;
    private $myAccount;
    private $numBuyins;
    private $currentPrice;
    private $lowPrice;
    private $startPrice;
    private $productDescription;
    private $productTitle;
    private $productType;
    private $productImg;
    private $logoImg;
    private $shippingCost;
    private $maxCharge;
    private $backgroundImg;
    private $saleEndFormated;
    private $website;
    private $amazonLink;
    private $error;
    private $saleExpired;
    private $boughtSale;
    private $accentColor;
    private $recipientTokenId;
    private $myRecipientRequest;
    private $timeRightNow;

    public function init($data) {
        $saleId = 0; // init
        if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
            $saleId = $_GET['id'];
        }
        if($saleId<=0) {
            throw new Exception("Sale not found");
            //return false;
        }
        $this->myAccount = new Account($this->db);

        $this->mySale = new Sale($this->db);
        $this->mySale->read($saleId);
        $this->saleExpired = time() >= $this->mySale->getSaleEnd();
        
        $this->myArtist = new Artist($this->db);
        $this->myArtist->read($this->mySale->getArtistId());
        $this->recipientTokenId = $this->myArtist->getRecipientToken($this->mySale->getArtistId());

        $this->myProduct = new Product($this->db);
        $this->myProduct->read($this->mySale->getProductId());
        $this->myProduct->getName();

        if($this->myProduct->getType()=='DigitalMusic') {
            $this->myDigitalMusic = new digitalMusic($this->db);
        } else if($this->myProduct->getType()=='PhysicalMusic') {
            $this->myPhysicalMusic = new physicalMusic($this->db);
        }

        $this->numBuyins = $this->mySale->getNumBuyins();
        $this->currentPrice = number_format($this->mySale->getCurrentPrice(),2);
        $this->lowPrice = number_format($this->mySale->getLowPrice(),2);
        $this->startPrice = number_format( $this->mySale->getStartPrice(),2);
        $this->productType = $this->myProduct->getProductType();
        $this->fullURL = 'Zillionears.com/socialsale&amp;id='.$this->mySale->getId();
        $this->shippingCost = number_format($this->myProduct->getShippingCost(),2);
        $this->maxCharge = (float)$this->mySale->getCurrentPrice()+(float)$this->myProduct->getShippingCost();
        //$this->productDescription = $this->myProduct->getDescription();
        $this->productTitle =  $this->myProduct->getName();
        $this->artistName = $this->myArtist->getArtistName();
        $this->productImg = 'https://www.zillionears.com/'.$this->myProduct->getProductImg();
        $attachment = new attachment($this->db);
        //$attachment->read($this->mySale->getLogoId());
        $this->accentColor = $this->mySale->getAccentColor();
        $this->logoImgWidth = $attachment->getWidth();
        $this->logoImgHeight = $attachment->getHeight();
        $this->logoImg = $this->mySale->getLogo();
        $this->backgroundImg = $this->mySale->getBackground();
        $this->saleEndFormated = $this->mySale->getSaleEndForCountdown();
        $this->saleEndVisual = date('F j\, Y', $this->mySale->getSaleEnd());
        $this->saleExpired = time() >= $this->mySale->getSaleEnd();
        $this->timeRightNow = time();
        $this->hasRecipientRegToken = $this->myArtist->countRecipientToken($this->myArtist->getAccountId());
        
       

        $this->website = $this->myArtist->getWebsite();
        $this->pageTitle = $this->myArtist->getArtistName()." | Social Sale";
        $this->currentPage = 'checkout';

        parent::header();
        if(!parent::loggedIn()) {
            parent::redirect('login&action=checkout&id='.$saleId);
        }
        
        $this->boughtSale = $this->mySale->hasUserBoughtSale(parent::userId());
        
        if(!$this->boughtSale) {
            if(array_key_exists('error', $_GET) && $_GET['error']=='expired') {
                $this->error = '<h2>There was an error processing your payment.  Please try again.</h2><h2>Card will be expired when the sale ends on '. date('F j, Y', $this->mySale->getSaleEnd()).'</h2>';
            }

            $cbRequest = new cbRequest($this->db);
            $cbRequest->setUserId(parent::userId());
            $cbRequest->setSaleId($this->mySale->getId());
            $cbRequest->setPrice($this->mySale->getCurrentPrice()+$this->myProduct->getShippingCost());
            $cbRequest->save();
            $cbRequest->newCallerRef();

            $pipeline = new Amazon_FPS_CBUIMultiUsePipeline(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
            
            if(stripos($_SERVER['SERVER_NAME'], 'www')===FALSE) {
               $domain = str_replace('www.', '', DOMAIN); 
	    } else {
                $domain = DOMAIN;
	    }
            
            if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
                $domain = str_replace('http://', 'https://', DOMAIN);
            }
            
            $pipeline->setMandatoryParameters($cbRequest->getCallerRef(),
                    $domain . "/index.php?page=completesale&id=".$this->mySale->getId(), $this->currentPrice);

            //optional parameters
            $pipeline->addParameter("currencyCode", "USD");
            //$pipeline->setUsageLimit1("Count", '1', null);
            $datediff = $this->mySale->getSaleEnd() - time();
            //$pipeline->setUsageLimit1("Amount", $this->mySale->getCurrentPrice(), (round($datediff/60/60/24)+7). " Days");

            $pipeline->addParameter("validityStart", time());
            $pipeline->addParameter("validityExpiry", $this->mySale->getSaleEnd()+60*24*60*60);
            $pipeline->addParameter("recipientTokenList", $this->recipientTokenId);
            //$pipeline->setUsageLimit1(Count, 1, (round($datediff/60/60/24)+7). " Days");
            $pipeline->addParameter('collectShippingAddress', 'true');
            $pipeline->addParameter("paymentReason", $this->myArtist->getArtistName() . ' - '. $this->myProduct->getName() .' Social Sale');
            $pipeline->addParameter("cobrandingUrl", "https://zillionears.com/images/zillionearsLogoCoBrandAamazon.jpg");
            $pipeline->addParameter("cobrandingStyle", "logo");
            $pipeline->addParameter("websiteDescription", "Zillionears.com");
            if ($this->myProduct->getShippingCost()>0.0) {
                $pipeline->addParameter("shipping", $this->myProduct->getShippingCost());
            }

            $this->amazonLink = $pipeline->getUrl();
        }

        return true;
    }

    public function header() {
        //parent::header();
        require_once('templates/socialsaleHeader.html');


        return true;
    }

    public function footer() {
        require_once('templates/socialsaleFooter.html');
        return true;
    }

    public function body() {
        require_once('templates/checkout.html');
        return true;
    }

}

?>
