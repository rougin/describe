<?php

namespace Rougin\Describe;

class DescribeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $table = 'temp';

    /**
     * Sets up the Describe class.
     *
     * @return void
     */
    public function setUp()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $driver = new \Rougin\Describe\Driver\MySQLDriver($pdo, 'demo');

        $this->describe = new \Rougin\Describe\Describe($driver);
    }

    /**
     * Tests \Rougin\Describe\Exceptions\TableNameNotFoundException.
     *
     * @return void
     */
    public function testTableNameNotFoundException()
    {
        $this->setExpectedException('Rougin\Describe\Exceptions\TableNameNotFoundException');

        $this->describe->getTable($this->table);
    }
}
