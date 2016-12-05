<?php

namespace Rougin\Describe\Driver;

/**
 * Database Driver Interface
 *
 * An interface for handling PDO drivers.
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface DriverInterface
{
    /**
     * Returns the result.
     *
     * @param  string $tableName
     * @return array
     */
    public function getTable($tableName);

    /**
     * Shows the list of tables.
     *
     * @return array
     */
    public function showTables();
}
