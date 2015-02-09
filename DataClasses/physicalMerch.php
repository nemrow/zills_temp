<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');

class physicalMerch extends DataClassBase {

    public function getProductId() {
        return $this->get('productId');
    }

    public function setProductId($dtUpdated) {
        $this->set('productId', $dtUpdated);
    }

    public function getXS() {
        return $this->get('XS');
    }

    public function setXS($count) {
        $this->set('XS', $count);
    }

    public function getS() {
        return $this->get('S');
    }

    public function setS($count) {
        $this->set('S', $count);
    }

    public function getM() {
        return $this->get('M');
    }

    public function setM($count) {
        $this->set('M', $count);
    }

    public function getL() {
        return $this->get('L');
    }

    public function setL($count) {
        $this->set('L', $count);
    }

    public function getXL() {
        return $this->get('XL');
    }

    public function setXL($count) {
        $this->set('XL', $count);
    }

    public function getXXL() {
        return $this->get('XXL');
    }

    public function setXXL($count) {
        $this->set('XXL', $count);
    }

    public function getXXXL() {
        return $this->get('XXXL');
    }

    public function setXXXL($count) {
        $this->set('XXXL', $count);
    }

    public function getNA() {
        return $this->get('NA');
    }

    public function setNA($count) {
        $this->set('NA', $count);
    }

    public function __construct($db) {
        $this->tableName = 'physicalmerch';
        $this->tableType = 'Physical Merch';

        $this->colNames[$this->colCount] = 'id';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'XS';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'S';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'M';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'L';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'XL';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'XXL';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'XXXL';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'NA';
        $this->colTypes[$this->colCount++] = 'int';

        parent::__construct($db);
    }

}
?>