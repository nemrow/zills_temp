<?php
require_once('DatabaseBase.php');
require_once('MySQLDB.php');
require_once('DataClasses/account.php');
require_once('DataClasses/order.php');
require_once('DataClasses/sale.php');
require_once('DataClasses/attachment.php');
require_once('DataClasses/cbRequest.php');
require_once('DataClasses/fpsResponse.php');
require_once('DataClasses/recipientRequest.php');
require_once('DataClasses/fpsResponseHistory.php');
require_once('Amazon/FPS/Model.php');
require_once('Amazon/FPS/Mock.php');
require_once('Amazon/FPS/Client.php');
require_once('Amazon/FPS/Model/PayRequest.php');
require_once('Amazon/FPS/Model/Amount.php');
require_once('Amazon/FPS/Model/GetTransactionStatusRequest.php');
require_once('Includes/emailTemplates.php');


class CronJobHelper {
    private $db;
        
    public function __construct ($db = null) {
        if($db==null) {
            $this->db = new MySQLDB();
        } else {
            $this->db = $db;
        }
    }
    
   public function showAllFansInSale(){
        $myOrder = new order($this->db);
        $order = $myOrder->getFansFromSale(2010);    
        $return = '';
        // Array Given: o.userId, a.firstName, a.lastName, a.email, o.dtCreated, o.maxPrice, o.status, o.error
        for($i=0; $i<count($order); $i++) {
            $return .= '<tr>';
            $return .= "<td class='zillsAdminSingleSoSaTableRight'><a href='adminSingleAccount&id={$order[$i][0]}'>{$order[$i][0]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$order[$i][1]} {$order[$i][2]}</td>";
            $return .= date('M j Y', $order[$i][3]);
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$order[$i][4]}</td>";
            $return .= "<td class='zillsAdminSingleSoSaTableRight'>{$order[$i][5]}</td>";
            $return .='</tr>';
        }
        return $return;
    }
}
?>
