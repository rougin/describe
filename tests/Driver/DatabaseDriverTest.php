<?php

namespace Rougin\Describe\Driver;

class DatabaseDriverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException.
     *
     * @return void
     */
    public function testDatabaseDriverNotFoundException()
    {
        $this->setExpectedException('Rougin\Describe\Exceptions\DatabaseDriverNotFoundException');

        $driver = new \Rougin\Describe\Driver\DatabaseDriver('mssql', []);
    }
}
