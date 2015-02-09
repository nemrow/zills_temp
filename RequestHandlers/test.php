<?php

require_once('Includes/RequestHandlerBase.php');
class test extends RequestHandlerBase {


    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists

        print_r($_POST);
        return true;
    }

    public function process() {

        if ($this->db->affectedRows()==1) {
            return 'success';
        }
    }

}

?>