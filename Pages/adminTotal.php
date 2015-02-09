<?php
require_once('Includes/CaptureSalesHelper.php');

class adminTotal extends pageBase {
    private $totalSales;
    private $totalFans;
    private $totalBands;
    private $totalActiveSales;
    private $totalExpiredSales;
    private $totalTransactions;
    private $totalGrossRevenue;
    private $totalAmazonFees;
    private $totalBandCuts;
    private $totalZillsCuts;

    public function init($data) {
        $this->pageTitle = "Zillionears | Admin Totals";
        $this->currentPage = 'admintotal';
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }
        
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);

        $this->totalSales = $myCaptureSalesHelper->getTotalSales();
        $this->totalFans = $myCaptureSalesHelper->getTotalFans();
        $this->totalBands = $myCaptureSalesHelper->getTotalBands();

        $this->totalActiveSales = $myCaptureSalesHelper->getTotalActiveSales();
        $this->totalExpiredSales = $myCaptureSalesHelper->getTotalExpiredSales();
        $this->totalTransactions = $myCaptureSalesHelper->getTotalTransactions();
        $this->totalGrossRevenue = number_format($myCaptureSalesHelper->getTotalGrossRevenue(),2);
        $this->totalAmazonFees = number_format($myCaptureSalesHelper->getTotalAmazonFees(),2);
        $this->totalBandCuts = number_format($myCaptureSalesHelper->getTotalBandCuts(),2);
        $this->totalZillsCuts = number_format($myCaptureSalesHelper->getTotalZillsCuts(),2);
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
        require_once('templates/adminTotals.html');
        return true;
    }

}

?>
