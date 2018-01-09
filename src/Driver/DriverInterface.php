<?php

namespace Rougin\Describe\Driver;

/**
 * Database Driver Interface
 *
 * An interface for handling PDO drivers.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface DriverInterface
{
    /**
     * Returns an array of Column instances from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table);

    /**
     * Returns an array of Column instances from a table.
     * NOTE: To be removed in v2.0.0. Use columns() instead.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function getColumns($table);

    /**
     * Returns an array of Column instances from a table.
     * NOTE: To be removed in v2.0.0. Use getColumns() instead.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function getTable($table);

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use tables() instead.
     *
     * @return array
     */
    public function getTableNames();

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use getTableNames() instead.
     *
     * @return array
     */
    public function showTables();

    /**
     * Returns an array of Table instances.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables();
}
