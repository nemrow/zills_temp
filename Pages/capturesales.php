<?php
require_once('DataClasses/order.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/product.php');
require_once('DataClasses/referer.php');
require_once('DataClasses/artist.php');
require_once('Includes/CaptureSalesHelper.php');


class CaptureSales extends pageBase {
    private $completedSales;
    private $uncapturedOrders;
    private $pendingStatusOrders;
    private $completedOrders;
    private $errorMessage;

    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Capture Sales";
        $this->currentPage = 'capturesales';
        if(parent::userId()<=0) {
            parent::redirect('login');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        if(array_key_exists('capture', $_GET)) {
            if(is_numeric($_GET['capture'])) {
                $orderId = (int)$_GET['capture'];
                try {
                    $myCaptureSalesHelper->captureSale($orderId);
                } catch (Exception $e) {
                    $this->errorMessage = "<h2 class=\"error\">".$e->getMessage()."</h2>";
                }
            } else if(strtolower($_GET['capture'])=='all') {
                try {
                    $myCaptureSalesHelper->captureSales();
                } catch (Exception $e) {
                    $this->errorMessage = "<h2 class=\"error\">".$e->getMessage()."</h2>";
                }
            } else if(strtolower($_GET['capture'])=='todays') {
                try {
                    $myCaptureSalesHelper->captureSalesFromYesterday();
                } catch (Exception $e) {
                    $this->errorMessage = "<h2 class=\"error\">".$e->getMessage()."</h2>";
                }
            }
        } else if(array_key_exists('update', $_GET)) {
            if(is_numeric($_GET['update'])) {
                $orderId = (int)$_GET['update'];
                try {
                    $myCaptureSalesHelper->getLatestStatus($orderId);
                } catch (Exception $e) {
                    $this->errorMessage = "<h2 class=\"error\">".$e->getMessage()."</h2>";
                }
            } else if(strtolower($_GET['update'])=='all') {
                try {
                    $myCaptureSalesHelper->updateAllStatuses();
                } catch (Exception $e) {
                    $this->errorMessage = "<h2 class=\"error\">".$e->getMessage()."</h2>";
                }
            }
        }

        $this->completedSales = $this->getSalesTable($myCaptureSalesHelper->getCompletedSales());
        $this->uncapturedOrders = $this->getUncapturedOrdersTable($myCaptureSalesHelper->getUncapturedOrders());
        $this->pendingStatusOrders = $this->getPendingOrdersTable($myCaptureSalesHelper->getPendingOrders());
        $this->completedOrders = $this->getCompletedOrdersTable($myCaptureSalesHelper->getCompletedOrders());
        return true;
    }

