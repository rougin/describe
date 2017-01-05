# Describe

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Gets information of a table schema from a database in PHP.

## Install

Via Composer

``` bash
$ composer require rougin/describe
```

## Usage

``` php
$pdo    = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
$driver = new Rougin\Describe\Driver\MySQLDriver($pdo, 'demo');

// or

$credentials = [ 'hostname' => 'localhost', 'database' => 'demo', 'username' => 'root', 'password' => '' ];
$driver      = new Rougin\Describe\Driver\DatabaseDriver('mysql', $credentials);

$describe = new Rougin\Describe\Describe($driver);

// Returns an array of columns from the specified table
var_dump($describe->getColumns('users'));
var_dump($describe->getTable('users'));

// Returns an array of available tables from the database
var_dump($describe->showTables());
var_dump($describe->getTableNames());

// Gets the primary key from the specified table
// Second parameters means to return the Column object or the column name
var_dump($describe->getPrimaryKey('users', true));
```

#### Adding a new database driver

You can always add a new database driver if you want. Just implement the database driver of your choice in a [DriverInterface](https://github.com/rougin/describe/blob/master/src/Driver/DriverInterface.php).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/describe.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/describe/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/describe.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/describe.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/describe.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rougin/describe
[link-travis]: https://travis-ci.org/rougin/describe
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/describe/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/describe
[link-downloads]: https://packagist.org/packages/rougin/describe
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors
