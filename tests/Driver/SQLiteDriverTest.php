<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Describe;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SQLiteDriverTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function doSetUp()
    {
        $file = __DIR__ . '/../Databases/test.db';

        $driver = new SQLiteDriver(new \PDO('sqlite:' . $file));

        $this->describe = new Describe($driver);
    }
}
