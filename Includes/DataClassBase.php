<?php

require_once('DataValidation.php');

abstract class DataClassBase {
    protected $colNames;
    private $colValues;
    protected $colTypes;
    protected $db;
    protected $id;
    protected $tableName;
    protected $tableType;
    protected $deleteAllowed=false;
    protected $readOnly = false;
    protected $noAuditDates = false;
    protected $colCount = 0;
    private $colUpdated;
    private $updates = false;


    public function __construct (DatabaseBase $db) {
        $this->db=$db;

        if(!$this->noAuditDates) {
            $this->colNames[$this->colCount]='dtUpdated';
            $this->colTypes[$this->colCount++]='date';

            $this->colNames[$this->colCount]='dtCreated';
            $this->colTypes[$this->colCount++]='date';
        }

        for ($i=0; $i<count($this->colTypes);$i++) {
            $this->colUpdated[$i]=false;
            $this->colValues[$i]=-1;
        }
    }

    protected function get($columnName) {
        $i = array_search($columnName, $this->colNames);
        if($i === FALSE) {
            throw new Exception("No such column: $columnName");
        }
        return DataValidation::retrieveForDisplay($this->colValues[$i], $this->colTypes[$i]);
    }
    protected function set($columnName, $value) {

        $i = array_search($columnName, $this->colNames);
        if($i === FALSE) {
            throw new Exception("No such column: $columnName");
        }

        $this->colValues[$i] = DataValidation::validateAndParse($value, $this->colTypes[$i]);
        $this->colUpdated[$i] = true;
        $this->updates = true;
    }

    //Common properties
    final public function getId() {
        return $this->id;
    }

    final public function setId($unsupported) {
        throw new Exception("Unsupported");
    }

    final public function getDtCreated() {
        if($this->noAuditDates) {
            throw new Exception("Audit Dates Unsupported");
        } else {
            return $this->get('dtCreated');
        }
    }

    final public function getDtUpdated() {
        if($this->noAuditDates) {
            throw new Exception("Audit Dates Unsupported");
        } else {
            return $this->get('dtUpdated');
        }
    }

    final public function setDtUpdated($unsupported) {
        throw new Exception("Unsupported");
    }

    final public function setDtCreated($unsupported) {
        throw new Exception("Unsupported");
    }

    public function read($id) {
        $this->readByKeyValues(Array('id'), Array($id));
    }


    protected function readByKeyValue($key, $value) {
        $this->readByKeyValues(Array($key), Array($value));
    }

    protected function readByKeyValues($keys, $values) {


        $query = "SELECT ";

        $query .= "* FROM `{$this->tableName}` WHERE 1=1";
        for($i=0; $i<count($keys); $i++) {
            if(!isset($keys[$i]) || array_key_exists($keys[$i], $this->colNames)) {
                throw new Exception("Invalid key specified");
            }
            if(!isset($keys[$i]) || $keys[$i]=='' || ($keys[$i]=='id' && !is_numeric($values[$i]))) {
                throw new Exception("Invalid $this->tableType specified");
            }
            $query .= " AND `{$keys[$i]}`=\"{$values[$i]}\"";
        }

        $result = $this->db->query($query);

        if ($this->db->resultSize($result) != 1) {
                throw new Exception("Unable to read {$this->tableType} info");
        }
        $row = $this->db->fetchAssoc($result);
        // initialize

        foreach($row as $key => $value) {
            if($key=='id') {
                $this->id = $value;
            }
            $i = array_search($key, $this->colNames);
            $this->colValues[$i]=$value;
        }

    }

    protected function readListByKeyValue($keys, $values, $limit) { //Todo not clean, but ugh.  Should move over to helper class
        if (count($keys) != count($values)) {
            throw new Exception("Key count not equal value count");
        }
        $query = "SELECT * FROM `{$this->tableName}` WHERE 1=1 ";

        for($i=0; $i<count($keys); $i++) {
            $query .= " AND `{$keys[$i]}`=\"{$values[$i]}\"";
        }
        if($limit!=0) {
            $query .= " LIMIT 1";

        }
        $result = $this->db->query($query);
        if ($this->db->resultSize($result) < 1) {
            //echo $query;
                throw new Exception("Unable to read {$this->tableType} info");
        }

        return $result;

    }
    public function save() {
        $this->savebase(true);
    }

    protected function saveWithOutUpdates() {
        $this->savebase(false);
    }

    private function savebase($updateTimestamps) {

        if(count($this->colNames)!=count($this->colValues)) {
            throw new Exception("Error with {$this->tableType}");
        }
        if(!$this->updates) {
            throw new Exception("Nothing to update");
        }
         //$this->db->beginTran();
         if($this->id!=0) {
             if($this->readOnly) {
                 throw new Exception("This table is read only");
             }
             $query = "UPDATE `{$this->tableName}` SET ";
             for($i=0; $i<count($this->colNames); $i++) {
                 if($this->colNames[$i]=='dtUpdated' && $updateTimestamps) {
                     $query .= "`dtUpdated` = ".time();
                 } else if($this->colUpdated[$i]) {
                     $query .= "`{$this->colNames[$i]}` = '".mysql_real_escape_string($this->colValues[$i])."',";
                 }
             }
             $query[strlen($query)-1] = ' ';
             $query .= "WHERE id={$this->id}";
         } else {
             $query = "INSERT INTO `{$this->tableName}` (";
             for($i=0; $i<count($this->colNames); $i++) {
                if($this->colUpdated[$i] || $this->colNames[$i]=='dtCreated' && $updateTimestamps) {
                     $query .= "`{$this->colNames[$i]}`,";
                 }

             }
             $query[strlen($query)-1] = ' ';
             $query .= ") VALUES (";
             for($i=0; $i<count($this->colValues);$i++) {
                if($this->colNames[$i]=='dtCreated' ) {
                    $query .= time().",";
                } else if($this->colUpdated[$i]) {
                     $query .= "\"".mysql_real_escape_string($this->colValues[$i])."\",";
                }

             }
             $query[strlen($query)-1] = ' ';
             $query .= ')';
        }

        $this->db->query($query);

        if($this->db->affectedRows()!=1 || $this->db->hasError()) {
            echo $query;
        //    $this->db->rollback();
            if($this->id==0) {
                throw new Exception("Could not insert $this->tableType!");
            } else {
                throw new Exception("Could not update $this->tableType!");
            }

        }
        if($this->id==0) {
            $this->id = $this->db->getInsertId();
        }
        //$this->db->commit();
    }

    public function delete($id) {
        if(!$this->deleteAllowed) {
            throw new Exception("Delete not allowed");
        }
        if($id!=0) {
            $this->db->query("DELETE FROM {$this->tableName} WHERE id=$id");
        } else {
            throw new Exception("Could not delete {$this->tableType}");
        }
    }

    protected function generateSalt($length) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $salt = "";
        mt_srand($this->make_seed());
        for($i=0; $i < 25; $i++) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
        }
        return $salt;
    }

    protected function generateSHA512Salt($length) {
        return substr(hash('sha512', $this->generateSalt(($length*2)%256)), 0, $length);
    }

    private function make_seed() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 106700);
    }
}

?>
