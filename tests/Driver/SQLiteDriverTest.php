<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqliteDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $file = __DIR__ . '/../Databases/test.db';

        $driver = new SqliteDriver(new \PDO('sqlite:' . $file));

        $this->describe = new Describe($driver);
    }
}
