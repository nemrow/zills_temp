<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}
class sale extends DataClassBase {

    public function getArtistId() {
        return $this->get('artistId');
    }

    public function setArtistId($id) {
        $this->set('artistId', $id);
    }

    public function getProductId() {
        return $this->get('productId');
    }

    public function setProductId($id) {
        $this->set('productId', $id);
    }

    public function getStartPrice() {
        return $this->get('startPrice');
    }

    public function setStartPrice($price) {
        $this->set('startPrice', $price);
    }

    public function getLowPrice() {
        return $this->get('lowPrice');
    }

    public function setLowPrice($price) {
        $this->set('lowPrice', $price);
    }

    public function getDecrement() {
        return $this->get('decrement');
    }

    public function setDecrement($decrement) {
        $this->set('decrement', $decrement);
    }

    public function getSaleEnd() {
        return $this->get('saleEnd');
    }

    public function setSaleEnd($date) {
        $this->set('saleEnd', $date);
    }

    public function getLogoId() {
        return $this->get('logoId');
    }

    public function setLogoId($id) {
        $this->set('logoId', $id);
    }

    public function getBackgroundId() {
        return $this->get('backgroundId');
    }

    public function setBackgroundId($id) {
        $this->set('backgroundId', $id);
    }
    
    public function getAccentColor() {
        return $this->get('accentColor');
    }

    public function setAccentColor($color) {
        $this->set('accentColor', $color);
    }

    public function getEmailMessage() {
        return $this->get('emailMessage');
    }

    public function setEmailMessage($email) {
        $this->set('emailMessage', $email);
    }
    
    public function getShareCount() {
        return $this->get('shareCount');
    }

    public function setShareCount($count) {
        $this->set('shareCount', $count);
    }

    public function __construct ($db) {
        $this->tableName='sale';
        $this->tableType='sale';
        // $this->readOnly = true;

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='artistId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='productId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='startPrice';
        $this->colTypes[$this->colCount++]='price';

        $this->colNames[$this->colCount]='lowPrice';
        $this->colTypes[$this->colCount++]='price';

        $this->colNames[$this->colCount]='decrement';
        $this->colTypes[$this->colCount++]='double';

        $this->colNames[$this->colCount]='saleEnd';
        $this->colTypes[$this->colCount++]='date';

        $this->colNames[$this->colCount]='logoId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='backgroundId';
        $this->colTypes[$this->colCount++]='int';
        
        $this->colNames[$this->colCount]='accentColor';
        $this->colTypes[$this->colCount++]='text';

        $this->colNames[$this->colCount]='emailMessage';
        $this->colTypes[$this->colCount++]='text';
        
        $this->colNames[$this->colCount]='shareCount';
        $this->colTypes[$this->colCount++]='int';

        parent::__construct($db);
    }

    public function getLogo() {
        $attachment = new Attachment($this->db);
        $attachment->read($this->getLogoId());

        return $attachment->getPath();
    }

    public function getBackground() {
        $attachment = new Attachment($this->db);
        $attachment->read($this->getBackgroundId());
        return $attachment->getPath();
    }

    public function getCurrentPrice() {
        // stops the price from going below the Lowest Possibl Price
        $unpluggedPrice = ceil(($this->getStartPrice() - $this->getDecrement()*$this->getNumBuyins())*100)/100;
        if($unpluggedPrice > $this->getLowPrice()){
            return $unpluggedPrice;
        } else {
            return $this->getLowPrice();
        }
    }

    public function getSaleOver() {
        return time() > $this->getSaleEnd();
    }

    public function getNumBuyins() {
        $query = "SELECT count(id) FROM `order` WHERE `saleId`=\"{$this->getId()}\" AND status IN (\"AUTHORIZED\", \"CAPTURED\", \"SC\")";
        $result = $this->db->query($query);
        $line = $this->db->fetchRow($result);
        return $line[0];
    }
    
    public function getNumSuccessfulCaptures() {
        $query = "SELECT count(id) FROM `order` WHERE `saleId`=\"{$this->getId()}\" AND status = \"CAPTURED\"";
        $result = $this->db->query($query);
        $line = $this->db->fetchRow($result);
        return $line[0];
    }

