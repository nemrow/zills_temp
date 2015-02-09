<?php
//require_once('Sendgrid/sendgrid-newsletter-lib.php');
//require_once('SendGrid/SendGrid.php');
//require_once('SendGrid/SendGrid_loader.php');
require_once('Includes/emailTemplates.php');
require_once('Includes/CaptureSalesHelper.php');
require_once ('DataClasses/sale.php');

class CreateEmailList{
    
    public function auth() {
        return true;
    }
    

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        //$this->email = $data['email'];
        return true;
    }
    
    public function process(){
       
        //$mySale->read(2022);
        //$mySale->getAccentColor();
        
        
        //$emailTemplates = new emailTemplates;
        //$result = $emailTemplates->sendSingleEmail('nemrowj@gmail.com', 'staff@zillionears.com', 'sbjecss1', 'head2', 'subhad3', 'cont4', 'sig5');
        //return $result;
        //return $result;
        
    }
}
?>
