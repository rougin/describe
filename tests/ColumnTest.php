<?php

namespace Rougin\Describe;

use Rougin\Describe\Describe;
use Rougin\Describe\Driver\MySQLDriver;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    const COLUMN_ID = 0;

    const COLUMN_USER_ID = 3;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * Sets up the Describe class.
     *
     * @return void
     */
    public function setUp()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=demo', 'root', '');

        $driver = new MySQLDriver($pdo, 'demo');

        $describe = new Describe($driver);

        $this->columns = $describe->getTable($this->table);
    }

    /**
     * Tests Column::getDataType.
     *
     * @return void
     */
    public function testGetDataType()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertEquals('integer', $column->getDataType());
    }

    /**
     * Tests Column::getDefaultValue.
     *
     * @return void
     */
    public function testGetDefaultValue()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertEmpty($column->getDefaultValue());
    }

    /**
     * Tests Column::getField.
     *
     * @return void
     */
    public function testGetField()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('user_id', $column->getField());
    }

    /**
     * Tests Column::getReferencedField.
     *
     * @return void
     */
    public function testGetReferencedField()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('id', $column->getReferencedField());
    }

    /**
     * Tests Column::getReferencedTable.
     *
     * @return void
     */
    public function testGetReferencedTable()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('user', $column->getReferencedTable());
    }

    /**
     * Tests Column::getLength.
     *
     * @return void
     */
    public function testGetLength()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals(10, $column->getLength());
    }

    /**
     * Tests Column::isAutoIncrement.
     *
     * @return void
     */
    public function testIsAutoIncrement()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertTrue($column->isAutoIncrement());
    }

    /**
     * Tests Column::isForeignKey.
     *
     * @return void
     */
    public function testIsForeignKey()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertTrue($column->isForeignKey());
    }

    /**
     * Tests Column::isNull.
     *
     * @return void
     */
    public function testIsNull()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertFalse($column->isNull());
    }

    /**
     * Tests Column::isUnique.
     *
     * @return void
     */
    public function testIsUnique()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertFalse($column->isUnique());
    }

    /**
     * Tests Column::isUnsigned.
     *
     * @return void
     */
    public function testIsUnsigned()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $column->setUnsigned(false);

        $this->assertFalse($column->isUnsigned());
    }

    /**
     * Tests Column::isPrimaryKey.
     *
     * @return void
     */
    public function testIsPrimaryKey()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertTrue($column->isPrimaryKey());
    }

    /**
     * Tests methods in underscore case.
     *
     * @return void
     */
    public function testUnderscoreCase()
    {
        $column = $this->columns[self::COLUMN_ID];

        $column->dummy_method();

        $this->assertTrue($column->is_primary_key());
    }
}
