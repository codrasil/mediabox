# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
### Changed

<br>

## [1.1.0] - 2020-08-21
### Added
- Added api endpoint to zip given files
- Added download method to MediaboxApiController
- Added upload method to MediaboxApiController
- Added keys to FileKeys enum class file to check file type, modification dates, and directory names
- Added keys to check count, file type, and dates to File class when returned as array or json
- Added method to retrieve current folder info in Mediabox class
- Added CHANGELOG.md file to track changes
- Added `illuminate/cache` as requirement package
- Added method "stream", alias for the "fetch" method
### Changed
- Removed 'binding' middleware for api routes
- Modified the zip method to allow array of paths to be passed
- Removed file's name to the icon class
- Changed the filename method's trimmed trailing slash from `/` to `DIRECTORY_SEPARATOR`
- Updated owner fetching to support Windows OS
- Change MediaboxApiController's rename method from accepting only name fields to all fields

<br>

## [1.0.1] - 2020-06-04
### Added
- Add poser badge to README.md file
### Changed
- Update composer description
- Update documentation files

<br>

## [1.0.0] - 2020-06-04
### Added
- Add Mediabox class file
- Add File class file
- Add Unit tests for class files
- Add Laravel specific features like routes, views, controllers, etc.

<br>

[Unreleased]: https://github.com/codrasil/mediabox/compare/v1.0.1...HEAD
[1.1.0]: https://github.com/codrasil/mediabox/releases/tag/v1.0.1...v1.1.0
[1.0.1]: https://github.com/codrasil/mediabox/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/codrasil/mediabox/releases/tag/v1.0.0
