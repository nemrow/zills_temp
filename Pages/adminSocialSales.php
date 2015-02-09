<?php
require_once('Includes/CaptureSalesHelper.php');

class adminsocialsales extends pageBase {
    private $totalSales;
    private $totalActiveSales;
    private $totalExpiredSales;
    private $show;
    private $salesRows;

    public function init($data) {
        $this->pageTitle = "Zillionears | Admin Social Sales";
        $this->currentPage = 'adminsocialsales';

        if(array_key_exists('show', $_GET)) {
            if($_GET['show']=='expired') {
                $this->show='expired';
            } else if($_GET['show']=='active') {
                $this->show='active';
            } else {
                $this->show='all';
            }
        } else {
            $this->show='all';
        }
        //$this->loginUrl = "&amp;action=createss";
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $this->totalSales =  $myCaptureSalesHelper->getTotalSales();
        $this->totalActiveSales =  $myCaptureSalesHelper->getTotalActiveSales();
        $this->totalExpiredSales =  $myCaptureSalesHelper->getTotalExpiredSales();
        $this->salesRows = $this->getSalesRows();

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
        require_once('templates/adminSocialSales.html');
        return true;
    }

    public function getSalesRows() {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getSocialSales($this->show);
        $return = '';

        for($i=0; $i<count($rows); $i++) {
           $return .= '<tr>';
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\"><a href=\"adminSingleSocialSale&id={$rows[$i][0]}\">{$rows[$i][0]}</a></td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][1]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][2]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][3]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">\${$rows[$i][4]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">\${$rows[$i][5]}</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">$".number_format($rows[$i][6],2)."</td>";
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][7]}</td>";
           $return .= "</tr>";
        }
        return $return;
    }
//    
//    public function getAccountsRows() {
//        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
//        $rows = $myCaptureSalesHelper->getSocialSales($this->show);
//        $return = '';
//
//        for($i=0; $i<count($rows); $i++) {
//           $return .= '<tr>';
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\"><a href=\"adminSingleSocialSale&id={$rows[$i][0]}\">{$rows[$i][0]}</a></td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][1]}</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][2]}</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][3]}</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">\${$rows[$i][4]}</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">\${$rows[$i][5]}</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">$".number_format($rows[$i][6],2)."</td>";
//           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\">{$rows[$i][7]}</td>";
//           $return .= "</tr>";
//        }
//        return $return;
//    }

}

?>
