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

        $user = Testcase::ROOT_USER;

        $pass = Testcase::ROOT_PASS;

        $pdo = new \PDO((string) $dsn, $user, $pass);

        $driver = new MysqlDriver($pdo, 'desc');

        $this->describe = new Describe($driver);
    }
}
