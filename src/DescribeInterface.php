<?php namespace Rougin\Describe;

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

	/**
	 * Show the list of tables
	 * 
	 * @return array
	 */
	public function showTables();

}