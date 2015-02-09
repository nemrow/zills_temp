<?php

class logout extends pageBase {

    public function init($data) {
        parent::header();
        parent::logout();
        if(array_key_exists('saleId', $_GET) && is_numeric($_GET['saleId'])) {
            parent::redirect('socialsale&id='.(int)$_GET['saleId']);
        }
        parent::redirect('index.php');
    }

    public function header() {


        return true;
    }

    public function footer() {

        return true;
    }

    public function body() {
        return true;
    }

}

?>
