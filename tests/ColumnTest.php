<?php

namespace Rougin\Describe;

use Rougin\Describe\Driver\MysqlDriver;

class ColumnTest extends Testcase
{
    const COLUMN_ID = 0;

    const COLUMN_USER_ID = 3;

    /**
     * @var \Rougin\Describe\Column[]
     */
    protected $columns;

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * @return void
     */
    public function doSetUp()
    {
        $dsn = 'mysql:host=localhost;dbname=desc';

        $user = Testcase::ROOT_USER;

        $pass = Testcase::ROOT_PASS;

        $pdo = new \PDO((string) $dsn, $user, $pass);

        $driver = new MysqlDriver($pdo, 'desc');

        $describe = new Describe($driver);

        $columns = $describe->getTable($this->table);

        $this->columns = $columns;
    }

    /**
     * @return void
     */
    public function test_field_is_auto_increment()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertTrue($column->isAutoIncrement());
    }

    /**
     * @return void
     */
    public function test_field_is_foreign_key()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertTrue($column->isForeignKey());
    }

    /**
     * @return void
     */
    public function test_field_is_null()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertFalse($column->isNull());
    }

    /**
     * @return void
     */
    public function test_field_is_primary_key()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertTrue($column->isPrimaryKey());
    }

    /**
     * @return void
     */
    public function test_field_is_unique()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertFalse($column->isUnique());
    }

    /**
     * @return void
     */
    public function test_field_is_unsigned()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $column->setUnsigned(false);

        $this->assertFalse($column->isUnsigned());
    }

    /**
     * @return void
     */
    public function test_getting_data_type()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertEquals('integer', $column->getDataType());
    }

    /**
     * @return void
     */
    public function test_getting_default_value()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertEmpty($column->getDefaultValue());
    }

    /**
     * @return void
     */
    public function test_getting_field_length()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals(10, $column->getLength());
    }

    /**
     * @return void
     */
    public function test_getting_field_name()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('user_id', $column->getField());
    }

    /**
     * @return void
     */
    public function test_getting_referenced_field()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('id', $column->getReferencedField());
    }

    /**
     * @return void
     */
    public function test_getting_referenced_table()
    {
        $column = $this->columns[self::COLUMN_USER_ID];

        $this->assertEquals('user', $column->getReferencedTable());
    }

    /**
     * @return void
     */
    public function test_underscore_case_fields()
    {
        $column = $this->columns[self::COLUMN_ID];

        $this->assertTrue($column->is_primary_key());
    }
}
