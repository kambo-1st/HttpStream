# kambo httpstream
[![Build Status](https://img.shields.io/travis/kambo-1st/HttpStream.svg?branch=master&style=flat-square)](https://travis-ci.org/kambo-1st/HttpStream)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/kambo-1st/HttpStream.svg?style=flat-square)](https://scrutinizer-ci.com/g/kambo-1st/HttpStream/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/kambo-1st/HttpStream.svg?style=flat-square)](https://scrutinizer-ci.com/g/kambo-1st/HttpStream/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Implementation of additional streams for the PSR-7 - HTTP message interfaces

### Stream implementation
This package comes with a following stream implementations:
- string stream
- callback stream

Each of these stream offers additional functionality not provided by original PSR-7 stream implementations.

## Install

Prefered way to install library is with composer:
```sh
composer require kambo/httpstream
```

### Basic usage

### StringStream
String stream is simple synthetic sugar that allows instantiation of stream from the string. Implementation create temporary resource which will be used as base for the StringStream and it is fully compatible with the PSR-7 stream.

```php
$stringStream = new StringStream('foo');
$stringStream->getContents(); // returns 'foo'
```

### CallbackStream
Callback stream provides a readonly stream wrapper around given callback function. Callback will be executed only once by invoking method getContents or by casting object into string. Result of function is not cached and whole stream is after callback invocation in unusable state.
This gravely limit usage of methods tell, seek, rewind and read. They cannot be used and invoking any of them will throw exception.

```php
$callback = function () {
    return 'bar';
};
$callbackStream = new CallbackStream($callback);
$callbackStream->getContents(); // Invoke function and returns 'bar'.
$callbackStream->getContents(); // stream is in detached state empty string ('') has been returned.
```

## License
The MIT License (MIT), https://opensource.org/licenses/MIT
