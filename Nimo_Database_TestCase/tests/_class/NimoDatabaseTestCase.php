<?php
require_once dirname(__FILE__) . "/DatabaseConnectBag.php";

class NimoDatabaseTestCase extends PHPUnit_Extensions_Database_TestCase{

    static private $pdo = null;
    private $connection = null;

    private $database_connect_bag = null;

    public function SetLoginDatabaseInfo(DatabaseConnectBag $bag) {
        $this->database_connect_bag = $bag;
    }

    public function GetPdo() {
    	return self::$pdo;
    }

    protected function getConnection() {
    	if ($this->database_connect_bag === null) {
    		throw new Exception("should be use SetLoginDatabaseInfo before getConnection");
    	}
        $database_connect_bag = $this->database_connect_bag;
        $db_dsn = $database_connect_bag->type
            .":host="  . $database_connect_bag->host
            .";dbname=". $database_connect_bag->dbname
        ;
    	$db_dbname   = $database_connect_bag->dbname;
    	$db_username  = $database_connect_bag->username;
    	$db_password = $database_connect_bag->password;

        if ($this->connection === null) {
            if (self::$pdo == null) {
                $have_account = $this->isVarNull($db_username);
                $have_password = $this->isVarNull($db_password);
                if ($have_account AND $have_password) {
	                self::$pdo = new PDO( $db_dsn, $db_username, $db_password);
                } else {
	                self::$pdo = new PDO( $db_dsn);
                }
            }
            $this->connection = $this->createDefaultDBConnection(
                self::$pdo,
                $db_dbname
            );
        }
        return $this->connection;
    }

    private function isVarNull($var) {
    	return ($var === null);
    }

    protected function getDataSet() {}
}
