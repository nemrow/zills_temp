<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}

class recipientRequest extends DataClassBase {

    public function getUserId() {
        return $this->get('userid');
    }

    public function setUserId($id) {
        $this->set('userid', $id);
    }

    public function getStatus() {
        return $this->get('status');
    }

    public function setStatus($status) {
        $this->set('status', $status);
    }

    public function getError() {
        return $this->get('error');
    }

    public function setError($error) {
        $this->set('error', $error);
    }

    public function getCallerRef() {
        return $this->get('callerref');
    }

    public function setCallerRef($callerRef) {
        $this->set('callerref', $callerRef);
    }

    public function getRefundToken() {
        return $this->get('refundtoken');
    }

    public function setRefundToken($refundToken) {
        $this->set('refundtoken', $refundToken);
    }
    public function getTokenId() {
        return $this->get('tokenId');
    }

    public function setTokenId($token) {
        $this->set('tokenId', $token);
    }

    public function __construct ($db) {
        $this->tableName='recipientrequest';
        $this->tableType='Amazon Recipient Request';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='userid';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='callerref';
        $this->colTypes[$this->colCount++]='string128';
        
        $this->colNames[$this->colCount]='refundtoken';
        $this->colTypes[$this->colCount++]='string128';

        
        $this->colNames[$this->colCount]='error';
        $this->colTypes[$this->colCount++]='text';
     
        $this->colNames[$this->colCount]='status';
        $this->colTypes[$this->colCount++]='string200';
        
        $this->colNames[$this->colCount]='tokenId';
        $this->colTypes[$this->colCount++]='string128';

        parent::__construct($db);
    }

    public function newCallerRef() {
        if($this->getCallerRef()!="" && $this->getCallerRef()!=-1) {
            throw new Exception ("Cannot override existing caller reference");
        }
        if($this->getId()<=0) {
            throw new Exception ("Must save recipient requestt before generateing caller reference");
        }

        $newRef = substr('RRequest'.$this->getId().parent::generateSHA512Salt(115), 0, 128);
        $this->setCallerRef($newRef);
        parent::saveWithOutUpdates();
    }
    
    public function newRefundId() {
        if($this->getRefundToken()!="" && $this->getRefundToken()!=-1) {
            throw new Exception ("Cannot override existing refund token");
        }
        if($this->getId()<=0) {
            throw new Exception ("Must save recipient request before generateing refund id");
        }

        $newRef = substr('RefRequest'.$this->getId().parent::generateSHA512Salt(115), 0, 128);
        $this->setRefundToken($newRef);
        parent::saveWithOutUpdates();
    }

    public function readByCallerReference($callerRef) {
        parent::readByKeyValue('callerref', $callerRef);
    }
    
    public function readArtistIdForRR($artistId) {
        $query = "SELECT rr.tokenId
            FROM `recipientrequest` rr
            INNER JOIN `artist` art
            ON art.accountId = rr.userid
            WHERE art.id = $artistId
            AND rr.status = 'SR'";
        
        $result = $this->db->query($query);
        
        if ($this->db->resultSize($result) != 1) {
                throw new Exception("Unable to read {$this->tableType} info");
        }
        
        $row = mysql_fetch_row($result);
        return $row[0];
    }
}
?>
