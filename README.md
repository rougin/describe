[![endorse](https://api.coderwall.com/rougin/endorsecount.png)](https://coderwall.com/rougin)

# Describe

Get the information about the database you're working on using PHP. It provides information of the specified database (from its tables down to its respective columns) in any relational database management system (RDMS).

# Installation

Install ```Describe``` via [Composer](https://getcomposer.org):

```$ composer require rougin/describe```

# Usage

```php
require 'vendor/autoload.php';

use Rougin\Describe\Describe;

$database       = 'hello';
$databaseDriver = 'mysql';
$hostname       = 'localhost';
$password       = '';
$username       = 'root';

$describe = new Describe($hostname, $database, $username, $password, $driver);
```

You can also initialize it via an array:

```php
require 'vendor/autoload.php';

use Rougin\Describe\Describe;

$databaseCredentials = array(
	'database' => 'hello',
	'driver'   => 'mysql',
	'hostname' => 'localhost',
	'password' => '',
	'username' => 'root'
);

$describe = new Describe($databaseCredentials);
```

To get the information of your specified table from the database:

**Example**: Let's use a table named ```account``` and it contains 3 columns:

* ```id```       int(10)
* ```name```     varchar(100)
* ```username``` varchar(100)

```php
$tableName = 'account';
$tableInformation = $describe->getTableInformation($tableName);

foreach ($tableInformation as $column) {
	echo '<pre>';
	print_r($column);
	echo '</pre>';
}
```

# Methods

* ```getPrimaryKey($table)``` - (or ```get_primary_key($table)```) Returns the primary key in the *described* ```$table```

* ```getTableInformation($table)``` - (or ```get_table_information($table)```) Returns the details in the *described* ```$table```

	* This method will return the following properties for each row of returned data:

		* ```defaultValue``` - (or ```default_value```) Checks if the field has a default value

		* ```extra``` - Returns an extra information

			* (for example, 'extra' will return 'auto_increment' if the column is a primary key in MySQL)

		* ```field``` - Name of the column

		* ```isNull``` - (or ```is_null```) Checks if the column can accept ```NULL``` values or not

		* ```key``` - Checks if it is a primary key or a foreign key

		* ```referencedColumn``` - (or ```referenced_column```) Returns the referenced column if the column is an foreign key

		* ```referencedTable``` - (or ```referenced_table```) Returns the referenced table if the column is an foreign key

		* ```type``` - Returns the data type and its length (if any)

* ```showTables()``` - (or ```show_tables()```) Returns a listing of tables in the specified database