<?php
class DatabaseConnectBag {
    public $dbname;
    public $type;
    public $host;
    public $username;
    public $password;

    public function __construct($dbname, $type, $host, $username='', $password='') {
    	$this->dbname   = $dbname;
    	$this->type     = $type;
    	$this->host     = $host;
    	$this->username = $username;
    	$this->password = $password;
    }
}
