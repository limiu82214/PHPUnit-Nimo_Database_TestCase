<?php
require_once dirname(__FILE__) . "/DatabaseConnectBag.php";
require_once dirname(__FILE__) . "/NimoDbUnitArrayDataSet.php";

class NimoDatabaseTestCase extends PHPUnit_Extensions_Database_TestCase{

    private $pdo = null;
    private $connection = null;

    private $database_connect_bag = null;

    public function SetLoginDatabaseInfo(DatabaseConnectBag $bag) {
        $this->database_connect_bag = $bag;
        $this->pdo = $this->getNewPdo($bag);
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

        if ($this->isNotImplementedPdo()) {
            $this->pdo = $this->getNewPdo($bag);
        }

        $this->connection = $this->createConnectionByPdo($this->pdo, $db_dbname);
        return $this->connection;
    }
    private function checkDataBaseConnectBag() {
        if ($this->database_connect_bag === null) {
            throw new Exception("should be use SetLoginDatabaseInfo before getConnection");
        }
    }
    private function isImplementedConnection() {
        return ($this->connection !== null);
    }
    private function isNotImplementedPdo() {
        return ($this->pdo === null);
    }
    private function createConnectionByPdo(PDO $pdo, $dbname) {
        $connection = $this->createDefaultDBConnection($pdo, $dbname);
        return $connection;
    }
    private function getNewPdo(DatabaseConnectBag $bag) {
        $this->checkDataBaseConnectBag();
        $database_connect_bag = $this->database_connect_bag;

        $dsn      = $this->getDsnByDatabaseConnectBag($database_connect_bag);
        $username = $database_connect_bag->username;
        $password = $database_connect_bag->password;

        return new PDO($dsn, $username, $password);
    }
    private function getDsnByDatabaseConnectBag(DatabaseConnectBag $database_connect_bag) {
        $dsn = $database_connect_bag->type
            .":host="  . $database_connect_bag->host
            .";dbname=". $database_connect_bag->dbname
        ;
        return $dsn;
    }

    protected function getDataSet() {}

    protected function createArrayDataSet(array $array) {
        return new NimoDbUnitArrayDataSet($array);
    }
}
