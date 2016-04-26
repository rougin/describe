<?php

namespace Rougin\Describe;

use PDO;
use Rougin\Describe\Describe;
use Rougin\Describe\Driver\MySQLDriver;

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
        $pdo = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $driver = new MySQLDriver($pdo, 'demo');

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
        $table = $this->describe->getTable($this->table . '.demo');
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