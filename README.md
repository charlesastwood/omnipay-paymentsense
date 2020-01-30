# Omnipay: PaymentSense

**PaymentSense driver for the Omnipay PHP payment processing library**


[![Build Status](https://travis-ci.org/digitickets/omnipay-paymentsense.png)](https://travis-ci.org/charlesastwood/omnipay-paymentsense)

[![Latest Stable Version](https://poser.pugx.org/digitickets/omnipay-paymentsense/version.png)](https://packagist.org/packages/charlesastwood/omnipay-paymentsense)
[![Total Downloads](https://poser.pugx.org/medialam/omnipay-paymentsense/d/total.png)](https://packagist.org/packages/charlesastwood/omnipay-paymentsense)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment processing library for PHP 5.3+. This driver adds integration for the PaymentSense payment gateway.

## Installation

This driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "charlesastwood/omnipay-paymentsense": "^1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

This package provides an Omnipay driver for integration with the PaymentSense payment gateway. For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay) repository.

**Important!** - As this gateway doesn't exist under the main Omnipay namespace, when you create the instance of the driver, you need to specify the complete namespace and class name, eg:

`$gateway = Omnipay::create('\Medialam\PaymentSense\Gateway');`

## Support 

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/charlesastwood/omnipay-paymentsense/issues),
or better yet, fork the library and submit a pull request.
