<?php

require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');

class fanadminsettings extends pageBase {
    private $firstName;
    private $lastName;
    private $email;
    private $photo;
    private $errorMessage;
    //private $address1;
    //private $address2;
    //private $city;
    //private $state;
    //private $zip;

    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Fan Admin Panel";
        $this->currentPage = 'fanadminsettings';
        if(parent::userId()<=0) {
            parent::redirect('login');
        }

        $account = new account($this->db);

        $account->read(parent::userId());
        if(isset($data) && count($data)>0) {
            //print_r($data);
            if(!isset($data['firstName']) || strlen($data['firstName'])==0) {
                $this->errorMessage = "Please specify a first name";
            }

            if(!isset($data['lastName']) || strlen($data['lastName'])==0) {
                $this->errorMessage = "Please specify a last name";
            }

            if(!isset($data['email']) || strlen($data['email'])==0) {
                $this->errorMessage = "Please specify an email";
            }

            if(isset($data['password']) && strlen($data['password'])>0) {
                if(!isset($data['confirm_password']) || $data['confirm_password']=='' || strlen($data['confirm_password'])==0) {
                    $this->errorMessage = "Please confirm your password";
                }
                if($data['confirm_password']!=$data['password']) {
                    $this->errorMessage = "The passwords do not match";
                }
            }

            if(isset($data['profileImageId']) && $data['profileImageId']!='' && !is_numeric($data['profileImageId'])) {
                $this->errorMessage = "Invalid image specified";
            }
            
            if(strtolower($account->getEmail())!=strtolower($data['email']) && $account->emailExists($data['email'])) {
                $this->errorMessage = "Email already in use.";
            }


            if(!isset($this->errorMessage) && strlen($this->errorMessage)==0) {
                try {
                    $account->setFirstName($data['firstName']);
                    $account->setLastName($data['lastName']);
                    $account->setEmail($data['email']);
                    if($data['password']!='') {
                        $account->setPassword($data['password']);
                    }
                    if($data['profileImageId']!='') {
                        $account->setImageId($data['profileImageId']);
                    }
                    $account->save();
                } catch (Exception $e) {
                    $this->errorMessage = $e->getMessage();

                }
            }
            //$this->errorMessage = "User information updated";
        }

        $this->firstName = (isset($data['firstName']) ? $data['firstName']  :  $account->getFirstName());
        $this->lastName = (isset($data['lastName']) ? $data['lastName']  :  $account->getLastName());
        $this->email = (isset($data['email']) ? $data['email']  :  $account->getEmail());
        $this->recipientRegToken = '';

        try {
            $attachment = new attachment($this->db);
            $attachment->read($account->getImageId());
            $this->photo = $attachment->getPath();

        } catch (Exception $e) {
            // do nothing
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
        require_once('templates/fanAdminSettings.html');
        return true;
    }

}

?>
