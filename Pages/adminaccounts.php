<?php
require_once('Includes/CaptureSalesHelper.php');

class adminaccounts extends pageBase {
    private $totalAccounts;
    private $totalFans;
    private $totalBands;
    private $accountRows;
    private $show;

    public function init($data) {
        $this->pageTitle = "Zillionears | Admin Accounts";
        $this->currentPage = 'adminaccounts';
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }
        if(array_key_exists('show', $_GET)) {
            if($_GET['show']=='fans') {
                $this->show='fans';
            } else if($_GET['show']=='bands') {
                $this->show='bands';
            } else {
                $this->show='all';
            }
        } else {
            $this->show='all';
        }

        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);

        $this->totalAccounts = $myCaptureSalesHelper->getTotalAccounts();
        $this->totalFans = $myCaptureSalesHelper->getTotalFans();
        $this->totalBands = $myCaptureSalesHelper->getTotalBands();
        $this->accountRows = $this->getAccountRows();

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
        require_once('templates/adminAccounts.html');
        return true;
    }

    public function getAccountRows() {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getAccounts($this->show);
        $return = '';

        for($i=0; $i<count($rows); $i++) {
           $return .= '<tr>';
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\"><a href=\"adminSingleAccount&id={$rows[$i][0]}\">{$rows[$i][0]}</a></td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][1]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][2]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][3]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">".date('m/d/y',$rows[$i][4])."</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][5]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][6]}</td>";
           //$return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][7]}</td>";
           $return .= "</tr>";
        }
        return $return;
    }

}

?>
