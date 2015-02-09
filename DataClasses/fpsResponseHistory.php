<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}

class fpsResponseHistory extends DataClassBase {

    public function getcbRequestId() {
        return $this->get('cbRequestId');
    }

    public function setcbRequestId($id) {
        $this->set('cbRequestId', $id);
    }

    public function getTransactionId() {
        return $this->get('transactionid');
    }

    public function setTransactionId($id) {
        $this->set('transactionid', $id);
    }

    public function getStatus() {
        return $this->get('status');
    }

    public function setStatus($status) {
        $this->set('status', $status);
    }

    public function getRequestId() {
        return $this->get('requestId');
    }

    public function setRequestId($id) {
        $this->set('requestId', $id);
    }

    public function getTransactionStatus() {
        return $this->get('transactionStatu');
    }

    public function setTransactionStatus($status) {
        $this->set('transactionStatus', $status);
    }

    public function getStatusMessage() {
        return $this->get('statusMessage');
    }

    public function setStatusMessage($message) {
        $this->set('statusMessage', $message);
    }

    public function getFpsResposneId() {
        return $this->get('fpsresponseid');
    }

    public function setFpsResposneId($id) {
        $this->set('fpsresponseid', $id);
    }

    public function __construct ($db) {
        $this->tableName='fpsresponsehistory';
        $this->tableType='Amazon Response History';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='cbRequestId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='fpsresponseid';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='transactionid';
        $this->colTypes[$this->colCount++]='string39';

        $this->colNames[$this->colCount]='status';
        $this->colTypes[$this->colCount++]='string25';

        $this->colNames[$this->colCount]='requestId';
        $this->colTypes[$this->colCount++]='string39';

        $this->colNames[$this->colCount]='transactionStatus';
        $this->colTypes[$this->colCount++]='string20';

        $this->colNames[$this->colCount]='statusMessage';
        $this->colTypes[$this->colCount++]='string250';
        parent::__construct($db);
    }

    public function responseExists($cbRequestId) {
        $requestId = (int)$cbRequestId;
        $sql = "SELECT count(id) FROM `fpsresponse` WHERE `cbRequestId` = $requestId";
        return $this->db->queryCount($sql);
    }
}
?>
