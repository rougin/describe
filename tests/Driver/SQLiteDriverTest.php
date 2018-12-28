<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * SQLite Driver Test
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SQLiteDriverTest extends AbstractTestCase
{
    /**
     * Sets up the driver instance.
     *
     * @return void
     */
    public function setUp()
    {
        $file = __DIR__ . '/../Databases/test.db';

        $pdo = new \PDO('sqlite:' . $file);

        $driver = new SQLiteDriver($pdo);

        $this->describe = new Describe($driver);
    }
}
