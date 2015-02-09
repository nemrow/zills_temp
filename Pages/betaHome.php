<?php
require_once('Includes/CaptureSalesHelper.php');

class betaHome extends pageBase {
	private $totalSales;
    private $show;
    private $salesRows;

    public function init($data) {
        $this->pageTitle = "Zillionears | Beta Home";
        $this->currentPage = 'Index';

		$myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $this->salesRows = $this->getSalesRows();

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
        require_once('templates/betaHome.html');
        return true;
    }

	public function getSalesRows() {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getSocialSales($this->show);
        $return = '';

        for($i=0; $i<count($rows); $i++) {
           $return .= '<tr>';
           $return .= "<td class=\"zillsAdminSingleSoSaTableRight\"><a href=\"socialsale&id={$rows[$i][0]}\" target=\"_blank\">{$rows[$i][0]}</a></td>";
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

}

?>
