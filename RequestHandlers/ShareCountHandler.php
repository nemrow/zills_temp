<?php
require_once('Includes/CaptureSalesHelper.php');
require_once('Includes/RequestHandlerBase.php');

class shareCountHandler extends RequestHandlerBase{
    public function auth() {
        return true;
    }
    

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->saleId = $data['saleId'];
        return true;        
    }
   
    public function process() {
        $myCaptureSalesHelper = new CaptureSalesHelper;
        $myCaptureSalesHelper->incrementShareCount($this->saleId);
        return $this->saleId;
    }
 
}

?>
