<?php
require_once('DataClasses/cbRequest.php');
require_once('DataClasses/order.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/account.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/product.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/physicalMerch.php');
require_once('Amazon/IpnReturnUrlValidation/SignatureUtilsForOutbound.php');
require_once('SendGrid/SendGrid.php');
require_once('SendGrid/SendGrid_loader.php');
require_once('Includes/emailTemplates.php');

class completesale extends pageBase {

    private $message;
    private $myAccount;
    private $myProduct;
    private $mySale;
    private $myArtist;

    public function init($data) {
        parent::header();
        $cbRequest = new cbRequest($this->db);
        $saleId = 0; // init
        if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
            $saleId = $_GET['id'];
        }
        if($saleId<=0) {
            throw new Exception("Sale not found");
            //return false;
        }

        $accountId = parent::userId(); 
        $this->myAccount = new account($this->db);
        $this->myAccount->read($accountId);
        $this->email = $this->myAccount->getEmail();

        $this->mySale = new sale($this->db);
        $this->mySale->read($saleId);

        $this->myArtist = new artist($this->db);
        $this->myArtist->read($this->mySale->getArtistId());


        $this->myProduct = new product($this->db);
        $this->myProduct->read($this->mySale->getProductId());
        $this->myProduct->getName();

        if($this->myProduct->getType()=='DigitalMusic') {
            $this->myDigitalMusic = new digitalMusic($this->db);
        } else if($this->myProduct->getType()=='PhysicalMusic') {
            $this->myPhysicalMusic = new physicalMusic($this->db);
        }

        $this->numBuyins = $this->mySale->getNumBuyins();
        $this->currentPrice = $this->mySale->getCurrentPrice();
        $this->lowPrice = $this->mySale->getLowPrice();
        $this->startPrice = $this->mySale->getStartPrice();
        $this->productType = $this->myProduct->getProductType();
        $this->productDescription = $this->myProduct->getDescription();
        $this->productTitle =  $this->myProduct->getName();
        $this->productImg = $this->myProduct->getProductImg();
        $this->logoImg = $this->mySale->getLogo();
        $this->backgroundImg = $this->mySale->getBackground();
        $this->saleEndFormated = $this->mySale->getSaleEnd();

        if(array_key_exists('callerReference', $_GET)) { //TODO validate
            if(array_key_exists('expiry', $_GET)) {
                //$mySale->read($_GET['id']);
                $expireMonth = explode('/', $_GET['expiry']);

                if($this->mySale->getSaleEnd()>= mktime(0, 0, 0, $expireMonth[0], 1, $expireMonth[1])) {
                    parent::redirect('checkout&id='.$_GET['id'].'&error=expired');// ) ;
                } else {
                    $cbRequest->readByCallerReference($_GET['callerReference']);
                    $cbRequest->setTokenId($_GET['tokenID']);
                    $cbRequest->setStatus($_GET['status']);
                    $cbRequest->setAddressName($_GET['addressName']);
                    $cbRequest->setAddressLine1($_GET['addressLine1']);
                    $cbRequest->setAddressLine2($_GET['addressLine2']);
                    $cbRequest->setCity($_GET['city']);
                    $cbRequest->setState($_GET['state']);
                    $cbRequest->setZip($_GET['zip']);
                    $cbRequest->setCountry($_GET['country']);
                    $cbRequest->setPhoneNumber($_GET['phoneNumber']);
                    //if(array_key_exists($key, $searcharray))
                    //$cbRequest->setError($_GET['errorMessage']);
                    $cbRequest->save();
                    
                    // initiate email templates
                    $emailTemplates = new emailTemplates;
                    
                    $emailTemplates->sendMail_Fan_YourInSale($this->myAccount->getEmail(), $this->myProduct->getName(), $this->myArtist->getArtistName(), $this->mySale->getCurrentPrice(), $this->mySale->getLowPrice(), $this->mySale->getId());                   

                }
            }
        } else {
            $error = "Payment did not go through";
            if(array_key_exists('errorMessage', $_GET)) {
                $error .= $_GET['errorMessage'];
            }
            throw new Exception($error);
        }

        switch ($_GET['status']) {
            case "SA":
            case "SB":
            case "SC":
                $order = new order($this->db);
                $order->setType($_GET['status']);
                $order->setUserId(parent::userId());
                $order->setSaleId($cbRequest->getSaleId());
                $order->setPaymentId($cbRequest->getId());
                $order->setMaxPrice($cbRequest->getPrice());
                $order->setStatus("AUTHORIZED");
                $order->save();
                $cbRequest->setOrderIdWithoutUpdate($order->getId());
                //Redirect
                parent::redirect("fanAdminSocialSales");
                break;
            case "SE":
                $this->message = "A system error has occurred.  Please try <a href=\"socialsale&id={$_GET['id']}\">checking out</a> again";
                break;
            case "A":
                parent::redirect("socialsale&id=".$_GET['id']);
                break;
            case "CE":
                $this->message = "A caller exception has occurred.  Please try <a href=\"socialsale&id={$_GET['id']}\">checking out</a> again";
                break;
            case "PE":
                $this->message = "The payment method is not selected.  Please use a Credit Card or ACH transfer.  Please try <a href=\"socialsale&id={$_GET['id']}\">checking out</a> again";
                break;
            case "NP":
                $this->message = "The payment method is not selected.  Please use a Credit Card or ACH transfer.  Please try <a href=\"socialsale&id={$_GET['id']}\">checking out</a> again";
                break;
            case "NM":
                $this->message = "Our payment system is currently down.  Please try again later.  Back  <a href=\"index.php\">home</a> again";
                break;
            default:
                throw new Exception("Unsupported status recieved from Amazon");
                break;
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
        require_once('templates/completesale.html');
        return true;
    }

}

?>
