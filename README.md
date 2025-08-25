# Describe

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Describe is a PHP package that returns information about a table structure from a database.

## Installation

Install `Describe` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/describe
```

## Basic usage

`Describe` requires a vendor-specific driver to get a database table's structure:

``` php
// index.php

use Rougin\Describe\Driver\MysqlDriver;

$dsn = 'mysql:host=localhost;dbname=test';

$pdo = new PDO($dsn, 'root', '');

$driver = new MysqlDriver($pdo, 'test');
```

Below are the available drivers for specified vendors:

| **Driver**                               | **Description**                              | **Vendor**                                                                    |
|------------------------------------------|----------------------------------------------|-------------------------------------------------------------------------------|
| `Rougin\Describe\Driver\MysqlDriver`     | Uses the `DESCRIBE` query.                   | [MySQL](https://www.mysql.com/)                                               |
| `Rougin\Describe\Driver\SqlServerDriver` | Uses the `INFORMATION_SCHEMA.COLUMNS` query. | [SQL Server](https://www.microsoft.com/en-us/sql-server/sql-server-downloads) |
| `Rougin\Describe\Driver\SqliteDriver`    | Uses the `PRAGMA table_info()` query.        | [SQLite](https://www.sqlite.org/)                                             |

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

## Using `Table`

The `Table` class is similar with the `DriverInterface` with the difference that it can return the primary key from the list of columns:

``` php
use Rougin\Describe\Table;

$table = new Table('users', $driver);

/** @var \Rougin\Describe\Column[] */
$columns = $driver->columns();

/** @var \Rougin\Describe\Column */
$primary = $driver->primary();
```

For more information regarding the `Column` object, kindly check its [code documentation](https://github.com/rougin/describe/blob/master/src/Column.php).

## Adding a new database driver

Use the `DriverInterface` for implementing a vendor-specific driver:

``` php
namespace Rougin\Describe\Driver;

interface DriverInterface
{
    /**
     * Returns a list of columns from a table.
     *
     * @param string $table
     *
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

## Use-cases

The following projects below uses `Describe` as a valuable tool:

### Combustor

[Combustor](https://roug.in/combustor/) is a utility package for [Codeigniter 3](https://codeigniter.com/userguide3/) that generates controllers, models, and views based on the provided database tables. It uses `Describe` for getting columns from a database table and as the basis for code generation.

### Refinery

[Refinery](https://roug.in/refinery/) is a console-based package of [Migrations Class](https://www.codeigniter.com/userguide3/libraries/migration.html) for the [Codeigniter 3](https://codeigniter.com/userguide3). It uses `Describe` for retrieving the database tables for creating database migrations.

## Changelog

Please see [CHANGELOG][link-changelog] for more recent changes.

## Development

Includes configuration for code quality, coding style, and unit tests.

> [!NOTE]
> The sub-sections below are for those who need to access the package's source code for development, such as creating fixes or new features.

### Code quality

Analyze code quality using [phpstan](https://phpstan.org/):

``` bash
$ phpstan
```

### Coding style

Enforce coding style using [php-cs-fixer](https://cs.symfony.com/):

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

### Unit tests

Execute unit tests using [phpunit](https://phpunit.de/index.html):

``` bash
$ composer test
```

## Credits

Big thanks to [all contributors][link-contributors] in this package!

## License

This package uses the [MIT Licenses (MIT)][link-license].

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
