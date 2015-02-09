<?php

require_once('DataClasses/account.php');

class register extends pageBase {
    private $errorMessage;
    private $actionData;
    private $url;
    private $message;

    public function init($data) {
        parent::header();
        $this->pageTitle = "Zillionears | Register";
        $this->currentPage = 'register';
        $this->url = 'fanadminsettings';

        if(array_key_exists('action', $_GET) && array_key_exists('id', $_GET)) {
            if($_GET['action']=='checkout' && (int) $_GET['id'] > 0) {
                $this->actionData = '&amp;action=checkout&amp;id=' . (int) $_GET['id'];
                $this->url = 'checkout&id='. (int) $_GET['id'];
                $this->message = "Please register a Zillionears.com account to get in on the deal!";
            }
            if(array_key_exists('id', $_GET) && $_GET['action']=='socialsale' && (int) $_GET['id'] > 0) {
                $this->actionData = '&amp;action=socialsale&amp;id=' . (int) $_GET['id'];
                $this->url = 'socialsale&id='. (int) $_GET['id'];
                //$this->message = "Please login to your Zillionears.com account to get in on the deal!";
            }
            if($_GET['action']=='fanAdminSocialSales' || $_GET['action']=='fanAdminSettings' || $_GET['action']=='bandAdminSettings' || $_GET['action']=='bandAdminSales' || $_GET['action']=='fanAdminOrders') {
                $this->actionData = '&amp;action='.$_GET['action'];
                $this->url = $_GET['action'];
               // $this->message = "Please login to your Zillionears.com account to view your account.";
            }
            if($_GET['action']=='createss') {
                $this->url = 'createss';
            }
        }

        $account = new account($this->db);
        if(isset($data) && count($data)>0) {
            if(!array_key_exists('email', $data) || strtolower($data['email'])=='email') {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>Where's that email at?!?</p></div>";
                return true;
            }
            if(!array_key_exists('password', $data)) {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>We need a password!</p></div>";
                return true;
            }
            if(!array_key_exists('firstName', $data)) {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>Should we just call you no name? Where's your first name?</p></div>";
                return true;
            }
            if(!array_key_exists('lastName', $data)) {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>Do you not have a last name?</p></div>";
                return true;
            }
            if($account->emailExists($data['email'])) {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>That account already exists dude!</p></div>";
                return true;
            }
            $userId = $account->create('customer', $data['email'], $data['password'], $data['firstName'], $data['lastName']);
            if($userId>0) {
                //success
                parent::login(false, $userId, $this->url);
            } else {
                $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>Something went wrong registering your account!</p></div>";
            }
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
        require_once('templates/register.html');
        return true;
    }

}

?>
