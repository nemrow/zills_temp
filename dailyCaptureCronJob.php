<?php

require_once('/home/jamesmcguire/zillionears.com/public_html/Includes/CaptureSalesHelper.php');
require_once('/home/jamesmcguire/zillionears.com/public_html/Includes/emailTemplates.php');
require_once ('/home/jamesmcguire/zillionears.com/config.php');

$CaptureSalesHelper = new CaptureSalesHelper;
$CaptureSalesHelper->captureSalesFromYesterday();



?>
