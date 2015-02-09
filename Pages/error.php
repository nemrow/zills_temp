<?php

class error extends pageBase {
    private $errorMsg;

    public function init($data) {
        //parent::header();
        $this->errorMsg = $data;
        $this->pageTitle = "Zillionears | Error";
        $this->currentPage = 'error';

        return true;
    }

    public function header() {
        require_once('templates/header.html');

        return true;
    }

    public function footer() {
        require_once('templates/footer.html');
        return true;
    }

    public function body() {
        require_once('templates/error.html');
        return true;
    }

    private function getError() {
        return $this->errorMsg;
    }

}

?>
