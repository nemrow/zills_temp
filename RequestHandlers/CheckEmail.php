<?php

require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');

class CheckEmail extends RequestHandlerBase {
    private $email;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = $data['email'];
        
        return true;
    }

    public function process() {
        $query = "SELECT id FROM account WHERE email = \"".mysql_real_escape_string($this->email)."\"";
        $result = $this->db->query($query);

        if ($this->db->resultSize($result)>0) {
            return "EmailExists";
        }
        return "success";
    }

}

?>