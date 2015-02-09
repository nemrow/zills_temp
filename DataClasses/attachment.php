<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}


class attachment extends DataClassBase {


    public function getPath() {
        return $this->get('path');
    }

    public function setPath($path) {
        $this->set('path', $path);
    }

    public function getIP() {
        return $this->get('ip');
    }

    public function setIP($ip) {
        $this->set('ip', $ip);
    }

    public function getHeight() {
        return $this->get('height');
    }

    public function setHeight($height) {
        $this->set('height', $height);
    }

    public function getWidth() {
        return $this->get('width');
    }

    public function setWidth($width) {
        $this->set('width', $width);
    }

    public function getDtExpires() {
        return $this->get('dtExpires');
    }

    public function setDtExpires($date) {
        $this->set('dtExpires', $date);
    }

    public function __construct($db) {
        $this->tableName = 'attachment';
        $this->tableType = 'Attachment';

        $this->colNames[$this->colCount] = 'id';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'path';
        $this->colTypes[$this->colCount++] = 'string250';

        $this->colNames[$this->colCount] = 'ip';
        $this->colTypes[$this->colCount++] = 'string16';

        $this->colNames[$this->colCount] = 'height';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'width';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'dtExpires';
        $this->colTypes[$this->colCount++] = 'int';



        parent::__construct($db);
    }

}
?>
