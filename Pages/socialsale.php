<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/product.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/recipientRequest.php');
require_once('facebook/src/facebook.php');
require_once('Amazon/CBUI/CBUIRecipientTokenPipeline.php');

class socialsale extends pageBase {
    private $myProduct;
    private $mySale;
    private $myArtist;
    private $myDigitalMusic;
    private $myPhysicalMusic;

    //page vars
    private $numBuyins;
    private $currentPrice;
    private $lowPrice;
    private $saleId;
    private $startPrice;
    private $trackListEnabled;
    private $trackList;
    private $productDescription;
    private $productTitle;
    private $productType;
    private $productImg;
    private $logoImg;
    private $backgroundImg;
    private $saleEndFormated;
    private $thumbs;
    private $website;
    private $saleExpired;
    private $accentColor;
    private $managerId;
    private $activated;
    private $amazonLink;
    private $artistAccountId;
    private $saleStatus;
    private $hasRecipientRegToken;

    private $id;

    public function init($data) {
        $saleId = 0; // init
        if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
            $saleId = (int)$_GET['id'];
            $this->id = (int)$_GET['id'];
        }
        if($saleId<=0) {
            throw new Exception("Sale not found");
            //return false;
        }
        $this->mySale = new Sale($this->db);
        $this->mySale->read($saleId);

        $this->myArtist = new Artist($this->db);
        $this->myArtist->read($this->mySale->getArtistId());


        $this->myProduct = new Product($this->db);
        $this->myProduct->read($this->mySale->getProductId());
        $this->myProduct->getName();
        
        $this->myAccount = new Account($this->db);
        $this->myAccount->read($this->myArtist->getAccountId());

        if($this->myProduct->getType()=='DigitalMusic') {
            $this->myDigitalMusic = new digitalMusic($this->db);
        } else if($this->myProduct->getType()=='PhysicalMusic') {
            $this->myPhysicalMusic = new physicalMusic($this->db);
        }

        $this->numBuyins = $this->mySale->getNumBuyins();
        $this->currentPrice = number_format($this->mySale->getCurrentPrice(),2);
        $this->lowPrice = number_format($this->mySale->getLowPrice(),2);
	$this->saleID = $this->mySale->getId();
        $this->artistAccountId = $this->myArtist->getAccountId();
        $this->startPrice = number_format($this->mySale->getStartPrice(),2);
        $this->productType = $this->myProduct->getProductType();
        $this->trackList = $this->getTrackList();
        $this->musicPaths = $this->getAllTrackURLs($this->myProduct->getId());
        $this->trackCount = $this->getTrackCount($this->myProduct->getId());
        $this->trackListEnabled = $this->myProduct->getType()!='PhysicalMerch' && $this->trackList != '';
        //$this->productDescription = $this->myProduct->getDescription();
        $this->productTitle =  $this->myProduct->getName();
        $this->productImg = $this->myProduct->getProductImg();
        //$this->logoImg = $this->mySale->getLogo();
        $this->accentColor = $this->mySale->getAccentColor();
        $attachment = new attachment($this->db);
        $attachment->read($this->mySale->getLogoId());
        $this->logoImgWidth = $attachment->getWidth();
        $this->logoImgHeight = $attachment->getHeight();
        $attachment->read($this->myProduct->getImageId());
        $this->productImgHeight = $attachment->getHeight();
        $this->productImgWidth = $attachment->getWidth();
        $this->artistName = $this->myArtist->getArtistName();
        $this->backgroundImg = $this->mySale->getBackground();
        $this->thumbs = $this->getThumbs($this->mySale->getThumbList());
        $this->saleEndFormated = $this->mySale->getSaleEndForCountdown();
        $this->saleExpired = time() >= $this->mySale->getSaleEnd();
        $this->website = $this->myArtist->getWebsite();
        $this->pageTitle = $this->myArtist->getArtistName()." | Social Sale";
	$this->artistName = $this->myArtist->getArtistName();
        $this->saleStatus = 'pendingReg'; // options will be pendingReg, pendingOther, active 
        $this->currentPage = 'SocialSale';
        //$this->hasActiveAmazonAccount = $this->myAccount->hasActiveAmazonAccount();
        $this->hasRecipientRegToken = $this->myArtist->countRecipientToken($this->myArtist->getAccountId());
       
        parent::header();
        
        if (!$this->hasRecipientRegToken > 0){//!$this->hasActiveAmazonAccount) { // need to make CBUI call to create link

            $myRecipientRequest = new recipientRequest($this->db);
            $myRecipientRequest->setUserId(parent::userId());
            $myRecipientRequest->save();
            $myRecipientRequest->newCallerRef();
            $myRecipientRequest->newRefundId();
            
            $pipeline = new Amazon_FPS_CBUIRecipientTokenPipeline(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
            
            if(stripos($_SERVER['SERVER_NAME'], 'www')===FALSE) {
               $domain = str_replace('www.', '', DOMAIN); 
	    } else {
                $domain = DOMAIN;
	    }
            
            if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
                $domain = str_replace('http://', 'https://', DOMAIN);
            }
            $pipeline->setMandatoryParameters($myRecipientRequest->getCallerRef(),
                    $domain . "/index.php?page=completeregister&id=$saleId", 0, 0, "TRUE");
            $pipeline->addParameter('callerReferenceRefund', $myRecipientRequest->getRefundToken());
           
            $pipeline->addParameter("cobrandingUrl", "https://zillionears.com/images/zillionearsLogoCoBrandAamazon.jpg");
            $pipeline->addParameter("cobrandingStyle", "logo");


            $this->amazonLink = $pipeline->getUrl();
        }
        
