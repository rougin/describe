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
     * Returns a listing of columns from the specified table.
     *
     * @param  string $tableName
     * @return array
     */
    public function getColumns($tableName);

    /**
     * Returns a listing of columns from the specified table.
     * NOTE: To be removed in v2.0.0.
     *
     * @param  string $tableName
     * @return array
     */
    public function getTable($tableName);

    /**
     * Returns a listing of tables from the specified database.
     *
     * @return array
     */
    public function getTableNames();

    /**
     * Shows the list of tables.
     * NOTE: To be removed in v2.0.0.
     *
     * @return array
     */
    public function showTables();
}
