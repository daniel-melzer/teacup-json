Teacup Json Component [![Build Status](https://travis-ci.org/daniel-melzer/teacup-json.png?branch=master)](https://travis-ci.org/daniel-melzer/teacup-json)
=====================

Usage
-----

```php
use Teacup\Json as Json;

//Encode.
Json::encode($value);

//Encode with options.
Json::encode($value, Json::HEX_AMP);
Json::encode($value, Json::HEX_AMP|Json::HEX_QUOT);

//Decode.
Json::decode($json);

//Get result as array.
Json::decode($json, true);

//Limit depth to 50.
Json::decode($json, false, 50);
```

Options
-------
* ```HEX_TAG```: All < and > are converted to \u003C and \u003E. Available since PHP 5.3.0.
* ```HEX_AMP```: All &s are converted to \u0026. Available since PHP 5.3.0.
* ```HEX_APOS```: All ' are converted to \u0027. Available since PHP 5.3.0.
* ```HEX_QUOT```: All " are converted to \u0022. Available since PHP 5.3.0.
* ```FORCE_OBJECT```: Outputs an object rather than an array when a non-associative array is used. Especially useful when the recipient of the output is expecting an object and the array is empty.
* ```NUMERIC_CHECK```: Encodes numeric strings as numbers. Available since PHP 5.3.3.
* ```BIGINT_AS_STRING```: Encodes large integers as their original string value. Available since PHP 5.4.0.
* ```JSON_PRETTY_PRINT```: Use whitespace in returned data to format it. Available since PHP 5.4.0.
* ```JSON_UNESCAPED_SLASHES```: Don't escape /. Available since PHP 5.4.0.
* ```JSON_UNESCAPED_UNICODE```: Encode multibyte Unicode characters literally (default is to escape as \uXXXX). Available since PHP 5.4.0.

Errors
------
```Json::encode()``` and ```Json::decode()``` are throwing RuntimeExceptions if an error occures.