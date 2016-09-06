<?php

namespace Rougin\Describe;

use PDO;
use Rougin\Describe\Describe;
use Rougin\Describe\Driver\DatabaseDriver;

use PHPUnit_Framework_TestCase;

class MySQLDriverTest extends PHPUnit_Framework_TestCase
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
     * Sets up the Describe class.
     *
     * @return void
     */
    public function setUp()
    {
        $driver = new DatabaseDriver('mysql', [
            'hostname' => 'localhost',
            'database' => 'demo',
            'username' => 'root',
            'password' => '',
        ]);

        $this->describe = new Describe($driver);
    }

    /**
     * Tests Describe::getPrimaryKey method.
     *
     * @return void
     */
    public function testGetPrimaryKeyMethod()
    {
        $primaryKey = $this->describe->getPrimaryKey($this->table);
        $primaryKey = $this->describe->get_primary_key($this->table);

        $this->assertEquals('id', $primaryKey);
    }

    /**
     * Tests Describe::getTable method.
     *
     * @return void
     */
    public function testGetTableMethod()
    {
        $table = $this->describe->getTable('demo.' . $this->table);
        $table = $this->describe->get_table($this->table);

        $this->assertEquals($this->expectedColumns, count($table));
    }

    /**
     * Tests Describe::showTables method.
     *
     * @return void
     */
    public function testShowTablesMethod()
    {
        $tables = $this->describe->showTables();
        $tables = $this->describe->show_tables();

        $this->assertEquals(2, count($tables));
    }
}
