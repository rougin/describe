<?php

namespace Rougin\Describe;

use PDO;
use Rougin\Describe\Describe;
use Rougin\Describe\Driver\MySQLDriver;

use PHPUnit_Framework_TestCase;

class ColumnTest extends PHPUnit_Framework_TestCase
{
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
        $pdo = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
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
        // id
        $column = $this->columns[0];

        $this->assertEquals('integer', $column->getDataType());
        $this->assertEquals('integer', $column->get_data_type());
    }

    /**
     * Tests Column::getDefaultValue.
     *
     * @return void
     */
    public function testGetDefaultValue()
    {
        // id
        $column = $this->columns[0];

        $this->assertEmpty($column->getDefaultValue());
        $this->assertEmpty($column->get_default_value());
    }

    /**
     * Tests Column::getReferencedField.
     *
     * @return void
     */
    public function testGetReferencedField()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertEquals('id', $column->getReferencedField());
        $this->assertEquals('id', $column->get_referenced_field());
    }

    /**
     * Tests Column::getReferencedTable.
     *
     * @return void
     */
    public function testGetReferencedTable()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertEquals('demo.user', $column->getReferencedTable());
        $this->assertEquals('demo.user', $column->get_referenced_table());
    }

    /**
     * Tests Column::getLength.
     *
     * @return void
     */
    public function testGetLength()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertEquals(10, $column->getLength());
        $this->assertEquals(10, $column->get_length());
    }

    /**
     * Tests Column::isAutoIncrement.
     *
     * @return void
     */
    public function testIsAutoIncrement()
    {
        // id
        $column = $this->columns[0];

        $this->assertTrue($column->isAutoIncrement());
        $this->assertTrue($column->is_auto_increment());
    }

    /**
     * Tests Column::isForeignKey.
     *
     * @return void
     */
    public function testIsForeignKey()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertTrue($column->isForeignKey());
        $this->assertTrue($column->is_foreign_key());
    }

    /**
     * Tests Column::isNull.
     *
     * @return void
     */
    public function testIsNull()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertFalse($column->isNull());
        $this->assertFalse($column->is_null());
    }

    /**
     * Tests Column::isUnique.
     *
     * @return void
     */
    public function testIsUnique()
    {
        // user_id
        $column = $this->columns[3];

        $this->assertFalse($column->isUnique());
        $this->assertFalse($column->is_unique());
    }

    /**
     * Tests Column::isUnsigned.
     *
     * @return void
     */
    public function testIsUnsigned()
    {
        // user_id
        $column = $this->columns[3];

        $column->setUnsigned(false);

        $this->assertFalse($column->isUnsigned());
        $this->assertFalse($column->is_unsigned());
    }

    /**
     * Tests Column::isPrimaryKey.
     *
     * @return void
     */
    public function testIsPrimaryKey()
    {
        // id
        $column = $this->columns[0];

        $this->assertTrue($column->isPrimaryKey());
        $this->assertTrue($column->is_primary_key());
    }
}
