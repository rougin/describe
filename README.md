# Describe

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Describe is a PHP library that returns `Column` objects based on table schema information from a database.

## Installation

Install `Describe` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/describe
```

## Basic Usage

### Using a vendor-specific driver

``` php
use Rougin\Describe\Driver\MysqlDriver;

$dsn = 'mysql:host=localhost;dbname=demo';

$pdo = new PDO($dsn, 'root', '');

$driver = new MysqlDriver($pdo, 'demo');
```

Available drivers:

* [MysqlDriver](https://github.com/rougin/describe/blob/master/src/Driver/MysqlDriver.php)
* [SqliteDriver](https://github.com/rougin/describe/blob/master/src/Driver/SqliteDriver.php)

### Using a `DatabaseDriver`

``` php
use Rougin\Describe\Driver\DatabaseDriver;

$credentials = array('password' => '');

$credentials['hostname'] = 'localhost';
$credentials['database'] = 'demo';
$credentials['username'] = 'root';

$driver = new DatabaseDriver('mysql', $credentials);
```

### Using `Table`

``` php
$table = new Rougin\Describe\Table('users', $driver);

// Returns an array of "Column" instances
var_dump($table->columns());

// Returns the primary key "Column" from the table
var_dump($table->primary());
```

For more information regarding the `Column` object, kindly check it [here](https://github.com/rougin/describe/blob/master/src/Column.php).

### Adding a new database driver

To add a driver for a specified database, just implement it to a `DriverInterface`:

``` php
namespace Rougin\Describe\Driver;

/**
 * Database Driver Interface
 *
 * An interface for handling PDO drivers.
 *
 * @package Describe
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface DriverInterface
{
    /**
     * Returns an array of columns from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table);

    /**
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables();
}
```

## Projects using Describe

### [Combustor](https://roug.in/combustor/)

Combustor uses Describe for getting database information for generating a codebase.

### [Refinery](https://roug.in/refinery/)

Same as Combustor, Refinery also uses Describe for creating database migrations for Codeigniter.

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