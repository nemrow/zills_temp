<?php
require_once('DataClasses/artist.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/product.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('Includes/CaptureSalesHelper.php');

class adminsingleaccount extends pageBase {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $dateJoined;
    private $accountType;
    private $manager;
//    private $addressName;
//    private $addressLine1;
//    private $addressLine2;
//    private $city;
    private $fanSalesRows;
    private $bandSalesRows;
    private $fanSaleCount;
    private $bandSaleCount;

    public function init($data) {
        $this->pageTitle = "Zillionears | Single Account";
        $this->currentPage = 'adminsingleaccount';
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
            throw new Exception('No account specified');
        }
        $myAccount = new account($this->db);
        $myAccount->read($this->id);
        $myAttachment = new attachment($this->db);
        if($myAccount->getImageId()>0) {
            $myAttachment->read($myAccount->getImageId());
            $this->userImage = $myAttachment->getPath();
        } else {
            $this->userImage = 'blank.gif';
        }


        $this->firstName = $myAccount->getFirstName();
        $this->lastName = $myAccount->getLastName();
        $this->email = $myAccount->getEmail();
        $this->dateJoined = date('m/d/y', $myAccount->getDtCreated());
        $this->accountType = $myAccount->getAccountType();
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);

        if($myAccount->getAccountType()!='customer') {
            try {
                $myArtist = new artist($this->db);
                $myArtist->readByManagerId($myAccount->getId());
                $this->paypalEmail = $myArtist->getPaypal();
                $this->manager= true;
                $rows = $myCaptureSalesHelper->getSocialSalesForFan($this->id);
                $this->bandSaleCount = count($rows);
                $this->bandSalesRows = $this->getBandSalesRows($rows);
            } catch (Exception $e) {
            $this->manager= false;
            }

        } else {
            $this->manager= false;
        }


        $rows = $myCaptureSalesHelper->getSocialSalesForFan($this->id);
        $this->fanSaleCount = count($rows);
        if(count($rows)>0) {
            $this->fanSalesRows = $this->getFanSalesRows($rows);
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
        require_once('templates/adminSingleAccount.html');
        return true;
    }

    public function getFanSalesRows($rows) {

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

    public function getBandSalesRows($rows) {
        $myCaptureSalesHelper = new CaptureSalesHelper($this->db);
        $rows = $myCaptureSalesHelper->getSocialSalesForBand($this->id);
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

}

?>
