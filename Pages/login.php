<?php

require_once('DataClasses/account.php');


class login extends pageBase {
    private $errorMessage;
    private $actionData;
    private $message;
    private $url = 'fanadminsettings';
    private $letters;

    public function init($data) {
        parent::header();

        $this->pageTitle = "Zillionears | Login";
        $this->currentPage = 'login';
        $account = new account($this->db);

        if(array_key_exists('action', $_GET)) {
            if(array_key_exists('id', $_GET) && $_GET['action']=='checkout' && (int) $_GET['id'] > 0) {
                $this->actionData = '&amp;action=checkout&amp;id=' . (int) $_GET['id'];
                $this->url = 'checkout&id='. (int) $_GET['id'];
                $this->message = "Please login to your Zillionears.com account to get in on the deal!";
            }
            if(array_key_exists('id', $_GET) && $_GET['action']=='socialsale' && (int) $_GET['id'] > 0) {
                $this->actionData = '&amp;action=socialsale&amp;id=' . (int) $_GET['id'];
                $this->url = 'socialsale&id='. (int) $_GET['id'];
               // $this->message = "Please login to your Zillionears.com account to get in on the deal!";
            }
            if($_GET['action']=='fanAdminSocialSales' || $_GET['action']=='fanAdminSettings' || $_GET['action']=='bandAdminSettings' || $_GET['action']=='bandAdminSales' || $_GET['action']=='fanAdminOrders') {
                $this->actionData = '&amp;action='.$_GET['action'];
                $this->url = $_GET['action'];
                //$this->message = "Please login to your Zillionears.com account to view your account.";
            }
            if($_GET['action']=='createss') {
                $this->url = 'createss';
            }

        }

        if(parent::loggedIn()) {
            parent::redirect($this->url);
        }

        if(array_key_exists('email', $data) && array_key_exists('password', $data)) {
            try {
                $userId = $account->login($data['email'], $data['password']);
                if($userId >0) {
                //logged in
                    $useCookies = array_key_exists('keepLoggedIn', $data) && $data['keepLoggedIn'];
                    parent::login($useCookies, $userId, $this->url);
                } else {
                    $this->errorMessage = "<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>Could not find your email and password.  You have used ".(-$userId)." login attempts out of ".LOGINATTEMPTS.".  After all ".LOGINATTEMPTS." have been used, you will have to wait ".LOGINATTEMPTSTIME." minutes before logging in.</p></div>";
                }
            } catch (Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
            
        } else {
            // do nothing

        }
        
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
        require_once('templates/login.html');
        return true;
    }

}

?>
