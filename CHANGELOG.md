# Changelog

All notable changes to `Describe` will be documented in this file.

## [1.8.0](https://github.com/rougin/describe/compare/v1.7.0...v1.8.0) - Unreleased

### Added
- `SqlServerDriver` for handling `SQL Server` database tables
- `SqliteDriver` - Cast `tinyint` as `boolean`

### Changed
- Code documentation by `php-cs-fixer`, code quality by `phpstan`
- Workflow from `Travis CI` to `Github Actions`
- Code coverage from `Scrutinizer CI` to `Codecov`

### Fixed
- `SqliteDriver` - Incorrect data type from result

### Removed
- `doctrine/inflector` package

## [1.7.0](https://github.com/rougin/describe/compare/v1.6.0...v1.7.0) - 2018-01-10

### Added
- `DriverInterface::columns`
- `DriverInterface::primary`
- `DriverInterface::tables`
- `DriverNotFoundException`
- `Table` class
- `TableNotFoundException`

### Changed
- Code quality
- Minimum version of PHP to `v5.3.0`

### Removed
- `CONTRIBUTING.md`

## [1.6.0](https://github.com/rougin/describe/compare/v1.5.1...v1.6.0) - 2017-01-05

### Added
- Exceptions
- Parameter `$object` in `Describe::getPrimaryKey` for returning a `Column` instead of column's name
- `Describe::getColumns` and `Describe::getTableNames`

### Changed
- Code quality

## [1.5.1](https://github.com/rougin/describe/compare/v1.5.0...v1.5.1) - 2016-09-06

### Added
- StyleCI for conforming code to PSR standards

## [1.5.0](https://github.com/rougin/describe/compare/v1.4.2...v1.5.0) - 2016-07-29

### Added
- `Rougin\Describe\Drivers` namespace
- `DatabaseDriver` for easy instantiation of database drivers

## [1.4.2](https://github.com/rougin/describe/compare/v1.4.1...v1.4.2) - 2016-04-28

### Fixed
- Issue in building `Describe` in HHVM

## [1.4.1](https://github.com/rougin/describe/compare/v1.4.0...v1.4.1) - 2016-04-27

### Added
- Tests for `Column`

### Fixed
- Issue in using `MysqlDriver` in `CodeigniterDriver`

## [1.4.0](https://github.com/rougin/describe/compare/v1.3.0...v1.4.0) - 2016-04-23

### Added
- Tests for `MysqlDriver`
- Getting foreign keys in `SqliteDriver`
- `DriverInterface::showTables` in `CodeigniterDriver` and `SqliteDriver`

## [1.3.0](https://github.com/rougin/describe/compare/v1.2.2...v1.3.0) - 2016-03-30

### Added
- Tests

### Fixed
- Wrong inserted parameters in `MysqlDriver` for the `CodeigniterDriver`

## [1.2.2](https://github.com/rougin/describe/compare/v1.2.1...v1.2.2) - 2016-03-25

### Fixed
- Issue in instantiating `SqliteDriver` in `CodeigniterDriver`

## [1.2.1](https://github.com/rougin/describe/compare/v1.2.0...v1.2.1) - 2015-11-04

### Changed
- `get_table_information()` to `get_table()` in `Rougin\Describe\Describe`

## [1.2.0](https://github.com/rougin/describe/compare/v1.1.3...v1.2.0) - 2015-10-21

### Added
- [`DriverInterface`](https://github.com/rougin/describe/blob/master/src/Driver/DriverInterface.php) for extending database drivers
- Drivers
    - [`MysqlDriver`](https://github.com/rougin/describe/blob/master/src/Driver/MysqlDriver.php)
    - [`SqliteDriver`](https://github.com/rougin/describe/blob/master/src/Driver/SqliteDriver.php)
    - [`CodeigniterDriver`](https://github.com/rougin/describe/blob/master/src/Driver/CodeigniterDriver.php)

### Changed
- `Drivers` folder to `Driver`
- Documentation

## [1.1.3](https://github.com/rougin/describe/compare/v1.1.2...v1.1.3) - 2015-07-26

### Fixed
- Bug in selecting constraints in a `MySQL` database driver

## [1.1.2](https://github.com/rougin/describe/compare/v1.1.1...v1.1.2) - 2015-07-03

### Changed
- Renamed `get_foreign_*` to `get_referenced_*`
- `MySQL` database driver logic

### Fixed
- Missing `setForeign()` method in `Column` class

## [1.1.1](https://github.com/rougin/describe/compare/v1.1.0...v1.1.1) - 2015-06-26

### Changed
- Rewritten database drivers from scratch

## [1.1.0](https://github.com/rougin/describe/compare/v1.0.0...v1.1.0) - 2015-05-30

### Added
- Support for foreign keys referenced in other databases
- `showTables()` method in `Describe` class

### Changed
- Namespace to 'Rougin\Describe'

## 1.0.0 - 2015-04-01

### Added
- `Describe` library