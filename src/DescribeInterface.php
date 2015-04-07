<?php namespace Describe;

/**
 * Describe Interface
 *
 * @package  Describe
 * @category Interface
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface DescribeInterface {

	/**
	 * Return the result
	 * 
	 * @return array
	 */
	public function getInformationFromTable($table);

}