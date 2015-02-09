<?php
require_once('DatabaseBase.php');
require_once('MySQLDB.php');
require_once('DataClasses/account.php');
require_once('DataClasses/attachment.php');

abstract class PageBase {
    protected $db;
    protected $pageTitle;
    protected $currentPage;
    protected $myFacebook;
    protected $loginUrl='';
    private $sessionStarted = false;

    public function __construct () {
        $this->db = new MySQLDB();
    }

    public function header() {
        if(!$this->sessionStarted) {
            $this->sessionStarted = true;
            $this->startSession();
            //$this->myFacebook = new Facebook(array(
            //    'appId'  => FACEBOOKAPIID,
            //    'secret' => FACEBOOKSECRET,
            //));
        }
        if(array_key_exists('id', $_GET)) {
            $id = (int)$_GET['id'];
        } else {
            $id = 0;
        }
        try {
            if(array_key_exists('page', $_GET)) {
                $page = mysql_real_escape_string($_GET['page']);
            } else {
                $page = "";
            }
            if(array_key_exists('HTTP_REFERER', $_SERVER)) {
                $referer = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
            } else {
                $referer = "";
            }
            if(array_key_exists('REMOTE_ADDR', $_SERVER)) {
                $ipaddress = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
            } else {
                $ipaddress = "";
            }
            $SQL = 'INSERT INTO referers VALUES (NULL, "'.  $referer.'","'.$page.'", '.$id.', "'.$ipaddress.'")';
            $this->db->query($SQL);
        } catch (Exception $e) {

        }
    }

    public function redirect($url) {
        header("Location: $url");
        die();
    }

    abstract public function init($data);

    abstract public function footer();

    abstract public function body();

    // starts session, logins, redirects, dies
    protected function login($useCookies, $userId, $redirectURL) {
        if(!$this->sessionStarted) {
            throw new Exception("Session must be started!");
        }
        $this->db->query("UPDATE account SET dtLastLogin=UNIX_TIMESTAMP() WHERE id=\"$userId\"");
        session_regenerate_id();

        $result = $this->db->query("SELECT email, password, accountType FROM account WHERE id=\"$userId\"");
        if($this->db->resultSize($result) > 0 ) {
            list($email, $passwordHash, $userAccountType) = $this->db->fetchRow($result);
            $_SESSION['userAccountType'] = $userAccountType;
            $_SESSION['userId'] = $userId;

            if($useCookies) {
                setcookie("email", $email, time()+604800);
                setcookie("pass", $passwordHash, time()+604800);
            }
        } else {
            throw new Exception('Error logging in');
        }

        $this->redirect($redirectURL);
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
                if(array_key_exists('email', $_COOKIE)) {
                    $myAccount = new account($this->db);
                    $userId = $myAccount->cookieLogin($_COOKIE['email'], $_COOKIE['pass']);
                    if($userId>0) {
                        return $userId;
                    }
                    return 0;
                } else {
                    return 0;
                }
            }
        }
    }

    protected function userName() {
        $myAccount = new account($this->db);
        $myAccount->read($this->userId());
        return $myAccount->getFirstName() . " " . $myAccount->getLastName();
    }

    protected function userAccountType() {
        if(!$this->sessionStarted) {
            throw new Exception('Could not get account type: Session not started.');
        } else {
            if(array_key_exists('userAccountType', $_SESSION)) {
                return $_SESSION['userAccountType'];
            } else {
                return 0;
            }
        }
    }

    protected function getUserPicture() {
        $myAccount = new account($this->db);
        $myAccount->read($this->userId());
        $myAttachment = new attachment($this->db);
        if($myAccount->getImageId()> 0) {
            $myAttachment->read($myAccount->getImageId());
            return $myAttachment->getPath();
        } else {
            return 'images/faceHolder1.jpg';
        }
        
    }

    protected function logout() {
        session_unset();
    }

    private function startSession() {
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
    }
}

?>
