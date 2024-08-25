<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CodeigniterDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $config = array();

        $config['dbdriver'] = 'mysqli';
        $config['hostname'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = 'root';
        $config['database'] = 'test';

        $driver = new CodeigniterDriver($config);

        $this->describe = new Describe($driver);
    }
}
