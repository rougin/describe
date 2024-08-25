<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;
use Rougin\Describe\Testcase;

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
        $dsn = 'mysql:host=localhost;dbname=desc';

        $pdo = new \PDO($dsn, Testcase::ROOT_USER, Testcase::ROOT_USER);

        $driver = new MysqlDriver($pdo, 'desc');

        $this->describe = new Describe($driver);
    }
}
