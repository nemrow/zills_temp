<?php
require_once('Includes/DataClassBase.php');
class referer extends DataClassBase {

    public function getReferer() {
        return $this->get('referer');
    }

    public function setReferer($referer) {
        $this->set('referer', $referer);
    }
    public function getPage() {
        return $this->get('page');
    }

    public function setPage($page) {
        $this->set('page', $page);
    }

    public function getIP() {
        return $this->get('ipaddress');
    }

    public function setIP($ip) {
        $this->set('ipaddress', $ip);
    }


    public function __construct ($db) {
        $this->tableName='referer';
        $this->tableType='referer';
        $this->readOnly = true;
        $this->noAuditDates = true;

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='referer';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='page';
        $this->colTypes[$this->colCount++]='string250';

        $this->colNames[$this->colCount]='pageId';
        $this->colTypes[$this->colCount++]='id';

        $this->colNames[$this->colCount]='ipaddress';
        $this->colTypes[$this->colCount++]='string15';

        parent::__construct($db);
    }

    public function getRefList($pageName, $saleId) {
        $SQL = "SELECT `referer`, count(`referer`) FROM `referers` WHERE `page`=\"$pageName\" AND pageId=$saleId GROUP BY `referer`";
        $result = $this->db->query($SQL);

        $i=0;
        if($this->db->resultSize($result)>=1) {
            while($line = $this->db->fetchRow($result)) {
                if($line[0]=="") {
                    $array[$i][0] = "No Referer";
                } else {
                    $array[$i][0] = $line[0];
                }
                $array[$i++][1] = $line[1];
            }
        } else {
            $array = Array();
        }

        return $array;
    }

    public function getPageViewCounts($pageName, $saleId) {
        $SQL = "SELECT count(`id`) FROM `referers` WHERE `page`=\"$pageName\" AND pageId=$saleId ";
        $result = $this->db->query($SQL);

        if($this->db->resultSize($result)>0) {
            $line = $this->db->fetchRow($result);
            return $line[0];
        } else {
            return 0;
        }
    }




}
?>
