<?php
require_once('Includes/DataClassBase.php');
require_once('Includes/sale.php');
require_once('Includes/RequestHandlerBase.php');

class AddEmail extends RequestHandlerBase {
    private $message;
    private $sale;

    public function auth() {
        parent::startSession();
        if(isset(parent::loggedIn()) && parent::loggedIn()>0) {
            $this->sale = new sale($this->db);
            return $this->sale->userAuthorized(parent::loggedIn());
        } else {
            return false;
        }

        return true;
    }

    public function validateAndLoadData($data) {  // todo validate if account/sale/etc already exists
        if(array_key_exists('message', $data)) {
            $this->message = $data['message'];
        } else {
            throw new Exception("Email message not sent");
        }

        return true;
    }

    public function process() {
        $this->sale->setEmailmessage($this->message);
        $this->sale->save();

        return true;
    }

}

?>