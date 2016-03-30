<?php

namespace Rougin\Describe\Driver;

use PDO;
use Rougin\Describe\Driver\DriverInterface;
use Rougin\Describe\Column;

/**
 * SQLite Driver
 *
 * A database driver extension for SQLite.
 * 
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SQLiteDriver implements DriverInterface
{
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Returns the result.
     * 
     * @return array
     */
    public function getTable($table)
    {
        $columns = [];

        $information = $this->pdo->prepare(
            'PRAGMA table_info("' . $table . '");'
        );

        $information->execute();
        $information->setFetchMode(PDO::FETCH_OBJ);

        while ($row = $information->fetch()) {
            $column = new Column;

            if ( ! $row->notnull) {
                $column->setNull(TRUE);
            }

            if ($row->pk) {
                $column->setPrimary(TRUE);
                $column->setAutoIncrement(TRUE);
            }

            $column->setDefaultValue($row->dflt_value);
            $column->setField($row->name);
            $column->setDataType(strtolower($row->type));

            array_push($columns, $column);
        }

        return $columns;
    }

    /**
     * Shows the list of tables.
     * 
     * @return array
     */
    public function showTables()
    {
        return [];
    }
}
