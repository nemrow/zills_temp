<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/product.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/recipientRequest.php');

class completeregister extends pageBase {
    private $backgroundImg;
    private $accentColor;
    private $artistName;
    private $lowPrice;
    private $productTitle;
    private $URL;

    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Register With Amazon";
        $this->currentPage = 'completeregister';
        
        if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
            $saleId = $_GET['id'];
        }

        $this->mySale = new Sale($this->db);
        $this->mySale->read($saleId);

        $this->myArtist = new Artist($this->db);
        $this->myArtist->read($this->mySale->getArtistId());

        $this->myProduct = new Product($this->db);
        $this->myProduct->read($this->mySale->getProductId());
        $this->myProduct->getName();
        
        $this->backgroundImg = $this->mySale->getBackground();
        $this->accentColor = $this->mySale->getAccentColor();
        $this->URL = 'https://www.zillionears.com/socialsale&id='.$saleId;
	$this->artistName = $this->myArtist->getArtistName();
        $this->lowPrice = number_format($this->mySale->getLowPrice(),2);
        $this->productTitle =  $this->myProduct->getName();
        $this->productImg = $this->myProduct->getProductImg();
        
        //print_r($_GET);
        
        $myRecipientRequest = new recipientRequest($this->db);

         if(array_key_exists('callerReference', $_GET)) { //TODO validate
            $myRecipientRequest->readByCallerReference($_GET['callerReference']);
            $myRecipientRequest->setStatus($_GET['status']);
            $myRecipientRequest->setTokenId($_GET['tokenID']);
            $myRecipientRequest->setStatus($_GET['status']);
            $myRecipientRequest->save();
            if($myRecipientRequest->getStatus()=="A") {
                $error = "User aborted Amazon registration";
                throw new Exception($error);
            } else if($myRecipientRequest->getStatus()=="CE") {
                $error = "An exception has occurred";
                throw new Exception($error);
            } else if($myRecipientRequest->getStatus()=="NP") {
                $error = "One of the following has occurred:";
                $error .= "The payment instruction installation was not allowed on the sender's account, because the sender's email account is not verified";
                $error .= "The sender and the recipient are the same";
                $error .= "The recipient account is a personal account, and therefore cannot accept credit card payments";
                $error .= "A user error occurred because the pipeline was cancelled and then restarted";
                throw new Exception($error);
            } // status of SR = good
         } else {
            $error = "Unable to register";
            if(array_key_exists('errorMessage', $_GET)) {
                $error .= $_GET['errorMessage'];
            }
            throw new Exception($error);
         }
        return true;
    }

    public function header() {
        parent::header();
        require_once('templates/socialsaleHeader.html');

        return true;
    }

    public function footer() {
        require_once('templates/socialsaleFooter.html');
        return true;
    }

    public function body() {
        require_once('templates/completeregister.html');
        return true;
    }

}

?>
