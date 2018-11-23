# Changelog

## 1.0.14 - 2017-07-11

### Fixed

* Prevent private key exposure in php log when open_basedir restriction is in effect.

## 1.0.13 - 2016-12-08

### Fixed

* Undefined index when object type is not defined

## 1.0.12 - 2016-10-17

### Improved

* This adapter now uses the username/password getters so it uses the safe storage mechanism in the main package (1.0.29)

## 1.0.11 - 2016-10-17

### Improved 

* Added a fingerprint verification.

## 1.0.9 - 2016-02-19

### Fixed

* The absolute path is now stores for better external referencing.
* When a private key is given is ca no longer trigger a warning with an open basedir restriction.

## 1.0.8 - 2015-12-08

### Fixed

* Added .gitattributes for smaller distributions.

## 1.0.7 - 2015-01-25

### Fixed

* Updated phpseclib to v 2.0.0
* Allow the connection to be injected.

## 1.0.6 - 2015-09-20

### Fixed

* [isConnected] Missing function added.

## 1.0.5 - 2015-05-26 

### Fixed

* [readStream] This method no longer uses a polyfill.
