# Changelog

All Notable changes to `Describe` will be documented in this file.

## [Unreleased](https://github.com/rougin/combustor/compare/v1.4.2...HEAD)

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
- Issue in using `MySQLDriver` in `CodeIgniterDriver`

## [1.4.0](https://github.com/rougin/describe/compare/v1.3.0...v1.4.0) - 2016-04-23

### Added
- Tests for `MySQLDriver`
- Getting foreign keys in `SQLiteDriver`
- `DriverInterface::showTables` in `CodeIgniterDriver` and `SQLiteDriver`

## [1.3.0](https://github.com/rougin/describe/compare/v1.2.2...v1.3.0) - 2016-03-30

### Added
- Tests

### Fixed
- Wrong inserted parameters in `MySQLDriver` for the `CodeIgniterDriver`

## [1.2.2](https://github.com/rougin/describe/compare/v1.2.1...v1.2.2) - 2016-03-25

### Fixed
- Issue in instantiating `SQLiteDriver` in `CodeIgniterDriver`

## [1.2.1](https://github.com/rougin/describe/compare/v1.2.0...v1.2.1) - 2015-11-04

### Changed
- `get_table_information()` to `get_table()` in `Rougin\Describe\Describe`

## [1.2.0](https://github.com/rougin/describe/compare/v1.1.3...v1.2.0) - 2015-10-21

### Added
- [`DriverInterface`](https://github.com/rougin/describe/blob/master/src/Driver/DriverInterface.php) for extending database drivers
- Drivers
	- [`MySQLDriver`](https://github.com/rougin/describe/blob/master/src/Driver/MySQLDriver.php)
	- [`SQLiteDriver`](https://github.com/rougin/describe/blob/master/src/Driver/SQLiteDriver.php)
	- [`CodeIgniterDriver`](https://github.com/rougin/describe/blob/master/src/Driver/CodeIgniterDriver.php)

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