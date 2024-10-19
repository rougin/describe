<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Table;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MysqlDriver extends AbstractDriver
{
    /**
     * @var string
     */
    protected $db;

    /**
     * @param \PDO   $pdo
     * @param string $db
     */
    public function __construct(\PDO $pdo, $db)
    {
        parent::__construct($pdo);

        $this->db = $db;
    }

    /**
     * Returns a list of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->setColumns($table, 'DESCRIBE ' . $table);
    }

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        $tables = array();

        $result = $this->pdo->prepare('SHOW TABLES');

        $result->execute();

        while ($row = $result->fetch())
        {
            /** @var string[] */
            $item = $row;

            $tables[] = new Table($item[0], $this);
        }

        return $tables;
    }

    /**
     * Prepares the defined columns.
     *
     * @param string                $table
     * @param array<string, string> $row
     *
     * @return \Rougin\Describe\Column
     */
    protected function newColumn($table, $row)
    {
        $column = new Column;

        $column->setDataType($row['Type']);

        $column->setDefaultValue($row['Default']);

        $column->setField($row['Field']);

        // Return the data type and its length --------------
        preg_match('/(.*?)\((.*?)\)/', $row['Type'], $match);

        if (isset($match[1]))
        {
            $column->setDataType($match[1]);

            $column->setLength((int) $match[2]);
        }
        // --------------------------------------------------

        // In MySQL ~8.0, integer does not show its length ---
        if ($column->getDataType() === 'integer')
        {
            if (! isset($match[1]))
            {
                $column->setLength(10);
            }
        }
        // --------------------------------------------------

        if ($row['Null'] === 'YES')
        {
            $column->setNull(true);
        }

        if ($row['Extra'] === 'auto_increment')
        {
            $column->setAutoIncrement(true);
        }

        if ($row['Key'] === 'PRI')
        {
            $column->setPrimary(true);
        }

        if ($row['Key'] === 'MUL')
        {
            $column->setForeign(true);
        }

        if ($row['Key'] === 'UNI')
        {
            $column->setUnique(true);
        }

        return $this->setForeign($column, $row, $table);
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param array<string, string>   $row
     * @param \Rougin\Describe\Column $column
     * @param string                  $table
     *
     * @return \Rougin\Describe\Column
     */
    protected function setForeign(Column $column, $row, $table)
    {
        $script = 'SELECT COLUMN_NAME as "column", REFERENCED_COLUMN_NAME as ' .
            '"referenced_column", CONCAT(REFERENCED_TABLE_SCHEMA, ".", ' .
            'REFERENCED_TABLE_NAME) as "referenced_table" FROM INFORMATION_SCHEMA' .
            '.KEY_COLUMN_USAGE WHERE CONSTRAINT_SCHEMA = "%s" AND TABLE_NAME = "%s";';

        $query = sprintf($script, $this->db, $table);

        $table = $this->pdo->prepare($query);

        $table->execute();

        /** @var array<string, string>[] */
        $items = $table->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($items as $item)
        {
            if ($item['column'] !== $row['Field'])
            {
                continue;
            }

            $refTable = $item['referenced_table'];

            $refTable = $this->strip($refTable);

            $column->setReferencedField($item['referenced_column']);

            $column->setReferencedTable($refTable);
        }

        return $column;
    }

    /**
     * Strips the table schema from the table name.
     *
     * @param string $table
     *
     * @return string
     */
    protected function strip($table)
    {
        $exists = strpos($table, '.') !== false;

        $updated = substr($table, strpos($table, '.') + 1);

        return $exists ? $updated : $table;
    }
}
