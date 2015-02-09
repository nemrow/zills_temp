<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('DataClasses/account.php');
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

class ResetPassword extends RequestHandlerBase {
    private $email;
    private $newPassword;
    private $firstName;
    private $lastName;
    private $emailTemplate;

    public function auth() {
        return true;
    }
    

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = $data['email'];
        return true;
    }
   
    public function process() {
        function md5_pass($length = 8){
            return substr(md5(rand().rand()), 0, $length);
        }
        $this->newPassword = md5_pass();
        
        $myAccount = new account($this->db);
        $myAccount->readByEmail($this->email);
        $this->firstName = $myAccount->getFirstName();
        $this->lastName = $myAccount->getLastName();
        $myAccount->setPassword($this->newPassword);
        $myAccount->save();
        
        $emailTemplate = new emailTemplates;
        $emailResponse = $emailTemplate->sendSingleEmail($this->email, 'Staff@Zillionears.com', 'Change Your Password', 'Hey '.$this->firstName, "Looks like it's time for a change... in password", "We have created a temporary password for you. Please go into your admin panel after logging in and change your password to something cooler! Your new temporary password is <strong>".$this->newPassword."</strong>. Please login and then change your password!", "Zillionears Team");
        return $emailResponse;
 
    }

}

?>