<?php
require_once dirname(__FILE__) . "/../Nimo_Database_TestCase/tests/_class/NimoDatabaseTestCase.php";

class NimoDatabaseTestCaseTest extends PHPUnit_Framework_TestCase{
    private $NDT = null;
    public function setUp() {
        $this->NDT = new NimoDatabaseTestCase();
    }

    public function test_NimoDatabaseTestCase_is_instance_of_PHPUnit_Extensions_Database_TestCase() {
        $NDT = $this->NDT;
        $this->assertInstanceOf('PHPUnit_Extensions_Database_TestCase', $NDT);
    }
    public function test_createArrayDataSet_is_instance_of_PHPUnit_Extensions_Database_DataSet_AbstractDataSet() {
        $NDT = $this->NDT;
        $data_set = $NDT->createArrayDataSet(array());
        $this->assertInstanceOf('PHPUnit_Extensions_Database_DataSet_AbstractDataSet', $data_set);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage should be used after SetLoginDatabaseInfo
     */
    public function test_GetPdo_is_error_before_SetLoginDatabaseInfo() {
        $NDT = $this->NDT;
        $NDT->GetPdo();
    }
    public function test_GetPdo_is_not_null_after_SetLoginDatabaseInfo() {
        $NDT = $this->NDT;
        $database_connect_bag = $this->getDatabaseConnectBag();
        $NDT->SetLoginDatabaseInfo($database_connect_bag);

        $this->assertNotNull($NDT->GetPdo());
    }
    private function getDatabaseConnectBag() {
        $db_dbname   = "test_db";
        $db_type     = "mysql";
        $db_host     = "localhost";
        $db_account  = "nimo";
        $db_password = "nimo";

        $database_connect_bag = new DatabaseConnectBag();
        $database_connect_bag->Set(
            $db_dbname,
            $db_type,
            $db_host,
            $db_account,
            $db_password
        );
        return $database_connect_bag;
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage should be used after SetLoginDatabaseInfo
     */
    public function test_GetConn_is_error_before_SetLoginDatabaseInfo() {
        $NDT = $this->NDT;
        $database_connect_bag = $this->getDatabaseConnectBag();
        // $NDT->SetLoginDatabaseInfo($database_connect_bag);

        $NDT->getConn();
    }

    public function test_GetConn_after_SetLoginDatabaseInfo() {
        $NDT = $this->NDT;
        $database_connect_bag = $this->getDatabaseConnectBag();
        $NDT->SetLoginDatabaseInfo($database_connect_bag);
        $connection = $NDT->getConn();

        $this->assertInstanceOf('PHPUnit_Extensions_Database_DB_IDatabaseConnection', $connection);
    }
    public function test_SetLoginDatabaseInfo_will_instance_pdo() {
        $NDT = $this->NDT;
        $database_connect_bag = $this->getDatabaseConnectBag();
        $NDT->SetLoginDatabaseInfo($database_connect_bag);

        $pdo = $NDT->GetPdo();
        $this->assertInstanceOf('PDO', $pdo);
    }
}
