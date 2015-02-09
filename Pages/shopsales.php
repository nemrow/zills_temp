<?php
require_once('Includes/CaptureSalesHelper.php');

class shopSales extends pageBase {
	private $totalSales;
    private $show;
    private $salesRows;

    public function init($data) {
        $this->pageTitle = "Zillionears | Shop Sales";
        $this->currentPage = 'shopSales';

	$myCaptureSalesHelper = new CaptureSalesHelper($this->db);
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
        require_once('templates/shopSales.html');
        return true;
    }

	public function getSalesRows() {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getSocialSales($this->show);
        $return = '';

        for($i=0; $i<9; $i++) {
           $return .= "<a href=\"socialsale&id={$rows[$i][0]}\">";
           $return .= '<div class="shopSalesSquareShell">';
           $return .= "<img class=\"shopSalesSquareImg\" src=\"{$rows[$i][8]}\" />";
           $return .= '<div class="shopSalesSquareBottomShell">';
           $return .= "<p class=\"shopSalesSquareBottomText1\">{$rows[$i][1]}</p>";
		   $return .= "<p class=\"shopSalesSquareBottomText2\">{$rows[$i][2]}</p>";
           $return .= '<div class="shopSalesSquareBottomOpacity"></div>';
           $return .= '</div>';
           $return .= '<div class="shopSalesSquareWhiteHover"></div>';
           $return .= '</div>';
           $return .= "</a>";
           
        }
        return $return;
    }

}

?>
