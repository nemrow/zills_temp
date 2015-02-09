<?php

require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');

class AddEmail extends RequestHandlerBase {
    private $email;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = $data['email'];


        return true;
    }

    public function process() {
        $query = "SELECT id FROM emails WHERE email = \"".mysql_real_escape_string($this->email)."\"";
        $result = $this->db->query($query);

        if ($this->db->resultSize($result)>1) {
            return "EmailExists";
        }
        $query = "INSERT INTO emails VALUES (NULL, \"".mysql_real_escape_string($this->email)."\");";
        $result = $this->db->query($query);
        if ($this->db->affectedRows()==1) {
            return 'success';
        } else {
            return 'We\'re sorry, but there was an error storing your email.  Please email admin@zillionears.com instead for your free trial.';
        }
    }

}

?>