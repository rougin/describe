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
        $file = __DIR__ . '/../Databases/test.db';

        $driver = new SqliteDriver(new \PDO('sqlite:' . $file));

        $this->describe = new Describe($driver);
    }

    /**
     * @return void
     */
    public function test_varchar_as_string()
    {
        $column = $this->getColumn();

        $expected = 'string';

        $actual = $column->getDataType();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_column_with_length()
    {
        $column = $this->getColumn();

        $expected = 4;

        $actual = $column->getLength();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \Rougin\Describe\Column
     * @throws \Exception
     */
    protected function getColumn()
    {
        $columns = $this->describe->columns('user');

        foreach ($columns as $column)
        {
            $name = $column->getField();

            if ($name === 'gender')
            {
                return $column;
            }
        }

        throw new \Exception('Column "gender" not found');
    }
}
