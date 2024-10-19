<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DatabaseDriverTest extends AbstractTestCase
{
    const DRIVER_NOT_FOUND = 'Rougin\Describe\Exceptions\DriverNotFoundException';

    /**
     * @return void
     */
    public function doSetUp()
    {
        $config = array('password' => '');

        $config['hostname'] = 'sqlite:' . __DIR__ . '/../Databases/describe.db';
        $config['username'] = 'root';
        $config['database'] = 'test';

        $driver = new DatabaseDriver('sqlite', $config);

        $this->describe = new Describe($driver);
    }

    /**
     * @return void
     */
    public function test_driver_not_found_exception()
    {
        $this->setExpectedException(self::DRIVER_NOT_FOUND);

        new DatabaseDriver('test', array());
    }
}
