<?php

namespace Rougin\Describe\Exceptions;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DriverNotFoundException extends \UnexpectedValueException
{
    /**
     * @var string
     */
    protected $message = 'Database driver not found!';
}
