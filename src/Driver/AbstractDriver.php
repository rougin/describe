<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Exceptions\TableNotFoundException;

/**
 * Abstract Driver
 *
 * @package  Describe
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractDriver
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Returns the list of columns based on a query.
     *
     * @param  string $table
     * @param  string $query
     * @param  array  $columns
     * @return \Rougin\Describe\Column[]
     */
    protected function query($table, $query, $columns = array())
    {
        try {
            $result = $this->pdo->prepare($query);

            $result->execute();

            $result->setFetchMode(\PDO::FETCH_OBJ);
        } catch (\PDOException $error) {
            $this->exception($table, $error->getMessage());
        }

        while ($row = $result->fetch()) {
            $column = $this->column(new Column, $table, $row);

            array_push($columns, $column);
        }

        empty($columns) && $this->exception($table);

        return $columns;
    }

    /**
     * Throws a TableNotFoundException.
     *
     * @param string      $table
     * @param string|null $text
     *
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    protected function exception($table, $text = null)
    {
        $message = 'Table "' . $table . '" not found!';

        $text !== null && $message = $text;

        throw new TableNotFoundException($message);
    }
}
