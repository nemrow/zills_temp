<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/product.php');
require_once('DataClasses/DigitalMusic.php');
require_once('DataClasses/PhysicalMusic.php');
require_once('DataClasses/PhysicalMerch.php');

class GetSaleInfo extends RequestHandlerBase {
    private $saleId;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {
        if(array_key_exists('id',$data) && isset($data['id']) && (int)$data['id']>0) {
            $this->saleId = (int)$data['id'];
        } else {
            throw new Exception('Sale ID not provided');
        }
        return true;
    }

    public function process() {
        $mySale = new sale($this->db);
        $myArtist = new artist($this->db);
        $myProduct = new product($this->db);

        $mySale->read($this->saleId);
        $myProduct->read($sale->getProductId());
        $myArtist->read($sale->getArtistId());

        $JSON = array(
            'id'=>$this->saleId,
            'artistName'=>$artist->getArtistName(),
            'productName'=>$product->getName(),
            'productDescription' => $product->getDescription(),
            'startPrice'=>$sale->getStartPrice(),
            'lowPrice'=>$sale->getLowPrice(),
            'saleEnd'=> $sale->getSaleEnd()
        );

        if($myProduct->getType()=='DigitalMusic') {
            $myDigitalMusic = new DigitalMusic($this->db);
            $JSON['productType'] = 'Digital Download';
            $tracks = $myDigitalMusic->getAllTracks($sale->getProductId());
            $JSON['DigitalTrackCount'] = $this->db->resultSize($tracks);
            for($i=0; $i<$this->db->resultSize($tracks);$i++) {
                $JSON['DigitalTrackNum'.$i] = $tracks['trackNumber'];
                $JSON['DigitalTrackTitle'.$i] = $tracks['trackTitle'];
                $JSON['DigitalTrackLength'.$i] = $tracks['length'];
                $JSON['DigitalTrackFileType'.$i] = $tracks['fileType'];
            }
        } else if ($myProduct->getType()=='PhysicalMusic') {
            $myPhysicalMusic = new PhysicalMusic($this->db);
            $JSON['productType'] = 'Album';
            $tracks = $myPhysicalMusic->getAllTracks($sale->getProductId());
            $JSON['PhysicalTrackCount'] = $this->db->resultSize($tracks);
            for($i=0; $i<$this->db->resultSize($tracks);$i++) {
                $JSON['PhysicalTrackNum'.$i] = $tracks['trackNumber'];
                $JSON['PhysicalTrackTitle'.$i] = $tracks['trackTitle'];
                $JSON['PhysicalTrackLength'.$i] = $tracks['length'];
            }
        } else if($myProduct->getType()=='PhysicalMerch') {
            $myMerch = new PhysicalMerch($this->db);
            $JSON['productType'] = 'Merchandise';
            $JSON['NA'] = $myMerch->getNA();
            $JSON['XS'] = $myMerch->getXS();
            $JSON['S'] = $myMerch->getS();
            $JSON['M'] = $myMerch->getM();
            $JSON['L'] = $myMerch->getL();
            $JSON['XL'] = $myMerch->getXL();
            $JSON['XXL'] = $myMerch->getXXL();
            $JSON['XXXL'] = $myMerch->getXXXL();
        }


        return json_encode($JSON);

    }

}

?>