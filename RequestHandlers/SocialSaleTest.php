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

class SocialSaleTest extends RequestHandlerBase {
    private $exceptionThrown=false;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        parent::startSession();
        // account block
        /*if(parent::loggedIn()) {
            $myAccount = new account($this->db);
            $myAccount->read(parent::userId());

            $_SESSION['socialsaletest']['email'] = $myAccount->getEmail();
            $_SESSION['socialsaletest']['firstName'] = $myAccount->getFirstName();
            $_SESSION['socialsaletest']['lastName'] = $myAccount->getLastName();
        } else {
            if(isset($_POST['email'])) {
                $_SESSION['socialsaletest']['email'] = $_POST['email'];
            } else {
                throw new Exception("Email must be provided");
            }
            if(isset($_POST['firstName'])) {
            $_SESSION['socialsaletest']['firstName'] = $_POST['firstName'];
            } else {
                throw new Exception("First Name must be provided");
            }

            if(isset($_POST['lastName'])) {
                 $_SESSION['socialsaletest']['lastName'] = $_POST['lastName'];
            } else {
                throw new Exception("Last Name must be provided");
            }
            $this->accountType = 'manager';
        }*/


        // artist block
        if(parent::userAccountType()!='manager' || !parent::loggedIn()) {
            if(isset($_POST['artistName'])) {
                $_SESSION['socialsaletest']['artistName'] = $_POST['artistName'];
            } else {
                $this->exceptionThrown = true;
                throw new Exception('Artist Name must be provided');
            }
        } else {
            $myArtist = new artist($this->db);
            $myArtist->readByManagerId(parent::userId());
            $_SESSION['socialsaletest']['artistName'] = $myArtist->getArtistName();
        }

        //product block
        if(isset($_POST['productDescription'])) {
            $_SESSION['socialsaletest']['productDescription']  = $_POST['productDescription'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Product Description must be provided');
        }
        if(isset($_POST['productName'])) {
            $_SESSION['socialsaletest']['productName'] = $_POST['productName'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Product Name must be provided');
        }
        if(isset($_POST['productType'])) {
            if($_POST['productType']=='Physical Music' || $_POST['productType']=='PhysicalMusic') {
                $_SESSION['socialsaletest']['productType'] = 'Physical Music';
            } else if($_POST['productType']=='Physical Merch' || $_POST['productType']=='PhysicalMerch') {
                $_SESSION['socialsaletest']['productType'] = 'Physical Merch';
            } else if($_POST['productType']=='Digital Music' || $_POST['productType']=='digitalMusic' || $_POST['productType']=='DigitalMusic') {
                $_SESSION['socialsaletest']['productType'] = 'Digital Music';
            } else {
                $this->exceptionThrown = true;
                throw new Exception('Invalid Product Type');
            }
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Product Type must be provided');
        }
        if(isset($_POST['productImageId'])) {
            $_SESSION['socialsaletest']['productImageId'] = $_POST['productImageId'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Product Image Id must be provided');
        }

        /*if($this->productType == 'DigitalMusic') {
            $this->digitalMusicCount = (int) $_POST['digitalTrackCount'];

            for($i=0; $i<$this->digitalMusicCount;$i++) {
                $this->digitalTracks[$i]['attachmentId']=$_POST['digitalTrackTitleIds'.$i];
                $this->digitalTracks[$i]['title']=$_POST['digitalTrackTitle'.$i];
            }

        } else if($this->productType == 'PhysicalMusic') {
            $this->digitalPhysicalCount = (int) $_POST['physicalTrackCount'];
            for($i=0; $i<$this->physicalMusicCount;$i++) {
                $this->physicalTracks[$i]=$_POST['physicalTrackTitle'.$i];
            }
        } else if($this->productType == 'PhysicalMerch') {
            if(isset($_POST['prodPhysMusShip'])) {
                $this->shipping = $_POST['prodPhysMusShip'];
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
                    throw new Exception("No sizes selected");
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
        }*/

        //sale block
        if(isset($_POST['decrement']) && $_POST['decrement']!='') {
            $_SESSION['socialsaletest']['decrement'] = str_replace('$', '', $_POST['decrement']);
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Deducted per purchase value must be provided');
        }
        if(isset($_POST['lowPrice'])) {
            $_SESSION['socialsaletest']['lowPrice'] = $_POST['lowPrice'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Lowest price must be provided');
        }
        if(isset($_POST['startPrice'])) {
            $_SESSION['socialsaletest']['startPrice'] = $_POST['startPrice'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Start price must be provided');
        }
        if(isset($_POST['saleEnd'])) {
            $_SESSION['socialsaletest']['saleEnd'] = $_POST['saleEnd'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Sale end date must be provided');
        }
        if(isset($_POST['backgroundId'])) {
            $_SESSION['socialsaletest']['backgroundId'] = $_POST['backgroundId'];
        } else {
            $this->exceptionThrown = true;
            throw new Exception('Background image id must be provided');
        }


        return true;
    }

    public function process() {
        if ($this->exceptionThrown) {
            return 'Error creating preview';
        } else {
            return 'success';
        }



    }

}

?>