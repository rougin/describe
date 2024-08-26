<?php

namespace Rougin\Describe;

use Rougin\Describe\Driver\MysqlDriver;

class TableTest extends Testcase
{
    /**
     * @var \Rougin\Describe\Table
     */
    protected $table;

    /**
     * @return void
     */
    public function doSetUp()
    {
        $dsn = 'mysql:host=localhost;dbname=desc';

        $user = Testcase::ROOT_USER;

        $pass = Testcase::ROOT_PASS;

        $pdo = new \PDO((string) $dsn, $user, $pass);

        $driver = new MysqlDriver($pdo, 'desc');

        $this->table = new Table('post', $driver);
    }

    /**
     * @return void
     */
    public function test_table_name()
    {
        $result = $this->table->name();

        $this->assertEquals('post', $result);
    }

    /**
     * @return void
     */
    public function test_total_columns()
    {
        $columns = $this->table->columns();

        $expected = 5;

        $result = count($columns);

        $this->assertEquals($expected, $result);
    }
}
