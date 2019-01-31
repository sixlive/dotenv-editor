# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
* Added a `unset` method to allow the possibily to remove a property defined in the .env file.

### Changed
* The current `DotenvEditorTest` tests to validate the usage of the new `unset` method.

## [1.1.1] - 2018-11-05
### Fixed
* Issue parsing Laravel `APP_KEY` ([#4](https://github.com/sixlive/dotenv-editor/pull/4))

## [1.1.0] - 2018-08-19
### Changed
* Write method returns a `bool` ([#2](https://github.com/sixlive/dotenv-editor/pull/2))
* `InvalidArgumentException` gets thrown if the `load` path does not exist ([#2](https://github.com/sixlive/dotenv-editor/pull/2))

## [1.0.0] - 2018-08-17
Initial release
