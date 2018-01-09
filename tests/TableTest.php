<?php

namespace Rougin\Describe;

use Rougin\Describe\Driver\MySQLDriver;

class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Describe\Table
     */
    protected $table;

    /**
     * Sets up the table instance.
     *
     * @return void
     */
    public function setUp()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=demo', 'root', '');

        $this->table = new Table('post', new MySQLDriver($pdo, 'demo'));
    }

    /**
     * Tests Table::columns.
     *
     * @return void
     */
    public function testColumnsMethod()
    {
        $columns = $this->table->columns();

        $expected = 5;

        $result = count($columns);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Table::name.
     *
     * @return void
     */
    public function testNameMethod()
    {
        $result = $this->table->name();

        $this->assertEquals('post', $result);
    }
}