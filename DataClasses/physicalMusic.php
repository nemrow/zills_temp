<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');

class physicalMusic extends DataClassBase {

    public function getProductId() {
        return $this->get('productId');
    }

    public function setProductId($id) {
        $this->set('productId', $id);
    }


    public function getTrackTitle() {
        return $this->get('trackTitle');
    }

    public function setTrackTitle($title) {
        $this->set('trackTitle', $title);
    }

    public function getTrackNumber() {
        return $this->get('trackTitle');
    }

    public function setTrackNumber($track) {
        $this->set('trackNumber', $track);
    }

    public function getLength() {
        return $this->get('length');
    }

    public function setLength($length) {
        $this->set('length', $length);
    }

    public function getFileType() {
        return $this->get('fileType');
    }

    public function setFileType($fileType) {
        $this->set('fileType', $fileType);
    }

    public function __construct($db) {
        $this->tableName = 'physicalmusic';
        $this->tableType = 'Physical Music';

        $this->colNames[$this->colCount] = 'id';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'productId';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'trackTitle';
        $this->colTypes[$this->colCount++] = 'string200';

        $this->colNames[$this->colCount] = 'trackNumber';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'length';
        $this->colTypes[$this->colCount++] = 'length';

        $this->colNames[$this->colCount] = 'fileType';
        $this->colTypes[$this->colCount++] = 'fileType';

        parent::__construct($db);
    }

    public function getAllTracks($productId) {
        $result='';
        try {
            $qresult = parent::readListByKeyValue(array("productId"), array($productId), 0);
            $i=0;
            while($row = $this->db->fetchAssoc($qresult)) {
                $result[$i]['trackTitle'] = $row['trackTitle'];
                $result[$i]['trackNumber'] = $row['trackNumber'];
                $result[$i++]['length'] = $row['length'];
            }
        } catch (Exception $e) {
            throw new Exception("Unable to get track list: ". $e->getMessage());
        }

        return $result;
    }

}
?>
