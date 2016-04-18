<?php

namespace Rougin\Describe\Test;

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
     * Sets up the Describe class.
     *
     * @return void
     */
    public function setUp()
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

    /**
     * Tests Describe::getPrimaryKey method.
     * 
     * @return void
     */
    public function testGetPrimaryKeyMethod()
    {
        $expected = 'id';
        $primaryKey = $this->describe->getPrimaryKey($this->table);
        $primaryKey = $this->describe->get_primary_key($this->table);

        $this->assertEquals($expected, $primaryKey);
    }

    /**
     * Tests Describe::getTable method.
     * 
     * @return void
     */
    public function testGetTableMethod()
    {
        $table = $this->describe->getTable($this->table);
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
