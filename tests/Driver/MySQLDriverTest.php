<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * MySQL Driver Test
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MySqlDriverTest extends TestCase
{
    /**
     * Sets up the driver instance.
     *
     * @return void
     */
    public function setUp()
    {
        $dsn = 'mysql:host=localhost;dbname=demo';

        $pdo = new \PDO($dsn, 'root', '');

        $driver = new MySQLDriver($pdo, 'demo');

        $this->describe = new Describe($driver);
    }
}