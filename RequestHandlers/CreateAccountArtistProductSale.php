<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMerch.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/product.php');
require_once('DataClasses/sale.php');
require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('SendGrid/SendGrid.php');
require_once('SendGrid/SendGrid_loader.php');
require_once('Includes/emailTemplates.php');

class CreateAccountArtistProductSale extends RequestHandlerBase {
    private $email;
    private $emailTemplates;
    private $firstName;
    private $lastName;
    private $artistName;
    private $website;
    private $productDescription;
    private $productImageId;
    private $productName;
    private $productType;
    private $shipping;
    private $digitalMusicCount;
    private $digitalTracks;
    private $physicalMusicCount;
    private $physicalTracks;
    //Physical merch
    private $physicalMerchUnlimitedSales;
    private $physicalMerchXS;
    private $physicalMerchS;
    private $physicalMerchM;
    private $physicalMerchL;
    private $physicalMerchXL;
    private $physicalMerchXXL;
    private $physicalMerchXXXL;
    private $physicalMerchNA;
    private $password;
    private $decrement;
    private $lowPrice;
    private $saleEnd;
    private $startPrice;
    private $logoId;
    private $backgroundId;
    private $accentColor;
    private $zippedAlbumTitle;

    private $mode;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        parent::startSession();

        if(!isset($_POST['accountTypePreCreateSs']) && $_POST['accountTypePreCreateSs']!='new' && $_POST['accountTypePreCreateSs']!='manager' && $_POST['accountTypePreCreateSs']!='band') {
            throw new Exception('Create sale type not specified');
        } else {
            $this->mode = $_POST['accountTypePreCreateSs'];
        }
        if($this->mode=='band' && parent::userAccountType()!='manager') {
            throw new Exception('Account type is not manager');
        } else {
            $this->mode = $_POST['accountTypePreCreateSs'];
        }

        if($this->mode=='fan' && parent::userAccountType()!='customer') {
            throw new Exception('Account already upgraded to band.');
        }

        if($this->mode=='new' && parent::loggedIn()) {
            throw new Exception('Trying to create a new account, but you are already logged in.');
        } else {
            $this->mode = $_POST['accountTypePreCreateSs'];
        }

        if($this->mode!='band') {
            // artist block
            if(isset($_POST['artistName'])) {
                $this->artistName = $_POST['artistName'];
            } else {
                throw new Exception('Artist Name must be provided');
            }

            if(isset($_POST['website'])) {
                $this->website = $_POST['website'];
            } else {
                throw new Exception('Website must be provided');
            }
        }

        if($this->mode=='new') {
            // account block
            if(isset($_POST['email'])) {
                $this->email = $_POST['email'];
            } else {
                throw new Exception("Email must be provided");
            }
            if(isset($_POST['firstName'])) {
                $this->firstName = $_POST['firstName'];
            } else {
                throw new Exception("First Name must be provided");
            }
            if(isset($_POST['password'])) {
                $this->password = $_POST['password'];
            } else {
                throw new Exception("Password must be provided");
            }
            if(isset($_POST['password2'])) {
                if($this->password!=$_POST['password2']) {
                    throw new Exception('Password does not match');
                }
            } else {
                throw new Exception("Password must be confirmed");
            }
            if(isset($_POST['lastName'])) {
                 $this->lastName = $_POST['lastName'];
            } else {
                throw new Exception("Last Name must be provided");
            }
            $this->accountType = 'manager';
        }

        //product block
        if(isset($_POST['productName'])) {
            $this->productName = $_POST['productName'];
        } else {
            throw new Exception('Product Name must be provided');
        }
        if(isset($_POST['productType'])) {
            if($_POST['productType']=='Physical Music' || $_POST['productType']=='PhysicalMusic') {
                $this->productType = 'PhysicalMusic';
            } else if($_POST['productType']=='Physical Merch' || $_POST['productType']=='PhysicalMerch') {
                $this->productType = 'PhysicalMerch';
            } else if($_POST['productType']=='Digital Music' || $_POST['productType']=='DigitalMusic') {
                $this->productType = 'DigitalMusic';
            } else {
                $this->productType = $_POST['productType'];
            }
        } else {
            throw new Exception('Product Type must be provided');
        }
        if(isset($_POST['productImageId']) && $_POST['productImageId']>0) {
            $this->productImageId = $_POST['productImageId'];
        } else {
            throw new Exception('Product Image Id must be provided');
        }

