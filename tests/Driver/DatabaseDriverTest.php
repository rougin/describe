<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * Database Driver Test
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseDriverTest extends AbstractTestCase
{
    const DRIVER_NOT_FOUND = 'Rougin\Describe\Exceptions\DriverNotFoundException';

    /**
     * Sets up the driver instance.
     *
     * @return void
     */
    public function setUp()
    {
        $config = array('password' => '');

        $config['hostname'] = 'sqlite:' . __DIR__ . '/../Databases/test.db';
        $config['username'] = 'root';
        $config['database'] = 'demo';

        $driver = new DatabaseDriver('sqlite', $config);

        $this->describe = new Describe($driver);
    }

    /**
     * Tests DatabaseDriver::driver with DriverNotFoundException.
     *
     * @return void
     */
    public function testDriverMethodWithDriverNotFoundException()
    {
        $this->setExpectedException(self::DRIVER_NOT_FOUND);

        $driver = new DatabaseDriver('test', array());
    }
}
