<?php
require_once dirname(__FILE__) . "/../src/Foo.php";
require_once dirname(__FILE__) . "/_class/NimoDatabaseTestCase.php";

class FooTest extends NimoDatabaseTestCase {

    private $pdo = null;
    private $connection = null;

    public function __construct() {
        // 登入資料庫
        $this->initialDatabase();
    }

    private function initialDatabase() {
        $database_connect_bag = $this->getDatabaseConnectBag();
        $this->SetLoginDatabaseInfo($database_connect_bag);

        $this->connection = parent::GetConn();
        $this->pdo        = parent::GetPdo();
    }

    private function getDatabaseConnectBag() {
        $db_dbname   = "test_db";
        $db_dsn_type = "mysql";
        $db_dsn_host = "localhost";
        $db_account  = "nimo";
        $db_password = "nimo";

        $database_connect_bag = new DatabaseConnectBag();
        $database_connect_bag->Set(
            $db_dbname,
            $db_dsn_type,
            $db_dsn_host,
            $db_account,
            $db_password
        );
        return $database_connect_bag;
    }

    // 設定每次測試的資料庫初始資料
    protected function getDataSet() {
        return $this->createArrayDataSet(
            array(
                'test_table' => array(
                    array( "sn" => null, "name" => "nimo", "age" => 25),
                    array( "sn" => null, "name" => "bloodcat", "age" => 26),
                )
            )
        );
        // return $this->createXMLDataSet(__DIR__ . '/_files/testSeedData.xml');
    }

    public function testSimple() {
        $conn = $this->connection;
        $pdo = $this->pdo;

        $foo = new Foo($pdo);

        $foo->insert(array('name'=>'dong', 'age'=>'23'));

        $actual   = $conn->createQueryTable('test_table', 'SELECT * FROM test_table');
        $data_set = $this->createXMLDataSet(__DIR__ . '/_files/testExpectedData.xml');
        $expected = $data_set->getTable('test_table');

        $this->assertTablesEqual($expected, $actual);
    }


}
