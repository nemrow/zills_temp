<?php
$fullPath = '/home/jamesmcguire/zillionears.com/public_html/';
if(__DIR__ != '/home/jamesmcguire/zillionears.com/public_html/DataClasses'){
    require_once('Includes/DataClassBase.php');
}else{
    require_once($fullPath.'Includes/DataClassBase.php');
}

class account extends DataClassBase {

    public function getEmail() {
        return $this->get('email');
    }

    public function setEmail($email) {
        $this->set('email', $email);
    }

    public function getPasswordHash() {
        return $this->get('password');
    }

    public function setPasswordHash($password) {
        $this->set('password', $password);
    }

    public function getSalt() {
        return $this->get('salt');
    }

    public function setSalt($salt) {
        $this->set('salt', $salt);
    }

    public function getAccountType() {
        return $this->get('accountType');
    }

    public function setAccountType($type) {
        $this->set('accountType', $type);
    }

    public function getFirstName() {
        return $this->get('firstName');
    }

    public function setFirstName($name) {
        $this->set('firstName', $name);
    }

    public function getLastName() {
        return $this->get('lastName');
    }

    public function setLastName($name) {
        $this->set('lastName', $name);
    }

    public function getImageId() {
        return $this->get('imageId');
    }

    public function setImageId($id) {
        $this->set('imageId', $id);
    }

    public function getDtLastLogin() {
        return $this->get('dtLastLogin');
    }

    public function setDtLastLogin($date) {
        $this->set('dtLastLogin', $date);
    }

    public function __construct ($db) {
        $this->tableName='account';
        $this->tableType='Account';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='email';
        $this->colTypes[$this->colCount++]='string200';

        $this->colNames[$this->colCount]='salt';
        $this->colTypes[$this->colCount++]='password';

        $this->colNames[$this->colCount]='password';
        $this->colTypes[$this->colCount++]='password';

        $this->colNames[$this->colCount]='accountType';
        $this->colTypes[$this->colCount++]='accountType';

        $this->colNames[$this->colCount]='firstName';
        $this->colTypes[$this->colCount++]='string150';

        $this->colNames[$this->colCount]='lastName';
        $this->colTypes[$this->colCount++]='string150';

        $this->colNames[$this->colCount]='imageId';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='dtLastLogin';
        $this->colTypes[$this->colCount++]='date';

        parent::__construct($db);
    }

    public function emailExists($emailUV) {
        $email = mysql_real_escape_string($emailUV);
        $sql = "SELECT count(id) FROM `account` where `email`=\"$email\"";
        return $this->db->queryCount($sql) > 0;
    }

    public function login($emailUV, $password) {
        $email = mysql_real_escape_string($emailUV);
	$this->logAttempt($email);
        $attempts = $this->checkAttempts($email);
        if($attempts < LOGINATTEMPTS) {
            $sql = "SELECT id, salt, password FROM `account` WHERE `email`=\"$email\" LIMIT 1";
            $result = $this->db->query($sql);
            list($userId, $salt, $passwordHash) = $this->db->fetchRow($result);
            if($this->computePasswordHash($password, $salt) == $passwordHash) {
                $this->clearAttempts($email);
                return $userId;
            } else {
                return -$attempts;
            }
        } else {
            throw new Exception("<div class='boringLoginErrorFaceHolder'><img class='boringLoginErrorFaceImg' src='images/errorFace.png' /><p class='boringLoginErrorTextBox'>You have been locked out.  Please wait 15 minutes and try again.</p></div>");
        }
    }

   public function cookieLogin($emailUV, $passwordHash) {
        $email = mysql_real_escape_string($emailUV);
        $password = mysql_real_escape_string($passwordHash);
	$this->logAttempt($email);
        $attempts = $this->checkAttempts($email);
        if($attempts < LOGINATTEMPTS) {
            $sql = "SELECT id, accountType FROM `account` WHERE `email`=\"$email\" and `password`=\"$password\" LIMIT 1";
            $result = $this->db->query($sql);
            if($this->db->resultSize($result) > 0) {
                list($userId, $userAccountType) = $this->db->fetchRow($result);
                $_SESSION['userAccountType'] = $userAccountType;
                $_SESSION['userId'] = $userId;
                $this->clearAttempts($email);
                return $userId;
            } else {
                setcookie('email', '');
                setcookie('pass', '');
                setcookie('email','', time()-3600);
                setcookie('pass','', time()-3600);
                return -$attempts;
            }
        } else {
            throw new Exception("You have been locked out.  Please wait 15 minutes and try again.");
        }
    }

    private function logAttempt($email) {
        $sql = "INSERT INTO `attempt` (ip, email, dtCreated) VALUES (\"{$_SERVER['REMOTE_ADDR']}\", \"$email\", ".time().")";
        $this->db->query($sql);
    }

    private function checkAttempts($email) {
        $sql = "SELECT count(id) FROM `attempt` WHERE (`ip`=\"{$_SERVER['REMOTE_ADDR']}\" OR `email`=\"$email\") AND dtCreated >= ". (time()-(60*15));
        $result = $this->db->queryCount($sql);
        return $result;
    }

    private function clearAttempts($email) {
        $sql = "DELETE FROM `attempt` WHERE `ip`=\"{$_SERVER['REMOTE_ADDR']}\" AND `email`=\"$email\"";
        $this->db->query($sql);
    }

    public function create($accountType, $email, $password, $firstName, $lastName) {
        if($this->emailExists($email)) {
            throw new Exception('Email already in use.');
        }

        $salt = hash('sha512', $this->generateSalt(25)+time());
        $this->setAccountType($accountType);
        $this->setEmail($email);
        $this->setSalt($salt);
        $this->setPasswordHash($this->computePasswordHash($password, $salt));
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->save();
        if($this->getId() <= 0) {
            throw new Exception("Account could not be created");
        }
        return $this->getId();
    }

    public function setPassword($newPassword) {
        $this->setPasswordHash($this->computePasswordHash($newPassword, $this->getSalt()));
    }

    private function computePasswordHash($password, $salt) {
        return hash("sha512", PEANUT.$password.$salt);
    }
    
    public function readByEmail($email) {
        parent::readByKeyValue('email', $email);
    }
    
    public function hasActiveAmazonAccount() {
        $sql = "SELECT count(a.id) FROM account a ";
        $sql .= "INNER JOIN recipientrequest rr on rr.userid=a.id ";
        $sql .= "WHERE rr.status=\"SR\"";
        $count = $this->db->queryCount($sql);
        return $count>0;
    }
    
}
?>
