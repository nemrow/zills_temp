<?php

require_once('Includes/RequestHandlerBase.php');
require_once('DataClasses/sale.php');

class Excel extends RequestHandlerBase {
    private $saleId;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->saleId = (int)$_GET['id'];
        if($this->saleId<=0) {
            throw new Exception("Invalid sale ID");
        }


        return true;
    }

    public function process() {
        $saleId = new sale($this->db);
        $emailList = $saleId->getFanList($this->saleId);

        $output = $this->xlsBOF();
        $output .= $this->xlsWriteLabel(0, 0, 'Name');
        $output .= $this->xlsWriteLabel(0, 1, 'Email');
        $output .= $this->xlsWriteLabel(0, 2, 'Zip');
        $output .= $this->xlsWriteLabel(0, 3, 'In At');
        for($i=1; $i<=count($emailList); $i++) {
            $output .= $this->xlsWriteLabel($i, 0, $emailList[$i-1][0]);
            $output .= $this->xlsWriteLabel($i, 1, $emailList[$i-1][1]);
            $output .= $this->xlsWriteLabel($i, 2, $emailList[$i-1][3]);
            $output .= $this->xlsWriteLabel($i, 3, "\$".$emailList[$i-1][2]);
        }
        $output .= $this->xlsEOF();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=FanEmailList.xls");
        header("Content-Transfer-Encoding: binary ");
        return $output;
    }

    private function xlsBOF() {
        return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);

    }

    private function xlsEOF() {
        return pack("ss", 0x0A, 0x00);

    }

    private function xlsWriteNumber($Row, $Col, $Value) {
        $output =  pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        $output .= pack("d", $Value);
        return $output;
    }

    private function xlsWriteLabel($Row, $Col, $Value ) {
        $L = strlen($Value);
        $output = pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
        $output .= $Value;
        return $output;
    }

}

?>