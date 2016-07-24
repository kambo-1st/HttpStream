# kambo httpfactory
[![Build Status](https://img.shields.io/travis/kambo-1st/HttpFactory.svg?branch=master&style=flat-square)](https://travis-ci.org/kambo-1st/HttpFactory)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/kambo-1st/HttpFactory.svg?style=flat-square)](https://scrutinizer-ci.com/g/kambo-1st/HttpFactory/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/kambo-1st/HttpFactory.svg?style=flat-square)](https://scrutinizer-ci.com/g/kambo-1st/HttpFactory/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Just another PHP implementation of PSR-17 - HTTP Factories interfaces

## Install

Prefered way to install library is with composer:
```sh
composer require kambo/httpfactory
```

## Usage

### Request factory
XXX

```php
$request = (new RequestFactory())->createRequest('GET', 'test.com');
```


## License
The MIT License (MIT), https://opensource.org/licenses/MIT
