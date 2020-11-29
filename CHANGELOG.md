# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.0] - 2020-11-29
### Added
- Adds support for PHP 8

## [1.2.0] - 2019-01-31
### Added
* Added a `unset` method to allow the possibily to remove a property defined in the .env file. ([#5](https://github.com/sixlive/dotenv-editor/pull/5))

## [1.1.1] - 2018-11-05
### Fixed
* Issue parsing Laravel `APP_KEY` ([#4](https://github.com/sixlive/dotenv-editor/pull/4))

## [1.1.0] - 2018-08-19
### Changed
* Write method returns a `bool` ([#2](https://github.com/sixlive/dotenv-editor/pull/2))
* `InvalidArgumentException` gets thrown if the `load` path does not exist ([#2](https://github.com/sixlive/dotenv-editor/pull/2))

## [1.0.0] - 2018-08-17
Initial release
