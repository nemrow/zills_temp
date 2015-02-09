<?php

class about extends pageBase {

    public function init($data) {
        $this->pageTitle = "Zillionears | About Us";
        $this->currentPage = 'Index';

        return true;
    }

    public function header() {
        parent::header();
        require_once('templates/aboutHeader.html');

        return true;
    }

    public function footer() {
        require_once('templates/footer.html');
        return true;
    }

    public function body() {
        require_once('templates/about.html');
        return true;
    }

}

?>
