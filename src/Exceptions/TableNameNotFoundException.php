<?php

namespace Rougin\Describe\Exceptions;

/**
 * Table Name Not Found Exception
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TableNameNotFoundException extends \PDOException
{
	/**
     * @var string
     */
    protected $message = 'Table name not found on database!';
}
