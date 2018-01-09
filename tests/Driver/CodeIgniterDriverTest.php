<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * Codeigniter Driver Test
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CodeigniterDriverTest extends TestCase
{
    /**
     * Sets up the driver instance.
     *
     * @return void
     */
    public function setUp()
    {
        $config = array('default' => array());

        $config['default']['dbdriver'] = 'mysqli';
        $config['default']['hostname'] = 'localhost';
        $config['default']['username'] = 'root';
        $config['default']['password'] = '';
        $config['default']['database'] = 'demo';

        $driver = new CodeIgniterDriver($config);

        $this->describe = new Describe($driver);
    }
}