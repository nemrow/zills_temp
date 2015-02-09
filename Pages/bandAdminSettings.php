<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');

class bandadminsettings extends pageBase {
    private $artistName;
    private $email;
    private $firstName;
    private $lastName;
    private $paypalEmail;
    private $eCheck;
    private $errorMessage;



    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Band Admin Panel";
        $this->currentPage = 'bandadminsettings';
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminSettings');
        }
        if(parent::userAccountType()!='manager') {
            parent::redirect('fanAdminSettings');
        }


        $myArtist = new artist($this->db);
        $myAccount = new account($this->db);
        $myAccount->read(parent::userId());
        $myArtist->readByManagerId(parent::userId());

        if(isset($data) && count($data)>0) {
            if(!isset($data['artistName']) || strlen($data['artistName'])==0) {
                $this->errorMessage = "Please specify an artist name";
            }
            if(!isset($data['firstName']) || strlen($data['firstName'])==0) {
                $this->errorMessage = "Please specify a first name";
            }

            if(!isset($data['lastName']) || strlen($data['lastName'])==0) {
                $this->errorMessage = "Please specify a last name";
            }

            if(!isset($data['email']) || strlen($data['email'])==0) {
                $this->errorMessage = "Please specify an email";
            }

            if((!isset($data['paypalEmail']) || strlen($data['paypalEmail'])==0) && !isset($data['eCheck'])) {
                $this->errorMessage = "Please specify a paypal email or select e-Check";
            }

            if(!isset($data['password']) || strlen($data['password'])==0) {
                $this->errorMessage = "Please specify a password";
            }

            if(!isset($data['confirm_password']) || strlen($data['confirm_password'])==0) {
                $this->errorMessage = "Please confirm your password";
            }

            if($data['confirm_password']!=$data['password']) {
                $this->errorMessage = "The passwords do not match";
            }

            if(!isset($this->errorMessage) && strlen($this->errorMessage)==0) {
                try {
                    $myAccount->setFirstName($data['firstName']);
                    $myAccount->setLastName($data['lastName']);
                    $myAccount->setEmail($data['email']);
                    $myAccount->setPassword($data['password']);
                    $myArtist->setArtistName($data['artistName']);

                    if(array_key_exists('eCheck', $data)) {
                        $myArtist->seteCheck($data['eCheck']==1);
                    } else {
                        $myArtist->seteCheck(false);

                    }
                    if(array_key_exists('paypalEmail', $data)) {
                        $myArtist->setPaypal($data['paypalEmail']);
                    }

                    $myArtist->save();
                } catch (Exception $e) {
                    $this->errorMessage = $e->getMessage();

                }
            }
        }

        $this->artistName = (isset($data['artistName']) ? $data['artistName']  :  $myArtist->getArtistName());
        $this->email = (isset($data['email']) ? $data['email']  :  $myAccount->getEmail());
        $this->firstName = (isset($data['firstName']) ? $data['firstName']  :  $myAccount->getFirstName());
        $this->lastName = (isset($data['lastName']) ? $data['lastName']  :  $myAccount->getLastName());
        $this->eCheck = (isset($data['eCheck']) ? $data['eCheck'] : $myArtist->geteCheck());
        if($this->eCheck) {
            $this->paypalEmail = 'E-Check';
        } else {
            $this->paypalEmail = (isset($data['paypalEmail']) ? $data['paypalEmail'] : $myArtist->getPaypal());
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
        require_once('templates/bandAdminSettings.html');
        return true;
    }

}

?>
