<?php

class pricing extends pageBase {

    public function init($data) {
        $this->pageTitle = "Zillionears | Pricing";
        $this->currentPage = 'pricing';
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
        require_once('templates/pricing.html');
        return true;
    }

}

?>
