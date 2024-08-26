# Describe

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Describe is a PHP package that returns details of each column based on the database table schema.

## Installation

Install `Describe` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/describe
```

## Basic Usage

### Using a vendor-specific driver

``` php
use Rougin\Describe\Driver\MysqlDriver;

$dsn = 'mysql:host=localhost;dbname=test';

$pdo = new PDO($dsn, 'root', '');

$driver = new MysqlDriver($pdo, 'test');
```

Available drivers:

* [MysqlDriver](https://github.com/rougin/describe/blob/master/src/Driver/MysqlDriver.php)
* [SqliteDriver](https://github.com/rougin/describe/blob/master/src/Driver/SqliteDriver.php)

### Using a `DatabaseDriver`

``` php
use Rougin\Describe\Driver\DatabaseDriver;

$creds = array('password' => '');

$creds['hostname'] = 'localhost';
$creds['database'] = 'test';
$creds['username'] = 'root';

$driver = new DatabaseDriver('mysql', $creds);
```

### Using `Table`

``` php
use Rougin\Describe\Table;

$table = new Table('users', $driver);

// Returns a list of columns
var_dump($table->columns());

// Returns the primary key "Column" from the table
var_dump($table->primary());
```

For more information regarding the `Column` object, kindly check it [here](https://github.com/rougin/describe/blob/master/src/Column.php).

### Adding a new database driver

To add a driver for a specified database, just implement it to a `DriverInterface`:

``` php
namespace Rougin\Describe\Driver;

interface DriverInterface
{
    /**
     * Returns a list of columns from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table);

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables();
}
```

## Projects using Describe

### [Combustor](https://roug.in/combustor/)

Combustor uses `Describe` for getting database information for generating a codebase.

### [Refinery](https://roug.in/refinery/)

Same as Combustor, Refinery also uses `Describe` for creating database migrations for Codeigniter.

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/describe/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/describe?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/describe.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/describe.svg?style=flat-square

[link-build]: https://github.com/rougin/describe/actions
[link-changelog]: https://github.com/rougin/describe/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/describe/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/describe
[link-downloads]: https://packagist.org/packages/rougin/describe
[link-license]: https://github.com/rougin/describe/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/describe