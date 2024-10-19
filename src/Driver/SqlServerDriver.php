<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Exceptions\TableNotFoundException;
use Rougin\Describe\Table;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqlServerDriver implements DriverInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Initializes the driver instance.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    /**
     * Returns a list of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    public function columns($table)
    {
        $query = "SELECT c.COLUMN_NAME, c.COLUMN_DEFAULT, c.IS_NULLABLE, c.DATA_TYPE, c.CHARACTER_MAXIMUM_LENGTH, ccu.CONSTRAINT_NAME, tc.CONSTRAINT_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS c
            LEFT JOIN INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE ccu ON ccu.TABLE_NAME = c.TABLE_NAME AND ccu.COLUMN_NAME = c.COLUMN_NAME
            LEFT JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS tc ON tc.TABLE_NAME = c.TABLE_NAME AND tc.CONSTRAINT_NAME = ccu.CONSTRAINT_NAME
            WHERE c.TABLE_NAME = '$table'
            ORDER BY c.ORDINAL_POSITION;";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        /** @var array<string, string>[] */
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $result = array();

        $foreigns = $this->getForeigns($table);

        foreach ($items as $item)
        {
            $result[] = $this->setColumn($item, $table, $foreigns);
        }

        if (count($result) === 0)
        {
            $message = 'Table "' . $table . '" does not exists!';

            throw new TableNotFoundException($message);
        }

        return $result;
    }

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        $query = 'SELECT * FROM INFORMATION_SCHEMA.TABLES;';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        /** @var array<string, string>[] */
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $result = array();

        foreach ($items as $item)
        {
            $result[] = new Table($item['TABLE_NAME'], $this);
        }

        return $result;
    }

    /**
     * @param array<string, string>   $row
     * @param string                  $table
     * @param array<string, string>[] $foreigns
     *
     * @return \Rougin\Describe\Column
     */
    protected function setColumn($row, $table, $foreigns = array())
    {
        $column = new Column;

        $primary = $row['CONSTRAINT_TYPE'] === 'PRIMARY KEY';
        $column->setPrimary($primary);

        $column->setField($row['COLUMN_NAME']);

        $default = $row['COLUMN_DEFAULT'];
        $default = $default === '(NULL)' ? null : $default;

        $null = $row['IS_NULLABLE'] === 'YES';
        $column->setNull($null);

        $length = $row['CHARACTER_MAXIMUM_LENGTH'];
        $column->setLength((int) $length);

        $type = $row['DATA_TYPE'];
        $column->setDataType($type);

        if ($row['CONSTRAINT_TYPE'] !== 'FOREIGN KEY')
        {
            return $column;
        }

        foreach ($foreigns as $item)
        {
            $sameTable = $item['FK_TABLE_NAME'] === $table;

            $field = $column->getField();

            $sameColumn = $item['FK_COLUMN_NAME'] === $field;

            if ($sameColumn && $sameTable)
            {
                $column->setReferencedField($item['REFERENCED_TABLE_NAME']);

                $column->setForeign(true);

                $column->setReferencedTable($item['REFERENCED_COLUMN_NAME']);
            }
        }

        return $column;
    }

    /**
     * @param string $table
     *
     * @return array<string, string>[]
     */
    protected function getForeigns($table)
    {
        $query = "SELECT 
            KCU1.CONSTRAINT_SCHEMA AS FK_CONSTRAINT_SCHEMA, 
            KCU1.CONSTRAINT_NAME AS FK_CONSTRAINT_NAME, 
            KCU1.TABLE_SCHEMA AS FK_TABLE_SCHEMA, 
            KCU1.TABLE_NAME AS FK_TABLE_NAME, 
            KCU1.COLUMN_NAME AS FK_COLUMN_NAME, 
            KCU1.ORDINAL_POSITION AS FK_ORDINAL_POSITION, 
            KCU2.CONSTRAINT_SCHEMA AS REFERENCED_CONSTRAINT_SCHEMA, 
            KCU2.CONSTRAINT_NAME AS REFERENCED_CONSTRAINT_NAME, 
            KCU2.TABLE_SCHEMA AS REFERENCED_TABLE_SCHEMA, 
            KCU2.TABLE_NAME AS REFERENCED_TABLE_NAME, 
            KCU2.COLUMN_NAME AS REFERENCED_COLUMN_NAME, 
            KCU2.ORDINAL_POSITION AS REFERENCED_ORDINAL_POSITION 
        FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS AS RC 

        INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU1 
            ON KCU1.CONSTRAINT_CATALOG = RC.CONSTRAINT_CATALOG  
            AND KCU1.CONSTRAINT_SCHEMA = RC.CONSTRAINT_SCHEMA 
            AND KCU1.CONSTRAINT_NAME = RC.CONSTRAINT_NAME 

        INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU2 
            ON KCU2.CONSTRAINT_CATALOG = RC.UNIQUE_CONSTRAINT_CATALOG  
            AND KCU2.CONSTRAINT_SCHEMA = RC.UNIQUE_CONSTRAINT_SCHEMA 
            AND KCU2.CONSTRAINT_NAME = RC.UNIQUE_CONSTRAINT_NAME 
            AND KCU2.ORDINAL_POSITION = KCU1.ORDINAL_POSITION

        WHERE KCU1.TABLE_NAME = '$table'";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        /** @var array<string, string>[] */
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
