<?php

namespace Rougin\Describe\Driver;

/**
 * Test Case
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    const TABLE_NOT_FOUND = 'Rougin\Describe\Exceptions\TableNotFoundException';

    const TABLE_NAME = 'post';

    const TOTAL_COLUMNS = 5;

    const TOTAL_TABLES = 2;

    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * Sets up the driver instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->markTestSkipped('No Describe instance yet');
    }

    /**
     * Tests DriverInterface::columns.
     *
     * @return void
     */
    public function testColumnsMethod()
    {
        $columns = $this->describe->columns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * Tests DriverInterface::columns with TableNotFoundException.
     *
     * @return void
     */
    public function testColumnsMethodWithTableNotFoundException()
    {
        $this->setExpectedException(self::TABLE_NOT_FOUND);

        $this->describe->columns('test');
    }

    /**
     * Tests DriverInterface::getColumns.
     *
     * @return void
     */
    public function testGetColumnsMethod()
    {
        $columns = $this->describe->getColumns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * Tests DriverInterface::getColumns in underscore case.
     *
     * @return void
     */
    public function testGetColumnsMethodInUnderscoreCase()
    {
        $columns = $this->describe->get_columns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * Tests Describe::getPrimaryKey.
     *
     * @return void
     */
    public function testGetPrimaryKeyMethod()
    {
        $result = $this->describe->getPrimaryKey('post');

        $this->assertEquals('id', $result);
    }

    /**
     * Tests DriverInterface::getTable.
     *
     * @return void
     */
    public function testGetTableMethod()
    {
        $columns = $this->describe->getTable(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * Tests DriverInterface::getTableNames.
     *
     * @return void
     */
    public function testGetTableNamesMethod()
    {
        $tables = $this->describe->getTableNames();

        $this->tables($tables);
    }

    /**
     * Tests Describe::primary.
     *
     * @return void
     */
    public function testPrimaryMethod()
    {
        $result = $this->describe->primary('post');

        $this->assertEquals('id', $result);
    }

    /**
     * Tests DriverInterface::showTables.
     *
     * @return void
     */
    public function testShowTablesMethod()
    {
        $tables = $this->describe->showTables();

        $this->tables($tables);
    }

    /**
     * Tests DriverInterface::tables.
     *
     * @return void
     */
    public function testTablesMethod()
    {
        $tables = $this->describe->tables();

        $this->tables($tables);
    }

    /**
     * Checks if the result is same as the expected.
     *
     * @param  array $columns
     * @return void
     */
    protected function columns($columns)
    {
        $expected = self::TOTAL_COLUMNS;

        $result = count($columns);

        $this->assertEquals($expected, $result);
    }

    /**
     * Checks if the result is same as the expected.
     *
     * @param  array $tables
     * @return void
     */
    protected function tables($tables)
    {
        $expected = self::TOTAL_TABLES;

        $result = count($tables);

        $this->assertEquals($expected, $result);
    }
}
