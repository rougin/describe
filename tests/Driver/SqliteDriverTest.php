<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqliteDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $file = __DIR__ . '/../Databases/describe.db';

        $driver = new SqliteDriver(new \PDO('sqlite:' . $file));

        $this->describe = new Describe($driver);
    }

    /**
     * @return void
     */
    public function test_column_with_length()
    {
        $column = $this->getColumn('gender');

        $expected = 4;

        $actual = $column->getLength();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_text_as_string()
    {
        $column = $this->getColumn('name');

        $expected = 'string';

        $actual = $column->getDataType();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_varchar_as_string()
    {
        $column = $this->getColumn('gender');

        $expected = 'string';

        $actual = $column->getDataType();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @param string $name
     *
     * @return \Rougin\Describe\Column
     * @throws \Exception
     */
    protected function getColumn($name)
    {
        $columns = $this->describe->columns('resu');

        foreach ($columns as $column)
        {
            $field = $column->getField();

            if ($field === $name)
            {
                return $column;
            }
        }

        throw new \Exception('Column "gender" not found');
    }
}