        return true;
    }

    public function header() {

        require_once('templates/socialsaleHeader.html');
        return true;
    }

    public function footer() {

        require_once('templates/socialsaleFooter.html');
        return true;
    }

    public function body() {
        require_once('templates/socialsale.html');
        return true;
    }

    private function getTrackList() {
        try {
            if($this->myProduct->getType() == 'PhysicalMusic') {
                $tracks = $this->myPhysicalMusic->getAllTracks($this->myProduct->getId());
            } else if ($this->myProduct->getType() == 'DigitalMusic') {
                $tracks = $this->myDigitalMusic->getAllTracks($this->myProduct->getId());
            } else {
                return '';
            }
            $return = '';
            $jPlayerNum = 1;
            foreach($tracks as $track) {
                $return .= '<div class="sosaTrack"><p>';
                $return .= $track['trackNumber'] . '. ';
                $return .= $track['trackTitle'].'</p><div class="jPLayerSpan"><div id="jquery_jplayer_'.$jPlayerNum.'"></div> <div id="jp_container_'.$jPlayerNum.'"> <ul class="jp-controls"> <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li> <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li> </ul> <div class="jp-no-solution"> <span>Update Required</span> To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>. </div> </div></div></div>';
                $jPlayerNum++;
            }
        } catch (Exception $e) {
            //Ignore
            return '';
        }

        return $return;
    }
    
    
    public function getAllTrackURLs($productId) {
            $return = '';
            $query = "SELECT dm.attachmentId, att.path, sa.id FROM `digitalmusic` dm, `attachment` att, `sale` sa WHERE att.id = dm.attachmentId AND dm.productId = sa.productId AND dm.productId = '{$productId}'";
            $result = $this->db->query($query);
            $jPlayerNum = 1;
            
            function encryptChars($input){
                $text = $input;
                $enc = '';
                $count = strlen($text);
                for($i=0;$i<$count;$i++){
                     $grabLetter = ord($text{$i});
                     if($grabLetter==49){$grabLetter = 50;}
                     else if($grabLetter==50){$grabLetter = 49;} 
                     else if($grabLetter==51){$grabLetter = 52;}
                     else if($grabLetter==52){$grabLetter = 51;}
                     else if($grabLetter==53){$grabLetter = 54;}
                     else if($grabLetter==54){$grabLetter = 53;}
                     else if($grabLetter==55){$grabLetter = 56;}
                     else if($grabLetter==56){$grabLetter = 55;}
                     else if($grabLetter==57){$grabLetter = 48;}
                     else if($grabLetter==48){$grabLetter = 57;}
                     $grabLetter = chr((int)$grabLetter); 
                     $enc = $enc.$grabLetter;      
                 };
                 $enc = substr($enc, 8, -4); // gets rid of "uploads/" from beginning and ".mp3" from the end.
                 $randoNum = rand(100000, 999999); // adds random number after the track name
                 return $enc.$randoNum;
            }
           // echo encryptChars("uploads/0000000000_shit.mp3");
            while ($row = mysql_fetch_assoc($result)) {
                $encryptedSong = encryptChars($row['path']);
                $return .= 'var encryptedSong'.$jPlayerNum.' = decryptSomeShit("'.$encryptedSong.'"); $("#jquery_jplayer_'.$jPlayerNum.'").jPlayer({ ready: function () { $(this).jPlayer("setMedia", { mp3: encryptedSong'.$jPlayerNum.' }); }, play: function() { $(this).jPlayer("pauseOthers"); }, swfPath: "js", supplied: "mp3", cssSelectorAncestor: "#jp_container_'.$jPlayerNum.'", wmode: "window" }).bind($.jPlayer.event.timeupdate, function(event) { if(event.jPlayer.status.currentTime > 30) { $(this).jPlayer("pause",0); }; });';
               $jPlayerNum++;
            }
        return $return;
    }
    
    
    
    public function getTrackCount($productId) {
            $query = "SELECT COUNT(dm.attachmentId) AS num FROM `digitalmusic` dm, `attachment` att, `sale` sa WHERE att.id = dm.attachmentId AND dm.productId = sa.productId AND dm.productId = '{$productId}'";
            $result = $this->db->query($query);
            $row = mysql_fetch_assoc($result);
            $numUsers = $row['num'];
        return $numUsers;
    }

    private function getThumbs($thumbsList) {
        $return = "";
        for($i=0; $i<count($thumbsList);$i++) {
            $return .= $this->getImg($thumbsList[$i]);
        }
        for($i=count($thumbsList); $i<11; $i++) {
            $j = rand(1, 11);
            $return .= $this->getImg("images/profileThumbs/stockFace{$j}.jpg");
        }


        return $return;
    }

    private function getImg($path) {
        return "<img src=\"$path\" />";
    }
    
    public function getRecipientToken($userid) {
            $query = "SELECT count(r.tokenId)
            FROM `recipientrequest` r
            WHERE r.userid = '$userid'
            AND r.status = 'SR'";
            $result = $this->db->queryCount($query);
            
            return $result;
    }

}

?>
