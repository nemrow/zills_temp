<?php

class createss extends pageBase {

    public function init($data) {
        $this->pageTitle = "Zillionears | Create Social Sale";
        $this->currentPage = 'CreateSocialSale';
        $this->loginUrl = "&amp;action=createss";

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
        require_once('templates/createSs.html');
        return true;
    }

}

?>
