<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MySQLDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $dsn = 'mysql:host=localhost;dbname=demo';

        $pdo = new \PDO($dsn, 'root', 'password');

        $driver = new MySQLDriver($pdo, 'demo');

        $this->describe = new Describe($driver);
    }
}
