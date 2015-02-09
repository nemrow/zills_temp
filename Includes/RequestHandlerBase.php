<?php
require_once('DatabaseBase.php');
require_once('MySQLDB.php');

abstract class RequestHandlerBase {
    protected $db;
    protected $response="";
    private $sessionStarted;

    public function __construct () {
        $this->db = new MySQLDB();
    }

    // auths user after validateData
    abstract public function auth();

    //loads and validates _POST data
    abstract public function validateAndLoadData($data);

    // processes request
    abstract public function process();


    protected function login($useCookies, $userId) {
        if(!$this->sessionStarted) {
            throw new Exception("Session must be started!");
        }
        $this->db->query("UPDATE account SET dtLastLogin=UNIX_TIMESTAMP() WHERE id=\"$userId\"");
        session_regenerate_id();

        $result = $this->db->query("SELECT accountType FROM account WHERE id=\"$userId\"");
        if($this->db->resultSize($result) != 1 ) {
            $_SESSION['userAccountType'] = "none";
        } else {
            $line = $this->db->fetchRow($result);
            $_SESSION['userAccountType'] = $line[0];
        }

        $_SESSION['userId'] = $userId;

        //$_SESSION['email'] = $email;
        //$_SESSION['pass'] = $passwordHash;
        if($useCookies) {
            setcookie("email", $email, time()+604800);
            setcookie("pass", $passwordHash, time()+604800);
        }
    }

    protected function loggedIn() {
        if(!$this->sessionStarted) {
            throw new Exception('Session not started.');
        } else {
            return isset($_SESSION['userId']);
        }
    }

    protected function userId() {
        if(!$this->sessionStarted) {
            throw new Exception('Session not started.');
        } else {
            if(array_key_exists('userId', $_SESSION)) {
                return $_SESSION['userId'];
            } else {
                return 0;
            }

        }
    }

    protected function userAccountType() {
        if(!$this->sessionStarted) {
            throw new Exception('Session not started.');
        } else {
            if(array_key_exists('userAccountType', $_SESSION)) {
                return $_SESSION['userAccountType'];
            } else {
                return 0;
            }
        }
    }

    protected function logout() {
        session_unset();
    }

    protected function startSession() {
        session_start();

        if (!isset($_SESSION['initiated'])) {
                session_regenerate_id();
                $_SESSION['initiated'] = true;
        }
        if (isset($_SESSION['HTTP_USER_AGENT'])) {
                if ($_SESSION['HTTP_USER_AGENT'] != hash("sha512", $_SERVER['HTTP_USER_AGENT'].'8!eBa%$x2x')) {
                        session_unset();
                        session_destroy();
                }

        } else {
                $_SESSION['HTTP_USER_AGENT'] = hash("sha512", $_SERVER['HTTP_USER_AGENT'].'8!eBa%$x2x');
        }
        /*if(isset($_COOKIE['email']) && !isset($_SESSION['email'])) {
                $_SESSION['email'] = $_COOKIE['email'];
                $_SESSION['pass'] = $_COOKIE['pass'];
                $_SESSION['userid'] = $_COOKIE['userid'];
        }

        if(array_key_exists('passVerifyTime', $_SESSION) && time()-$_SESSION['passVerifyTime'] > 900) { // 15 minute time out
            session_unregister('passVerifyTime');
            session_unregister('passVerify');
        }*/
        $this->sessionStarted=true;
    }

}

?>
