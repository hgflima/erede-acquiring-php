# E-Rede Acquiring PHP Library

A PHP client to use the E-Rede Acquiring Web Service.

[![Code Climate](https://codeclimate.com/repos/554cfcaa69568023f60072f4/badges/35a3e4f5871401705f63/gpa.svg)](https://codeclimate.com/repos/554cfcaa69568023f60072f4/feed)
[![Test Coverage](https://codeclimate.com/repos/554cfcaa69568023f60072f4/badges/35a3e4f5871401705f63/coverage.svg)](https://codeclimate.com/repos/554cfcaa69568023f60072f4/coverage)
[![wercker status](https://app.wercker.com/status/6e89356e294d2cfd56db18ff20d519e3/s "wercker status")](https://app.wercker.com/project/bykey/6e89356e294d2cfd56db18ff20d519e3)

## Requirements

PHP 5.3.3 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Add this to your `composer.json`:
```javascript
{
  "require": {
    "rede/acquiring": "1.0.1"
  }
}
```

Then install via:

    composer.phar install

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):
```php
require_once('vendor/autoload.php');
```
## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/hgflima/rede-acquiring/releases). Then, to use the bindings, include the `init.php` file.
```php
require_once('/path/to/erede-acquiring/init.php');
```

## Getting Started

In order to increase the readability we suggest to declare the code below on the top of your file
```php
use \ERede\Acquiring\Acquirer;
use \ERede\Acquiring\TransactionType;
```

## 20 seconds tutorial

The simplest way to do a payment using the E-Rede Acquiring Web Service is using this code
```php
$data = array('credit_card' => '4242424242424242', 'exp_month' => 5, 'exp_year' => 2015, 'amount' => '1050', 'capture' => true);
$acquirer = new Acquirer("FILIATION", "PASSWORD");
$response = $acquirer.fetch(TransactionType::CREDIT).authorize($data);
print_r($response);
```

## Next steps

Find more details about how to use this library

* [Creating an authorization](https://github.com/hgflima/rede-acquiring/blob/master/docs/authorization.md)
* [Capturing the authorization](https://github.com/hgflima/rede-acquiring/blob/master/docs/capture.md)
* [Find a transaction](https://github.com/hgflima/rede-acquiring/blob/master/docs/find.md)
* [Cancelling a transaction](https://github.com/hgflima/rede-acquiring/blob/master/docs/cancel.md)

## E-Rede Acquiring Web Service Documentation

Please see https://www.userede.com.br/desenvolvedores for up-to-date documentation

## Tests

In order to run tests first install [PHPUnit](http://packagist.org/packages/phpunit/phpunit) via [Composer](http://getcomposer.org/):

    composer.phar update --dev

To run the test suite:

    ./vendor/bin/phpunit

