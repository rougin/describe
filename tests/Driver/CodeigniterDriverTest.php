<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;
use Rougin\Describe\Testcase;

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
        $config['hostname'] = '127.0.0.1';
        $config['username'] = Testcase::TEST_USER;
        $config['password'] = Testcase::TEST_PASS;
        $config['database'] = 'desc';

        $driver = new CodeigniterDriver($config);

        $this->describe = new Describe($driver);
    }
}
