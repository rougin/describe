# Describe

[![Latest Stable Version](https://poser.pugx.org/rougin/describe/v/stable)](https://packagist.org/packages/rougin/describe) [![Total Downloads](https://poser.pugx.org/rougin/describe/downloads)](https://packagist.org/packages/rougin/describe) [![Latest Unstable Version](https://poser.pugx.org/rougin/describe/v/unstable)](https://packagist.org/packages/rougin/describe) [![License](https://poser.pugx.org/rougin/describe/license)](https://packagist.org/packages/rougin/describe) [![endorse](https://api.coderwall.com/rougin/endorsecount.png)](https://coderwall.com/rougin)

Get the information about the database you're working on in PHP. It provides information of the specified database (from its tables down to its respective columns) in any relational database management system (RDMS).

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

Or via one-line:

```php
require 'vendor/autoload.php';

use Rougin\Describe\Describe;

# MS SQL Server and Sybase with PDO_DBLIB
$databaseCredentials = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
$databaseCredentials = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");

# MySQL with PDO_MYSQL
$databaseCredentials = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

# SQLite Database
$databaseCredentials = new PDO("sqlite:my/database/path/database.db");

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

		* ```getDataType()``` - (or ```get_data_type()```) Get the specified data type

		* ```getDefaultValue()``` - (or ```get_default_value()```) Checks if the field has a default value

		* ```getField()``` - (or ```get_field()```) Name of the column

		* ```getLength()``` - (or ```get_length()```) Return the length of its corresponding data type (if any)

		* ```getReferencedField()``` - (or ```get_referenced_field()```) Returns the referenced column if the column is an foreign key

		* ```getReferencedTable()``` - (or ```get_referenced_table()```) Returns the referenced table if the column is an foreign key

		* ```isAutoIncrement()``` - (or ```is_auto_increment()```) Check if the field is an auto incrementing field

		* ```isForeignKey()``` - (or ```is_foreign_key()```) Check if the field is a foreign key

		* ```isNull()``` - (or ```is_null()```) Check if the field accept ```NULL``` values

		* ```isPrimaryKey()``` - (or ```is_primary_key()```) Check if the field is a primary key

		* ```isUnique()``` - (or ```is_unique()```) Check if field is unique

		* ```isUnsigned()``` - (or ```is_unsigned()```) Check if field is unsigned


* ```showTables()``` - (or ```show_tables()```) Returns a listing of tables in the specified database