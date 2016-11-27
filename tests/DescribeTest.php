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
    protected $exception = 'Rougin\Describe\Exceptions\TableNameNotFoundException';

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
        $object = new \PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $driver = new \Rougin\Describe\Driver\MySQLDriver($object, 'demo');

        $this->describe = new \Rougin\Describe\Describe($driver);
    }

    /**
     * Tests \Rougin\Describe\Exceptions\TableNameNotFoundException.
     *
     * @return void
     */
    public function testTableNameNotFoundException()
    {
        $this->setExpectedException($this->exception);

        $this->describe->getTable($this->table);
    }
}
