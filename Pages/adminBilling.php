<?php

class adminbilling extends pageBase {

    public function init($data) {
        $this->pageTitle = "Zillionears | Admin Billing";
        $this->currentPage = 'adminbilling';
        //$this->loginUrl = "&amp;action=createss";
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }

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
        require_once('templates/adminBilling.html');
        return true;
    }

}

?>
