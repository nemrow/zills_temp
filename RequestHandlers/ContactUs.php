<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('DataClasses/account.php');
require_once('DataClasses/artist.php');
require_once('DataClasses/digitalMusic.php');
require_once('DataClasses/physicalMerch.php');
require_once('DataClasses/physicalMusic.php');
require_once('DataClasses/product.php');
require_once('DataClasses/sale.php');
require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('Includes/emailTemplates.php');

class ContactUs extends RequestHandlerBase {
    private $email;

    public function auth() {
        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        $this->email = $data['email'];
        $this->subject = $data['subject'];
        $this->message = $data['message'];


        return true;
    }

    public function process() {
        /*$query = "SELECT id FROM emails WHERE email = \"".mysql_real_escape_string($this->email)."\"";
        $result = $this->db->query($query);

        if ($this->db->resultSize($result)>1) {
            return "EmailExists";
        }*/
        $query = "INSERT INTO contact VALUES (NULL, \"".mysql_real_escape_string($this->email)."\", \"".mysql_real_escape_string($this->subject)."\", \"".mysql_real_escape_string($this->message)."\");";
        $result = $this->db->query($query);
        if ($this->db->affectedRows()==1) {
            $myEmailer = new emailTemplates;
            $myEmailer->sendSingleEmail('JNemrow@zillionears.com', 'staff@zillionears.com', 'Contact Us - '.$this->subject, 'Contact Us Submission', 'Subject - '.$this->subject, 'Message - '.$this->message, 'Return Email - '.$this->email);
            return 'success';
        } else {
            return 'We\'re sorry, but there was an error storing your contact information.  Please email staff@zillionears.com instead.';
        }
        
    }

}

?>