<?php

/**
 * Description of MySQLDB
 *
 * @author james
 */
final class MySQLDB extends DatabaseBase {
    private $persistent=false;

    public function __construct () {
            $this->server= DBHOST;
            $this->user = DBUSER;
            $this->password = DBPASS;
            $this->name = DBNAME;
            $this->connect();
        }

        protected function connect() {
        	if($this->persistent==true) {
        		$this->link = mysql_pconnect($this->server, $this->user, $this->password);
        	} else {
			$this->link = mysql_connect($this->server, $this->user, $this->password);
		}
		if(!$this->link) {
			echo "error!" . mysql_error();
		}
		mysql_select_db($this->name, $this->link);
                if($this->hasError()) {
                    echo "error selecting DB ". mysql_error();
                }
        }

        function __destruct() {
        	if(!$this->persistent) {
	        	$this->close();
	       	}
        }

        function beginTran() {
        	//if($this->inTran==true) {
        	//	throw new Exception("Already in transaction");
        	//} else {
	        	$result = mysql_query("START TRANSACTION", $this->link);
                //        print_r($result);
                       // echo 'tran started';
	        //	$this->inTran=true;
	       // }
        }

        function commit() {
        	//if($this->inTran==false) {
        	//	throw new Exception("Not in transaction");
        	//} else {
                      //  echo 'tran exited';
        	       	mysql_query("COMMIT", $this->link);
        	//       	$this->inTran=false;
        	//}
        }

	function rollback() {
	     	//if($this->inTran==false) {
        	//	throw new Exception("Not in transaction");
        	//} else {
                       // echo 'tran rolled back';
        		mysql_query("ROLLBACK", $this->link);
        	//	$this->inTran=false;
        //	}
        }

	function close() {
            if(isset($this->link) && is_resource($this->link)) {
                mysql_close($this->link);
            }
	}

	function query($query) {
            return mysql_query($query, $this->link);
	}

        function queryCount($query) {
            $row = mysql_fetch_row(mysql_query($query));
            return $row[0];
        }

        function hasError() {
            return mysql_errno($this->link);
        }

	function resultSize($result) {
		return mysql_num_rows($result);
	}

	function getInsertId() {
		return mysql_insert_id($this->link);
	}

	function affectedRows() {
		return mysql_affected_rows($this->link);
	}

	function fetchRow($result) {
		return mysql_fetch_row($result);
	}
    	function fetchAssoc($result) {
		return mysql_fetch_assoc($result);
	}
}

?>
