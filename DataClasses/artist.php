<?php
require_once('Includes/DataClassBase.php');
class artist extends DataClassBase {

    public function getAccountId() {
        return $this->get('accountId');
    }

    public function setAccountId($id) {
        $this->set('accountId', $id);
    }

    public function getArtistName() {
        return $this->get('artistName');
    }

    public function setArtistName($name) {
        $this->set('artistName', $name);
    }

    public function getWebsite() {
        return $this->get('website');
    }

    public function setWebsite($website) {
        $this->set('website', $website);
    }

    public function getPaypal() {
        return $this->get('paypal');
    }

    public function setPaypal($paypal) {
        $this->set('paypal', $paypal);
    }

    public function getAddress() {
        return $this->get('address');
    }

    public function setAddress($address) {
        $this->set('address', $address);
    }

    public function getCity() {
        return $this->get('city');
    }

    public function setCity($city) {
        $this->set('city', $city);
    }

    public function getState() {
        return $this->get('state');
    }

    public function setState($state) {
        $this->set('state', $state);
    }

    public function getZip() {
        return $this->get('zip');
    }

    public function setZip($zip) {
        $this->set('zip', $zip);
    }

    public function __construct ($db) {
        $this->tableName='artist';
        $this->tableType='Artist';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='accountId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='artistName';
        $this->colTypes[$this->colCount++]='string150';

        $this->colNames[$this->colCount]='website';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='paypal';
        $this->colTypes[$this->colCount++]='string200';

        $this->colNames[$this->colCount]='address';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='city';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='state';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='zip';
        $this->colTypes[$this->colCount++]='string10';

        parent::__construct($db);
    }

    public function createArtist($accountId, $artistName, $website) {
        /*if($this->artistExists($artistName)) {
            throw new Exception('Artist already exists');
        }*/

        $this->setAccountId($accountId);
        $this->setArtistName($artistName);
        $this->setWebsite($website);
        $this->save();

        if($this->getId() <= 0) {
            throw new Exception("Artist could not be created");
        }
        return $this->getId();
    }

    public function artistExists($artistName) {
        $sql = "SELECT count(id) FROM artist where `artistName`=\"$artistName\"";
        return $this->db->queryCount($sql) > 0;
    }

    public function readByManagerId($userId) {
        parent::readByKeyValue('accountId', $userId);
    }
    
    public function getRecipientToken($artistId){
        $return = '';
        $query = "SELECT rr.tokenid
        FROM `recipientrequest` rr
        INNER JOIN `artist` art
        ON art.accountid = rr.userid
        WHERE art.id = '$artistId'
        AND rr.status = 'SR'";
        $result = $this->db->query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $return = $row['tokenid'];
        }
        return $return;
    }
    
    public function countRecipientToken($userid) {
            $query = "SELECT count(r.tokenId)
            FROM `recipientrequest` r
            WHERE r.userid = '$userid'
            AND r.status = 'SR'";
            $result = $this->db->queryCount($query);
            
            return $result;
    }
    
}
?>
