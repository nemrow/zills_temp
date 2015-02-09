<?php

class terms extends pageBase {

    public function init($data) {
        $this->pageTitle = "Zillionears | Terms of Service";
        $this->currentPage = 'terms';
        return true;
    }

    public function header() {
        parent::header();
        require_once('templates/header.html');

        return true;
    }

    public function footer() {
        require_once('templates/footer.html');
        return true;
    }

    public function body() {
        require_once('templates/terms.html');
        return true;
    }

}

?>
