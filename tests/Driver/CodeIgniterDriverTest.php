<?php

namespace Rougin\Describe\Driver;

class CodeIgniterDriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * @var integer
     */
    protected $expectedColumns = 5;

    /**
     * Tests Describe::getPrimaryKey method with SQLite Driver.
     *
     * @return void
     */
    public function testGetPrimaryKeyMethodWithSqliteDriver()
    {
        $this->setUpSqliteDriver();

        $primaryKey = $this->describe->getPrimaryKey($this->table);

        $this->assertEquals('id', $primaryKey);
    }

    /**
     * Tests Describe::getPrimaryKey method with SQLite Driver as object.
     *
     * @return void
     */
    public function testGetPrimaryKeyMethodWithSqliteDriverAsObject()
    {
        $this->setUpSqliteDriver();

        $primaryKey = $this->describe->getPrimaryKey($this->table, true);

        $this->assertInstanceOf('Rougin\Describe\Column', $primaryKey);
    }

    /**
     * Tests Describe::getTable method with SQLite Driver.
     *
     * @return void
     */
    public function testGetTableMethodWithSqliteDriver()
    {
        $this->setUpSqliteDriver();

        $table = $this->describe->getTable($this->table);

        $this->assertEquals($this->expectedColumns, count($table));
    }

    /**
     * Tests Describe::showTables method with SQLite Driver.
     *
     * @return void
     */
    public function testShowTablesMethodWithSqliteDriver()
    {
        $this->setUpSqliteDriver();

        $tables = $this->describe->showTables();

        $this->assertEquals(2, count($tables));
    }

    /**
     * Tests Describe::getPrimaryKey method with MySQL Driver.
     *
     * @return void
     */
    public function testGetPrimaryKeyMethodWithMysqlDriver()
    {
        $this->setUpMysqlDriver();

        $primaryKey = $this->describe->getPrimaryKey($this->table);

        $this->assertEquals('id', $primaryKey);
    }

    /**
     * Tests Describe::getTable method with MySQL Driver.
     *
     * @return void
     */
    public function testGetTableMethodWithMysqlDriver()
    {
        $this->setUpMysqlDriver();

        $table = $this->describe->getTable($this->table);

        $this->assertEquals($this->expectedColumns, count($table));
    }

    /**
     * Tests Describe::showTables method with MySQL Driver.
     *
     * @return void
     */
    public function testShowTablesMethodWithMysqlDriver()
    {
        $this->setUpMysqlDriver();

        $tables = $this->describe->showTables();

        $this->assertEquals(2, count($tables));
    }

    /**
     * Sets up the MySQL Driver.
     *
     * @return void
     */
    public function setUpMysqlDriver()
    {
        $config = [];

        $config['default'] = [
            'dbdriver' => 'mysqli',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'demo'
        ];

        $driver = new \Rougin\Describe\Driver\CodeIgniterDriver($config);

        $this->describe = new \Rougin\Describe\Describe($driver);
    }

    /**
     * Sets up the SQLite Driver.
     *
     * @return void
     */
    protected function setUpSqliteDriver()
    {
        $config = [];

        $config['default'] = [
            'dbdriver' => 'pdo',
            'hostname' => 'sqlite:' . __DIR__ . '/../Databases/test.db',
            'username' => '',
            'password' => '',
            'database' => ''
        ];

        $driver = new \Rougin\Describe\Driver\CodeIgniterDriver($config);

        $this->describe = new \Rougin\Describe\Describe($driver);
    }

    /**
     * Tests \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException.
     *
     * @return void
     */
    public function testDatabaseDriverNotFoundException()
    {
        $this->setExpectedException('Rougin\Describe\Exceptions\DatabaseDriverNotFoundException');

        $config['default'] = [
            'dbdriver' => 'mssql',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'demo'
        ];

        $driver = new \Rougin\Describe\Driver\CodeIgniterDriver($config);
    }
}
