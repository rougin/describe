Describe
========

Get the information about the database you're working on using PHP.

Goal
====

* To provide information of a database (from its tables down to its respective columns) in any relational database management system (RDMS).

Installation
============

Install ```Describe``` via [Composer](https://getcomposer.org):

```$ composer require rougin/describe:dev-master```

```$ composer install```

Usage
========

To initialize:

```
require 'vendor/autoload.php';

$database       = 'hello';
$databaseDriver = 'mysql';
$hostname       = 'localhost';
$password       = '';
$username       = 'root';

$describe = new Describe($hostname, $database, $username, $password, $driver);
```

You can also initialize it via an array:

```
require 'vendor/autoload.php';

$databaseCredentials = array(
	'database' = 'hello',
	'driver'   = 'mysql',
	'hostname' = 'localhost',
	'password' = '',
	'username' = 'root'
);

$describe = new Describe($databaseCredentials);
```

To get the information of your specified table from the database:

**Example**: Let's use a table named ```accounts``` and it contains 3 columns:

* ```id```       int(10)
* ```name```     varchar(100)
* ```username``` varchar(100) 

```
$tableName = 'accounts';
$tableInformation = $describe->getTableInformation($tableName);

foreach ($tableInformation as $column) {
	echo '<pre>';
	print_r($column);
	echo '</pre>';
}
```

Returned methods or properties
==============================

```$tableInformation->getPrimaryKey()``` Returns the primary key in the "described" table

The object named ```$column``` in the example above will return the following properties:

```defaultValue``` Check if the field has a default value

```extra``` Returns an extra information

(for example, 'extra' will return 'auto_increment' if the column is a primary key in MySQL)

```field``` Name of the column

```isNull``` Check if the column can accept NULL values or not

```key``` Check if it is a primary key or a foreign key

```referencedColumn``` Return the referenced column if the column is an foreign key

```referencedTable``` Return the referenced table if the column is an foreign key

```type``` Return the data type and its length (if any)