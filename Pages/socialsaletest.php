<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/product.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/sale.php');

class SocialSaleTest extends pageBase {
    //page vars
    private $numBuyins;
    private $currentPrice;
    private $lowPrice;
    private $startPrice;
    private $decrement;
    private $artist;
    private $trackListEnabled;
    private $trackList;
    private $productDescription;
    private $productType;
    private $productImg;
    private $logoImg;
    private $logoImgWidth;
    private $logoImgHeight;
    private $backgroundImg;
    private $saleEndFormated;
    private $thumbs;
    private $website;
    private $dtEnd;
    private $id = 0;
    private $saleExpired;

    public function init($data) {
        session_start();
        $this->saleExpired = false;
        if(!array_key_exists('socialsaletest', $_SESSION)) {
            throw new Exception ("Social Sale Preview Unavailable.  Please continue with sale.");
        }
        //print_r($_SESSION['socialsaletest']);
        if(array_key_exists('startPrice', $_SESSION['socialsaletest']) && is_numeric(str_replace('$', '', $_SESSION['socialsaletest']['startPrice']))) {
            $this->startPrice=(float)str_replace('$', '', $_SESSION['socialsaletest']['startPrice']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Start Price not specified");
        }

        if(array_key_exists('lowPrice', $_SESSION['socialsaletest']) && is_numeric(str_replace('$', '', $_SESSION['socialsaletest']['lowPrice']))) {
            $this->lowPrice=(float)str_replace('$', '',$_SESSION['socialsaletest']['lowPrice']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Floor Price not specified");
        }
        if(array_key_exists('decrement', $_SESSION['socialsaletest']) && is_numeric($_SESSION['socialsaletest']['decrement'])) {
            $this->decrement=(float)$_SESSION['socialsaletest']['decrement'];
        } else {
            throw new Exception("Could not Create sample Social Sale: Decrement not specified");
        }

        if(array_key_exists('productType', $_SESSION['socialsaletest'])) {
            $this->productType=htmlentities($_SESSION['socialsaletest']['productType']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Product type not specified");
        }

        if(array_key_exists('productName', $_SESSION['socialsaletest'])) {
            $this->productTitle=htmlentities($_SESSION['socialsaletest']['productName']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Product title not specified");
        }

        if(array_key_exists('productDescription', $_SESSION['socialsaletest'])) {
            $this->productDescription=htmlentities($_SESSION['socialsaletest']['productDescription']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Product description not specified");
        }

        if(array_key_exists('artistName', $_SESSION['socialsaletest'])) {
            $this->artist=htmlentities($_SESSION['socialsaletest']['artistName']);
        } else {
            throw new Exception("Could not Create sample Social Sale: Artist name not specified");
        }

        if(array_key_exists('productImageId', $_SESSION['socialsaletest']) && is_numeric($_SESSION['socialsaletest']['productImageId'])) {
            $imageId=(float)$_SESSION['socialsaletest']['productImageId'];
            if($imageId>0) {
                $attachment = new Attachment($this->db);
                $attachment->read($imageId);
                $this->productImg = $attachment->getPath();
            } else {
                $this->productImg = 'images/productplaceholder.jpg'; //TODO: get product placeholder
            }
        } else {
            throw new Exception("Could not Create sample Social Sale: Product Image not specified");
        }

        if(array_key_exists('logoId', $_SESSION['socialsaletest']) && is_numeric($_SESSION['socialsaletest']['logoId'])) {
            $imageId=(float)$_SESSION['socialsaletest']['logoId'];
            if($imageId>0) {
                $attachment = new Attachment($this->db);
                $attachment->read($imageId);
                $this->logoImg = $attachment->getPath();
                $this->logoImgHeight = $attachment->getHeight();
                $this->logoImgWidth = $attachment->getWidth();
            } else {
                $this->logoImg = 'images/logoplaceholder.jpg'; //Todo
                $this->logoImgHeight = 200;
                $this->logoImgWidth = 150;
            }
        } else {
            throw new Exception("Could not Create sample Social Sale: Logo Image not specified");
        }

        if(array_key_exists('backgroundId', $_SESSION['socialsaletest']) && is_numeric($_SESSION['socialsaletest']['backgroundId'])) {
            $imageId = (float)$_SESSION['socialsaletest']['backgroundId'];
            if($imageId>0) {
                $attachment = new Attachment($this->db);
                $attachment->read($imageId);
                $this->backgroundImg = $attachment->getPath();
            } else {
                $this->backgroundImg = 'images/backgroundplaceholder.jpg';
            }

        } else {
            throw new Exception("Could not Create sample Social Sale: Background Image not specified");
        }

        if(array_key_exists('saleEnd', $_SESSION['socialsaletest'])) {
            $this->dtEnd = $_SESSION['socialsaletest']['saleEnd'];
        } else {
            throw new Exception("Could not Create sample Social Sale: sale date not specified");
        }


        $this->numBuyins = rand(0,1000);

        $this->currentPrice = ($this->startPrice - $this->decrement*$this->numBuyins > $this->lowPrice) ? $this->startPrice - $this->decrement*$this->numBuyins : $this->lowPrice ;
        $this->startPrice = '$'. number_format($this->startPrice,2);
        $this->lowPrice = '$' .  number_format($this->lowPrice,2);
        $this->currentPrice = '$' .  number_format($this->currentPrice,2);


        $this->trackList = "Track Lists are not displayed in preview mode";

        $this->trackListEnabled = $this->productType != 'PhysicalMerch' && $this->productType != 'Physical Merch' && $this->trackList != '';



        $this->thumbs = $this->getThumbs();

        $this->saleEndFormated = $this->getSaleEnd();

        $this->website = "http://www.zillionears.com";
        $this->pageTitle = $this->artist." | Social Sale";
        $this->currentPage = 'SocialSaleTest';

        return true;
    }

    public function header() {

        require_once('templates/socialsaleHeader.html');
        return true;
    }

    public function footer() {

        require_once('templates/socialsaleFooter.html');
        return true;
    }

    public function body() {
        require_once('templates/socialsale.html');
        return true;
    }

    private function getTrackList() {
        try {
            if($this->myProduct->getType() == 'PhysicalMusic') {
                $tracks = $this->myPhysicalMusic->getAllTracks($this->myProduct->getId());
            } else if ($this->myProduct->getType() == 'DigitalMusic') {
                $tracks = $this->myDigitalMusic->getAllTracks($this->myProduct->getId());
            } else {
                return '';
            }
            $return = '';
            foreach($tracks as $track) {
                $return .= $track['trackNumber'] . '. ';
                $return .= $track['trackTitle'] . ' ';
                //$return .= '('.$track['length'].')<br/>';
            }
        } catch (Exception $e) {
            //Ignore
            return '';
        }

        return $return;
    }

    private function getSaleEnd() {
               // timezone, year, month, - 1, date
        $saleEnd = strtotime($this->dtEnd);

        $time = SERVERTIMEZONE . ', ';
        $time .= date('Y', $saleEnd) . ', ';
        $time .= date('n', $saleEnd) . ' - 1, ';
        $time .= date('j', $saleEnd);
        //return '-8, 2012,  8 - 1, 22';
        //echo date($saleEnd);
        return $time;
    }

    private function getThumbs() {
        $return = '';
        for($i=0; $i<11; $i++) {
            $j = rand(1, 11);
            $return .= $this->getImg("images/profileThumbs/stockFace{$j}.jpg");
        }

        return $return;
    }

    private function getImg($path) {
        return "<img src=\"$path\" />";
    }

}

?>