        if($this->productType == 'DigitalMusic') {
            $this->digitalMusicCount = (int) $_POST['digitalTrackCount'];

            for($i=0; $i<=$this->digitalMusicCount;$i++) {
                $this->digitalTracks[$i]['attachmentId']=$_POST['digitalTrackTitleIds'.$i];
                $this->digitalTracks[$i]['title']=$_POST['digitalTrackTitle'.$i];
            }

        } else if($this->productType == 'PhysicalMusic') {
            $this->digitalPhysicalCount = (int) $_POST['physicalTrackCount'];
            for($i=0; $i<$this->physicalMusicCount;$i++) {
                $this->physicalTracks[$i]=$_POST['physicalTrackTitle'.$i];
            }
        } else if($this->productType == 'PhysicalMerch') {
            if(isset($_POST['prodPhysMerchShip'])) {
                $this->shipping = $_POST['prodPhysMerchShip'];
            } else {
                throw new Exception('Product shipping price must be provided');
            }
            if(isset($_POST['prodPhysMerchUnlPurch']) && $_POST['prodPhysMerchUnlPurch']=='true') {
                $this->physicalMerchUnlimitedSales = true;
                if(isset($_POST['prodPhysMerchUnlSizeXS'])) {
                    $this->physicalMerchXS = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeS'])) {
                    $this->physicalMerchS = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeM'])) {
                    $this->physicalMerchM = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeL'])) {
                    $this->physicalMerchL = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeXL'])) {
                    $this->physicalMerchXL = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeXXL'])) {
                    $this->physicalMerchXXL = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeXXXL'])) {
                    $this->physicalMerchXXXL = -1;
                }
                if(isset($_POST['prodPhysMerchUnlSizeNA'])) {
                    $this->physicalMerchNA = -1;
                }
                if($this->physicalMerchNA==-1 && ($this->physicalMerchXS==-1 || $this->physicalMerchS==-1 || $this->physicalMerchM==-1 || $this->physicalMerchL==-1 ||  $this->physicalMerchXL==-1 || $this->physicalMerchXXL==-1 || $this->physicalMerchXXXL==-1 || $this->physicalMerchNA==-1)) {
                    throw new Exception("NA is set, cannot have any size information1");
                }
                if($this->physicalMerchNA != -1 && $this->physicalMerchXS!=-1 && $this->physicalMerchS!=-1 && $this->physicalMerchM!=-1 && $this->physicalMerchL!=-1 &&  $this->physicalMerchXL!=-1 && $this->physicalMerchXXL!=-1 && $this->physicalMerchXXXL!=-1 && $this->physicalMerchNA!=-1) {
                    throw new Exception("No sizes selected for unlimited");
                }
            } else {
                if(isset($_POST['prodPhysMerchSizeXS']) && $_POST['prodPhysMerchSizeXS']>0) {
                    $this->physicalMerchXS = $_POST['prodPhysMerchSizeXS'];
                } else {
                    $this->physicalMerchXS = 0;
                }
                if(isset($_POST['prodPhysMerchSizeS']) && $_POST['prodPhysMerchSizeS']>0) {
                    $this->physicalMerchS = $_POST['prodPhysMerchSizeS'];
                } else {
                    $this->physicalMerchS = 0;
                }
                if(isset($_POST['prodPhysMerchSizeM']) && $_POST['prodPhysMerchSizeM']>0) {
                    $this->physicalMerchM = $_POST['prodPhysMerchSizeM'];
                } else {
                    $this->physicalMerchM = 0;
                }
                if(isset($_POST['prodPhysMerchSizeL']) && $_POST['prodPhysMerchSizeL']>0) {
                    $this->physicalMerchL = $_POST['prodPhysMerchSizeL'];
                } else {
                    $this->physicalMerchL = 0;
                }
                if(isset($_POST['prodPhysMerchSizeXL']) && $_POST['prodPhysMerchSizeXL']>0) {
                    $this->physicalMerchXL = $_POST['prodPhysMerchSizeXL'];
                } else {
                    $this->physicalMerchXL = 0;
                }
                if(isset($_POST['prodPhysMerchSizeXXL']) && $_POST['prodPhysMerchSizeXXL']>0) {
                    $this->physicalMerchXXL = $_POST['prodPhysMerchSizeXXL'];
                } else {
                    $this->physicalMerchXXL = 0;
                }
                if(isset($_POST['prodPhysMerchSizeXXXL'])  && $_POST['prodPhysMerchSizeXXXL']>0) {
                    $this->physicalMerchXXXL = $_POST['prodPhysMerchSizeXXXL'];
                } else {
                    $this->physicalMerchXXXL = 0;
                }
                if(isset($_POST['prodPhysMerchSizeNA'])  && $_POST['prodPhysMerchSizeNA']>0) {
                    $this->physicalMerchNA = $_POST['prodPhysMerchSizeNA'];
                } else {
                    $this->physicalMerchNA = 0;
                }
                if($this->physicalMerchNA > 0  && ($this->physicalMerchXS > 0 || $this->physicalMerchS > 0 || $this->physicalMerchM > 0 || $this->physicalMerchL > 0 ||  $this->physicalMerchXL > 0 || $this->physicalMerchXXL > 0 || $this->physicalMerchXXXL > 0 || $this->physicalMerchNA > 0)) {
                    throw new Exception("NA is set, cannot have any size information2");
                }
                if($this->physicalMerchNA <= 0 && $this->physicalMerchXS <= 0 && $this->physicalMerchS <= 0 && $this->physicalMerchM <= 0 && $this->physicalMerchL <= 0 &&  $this->physicalMerchXL <= 0 && $this->physicalMerchXXL <= 0 && $this->physicalMerchXXXL <= 0 && $this->physicalMerchNA!=-1) {
                    throw new Exception("No sizes selected");
                }
            }
        }

