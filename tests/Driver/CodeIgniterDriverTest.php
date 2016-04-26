<?php

namespace Rougin\Describe;

use PDO;
use Rougin\Describe\Describe;
use Rougin\Describe\Driver\CodeIgniterDriver;

use PHPUnit_Framework_TestCase;

class CodeIgniterDriverTest extends PHPUnit_Framework_TestCase
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
        $primaryKey = $this->describe->get_primary_key($this->table);

        $this->assertEquals('id', $primaryKey);
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
        $table = $this->describe->get_table($this->table);

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
        $tables = $this->describe->show_tables();

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
        $primaryKey = $this->describe->get_primary_key($this->table);

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
        $table = $this->describe->get_table($this->table);

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
        $tables = $this->describe->show_tables();

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

        $driver = new CodeIgniterDriver($config);

        $this->describe = new Describe($driver);
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

        $driver = new CodeIgniterDriver($config);

        $this->describe = new Describe($driver);
    }
}
