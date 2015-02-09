<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}

class cbRequest extends DataClassBase {

    public function getUserId() {
        return $this->get('userId');
    }

    public function setUserId($id) {
        $this->set('userId', $id);
    }

    public function getSaleId() {
        return $this->get('saleId');
    }

    public function setSaleId($id) {
        $this->set('saleId', $id);
    }

    public function getOrderId() {
        return $this->get('orderId');
    }

    public function setOrderId($id) {
        $this->set('orderId', $id);
    }

    public function getPrice() {
        return $this->get('price');
    }

    public function setPrice($price) {
        $this->set('price', $price);
    }

    public function getStatus() {
        return $this->get('status');
    }

    public function setStatus($id) {
        $this->set('status', $id);
    }

    public function getError() {
        return $this->get('error');
    }

    public function setError($error) {
        $this->set('error', $error);
    }

    public function getCallerRef() {
        return $this->get('callerRef');
    }

    public function setCallerRef($callerRef) {
        $this->set('callerRef', $callerRef);
    }

    public function getTokenId() {
        return $this->get('tokenId');
    }

    public function setTokenId($token) {
        $this->set('tokenId', $token);
    }

    public function getAddressName() {
        return $this->get('addressName');
    }

    public function setAddressName($name) {
        $this->set('addressName', $name);
    }

    public function getAddressLine1() {
        return $this->get('addressLine1');
    }

    public function setAddressLine1($line) {
        $this->set('addressLine1', $line);
    }

    public function getAddressLine2() {
        return $this->get('addressLine2');
    }

    public function setAddressLine2($line) {
        $this->set('addressLine2', $line);
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

    public function getCountry() {
        return $this->get('country');
    }

    public function setCountry($country) {
        $this->set('country', $country);
    }

    public function getPhoneNumber() {
        return $this->get('phoneNumber');
    }

    public function setPhoneNumber($number) {
        $this->set('phoneNumber', $number);
    }

    public function __construct ($db) {
        $this->tableName='cbrequest';
        $this->tableType='Amazon Request';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='userId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='saleId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='orderId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='price';
        $this->colTypes[$this->colCount++]='price';

        $this->colNames[$this->colCount]='callerRef';
        $this->colTypes[$this->colCount++]='string128';

        $this->colNames[$this->colCount]='tokenId';
        $this->colTypes[$this->colCount++]='string128';

        $this->colNames[$this->colCount]='status';
        $this->colTypes[$this->colCount++]='string200';

        $this->colNames[$this->colCount]='error';
        $this->colTypes[$this->colCount++]='text';

        $this->colNames[$this->colCount]='addressName';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='addressLine1';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='addressLine2';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='city';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='state';
        $this->colTypes[$this->colCount++]='string50';

        $this->colNames[$this->colCount]='zip';
        $this->colTypes[$this->colCount++]='string11';

        $this->colNames[$this->colCount]='country';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='phoneNumber';
        $this->colTypes[$this->colCount++]='string15';

        parent::__construct($db);
    }

    public function newCallerRef() {
        if($this->getCallerRef()!="" && $this->getCallerRef()!=-1) {
            throw new Exception ("Cannot override existing caller reference");
        }
        if($this->getId()<=0) {
            throw new Exception ("Must save CB request before generateing caller reference");
        }

        $newRef = substr('CBRequest'.$this->getId().parent::generateSHA512Salt(115), 0, 128);
        $this->setCallerRef($newRef);
        parent::saveWithOutUpdates();
    }

    public function readByCallerReference($callerRef) {
        parent::readByKeyValue('callerRef', $callerRef);
    }

    public function setOrderIdWithoutUpdate($orderId) {
        $this->setOrderId($orderId);
        parent::saveWithOutUpdates();
    }

}
?>
