<?php
require_once dirname(__FILE__) . "/../src/Foo.php";
require_once dirname(__FILE__) . "/_class/NimoDatabaseTestCase.php";

class FooTest extends NimoDatabaseTestCase {

    static private $pdo = null;
    private $connection = null;

    public function getConnection() {
        $db_dbname   = "test_db";
        $db_dsn_type = "mysql";
        $db_dsn_host = "localhost";
        $db_account  = "nimo";
        $db_password = "nimo";
        $database_connect_bag = new DatabaseConnectBag( $db_dbname,
                                                        $db_dsn_type,
                                                        $db_dsn_host,
                                                        $db_account,
                                                        $db_password
        );

        // 設定登入資料庫資訊
        $this->SetLoginDatabaseInfo($database_connect_bag);

        // 保存共用的pdo和connectioin
        $this->connection = parent::getConnection();
        self::$pdo = $this->GetPdo();

        return $this->connection;
    }

    protected function getDataSet() {
        return $this->createXMLDataSet(__DIR__ . '/_files/testSeedData.xml');
    }

    public function testSimple() {
        $conn = $this->connection;
        $pdo = self::$pdo;

        $foo = new Foo($pdo);

        $foo->insert(array('name'=>'dong', 'age'=>'23'));

        $actual   = $conn->createQueryTable('test_table', 'SELECT * FROM test_table');
        $data_set = $this->createXMLDataSet(__DIR__ . '/_files/testExpectedData.xml');
        $expected = $data_set->getTable('test_table');

        $this->assertTablesEqual($expected, $actual);
    }


}
