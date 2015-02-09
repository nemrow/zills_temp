<?php
require_once('Includes/DataClassBase.php');
class attempt extends DataClassBase {

    public function getEmail() {
        return $this->get('email');
    }

    public function setEmail($email) {
        $this->set('email', $email);
    }

    public function getIP() {
        return $this->get('ip');
    }

    public function setIP($ip) {
        $this->set('ip', $ip);
    }

    public function __construct ($db) {
        $this->tableName='account';
        $this->tableType='Account';

        $this->colNames[$this->colCount]='id';
        $this->colTypes[$this->colCount++]='int';

        $this->colNames[$this->colCount]='email';
        $this->colTypes[$this->colCount++]='string200';

        $this->colNames[$this->colCount]='ip';
        $this->colTypes[$this->colCount++]='string15';

        parent::__construct($db);
    }

    public function emailExists($email) {
        $sql = "SELECT count(id) FROM account where `email`=\"$email\"";
        return $this->db->queryCount($sql) > 0;
    }

    public function login($email, $password) {
        $sql = "SELECT id, salt, password FROM account WHERE `email`=\"$email\" LIMIT 1";
        $result = $this->db->query($sql);
        list($userId, $salt, $passwordHash) = $this->db->fetchRow($result);
        if($this->computePasswordHash($password, $salt) == $passwordHash) {
            return $userId;
        } else {
            return false;
        }
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
}
?>
