<?php

namespace Rougin\Describe\Test;

use PDO;
use Rougin\Describe\Describe;
use Rougin\Describe\Driver\SQLiteDriver;

use PHPUnit_Framework_TestCase;

class SQLiteDriverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * Sets up the Describe class.
     *
     * @return void
     */
    public function setUp()
    {
        $databasePath = __DIR__ . '/../Databases/test.db';
        $pdo = new PDO('sqlite:' . $databasePath);
        $driver = new SQLiteDriver($pdo);

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
        $primaryKey = $this->describe->getPrimaryKey('users');
        $primaryKey = $this->describe->get_primary_key('users');

        $this->assertEquals($expected, $primaryKey);
    }

    /**
     * Tests Describe::getTable method.
     * 
     * @return void
     */
    public function testGetTableMethod()
    {
        $expected = 2;
        $table = $this->describe->getTable('users');
        $table = $this->describe->get_table('users');

        $this->assertEquals($expected, count($table));
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

        $this->assertEmpty($tables);
    }
}
