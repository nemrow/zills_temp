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
require_once('PHPMailer/class.phpmailer.php');
require_once('SendGrid/SendGrid.php');
require_once('SendGrid/SendGrid_loader.php');

class FanSignUpConfirmation extends RequestHandlerBase {
    private $email;

    public function auth() {
        return true;
    }
    

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = 'nemrowj@gmail.com';
        return true;
    }
   
    public function process() {
        
    $sendgrid = new SendGrid('zillionears', 'xJ&824Fm');
            
    $mail = new SendGrid\Mail();
    $mail->
    addTo('nemrowj@gmail.com')->
    setFrom('staff@zillionears.com')->
    setSubject('Subject goes here')->
    setText('Hello World!');
    
    $sendgrid->
    smtp->
    send($mail);
 
    }

}

?>