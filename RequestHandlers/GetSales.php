<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');

class GetSales extends RequestHandlerBase {

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {

    }

    public function process() {

    }

}

?>