    public function getSaleIdsByUser($userId) {
        $query = "SELECT o.id, s.id FROM `order` o ";
        $query .= "INNER JOIN `sale` s ON s.id = o.saleId ";
        $query .= "WHERE o.`userId`=\"$userId\" ";
        $query .= "ORDER BY 1 DESC";

        //echo $query;
        $result = $this->db->query($query);
        $i=0;
        if($this->db->resultSize($result)>0) {
            while($line = $this->db->fetchRow($result)) {
                $array[$i][0]= $line[0];
                $array[$i++][1]= $line[1];
            }
        } else {
            $array = Array();
        }

        return $array;
    }

    public function getSaleIdsByManager($managerId) {
        $query = "SELECT s.id FROM `sale` s ";
        $query .= "INNER JOIN `artist` a ON a.id = s.artistId ";
        $query .= "WHERE a.`accountid`=\"$managerId\" ";
        $query .= "ORDER BY 1 DESC";


        $result = $this->db->query($query);
        $i=0;
        if($this->db->resultSize($result)>=1) {
            while($line = $this->db->fetchRow($result)) {
                $array[$i++]= $line[0];
            }
        } else {
            $array = Array();
        }

        return $array;
    }

    public function getFanList($saleId) {
        $query = "SELECT concat(a.firstName,\" \",a.LastName), a.email, o.maxPrice, cbr.zip ";
        $query .= "FROM `order` o ";
        $query .= "INNER JOIN `account` a ON a.id = o.userId ";
        $query .= "INNER JOIN `cbrequest` cbr ON cbr.userId = o.userId ";
        $query .= "WHERE o.`saleId`=\"$saleId\" ";
        $query .= "AND cbr.saleId = $saleId ";
        $query .= "ORDER BY 1 DESC";

        $result = $this->db->query($query);
        $i=0;
        if($this->db->resultSize($result)>=1) {
            while($line = $this->db->fetchRow($result)) {
                $array[$i][0]= $line[0];
                $array[$i][1]= $line[1];
                $array[$i][2]= $line[2];
                $array[$i++][3]= $line[3];
            }
        } else {
            $array = Array();
        }

        return $array;
    }

    public function userAuthorized($userId) {
        $query = "SELECT count(acc.id) ";
        $query .= "FROM `sale` s";
        $query .= "INNER JOIN `artist` art on s.artistid = art.id";
        $query .= "INNER JOIN `account` acc on acc.id = art.accountid ";
        $query .= "WHERE acc.id=$userId";

        $result = $this->db->query($query);
        $line = $this->db->fetchRow($result);
        return $line[0];
    }

    public function getSaleEndForCountdown() {
               // timezone, year, month, - 1, date
        $saleEnd = $this->getSaleEnd();

        $time = SERVERTIMEZONE . ', ';
        $time .= date('Y', $saleEnd) . ', ';
        $time .= date('n', $saleEnd) . ' - 1, ';
        $time .= date('j', $saleEnd);
        //return '-8, 2012,  8 - 1, 22';
        //echo date($saleEnd);
        return $time;
    }

    public function getThumbList() {
        $query = "SELECT a.path, o.id*0+RAND() as random_record ";
        $query .= "FROM `order` o ";
        $query .= "INNER JOIN `account` acc ON o.userid=acc.id ";
        $query .= "INNER JOIN `attachment` a ON acc.imageId = a.id ";
        $query .= "WHERE ";
        $query .= "o.saleId = ".$this->getId();
        $query .= " ORDER BY random_record ";
        $query .= " LIMIT 11 ";
        $result = $this->db->query($query);
        $i=0;
        if($this->db->resultSize($result)>0) {
            while($line = $this->db->fetchRow($result)) {
                $array[$i++]= $line[0];
            }
        } else {
            $array = Array();
        }
        return $array;
    }
    
    public function hasUserBoughtSale($userId) {
        if(parent::getId()>0) {
            $query = "SELECT count(id) FROM `order` WHERE `saleId`=".parent::getId()." AND `userId`={$userId}";
            return $this->db->queryCount($query);
        } else {
            throw new Exception("No sale loaded");
        }        
    }
}
?>
