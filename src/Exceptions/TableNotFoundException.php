<?php

namespace Rougin\Describe\Exceptions;

/**
 * Table Not Found Exception
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TableNotFoundException extends \PDOException
{
    /**
     * @var string
     */
    protected $message = 'Table name not found on database!';
}
