<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}
class order extends DataClassBase {

    public function getUserId() {
        return $this->get('userId');
    }

    public function setUserId($id) {
        $this->set('userId', $id);
    }

    public function getSaleId() {
        return $this->get('saleId');
    }

    public function setSaleId($id) {
        $this->set('saleId', $id);
    }

    public function getPaymentId() {
        return $this->get('paymentId');
    }

    public function setPaymentId($id) {
        $this->set('paymentId', $id);
    }

    public function getMaxPrice() {
        return $this->get('maxPrice');
    }

    public function setMaxPrice($price) {
        $this->set('maxPrice', $price);
    }

    public function getFinalPrice() {
        return $this->get('finalPrice');
    }

    public function setFinalPrice($price) {
        $this->set('finalPrice', $price);
    }

    public function getStatus() {
        return $this->get('status');
    }

    public function setStatus($status) {
        $this->set('status', $status);
    }

    public function getType() {
        return $this->get('type');
    }

    public function setType($type) {
        $this->set('type', $type);
    }
    
    public function getError() {
        return $this->get('error');
    }

    public function setError($type) {
        $this->set('error', $type);
    }
    
    public function __construct ($db) {
        $this->tableName='order';
        $this->tableType='order';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='userId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='saleId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='paymentId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='maxPrice';
        $this->colTypes[$this->colCount++]='price';

        $this->colNames[$this->colCount]='finalPrice';
        $this->colTypes[$this->colCount++]='price';

        $this->colNames[$this->colCount]='status';
        $this->colTypes[$this->colCount++]='string200';
        
        $this->colNames[$this->colCount]='type';
        $this->colTypes[$this->colCount++]='string2';
        
        $this->colNames[$this->colCount]='error';
        $this->colTypes[$this->colCount++]='string200';

        parent::__construct($db);
    }

    public function readByUserSale($userId, $saleId) {
        parent::readByKeyValues(Array('userId', 'saleId'), Array($userId, $saleId));
    }

     public function getOrderList($managerId) {
        $query = "SELECT o.id, p.name, o.status ";
        $query .= "FROM `order` o ";
        $query .= "INNER JOIN `sale` s ON s.id = o.saleid ";
        $query .= "INNER JOIN `product` p ON p.id = s.productid ";
        $query .= "INNER JOIN `artist` art ON art.id = p.artistid ";
        $query .= "WHERE art.`accountId`=\"$managerId\" ";
        $query .= "ORDER BY 1 DESC";

        $result = $this->db->query($query);
        $i=0;
        if($this->db->resultSize($result)>0) {
            while($line = $this->db->fetchRow($result)) {
                $array[$i]['id']= $line[0];
                $array[$i]['name']= $line[1];
                $array[$i++]['status']= $line[2];
            }
        } else {
            $array = Array();
        }

        return $array;
    }
    
    public function getFansFromSale($saleId){
        $sql = "SELECT o.userId, a.firstName, a.lastName, a.email, o.dtCreated, o.maxPrice, o.status, o.error ";
        $sql .= "FROM `order` o ";
        $sql .= "INNER JOIN `account` a ON a.id = o.userId ";
        $sql .= "WHERE o.saleID=".$saleId;
        $result = $this->db->query($sql);
        $return = Array();
        for ($i=0; $line = $this->db->fetchRow($result); $i++) {
            $return[$i][0] = $line[0];
            $return[$i][1] = $line[1];
            $return[$i][2] = $line[2];
            $return[$i][3] = $line[3];
            $return[$i][4] = $line[4];
            $return[$i][5] = $line[5];
            $return[$i][6] = $line[6];
            $return[$i][7] = $line[7];
        }
        return $return;
    }

}
?>
