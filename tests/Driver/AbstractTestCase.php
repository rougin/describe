<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Testcase;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends Testcase
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
     * @return void
     */
    public function doSetUp()
    {
        $this->markTestSkipped('No Describe instance declared yet.');
    }

    /**
     * @return void
     */
    public function test_getting_primary_key()
    {
        $result = $this->describe->primary('post');

        $this->assertEquals('id', $result);
    }

    /**
     * @return void
     */
    public function test_getting_primary_key_from_getPrimaryKey()
    {
        $result = $this->describe->getPrimaryKey('post');

        $this->assertEquals('id', $result);
    }

    /**
     * @return void
     */
    public function test_table_not_found_exception()
    {
        $this->setExpectedException(self::TABLE_NOT_FOUND);

        $this->describe->columns('test');
    }

    /**
     * @return void
     */
    public function test_total_columns()
    {
        $columns = $this->describe->columns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * @return void
     */
    public function test_total_columns_from_getColumns()
    {
        $columns = $this->describe->getColumns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * @return void
     */
    public function test_total_columns_from_getTable()
    {
        $columns = $this->describe->getTable(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * @return void
     */
    public function test_total_columns_from_underscore()
    {
        $columns = $this->describe->get_columns(self::TABLE_NAME);

        $this->columns($columns);
    }

    /**
     * @return void
     */
    public function test_total_tables()
    {
        $tables = $this->describe->tables();

        $this->tables($tables);
    }

    /**
     * @return void
     */
    public function test_total_tables_from_getTableNames()
    {
        $tables = $this->describe->getTableNames();

        $this->tables($tables);
    }

    /**
     * @return void
     */
    public function test_total_tables_from_showTables()
    {
        $tables = $this->describe->showTables();

        $this->tables($tables);
    }

    /**
     * Checks if the result is same as the expected.
     *
     * @param \Rougin\Describe\Column[] $columns
     *
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
     * @param \Rougin\Describe\Table[] $tables
     *
     * @return void
     */
    protected function tables($tables)
    {
        $expected = self::TOTAL_TABLES;

        $result = count($tables);

        $this->assertEquals($expected, $result);
    }
}
