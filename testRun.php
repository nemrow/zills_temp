<?php
date_default_timezone_set('America/Los_Angeles');
if(__DIR__!= '/home/jamesmcguire/zillionears.com/public_html'){ // if not on live server
    require_once('C:/Dropbox/Zills with Dan/jameslive/config.php'); // grab config from computer
}else{
    require_once('/home/jamesmcguire/zillionears.com/config.php'); //grab from server
}
require_once('Includes/emailTemplates.php');
require_once('DataClasses/order.php');
require_once('Includes/CaptureSalesHelper.php');
require_once('Includes/CronJobHelper.php');

$emailTemplates = new emailTemplates;
$emailTemplates->sendMail_Band_SaleOver('nemrowj@gmail.com', 'MY PO', 2.01, 10, 9);


    
    

?>
