<?php
date_default_timezone_set('America/Los_Angeles');
if(__DIR__ == '/home/jamesmcguire/zillionears.com/public_html'){
    require_once('/home/jamesmcguire/zillionears.com/public_html/Includes/CaptureSalesHelper.php');
    require_once('/home/jamesmcguire/zillionears.com/public_html/Includes/emailTemplates.php');
    require_once('/home/jamesmcguire/zillionears.com/public_html/DataClasses/sale.php');
    require_once ('/home/jamesmcguire/zillionears.com/config.php');
    
}else{
    require_once ('C:/Dropbox/Zills with Dan/jameslive/public_html/Includes/CaptureSalesHelper.php');
    require_once ('C:/Dropbox/Zills with Dan/jameslive/config.php');
    require_once ('C:/Dropbox/Zills with Dan/jameslive/public_html/Includes/emailTemplates.php');
    require_once ('C:/Dropbox/Zills with Dan/jameslive/public_html/DataClasses/sale.php');
}
  
$myCaptureSalesHelper = new CaptureSalesHelper;
   $myCaptureSalesHelper->send24HourAlertMail();


?>
