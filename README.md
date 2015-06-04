# E-Rede Acquiring PHP Library

A PHP client to use the E-Rede Acquiring service.

[![Code Climate](https://codeclimate.com/repos/554cfcaa69568023f60072f4/badges/35a3e4f5871401705f63/gpa.svg)](https://codeclimate.com/repos/554cfcaa69568023f60072f4/feed)
[![Test Coverage](https://codeclimate.com/repos/554cfcaa69568023f60072f4/badges/35a3e4f5871401705f63/coverage.svg)](https://codeclimate.com/repos/554cfcaa69568023f60072f4/coverage)
[![wercker status](https://app.wercker.com/status/6e89356e294d2cfd56db18ff20d519e3/s "wercker status")](https://app.wercker.com/project/bykey/6e89356e294d2cfd56db18ff20d519e3)

## Requirements

PHP 5.3.3 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Add this to your `composer.json`:

    {
      "require": {
        "erede/acquiring": "0.1"
      }
    }

Then install via:

    composer.phar install

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

    require_once('vendor/autoload.php');
    
## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/hgflima/rede-acquiring/releases). Then, to use the bindings, include the `init.php` file.

    require_once('/path/to/erede-acquiring/init.php');

## Getting Started

Simple usage looks like:

    use \ERede\Acquiring\Acquirer;
    use \ERede\Acquiring\TransactionType;

    $data = array('number' => '4242424242424242', 'exp_month' => 5, 'exp_year' => 2015, 'amount' => "1050");
    $acquirer = new Acquirer("FILIATION", "PASSWORD");
    $response = $acquirer.fetch(TransactionType::CREDIT).authorize($data);
    var_dump($response);

## Documentation

Please see https://desenvolvedores.userede.com.br for up-to-date documentation.

## Tests

In order to run tests first install [PHPUnit](http://packagist.org/packages/phpunit/phpunit) via [Composer](http://getcomposer.org/):

    composer.phar update --dev

To run the test suite:

    ./vendor/bin/phpunit

