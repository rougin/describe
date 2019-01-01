<?php

namespace Rougin\Describe\Driver;

/**
 * Database Driver Interface
 *
 * An interface for handling PDO drivers.
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * Returns an array of Table instances.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables();
}
