<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Includes/DataClassBase.php');
require_once('Includes/RequestHandlerBase.php');
require_once('DataClasses/account.php');

class Login extends RequestHandlerBase {

    public function __construct($db) {
        parent::__construct($db);
    }

    public function auth() {
        return true;
    }

    public function validate($data) {
        $account = new account($this->db);
        $userid = $account->login($this->email, $this->password);
        if(!$account->login($this->email, $this->password)) {
            throw new exception('Invalid login');
        }

    }

    public function process() {


    }

}

?>