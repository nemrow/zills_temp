<?php

require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/order.php');

class bandadminorders extends pageBase {
    private $orderTableRows;
    private $orderDetails;

    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Band Admin Orders";
        $this->currentPage = 'bandadminorders';
        parent::header();
        if(parent::userId()<=0) {
            parent::redirect('login&action=bandAdminOrders');
        }
        if(parent::userAccountType()!='manager') {
            parent::redirect('fanAdminSettings');
        }

        $myOrder = new order($this->db);
        $this->orderDetails = '';
        $this->orderTableRows = $this->getOrderTableRows($myOrder->getOrderList(parent::userId()));
        //$this->
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
        require_once('templates/bandAdminOrders.html');
        return true;
    }

    private function getOrderTableRows($orders) {
        $return = "";
        foreach($orders as $order) {
            extract($order);
            $return .= "<tr>";
            $return .= "<td class=\"adminOrderNum\">";
            $return .= "<a href=\"#orderShell{$id}\" id=\"openOrderShell\" class=\"orderShellCursor\">#{$id}</a></td>";
            $return .= "<td class=\"adminOrderTitle\">$name</td>";
            $return .= "<td class=\"adminOrderRight\"><span class=\"adminOrderX\">X</span><span class=\"adminOrderSep\">|</span><span class=\"adminOrderCom\">Complete <input type=\"checkbox\" /></span></td>";
            $return .= "</tr>";
            
            $this->orderDetails .= "<div id=\"orderShell{$id}\">";
            $this->orderDetails .= '<div class="orderBoxNum">';
            $this->orderDetails .= "<p class=\"orderBoxNumP\">#${id}</p>";
            $this->orderDetails .= '</div>';
            $this->orderDetails .= '<div class="orderBoxTitleOptShell">';
            $this->orderDetails .= "<p class=\"orderBoxTitleOpt\">$name</p>";
            //$this->orderDetails .= '<p class="orderBoxTitleOptR">Medium</p>';
            $this->orderDetails .= '</div>';
            $this->orderDetails .= '<div class="orderBoxNum">';
            $this->orderDetails .= '<p class="orderBoxNumP">Shipping Info</p>';
            $this->orderDetails .= '</div>';

            $this->orderDetails .= '<p class="orderBoxShipP">';
            if($status=='AUTHORIZED') {
                $this->orderDetails .= "No shipping info for orders in AUTHORIZED status";
            } else {
                $this->orderDetails .= 'Dan Polaske<br />';
                $this->orderDetails .= '2342 Chumly Ct<br />';
                $this->orderDetails .= 'Rocklin, California 95765';
            }
            $this->orderDetails .= '</p>';

            $this->orderDetails .= '<p class="orderBoxCompBtn">Complete</p>';
            $this->orderDetails .= '<p class="orderBoxNotCompBtn">Not Complete</p>';
            if($status=='AUTHORIZED') {
                $this->orderDetails .= '<p class="orderBoxCancelP">or Cancel Order</p>';
            }
            $this->orderDetails .= '</div>"';

        }
        return $return;
    }



}

?>
