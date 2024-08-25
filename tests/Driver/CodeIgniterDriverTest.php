<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CodeIgniterDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
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
