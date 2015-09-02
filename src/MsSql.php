<?php

namespace Rougin\Describe;

use Rougin\Describe\DescribeInterface;
use Rougin\Describe\Column;

/**
 * MsSql Class
 *
 * @package  Describe
 * @category MSSQL
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MsSql implements DescribeInterface
{
    protected $database;
    protected $handle;

    /**
     * Inject the database handle
     * 
     * @param \PDO   $handle
     * @param string $database
     */
    public function __construct($handle, $database)
    {
        $this->handle = $handle;
        $this->database = $database;
    }

    /**
     * Return the result
     * 
     * @return array
     */
    public function getInformationFromTable($table)
    {
        $columns = array();

        return $columns;
    }

    /**
     * Show the list of tables
     * 
     * @return array
     */
    public function showTables()
    {
        $tables = array();

        return $tables;
    }
}
