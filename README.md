# E-Rede Acquiring PHP Library

A PHP client to use the E-Rede Acquiring service.

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

If you do not wish to use Composer, you can download the [latest release](https://github.com/stripe/stripe-php/releases). Then, to use the bindings, include the `init.php` file.

    require_once('/path/to/erede-acquiring/init.php');

## Getting Started

Simple usage looks like:

    $cardData = array('number' => '4242424242424242', 'exp_month' => 5, 'exp_year' => 2015);
    $acquirer = \ERede\Acquiring\Acquirer("123", "456");
    $response = $acquirer.fetch(\ERede\Acquiring\TransactionType::CREDIT).authorize($cardData);
    var_dump($response);

## Documentation

Please see https://desenvolvedores.userede.com.br for up-to-date documentation.

## Tests

In order to run tests first install [PHPUnit](http://packagist.org/packages/phpunit/phpunit) via [Composer](http://getcomposer.org/):

    composer.phar update --dev

To run the test suite:

    ./vendor/bin/phpunit

