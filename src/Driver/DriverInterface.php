<?php

namespace Rougin\Describe\Driver;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface DriverInterface
{
    /**
     * Returns a list of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table);

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables();
}
