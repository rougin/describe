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
        $dsn = 'mysql:host=127.0.0.1;dbname=dscb';

        $user = Testcase::TEST_USER;

        $pass = Testcase::TEST_PASS;

        $pdo = new \PDO($dsn, $user, $pass);

        $driver = new MysqlDriver($pdo, 'dscb');

        $this->describe = new Describe($driver);
    }
}
