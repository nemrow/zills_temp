<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/product.php');
require_once('DataClasses/account.php');
require_once('DataClasses/order.php');
require_once('Includes/CaptureSalesHelper.php');

class adminsinglesocialsale extends pageBase {
    private $id;
    private $name;
    private $artistName;
    private $numBuyIns;
    private $currentPrice;

    //add more variable names here

    public function init($data) {
        $this->pageTitle = "Zillionears | Single Social Sale";
        $this->currentPage = 'adminsinglesocialsale';
        //$this->loginUrl = "&amp;action=createss";
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='admin') {
            parent::redirect('fanAdminSettings');
        }
        if(array_key_exists('id', $_GET)) {
            $this->id = (int)$_GET['id'];
        } else {
            throw new Exception('No sale specified');
        }
        $mySale = new sale($this->db);
        $mySale->read($this->id);
        $myProduct = new product($this->db);
        $myProduct->read($mySale->getProductId());
        $myArtist = new artist($this->db);
        $myArtist->read($myProduct->getArtistId());
        $myAccount = new account($this->db);
        $myAccount->read($myArtist->getAccountId());


        $this->artistName = $myArtist->getArtistName();
        $this->name = $myProduct->getName();
        $this->accountManagerFirstName = $myAccount->getFirstName();
        $this->accountManagerLastName = $myAccount->getLastName();
        $this->saleEndDate = $mySale->getSaleEnd();
        $this->saleStartPrice = $mySale->getStartPrice();
        $this->numBuyIns = $mySale->getNumBuyins($mySale->getId());
        $this->saleStartPriceVisual = date('F j\, Y', $mySale->getSaleEnd());
        $this->saleLowPrice = $mySale->getLowPrice();
        $this->currentPrice = number_format($mySale->getCurrentPrice(),2);
        $this->GrossRev = number_format($this->currentPrice*$this->numBuyIns,2);
        $this->zillsCut = number_format((($this->GrossRev*0.05)+($this->numBuyIns*0.25)),2); 
        $this->amazonFees = number_format((($this->GrossRev*0.05)+($this->numBuyIns*0.05)),2);
        $this->bandsCut = number_format(($this->GrossRev - ($this->zillsCut+$this->amazonFees)),2);
        $this->getFansInSaleRows = $this->fansInSaleRows();
   
        //do the rest here/

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
        require_once('templates/adminSingleSocialSale.html');
        return true;
    }


    public function fansInSaleRows() {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getNumFanInSale($this->id);
        $return = '';

        for($i=0; $i<count($rows); $i++) {
           $return .= '<tr>';
           $return .= "<td class='zillsAdminSingleSoSaTableRight'><a href='adminSingleAccount&id={$rows[$i][0]}'>{$rows[$i][0]}</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$rows[$i][1]} {$rows[$i][2]}</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'>".date('M j Y', $rows[$i][3])."</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$rows[$i][4]}</td>";
           $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$rows[$i][5]}</td>";
           $return .='</tr>';
        }
        return $return;
    }

}

?>
