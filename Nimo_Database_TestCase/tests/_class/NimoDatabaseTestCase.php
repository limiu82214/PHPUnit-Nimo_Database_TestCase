<?php
require_once dirname(__FILE__) . "/DatabaseConnectBag.php";

class NimoDatabaseTestCase extends PHPUnit_Extensions_Database_TestCase{

    private $pdo = null;
    private $connection = null;

    private $database_connect_bag = null;

    public function SetLoginDatabaseInfo(DatabaseConnectBag $bag) {
        $this->database_connect_bag = $bag;
    }

    public function GetPdo() {
    	return $this->pdo;
    }

    protected function getConnection() {
        $this->checkDataBaseConnectBag();
        $db_dbname = $this->database_connect_bag->dbname;

        if ($this->isImplementedConnection()) {
            return $this->connection;
        }

        if ($this->isImplementedPDO()) {
            $this->connection = $this->createConnectionByPDO($this->pdo, $db_dbname);
        } else {
            $this->implementPDO();
            $this->connection = $this->createConnectionByPDO($this->pdo, $db_dbname);
        }
        return $this->connection;
    }
    private function checkDataBaseConnectBag() {
        if ($this->database_connect_bag === null) {
            throw new Exception("should be use SetLoginDatabaseInfo before getConnection");
        }
    }
    private function makeDatabaseDSN(DatabaseConnectBag $database_connect_bag) {
        $db_dsn = $database_connect_bag->type
            .":host="  . $database_connect_bag->host
            .";dbname=". $database_connect_bag->dbname
        ;
        return $db_dsn;
    }
    private function isImplementedConnection() {
        return ($this->connection !== null);
    }
    private function isImplementedPDO() {
        return ($this->pdo !== null);
    }
    private function createConnectionByPDO(PDO $pdo, $dbname) {
        $connection = $this->createDefaultDBConnection(
            $pdo,
            $dbname
        );
        return $connection;

    }
    private function implementPDO() {
        $this->checkDataBaseConnectBag();

        $database_connect_bag = $this->database_connect_bag;

        $db_dsn      = $this->makeDatabaseDSN($database_connect_bag);
        $db_dbname   = $database_connect_bag->dbname;
        $db_username = $database_connect_bag->username;
        $db_password = $database_connect_bag->password;

        $have_account = $this->isVarNull($db_username);
        $have_password = $this->isVarNull($db_password);
        if ($have_account AND $have_password) {
            $this->pdo = new PDO( $db_dsn, $db_username, $db_password);
        } else {
            $this->pdo = new PDO( $db_dsn);
        }

    }

    private function isVarNull($var) {
    	return ($var === null);
    }

    protected function getDataSet() {}
}
