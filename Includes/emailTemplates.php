<?php

class emailTemplates{
    private $percentEncodeTake;
    private $urlStart = "http://sendgrid.com/api/";
    private $sendgridUser = 'zillionears';
    private $sendgridPass = 'longhairyandobsessed';
  
    
    public function sendSingleEmail($to, $from, $subject, $header, $subHeader, $content, $signature){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'mail.send.json?';
        $json .= 'to='.urlencode($to);
        $json .= '&from='.urlencode($from);
        $json .= '&fromname='.urlencode('Zillionears');
        $json .= '&subject='.urlencode($subject);
        $json .= '&html='.urlencode($emailTemplate->basicEmailTemplate($subject, $header, $subHeader, $content, $signature));
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON = json_decode($result, true);
        if($parseJSON['message']=='success'){
            return 'success';
        } else{
            return 'fail';
        }
    }
    
    public function addEmailToList($listName, $email, $lName_fName){ 
        $emailTemplates = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/lists/email/add.json?';
        $json .= 'list='.$listName;
        $json .= '&data=%7B%22email%22%3A%22'.urlencode($email);
        $json .= '%22%2C%22name%22%3A%22'.urlencode($lName_fName).'%22%7D';
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['inserted']==1){
            return 'success';
        } else{
            return 'fail';
        }
    }
    
    public function updateLetter($letterName, $subject, $header, $subHeader, $content, $signature){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/edit.json?';
        $json .= 'identity=The%20Zillionears%20Team';
        $json .= '&name='.$letterName.'&newname='.$letterName;
        $json .= '&subject='.urlencode($subject);
        $json .= '&html='.urlencode($emailTemplate->basicEmailTemplate($subject, $header, $subHeader, $content, $signature));
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['message']=='success'){
            return 'success';
        } else{
            return 'fail';
        }       
    }
    
    public function scheduleLetter($letterName, $date){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/schedule/add.json?';
        $json .= 'name='.$letterName;
        $json .= '&at='.urlencode(date("c",$date));
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['message']=='success'){
             return 'success';
        } else{
            return 'fail';
        }      
    }
    
    public function createList($listName){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/lists/add.json?';
        $json .= 'list='.$listName;
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['message']=='success'){
             return 'success';
        } else{
            return 'fail';
        }    
    }
    
    public function createLetter($identity, $name, $subject, $header, $subHeader, $content, $signature){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/add.json?';
        $json .= 'identity='.urlencode($identity);
        $json .= '&name='.urlencode($name);
        $json .= '&subject='.urlencode($subject);
        $json .= '&html='.urlencode($emailTemplate->basicEmailTemplate($subject, $header, $subHeader, $content, $signature));
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['message']=='success'){
            return 'success';
        } else{
            return 'fail';
        }   
    }
    
    public function combineListToLetter($letterName, $listName){
        $emailTemplate = new emailTemplates;
        $json = '';
        $json .= $this->urlStart;
        $json .= 'newsletter/recipients/add.json?';
        $json .= 'name='.$letterName;
        $json .= '&list='.$listName;
        $json .= '&api_user='.$this->sendgridUser.'&api_key='.$this->sendgridPass;
        $result = file_get_contents($json);
        $parseJSON =  json_decode($result, true);
        if($parseJSON['message']=='success'){
             return 'success';
        } else{
            return 'fail';
        } 
    }
   
    public function sendMail_Band_CreatedSale($email, $prodName, $saleId){
        $this->sendSingleEmail(
                $email, 
                'Staff@Zillionears.com', 
                'Sale Created', 
                'Sale Created!', 
                'Your Social Sale <i>'.$prodName.'</i> is up and running!', 
                '<a href="www.zillionears.com/socialsale&id='.$saleId.'" style="color:#018f46">zillionears.com/socialsale&id='.$saleId.'</a><br/><br />Promote this sale with your fans to get the most out of your sale.<br /><br /><b>Sharing Tips:</b><ul><li style="margin-left:-10px; font-size:12px">Encourage your fans to check out the sale but don\'t be too pushy</li><li style="margin-left:-10px; font-size:12px">Maximum of 3 posts promoting the sale beginning, middle, end</li><li style="margin-left:-10px; font-size:12px">Post during the week, instead of the weekend, when possible</li></ul> Let me know if you have any questions.', 
                'Dan<br />DPolaske@Zillionears.com');
    }
    
    public function sendMail_Band_24Hours($email, $prodName, $saleId){
        $this->sendSingleEmail(
                $email, 
                'Staff@Zillionears.com', 
                '24 Hours Left', 
                'Sale ends in 24 hours!', 
                'Your Social Sale <i>'.$prodName.'</i> ends in 24 hours. Make sure you do some last minute promoting to ensure you get the most value out of this sale!', 
                '<a href="https://www.zillionears.com/socialsale&id='.$saleId.'" style="color:#018f46">zillionears.com/socialsale&id='.$saleId.'</a><br/><br />Cheers', 
                'Dan<br />DPolaske@zillionears.com');
    }
    
    public function sendMail_Fan_24Hours($email, $artistName, $currentPrice, $lowPrice, $saleId){
        $this->sendSingleEmail(
                $email, 
                'Staff@Zillionears.com', 
                '24 hours left',
                'Only 24 hours left!',
                'There\'s only 24 hours left in <i>'.$artistName.'</i>\'s Social Sale', 
                'That means only 24 hours left to drive that price down by sharing with your friends!<br /><br />The price is currently at $'.number_format(($currentPrice),2).', but can get down to $'.number_format(($lowPrice),2).'!<br /><br />Get out there and spread the word so that you save yourself some $$$!<br /><br /><a href="https://www.zillionears.com/socialsale&id='.$saleId.'" style="color:#018f46">zillionears.com/socialsale&id='.$saleId.'</a><br /><br />You will receive your music after the sale has ended and your billing info has been confirmed.', 'Jordan<br />JNemrow@zillionears.com');
    }
    
    public function sendMail_Band_SaleOver($email, $prodName, $finalPrice, $numBuyins, $successfulCaptures){
        $grossRev = $finalPrice*$successfulCaptures;
        $zillsCut = 0.00;  //(number_format($grossRev*0.05))+($successfulCaptures*0.25);
        $amznCut = (number_format($grossRev*0.05))+($successfulCaptures*0.05);
        $bandCut = $grossRev - ($zillsCut+$amznCut);
        $failedTrans = $numBuyins - $successfulCaptures;
        $failedTransSlice = '';
        if(number_format($successfulCaptures) != number_format($numBuyins)){
            $failedTransSlice = 'Failed transactions: '.$failedTrans.'<br><span style="font-size:10px">Some of your fans payments failed due to problems with their Amazon accounts. We will attempt to resolve them individually. They will not be able to download your music until payment is complete.</span><br />';
        }
        $this->sendSingleEmail(
                $email, 
                'Staff@Zillionears.com', 
                'End Of Sale', 
                'Chicka Chika Yeahhhh', 
                'Your Sale <i>'.$prodName.'</i> is over!', 
                'You can download a list of all your fans who participated in the sale including their names, emails, and zip codes in your <a href="http://www.zillionears.com/bandAdminSales" style="color:#018f46">artist dashboard.</a><br /><br />Here is your sale breakdown:<br /><br />Final sale price:  $'.number_format(($finalPrice),2).'<br /># of fans in sale: '.$numBuyins.'<br />'.$failedTransSlice.'Total sale revenue: $'.number_format(($grossRev),2).'<br />Our cut: $'.number_format(($zillsCut),2).'<br />Amazons cut: $'.number_format(($amznCut),2).'<br /><br />Finally your $$$$ = $'.number_format(($bandCut),2).'<br /><span style="font-size:10px">Amazon fees vary depending on individual customers payment methods</span><br /><br />Your money should show up in your amazon account shortly.<br /><br />You can view you amazon payments at <a href="https://payments.amazon.com" style="color:#018f46">payments.amazon.com</a><br /><br />Please let us know if you have not received your money or if you have any other questions.<br /><br />Thanks for doing a Social Sale with us, we would love to hear how your experience went so shoot us your number or give us a call.<br /><br />Thanks again,', 
                'Dan<br />dpolaske@zillionears.com<br />(916) 521-1306');
    }
    
    public function sendMail_Fan_SaleOver_Success($email, $artistName, $startPrice, $buyInPrice, $finalPrice){
        $percentSaved = number_format(((($startPrice-$finalPrice)/$startPrice)*100),2);
        $this->sendSingleEmail(
                $email,
                'Staff@Zillionear.com',
                'Social Sale Over',
                'Social Sale is over!', 
                'Your digital download from <i>'.$artistName.'</i> is ready!', 
                '<a href="http://www.zillionears.com/fanAdminSocialSales">Click here to get to your dashboard for your download.</a><br /><br />Here are the results for this Social Sale:<br /><br />Starting Price: $'.number_format(($startPrice),2).'<br />You got in at: $'.number_format(($buyInPrice),2).'<br>Final Price: <b>$'.$finalPrice.'</b><br />Savings of '.round(number_format(($percentSaved),2)).'%<br /><br />Your billing has successfully been charged <b>$'.number_format(($finalPrice),2).'</b>.<br /><br />Thanks again for checkin\' us out, we would love to hear how your experience was. Reply back, drop us your number or give me a call.<br /><br />On behalf of '.$artistName.', thanks for the support,', 'Jordan<br />(707) 849-6085<br />JNemrow@zillionears.com');
    }
    
    public function sendMail_Fan_SaleOver_Fail($email, $artistName, $finalPrice, $errorCode){
        $this->sendSingleEmail(
                $email,
                'Staff@Zillionear.com',
                'Purchase Failed',
                'Purchase Failed! $h!t...', 
                $artistName.'\'s is over, but the transaction failed!', 
                'When attempting to capture $'.$finalPrice.' from your amazon account for '.$artistName.'\'s sale, Amazon declined the transaction. The message we received about this transaction  is "'.$errorCode.'". Our staff has automatically been informed on this situation, and will contact you shortly. This could be caused by a frozen Amazon account on your end, or possibly a frozen Amazon account on the artists end.<br /><br />We apologize for any inconveniences, and we hope to resolve this soon. Feel free to say the "S.H." word as loud as you want... We are too.', 
                'Jordan<br />(707) 849-6085<br />JNemrow@zillionears.com');
    }

    public function sendMail_Fan_YourInSale($email, $prodName, $artistName, $currentPrice, $lowPrice, $saleId){
        $this->sendSingleEmail(
                $email,
                'Staff@Zillionears.com',
                "You bought ".$prodName.'!',
                'You\'re In!',
                "You've joined the rest of the cool kids in ".$artistName."'s Social Sale!",
                'Now the fun begins as you see the price you’ll pay continue to go down! You got in at $'.number_format(($currentPrice),2).', but it can get as low as $'.number_format(($lowPrice),2).'. Lets make it happen!<br /><br />To ensure the price you pay drops by the time the sale is over, make sure to share with your friends so everyone saves $$$!<br /><br /><a href="www.zillionears.com/socialsale&id='.$saleId.'" style="color:#018f46">zillionears.com/socialsale&id='.$saleId.'</a><br /><br />Thanks for supporting the music!',
                'Jordan<br />JNemrow@zillionears.com'
        );
    }
    
    public function basicEmailTemplate($subject, $header, $subHeader, $content, $signature){
        $template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>'.$subject.'</title><style type="text/css"> body {width: 100% !important; font-family:Arial, Helvetica, sans-serif;} body {-webkit-text-size-adjust: none;} table td {border-collapse: collapse;} .italicized{font-style:italic;}</style> </head> <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"><center><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tr><td align="center" valign="top"><table border="0" cellpadding="20" cellspacing="0" width="600px"><tr><td valign="top" align="left"><div mc:edit="std_content00"><h2 class="h2">'.$header.'</h2><h4 class="h4">'.$subHeader.'</h4><p>'.$content.'</p><i class="italicized">'.$signature.'</i><br /><img src="http://zillionears.com/images/logoForEmail.jpg" /></div></td></tr></table></td></tr></table></center></body></html>';
        return $template;
    }
    
    public function percentEncode($content){
        $percentEncodeFind = array("!","#","$","&","'","(",")","*","+",",","/",":",";","=","?","@","[","]"," ","<",">",'"',"{","}","%");
        $percentEncodeReplace = array("%21","%23","%24","%26","%27","%28","%29","%2A","%2B","%2C","%2F","%3A","%3B","%3D","%3f","%40","%5B","%5D","%20","%3C","%3E","%22","%7B","%7D","%25");
        $result = str_replace($percentEncodeFind, $percentEncodeReplace, $content);
        return $result;
    }
    
    public function basicPercentEncoder($content){
        $subject = $content;
        $encodeFind = array(' ',':','!',',',"'",'$');
        $encodeReplace = array('%20','%3A','%21','%2C','%27','%24');
        $result = str_replace($encodeFind, $encodeReplace, $subject);
        return $result;
    }
    
    public function make_thumb($src, $dest, $desired_width){

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }
    
}

?>
