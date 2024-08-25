<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MysqlDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $dsn = 'mysql:host=localhost;dbname=test';

        $pdo = new \PDO($dsn, 'root', 'root');

        $driver = new MysqlDriver($pdo, 'test');

        $this->describe = new Describe($driver);
    }
}