        //sale block
        if(isset($_POST['decrement']) && $_POST['decrement']!='') {
            $this->decrement = str_replace('$', '', $_POST['decrement']);
        } else {
            throw new Exception('Deducted per purchase value must be provided');
        }
        if(isset($_POST['lowPrice'])) {
            $this->lowPrice = $_POST['lowPrice'];
        } else {
            throw new Exception('Lowest price must be provided');
        }
        if(isset($_POST['startPrice'])) {
            $this->startPrice = $_POST['startPrice'];
        } else {
            throw new Exception('Start price must be provided');
        }
        if(isset($_POST['saleEnd'])) {
            $this->saleEnd = $_POST['saleEnd'];
        } else {
            throw new Exception('Sale end date must be provided');
        }
        if(isset($_POST['backgroundId'])) {
            $this->backgroundId = $_POST['backgroundId'];
        } else {
            throw new Exception('Background image id must be provided');
        }
        
        if(isset($_POST['accentColor'])) {
            $this->accentColor = $_POST['accentColor'];
        } else {
            throw new Exception('Accent Color id must be provided');
        }

        return true;
    }

    public function process() {
        $myAccount = new account($this->db);
        $myArtist = new artist($this->db);
        $myProduct = new product($this->db);
        $mySale = new sale($this->db);

        $this->db->beginTran();

        if($this->mode=="new") {
            try {
                $accountId = $myAccount->create('manager', $this->email, $this->password, $this->firstName, $this->lastName);
            } catch (Exception $e) {
                $this->db->rollback();
                throw new Exception($e->getMessage());
            }
        } else {
            $accountId = parent::userId();
            $myAccount->read($accountId);
            $this->email = $myAccount->getEmail();
            $this->firstName = $myAccount->getFirstName();
            $this->lastName = $myAccount->getLastName();
            if($this->mode=='customer' || $this->mode=='fan') {
                $myAccount->setAccountType('manager');
                $_SESSION['userAccountType'] = 'manager';
                $myAccount->save();
            }
        }
        if($accountId <= 0) {
            throw new Exception('Could not create artist');
            return false;
        }
        if($this->mode=='band') {
            $myArtist->readByManagerId($accountId);
            $artistId = $myArtist->getId();
        } else {
            try {
                $artistId = $myArtist->createArtist($accountId, $this->artistName, $this->website);
            } catch (Exception $e) {
                $this->db->rollback();
                throw new Exception($e->getMessage());
            }
        }

        if($artistId <= 0) {
            throw new Exception('Could not create artist');
            return false;
        }
            
        $myProduct->setArtistId($myArtist->getId());
        $myProduct->setImageId($this->productImageId);
        $myProduct->setName($this->productName);
        $myProduct->setType($this->productType);
        $this->zippedAlbumTitle = 'Albums/'.$myArtist->getArtistName().' - '.$myProduct->getName().' _'.  rand(100000, 999999).'.zip';
        $myProduct->setAlbumPath($this->zippedAlbumTitle);

        $myProduct->save();
        if($myProduct->getId() <= 0) {
            $this->db->rollback();
            throw new Exception("Product could not be created");
            return false;
        }

        if($this->productType=='DigitalMusic') {
            for($i=0; $i<=$this->digitalMusicCount; $i++) {
                if($this->digitalTracks[$i]['attachmentId'] > 0 ) {
                    $myDigitalMusic = new digitalMusic($this->db);
                    $myDigitalMusic->setAttachmentId($this->digitalTracks[$i]['attachmentId']);
                    $myDigitalMusic->setTrackTitle($this->digitalTracks[$i]['title']);
                    $myDigitalMusic->setTrackNumber($i+1);
                    $myDigitalMusic->setProductId($myProduct->getId());
                    $myDigitalMusic->save();
                    $myAttachment = new attachment($this->db);
                    $myAttachment->read($this->digitalTracks[$i]['attachmentId']);
                    $myAttachment->setDtExpires(0);
                    $myAttachment->save();
                }
            }
            // zip the album
            $zip = new ZipArchive;
            $res = $zip->open($this->zippedAlbumTitle, ZipArchive::CREATE); // test.zip is the file name
            if ($res === TRUE) {
                for($i=0; $i<=$this->digitalMusicCount; $i++) {
                    if($this->digitalTracks[$i]['attachmentId'] > 0 ) {
                        $myAttachment = new attachment($this->db);
                        $myAttachment->read($this->digitalTracks[$i]['attachmentId']);
                        $zip->addFile($myAttachment->getPath(), $this->digitalTracks[$i]['title']. ' - ' . $myArtist->getArtistName().'.mp3');
                    }
                }
                $zip->close();
                
            } else {
                throw new Exception('failed to create zip archive');
            }            
        } else if($this->productType == 'PhysicalMusic') {
            $myPhysicalMusic = new physicalMusic($this->db);
            for($i=0; $i<$this->physicalMusicCount; $i++) {
                $myPhysicalMusic = new physicalMusic($this->db);
                $myPhysicalMusic->setTrackTitle($this->digitalTracks[$i]['title']);
                $myPhysicalMusic->setTrackNumber($i+1);
                $myPhysicalMusic->setProductId($myProduct->getId());
            }
        } else if($this->productType == 'PhysicalMerch') {
            $myPhysicalMerch = new physicalMerch($this->db);
            if($this->physicalMerchNA) {
                $myPhysicalMerch->setNA($this->physicalMerchNA);
            } else {
                $myPhysicalMerch->setXS($this->physicalMerchXS);
                $myPhysicalMerch->setS($this->physicalMerchS);
                $myPhysicalMerch->setM($this->physicalMerchM);
                $myPhysicalMerch->setL($this->physicalMerchL);
                $myPhysicalMerch->setXL($this->physicalMerchXL);
                $myPhysicalMerch->setXXL($this->physicalMerchXXL);
                $myPhysicalMerch->setXXXL($this->physicalMerchXXXL);

            }
            $myPhysicalMerch->save();
        } else {
            $this->db->rollback();
            throw new Exception("Invalid sale type");
        }

        try {
            $mySale->setArtistId($myArtist->getId());
            $mySale->setProductId($myProduct->getId());
            $mySale->setDecrement($this->decrement);
            $mySale->setLowPrice($this->lowPrice);
            $mySale->setSaleEnd($this->saleEnd);
            $mySale->setStartPrice($this->startPrice);
            $mySale->setBackgroundId($this->backgroundId);
            $mySale->setLogoId($this->backgroundId); // set the same as background temporarliy even though we dont use it anymore
            $mySale->setAccentColor($this->accentColor);
            $mySale->save();
        } catch (Exception $e) {
            $this->db->rollback();
            throw new Exception($e->getMessage());
            return false;
        }
        if($mySale->getId() <= 0) {
            $this->db->rollback();
            throw new Exception("Sale could not be created");
            return false;
        }
        if($this->mode == 'new') {
            parent::login(false, $myAccount->getId());
        }
        // resize images
        $myProduct->optimizeBackgroundImage($mySale->getBackground());
        $myProduct->optimizeProductImage($myProduct->getProductImg());
        
        // sending the email
        $this->saleId = $mySale->getId();
        $emailTemplates = new emailTemplates;
        
        $emailTemplates->sendMail_Band_CreatedSale($this->email, $this->productName, $this->saleId);

        $this->db->commit();

        return $mySale->getId();
    }

}

?>