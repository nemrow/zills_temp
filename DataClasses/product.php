<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');
require_once('DataClasses/attachment.php');
require_once('Includes/resize-class.php');

class product extends DataClassBase {
    public function getArtistId() {
        return $this->get('artistId');
    }

    public function setArtistId($id) {
        $this->set('artistId', $id);
    }

    public function getName() {
        return $this->get('name');
    }

    public function setName($name) {
        $this->set('name', $name);
    }

    public function getDescription() {
        return $this->get('description');
    }

    public function setDescription($description) {
        $this->set('description', $description);
    }

    public function getType() {
        return $this->get('type');
    }

    public function setType($type) {
        $this->set('type', $type);
    }
    
    public function getAlbumPath() {
        return $this->get('albumPath');
    }

    public function setAlbumPath($path) {
        $this->set('albumPath', $path);
    }

    public function getImageId() {
        return $this->get('imageId');
    }

    public function setImageId($id) {
        $this->set('imageId', $id);
    }

    public function getShippingCost() {
        return $this->get('shippingCost');
    }

    public function setShippingCost($cost) {
        $this->set('shippingCost', $cost);
    }

    public function getPurchaseLimit() {
        return $this->get('purchaseLimit');
    }

    public function setPurchaseLimit($limit) {
        $this->set('purchaseLimit', $limit);
    }

    public function __construct($db) {
        $this->tableName = 'product';
        $this->tableType = 'Product';

        $this->colNames[$this->colCount] = 'id';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'artistId';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'name';
        $this->colTypes[$this->colCount++] = 'string150';
        
        $this->colNames[$this->colCount] = 'albumPath';
        $this->colTypes[$this->colCount++] = 'string200';

        $this->colNames[$this->colCount] = 'description';
        $this->colTypes[$this->colCount++] = 'text';

        $this->colNames[$this->colCount] = 'type';
        $this->colTypes[$this->colCount++] = 'productType';

        $this->colNames[$this->colCount] = 'imageId';
        $this->colTypes[$this->colCount++] = 'int';

        $this->colNames[$this->colCount] = 'shippingCost';
        $this->colTypes[$this->colCount++] = 'price';

        $this->colNames[$this->colCount] = 'purchaseLimit';
        $this->colTypes[$this->colCount++] = 'int';

        parent::__construct($db);
    }

    public function getProductType() {
        switch($this->getType()) {
            case 'PhysicalMerch':
                return 'Physical Merchandise';
            case 'DigitalMusic':
                return 'Digital Music';
            case 'PhysicalMusic':
                return 'Physical Music';
        }
    }

    public function getProductImg() {
        $attachment = new Attachment($this->db);
        $attachment->read($this->getImageId());
        return $attachment->getPath();
    }
    
    public function optimizeBackgroundImage($source_url){
        //$source_url = 'uploads/aa2e0b1f48_DSCN5529.jpg';
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        if($info[0] > 1920){
            $resizeObj = new resize($source_url);      
            $resizeObj -> resizeImage(1920, NULL, 'landscape');
            $resizeObj -> saveImage($source_url, 75);
        }else{
            imagejpeg($image, $source_url, 75);
        }
    }

    public function optimizeProductImage($source_url){
        //$source_url = 'uploads/aa2e0b1f48_DSCN5529.jpg';
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        if($info[0] > 500){
            $resizeObj = new resize($source_url);      
            $resizeObj -> resizeImage(500, NULL, 'landscape');
            $resizeObj -> saveImage($source_url, 75);
        }else{
            imagejpeg($image, $source_url, 75);
        }
    }

}
?>