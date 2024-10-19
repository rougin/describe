# Describe

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Describe is a PHP package that returns information about table structure from a database.

## Installation

Install `Describe` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/describe
```

## Basic Usage

Prior in getting information of a table structure, a vendor-specific driver must be implemented:

``` php
// index.php

use Rougin\Describe\Driver\MysqlDriver;

$dsn = 'mysql:host=localhost;dbname=test';

$pdo = new PDO($dsn, 'root', '');

$driver = new MysqlDriver($pdo, 'test');
```

Below are the available drivers for specified vendors:

| Driver                                 | Description                                  | Vendor                                                                        |
|----------------------------------------|----------------------------------------------|-------------------------------------------------------------------------------|
| Rougin\Describe\Driver\MysqlDriver     | Uses the `DESCRIBE` query.                   | [MySQL](https://www.mysql.com/)                                               |
| Rougin\Describe\Driver\SqlServerDriver | Uses the `INFORMATION_SCHEMA.COLUMNS` query. | [SQL Server](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) |
| Rougin\Describe\Driver\SqliteDriver    | Uses the `PRAGMA table_info()` query.        | [SQLite](https://www.sqlite.org/)                                             |

Alternatively, the `DatabaseDriver` can also be used to use a vendor-specific driver based on keyword:

``` php
use Rougin\Describe\Driver\DatabaseDriver;

$creds = array('password' => '');

$creds['hostname'] = 'localhost';
$creds['database'] = 'test';
$creds['username'] = 'root';

$driver = new DatabaseDriver('mysql', $creds);
```

After specifying the driver, use the `columns` method to return a list of columns:

``` php
// index.php

/** @var \Rougin\Describe\Column[] */
$columns = $driver->columns('users');
```

### Adding a new database driver

To add a new driver for a specified vendor, kindly implement it to a `DriverInterface`:

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

To return the primary key of a specified table, the `primary` method can be used:

``` php
// index.php

/** @var \Rougin\Describe\Column[] */
$columns = $driver->primary();
```

### Using `Table`

The `Table` class is similar with the `DriverInterface` with the difference that it can return the primary key from the list of columns:

``` php
use Rougin\Describe\Table;

$table = new Table('users', $driver);

/** @var \Rougin\Describe\Column[] */
$columns = $driver->tables();

/** @var \Rougin\Describe\Column */
$primary = $driver->primary();
```

For more information regarding the `Column` object, kindly check it [here](https://github.com/rougin/describe/blob/master/src/Column.php).

## Projects using Describe

The following projects below uses `Describe` as a valuable tool for getting a structure of a database table:

* [Combustor](https://roug.in/combustor/)

Combustor is a utility package for [Codeigniter 3](https://codeigniter.com/userguide3/) that generates controllers, models, and views based on the provided database tables. It uses the [Describe](https://roug.in/describe/) package for getting columns from a database table and as the basis for code generation.

* [Refinery](https://roug.in/refinery/)

Refinery is a console-based package of [Migrations Class](https://www.codeigniter.com/userguide3/libraries/migration.html) for the [Codeigniter 3](https://codeigniter.com/userguide3). It uses the [Describe](https://roug.in/describe/) package for retrieving the database tables for creating database migrations.

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

The unit tests for this package were written on [PHPUnit](https://phpunit.de/index.html):

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