<?php

/**
 * Description of DataBaseBase
 *
 * @author james
 */
abstract class DatabaseBase {
    protected $server;
        protected $user;
        protected $password;
        protected $link;


        abstract public function __construct ();

        abstract protected function connect();

        abstract protected function __destruct();

        abstract public function beginTran();

        abstract public function commit();

	abstract public function rollback();

	abstract public function close();

	abstract public function query($query);

        abstract public function hasError();

	abstract public function resultSize($result);

	abstract public function getInsertId();

	abstract public function affectedRows();

	abstract public function fetchRow($result);

    	abstract public function fetchAssoc($result);
}

?>
