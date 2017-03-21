# Imposter

[![Latest Stable Version](https://poser.pugx.org/typisttech/imposter/v/stable)](https://packagist.org/packages/typisttech/imposter)
[![Total Downloads](https://poser.pugx.org/typisttech/imposter/downloads)](https://packagist.org/packages/typisttech/imposter)
[![Build Status](https://travis-ci.org/TypistTech/imposter.svg?branch=master)](https://travis-ci.org/TypistTech/imposter)
[![codecov](https://codecov.io/gh/TypistTech/imposter/branch/master/graph/badge.svg)](https://codecov.io/gh/TypistTech/imposter)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TypistTech/imposter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TypistTech/imposter/?branch=master)
[![PHP Versions Tested](http://php-eye.com/badge/typisttech/imposter/tested.svg)](https://travis-ci.org/TypistTech/imposter)
[![StyleCI](https://styleci.io/repos/84912533/shield?branch=master)](https://styleci.io/repos/84912533)
[![Dependency Status](https://gemnasium.com/badges/github.com/TypistTech/imposter.svg)](https://gemnasium.com/github.com/TypistTech/imposter)
[![Latest Unstable Version](https://poser.pugx.org/typisttech/imposter/v/unstable)](https://packagist.org/packages/typisttech/imposter)
[![License](https://poser.pugx.org/typisttech/imposter/license)](https://packagist.org/packages/typisttech/imposter)
[![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.typist.tech/donate/imposter/)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg)](https://www.typist.tech/contact/)

Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins.


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Why?](#why)
- [Install](#install)
- [Config](#config)
  - [extra.imposter.namespace](#extraimposternamespace)
  - [extra.imposter.excludes](#extraimposterexcludes)
- [Usage](#usage)
- [Frequently Asked Questions](#frequently-asked-questions)
  - [How can I integrate Imposter with composer?](#how-can-i-integrate-imposter-with-composer)
  - [Does Imposter support `PSR4`, `PSR0`, `Classmap` and `Files`?](#does-imposter-support-psr4-psr0-classmap-and-files)
  - [Can I exclude some of the packages from `Imposter`?](#can-i-exclude-some-of-the-packages-from-imposter)
  - [Does Imposter support `exclude-from-classmap`?](#does-imposter-support-exclude-from-classmap)
  - [How about `require-dev` packages?](#how-about-require-dev-packages)
  - [How about packages that don't use namespaces?](#how-about-packages-that-dont-use-namespaces)
  - [How about packages that use fully qualified name?](#how-about-packages-that-use-fully-qualified-name)
- [Support!](#support)
  - [Donate via PayPal *](#donate-via-paypal-)
  - [Why don't you hire me?](#why-dont-you-hire-me)
  - [Want to help in other way? Want to be a sponsor?](#want-to-help-in-other-way-want-to-be-a-sponsor)
- [Alternatives](#alternatives)
- [Developing](#developing)
- [Running the Tests](#running-the-tests)
- [Feedback](#feedback)
- [Change log](#change-log)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Why?

Because of the lack of dependency management in WordPress, if two plugins bundled conflicting versions of the same package, hard-to-reproduce bugs arise.
Monkey patching composer vendor packages, wrapping them inside your own namespace is a less-than-ideal solution to avoid such conflicts. 

See:
- [A Narrative of Using Composer in a WordPress Plugin](https://wptavern.com/a-narrative-of-using-composer-in-a-wordpress-plugin)
- [A Warning About Using Composer With WordPress](https://blog.wppusher.com/a-warning-about-using-composer-with-wordpress/)

## Install

> If you want to hook Imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events), install [imposter-plugin](https://www.typist.tech/projects/imposter-plugin) instead.
> See: [How can I integrate Imposter with composer?](#how-can-i-integrate-imposter-with-composer)

Installation should be done via composer, details of how to install composer can be found at [https://getcomposer.org/](https://getcomposer.org/).

``` bash
$ composer require typisttech/imposter
```

## Config

In your `composer.json`:

```json
"extra": {
    "imposter": {
        "namespace": "My\\App\\Vendor",
        "excludes": [
            "dummy/dummy-excluded"
        ]
    }
}
```

### extra.imposter.namespace

*Required* String

This is the namespace prefix to be added to vendor packages.

### extra.imposter.excludes

*Optional* Array of strings

Vendor packages which needs to be excluded from namespace prefixing.
All [composer made packages](https://packagist.org/packages/composer/) are excluded by default.
Besides, anything under the `Composer` namespace will be excluded.

## Usage

After every `$ composer install` and `$ composer update`: 

```php
<?php 

use TypistTech\Imposter\ImposterFactory;

$imposter = ImposterFactory::forProject('/path/to/project/root');
$imposter->run();
```

The above snippet:
1. Look for `/path/to/project/root/composer.json`
2. Find out [vendor-dir](https://getcomposer.org/doc/06-config.md#vendor-dir)
3. Find out all [required packages](https://getcomposer.org/doc/04-schema.md#require), including those required by dependencies
4. Find out all [autoload paths](https://getcomposer.org/doc/04-schema.md#autoload) for all required packages
5. Prefix all namespaces with the imposter namespace defined in your `composer.json`

Before:
```php
<?php

namespace Dummy\File;

use AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use Dummy\SubOtherDummy;
use OtherDummy\SubOtherDummy;

class DummyClass
{
}
```

After:
```php
<?php

namespace My\App\Vendor\Dummy\File;

use My\App\Vendor\AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use My\App\Vendor\Dummy\SubOtherDummy;
use My\App\Vendor\OtherDummy\SubOtherDummy;

class DummyClass
{
}
```

## Frequently Asked Questions

### How can I integrate Imposter with composer?

Use [imposter-plugin](https://www.typist.tech/projects/imposter-plugin) instead.
It hooks Imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events).

### Does Imposter support `PSR4`, `PSR0`, `Classmap` and `Files`?

Yes for all. PSR-4 and PSR-0 autoloading, classmap generation and files includes are supported.

### Can I exclude some of the packages from `Imposter`?

Yes, see [`extra.imposter.excludes`](#extraimposterexcludes).
All [composer made packages](https://packagist.org/packages/composer/) are excluded by default.

### Does Imposter support `exclude-from-classmap`?

Not for now. 
Pull requests are welcome.

### How about `require-dev` packages?

Imposter do nothing on `require-dev` packages because imposter is intended for avoiding production environment., not for development environment. 

### How about packages that don't use namespaces?

Not for now. 
Tell me your idea by [opening an issue](https://github.com/TypistTech/imposter/issues/new)

### How about packages that use fully qualified name?

Not for now. We need a better regex in the [Transformer](src/Transformer.php) class.
Tell me your idea by [opening an issue](https://github.com/TypistTech/imposter/issues/new)

## Support! 

### Donate via PayPal [![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.typist.tech/donate/imposter/)

Love Imposter? Help me maintain Imposter, a [donation here](https://www.typist.tech/donate/imposter/) can help with it. 

### Why don't you hire me?
Ready to take freelance WordPress jobs. Contact me via the contact form [here](https://www.typist.tech/contact/) or, via email info@typist.tech 

### Want to help in other way? Want to be a sponsor? 
Contact: [Tang Rufus](mailto:tangrufus@gmail.com)

## Alternatives

Here is a list of alternatives that I found. But none satisfied my requirements.

*If you know other similar projects, feel free to edit this section!*

* [Mozart](https://github.com/coenjacobs/mozart) by Coen Jacobs
    - Works with PSR0 and PSR4 
    - Dependency packages store in a different directory

## Developing

To setup a developer workable version you should run these commands:

```bash
$ composer create-project --keep-vcs --no-install typisttech/imposter:dev-master
$ cd imposter
$ composer install
```

## Running the Tests

[Imposter](https://github.com/TypistTech/imposter) run tests on [Codeception](http://codeception.com/).

Run the tests:

``` bash
$ composer test

// Or, run with coverage support
$ composer test-with-coverage
```

We also test all PHP files against [PSR-2: Coding Style Guide](http://www.php-fig.org/psr/psr-2/).

Check the code style with ``$ composer check-style`` and fix it with ``$ composer fix-style``.

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/TypistTech/imposter/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email imposter@typist.tech instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details.

## Credits

[Imposter](https://github.com/TypistTech/imposter) is a [Typist Tech](https://www.typist.tech) project and maintained by [Tang Rufus](https://twitter.com/Tangrufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/imposter/graphs/contributors).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
