# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Add CHANGELOG.md file to track changes
- Add `illuminate/cache` as requirement package
- Add method "stream", alias for the "fetch" method
- Add upload method to MediaboxApiController
- Add keys to FileKeys enum class file to check file type, modification dates, and directory names
- Add keys to check count, file type, and dates to File class when returned as array or json
- Add method to retrieve current folder info in Mediabox class
### Changed
- Remove file's name to the icon class
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
[1.0.1]: https://github.com/codrasil/mediabox/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/codrasil/mediabox/releases/tag/v1.0.0
