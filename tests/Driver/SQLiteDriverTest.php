<?php

namespace Rougin\Describe\Driver;

class SQLiteDriverTest extends \PHPUnit_Framework_TestCase
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
        $databasePath = __DIR__ . '/../Databases/test.db';

        $driver = new \Rougin\Describe\Driver\DatabaseDriver('sqlite', [
            'hostname' => 'sqlite:' . $databasePath
        ]);

        $this->describe = new \Rougin\Describe\Describe($driver);
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

        $this->assertEquals(2, count($tables));
    }

    /**
     * Tests \Rougin\Describe\Exceptions\TableNameNotFoundException.
     *
     * @return void
     */
    public function testTableNameNotFoundException()
    {
        $this->setExpectedException('Rougin\Describe\Exceptions\TableNameNotFoundException');

        $this->describe->getTable('temp');
    }
}
