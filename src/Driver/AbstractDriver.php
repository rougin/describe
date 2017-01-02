<?php

namespace Rougin\Describe\Driver;

/**
 * Abstract Driver
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractDriver
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Returns the list of columns based on the specified query.
     *
     * @param  string $tableName
     * @param  string $query
     * @return void
     */
    public function getQuery($tableName, $query)
    {
        try {
            $information = $this->pdo->prepare($query);

            $information->execute();
            $information->setFetchMode(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            // Table not found
        }

        while ($row = $information->fetch()) {
            $this->setColumn($tableName, $row);
        }
    }
}