    public function getSalesTable($salesArray) {
        $return = '<table class="zillsAdminSingleSoSaTable4">';
        $return .= '<tr>';
        $return .= '<td class="zillsAdminSingleSoSaTableLeft">Sale Id</td><td class="zillsAdminSingleSoSaTableLeft">Sale Name</td><td class="zillsAdminSingleSoSaTableLeft">Type</td><td class="zillsAdminSingleSoSaTableLeft">Start Date</td><td class="zillsAdminSingleSoSaTableLeft">Sale End Date</td><td class="zillsAdminSingleSoSaTableLeft"># Sold</td>';
        $return .= '</tr>';
        for($i=0; $i<count($salesArray); $i++) {
            $return .= '<tr>';
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$salesArray[$i][0]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$salesArray[$i][1]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$salesArray[$i][2]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $salesArray[$i][3])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $salesArray[$i][4])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$salesArray[$i][5]}</td>";

            $return .= '</tr>';
        }
        $return .= '</table>';
        return $return;
    }

    public function getUncapturedOrdersTable($ordersArray) {
        $return = '<table class="zillsAdminSingleSoSaTable4">';
        $return .= '<tr>';
        $return .= '<td class="zillsAdminSingleSoSaTableLeft">Order Id</td><td class="zillsAdminSingleSoSaTableLeft">Sale Id</td><td class="zillsAdminSingleSoSaTableLeft">Product</td><td class="zillsAdminSingleSoSaTableLeft">Max Price</td><td class="zillsAdminSingleSoSaTableLeft">Order Date</td><td class="zillsAdminSingleSoSaTableLeft">Member</td><td class="zillsAdminSingleSoSaTableLeft">Sale End</td><td class="zillsAdminSingleSoSaTableLeft">Status</td><td class="zillsAdminSingleSoSaTableLeft">Capture</td>';
        $return .= '</tr>';
        for($i=0; $i<count($ordersArray); $i++) {
            $return .= '<tr>';
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][0]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][1]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][2]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][3]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $ordersArray[$i][4])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'><table><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][5]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][6]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][8]}</td></tr></table></td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y H:i O ', $ordersArray[$i][7])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][9]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'><a href=\"capturesales&capture={$ordersArray[$i][0]}\"><img src='images/captureBtn.png'</a></td>";
            $return .= '</tr>';
        }
        $return .= '</table>';
        return $return;
    }

    public function getPendingOrdersTable($ordersArray) {
        $return = '<table class="zillsAdminSingleSoSaTable4">';
        $return .= '<tr>';
        $return .= '<td class="zillsAdminSingleSoSaTableLeft">Order Id</td><td class="zillsAdminSingleSoSaTableLeft">Sale Id</td><td class="zillsAdminSingleSoSaTableLeft">Product</td><td class="zillsAdminSingleSoSaTableLeft">Max Price</td><td class="zillsAdminSingleSoSaTableLeft">Order Date</td><td class="zillsAdminSingleSoSaTableLeft">Member</td><td class="zillsAdminSingleSoSaTableLeft">Sale End</td><td class="zillsAdminSingleSoSaTableLeft">Status</td><td class="zillsAdminSingleSoSaTableLeft">Update</td>';
        $return .= '</tr>';
        for($i=0; $i<count($ordersArray); $i++) {
            $return .= '<tr>';
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][0]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][1]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][2]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][3]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $ordersArray[$i][4])."</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'><table><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][5]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][6]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][8]}</td></tr></table></td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y H:i O ', $ordersArray[$i][7])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][9]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'><a href=\"capturesales&update={$ordersArray[$i][0]}\">X</a></td>";
            $return .= '</tr>';
        }
        $return .= '</table>';
        return $return;
    }

    public function getCompletedOrdersTable($ordersArray) {
        $return = '<table class="zillsAdminSingleSoSaTable4">';
        $return .= '<tr>';
        $return .= '<td class="zillsAdminSingleSoSaTableLeft">Order Id</td><td class="zillsAdminSingleSoSaTableLeft">Sale Id</td><td class="zillsAdminSingleSoSaTableLeft">Product</td><td class="zillsAdminSingleSoSaTableLeft">Max Price</td><td class="zillsAdminSingleSoSaTableLeft">Order Date</td><td class="zillsAdminSingleSoSaTableLeft">Member</td><td class="zillsAdminSingleSoSaTableLeft">Sale End</td><td class="zillsAdminSingleSoSaTableLeft">Status</td><td class="zillsAdminSingleSoSaTableLeft">Final Price</td>';
        $return .= '</tr>';
        for($i=0; $i<count($ordersArray); $i++) {
            $return .= '<tr>';
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][0]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][1]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][2]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][3]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $ordersArray[$i][4])."</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'><table><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][5]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][6]}</td></tr><tr><td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][8]}</td></tr></table></td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y H:i O ', $ordersArray[$i][7])."</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][9]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$ordersArray[$i][10]}</td>";
            //$return .= "<td><a href=\"capturesales&update={$ordersArray[$i][0]}\">X</a></td>";
            $return .= '</tr>';
        }
        $return .= '</table>';
        return $return;
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
        require_once('templates/captureSales.html');
        return true;
    }

}

?>
