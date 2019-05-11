# Changelog

## 1.2.1 2019-05-11
### Changed
- Bind LitespeedCache as singleton
- Fixed bug in helper functions where output depended on getEnabled() instead of getEsiEnabled(). Also make helper fnction dependent on LitespeedCahche::shouldCache() 

## 1.2.0 2019-05-10
### Changed
- Added helpers getLitespeedCsrfField() and getLitespeedCsrfToken() that return the correct string based on whether ESI is enabled.

## 1.1.2 2019-05-08
### Changed
- Fixed accidental local include of joostvanveen/litespeedcache

## 1.1.1 2019-05-08
Do not use - contains bug
### Added
- Added esiEnabled to config

## 1.1.0 2019-05-06
### Added
- Added uncached ESI routes to return csrf_token() and csrf_field()
- Updated README

## 1.0.1 2019-05-02
### Changed
- Updated README.

## 1.0.0 2019-04-26
### Changed
- Fixed bug where default middleware was not loaded.

## 0.2.0 2019-04-23
### Added
- Added config('litespeedcache.defaults.excludedUris') and config('litespeedcache.defaults.excludedQueryStrings') to config

### Changed
- Updated README

## 0.1.1 2019-04-23
### Changed
- Use facade in middleware

## 0.1.0 2019-04-21
### Added
- Created facade 'LitespeedCache'.
- Created middleware.
- Created config.
- Added documentation to README. 
- Added unit tests. 
- Added documentation to README. 
