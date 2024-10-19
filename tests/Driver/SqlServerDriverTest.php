<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqlServerDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $dsn = 'sqlsrv:server=127.0.0.1;Database=tempdb';

        $pdo = new \PDO($dsn, 'sa', 'dbatools.I0');

        $driver = new SqlServerDriver($pdo);

        $this->describe = new Describe($driver);
    }
}
