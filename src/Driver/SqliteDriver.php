<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Table;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqliteDriver extends AbstractDriver
{
    /**
     * Returns a list of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->setColumns($table, 'PRAGMA table_info("' . $table . '");');
    }

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        $query = 'SELECT name FROM sqlite_master WHERE type = "table";';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $tables = array();

        /** @var array<string, string>[] */
        $items = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($items as $item)
        {
            if ($item['name'] === 'sqlite_sequence')
            {
                continue;
            }

            $tables[] = new Table($item['name'], $this);
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

        $column->setDefaultValue($row['dflt_value']);

        $column->setField($row['name']);

        $column->setDataType(strtolower($row['type']));

        // Return the data type and its length --------------
        preg_match('/(.*?)\((.*?)\)/', $row['type'], $match);

        if (isset($match[1]))
        {
            $column->setDataType(strtolower($match[1]));

            $column->setLength((int) $match[2]);
        }
        // --------------------------------------------------

        $column = $this->setForeign($column, $table);

        if ($row['pk'])
        {
            $column->setAutoIncrement(true);

            $column->setPrimary(true);
        }

        return $column->setNull(! $row['notnull']);
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param \Rougin\Describe\Column $column
     * @param string                  $table
     *
     * @return \Rougin\Describe\Column
     */
    protected function setForeign(Column $column, $table)
    {
        $query = 'PRAGMA foreign_key_list("' . $table . '");';

        $result = $this->pdo->prepare($query);

        $result->execute();

        /** @var array<string, string>[] */
        $items = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($items as $item)
        {
            if ($column->getField() !== $item['from'])
            {
                continue;
            }

            $column->setReferencedTable($item['table']);

            $column->setForeign(true);

            $column->setReferencedField($item['to']);
        }

        return $column;
    }
}
