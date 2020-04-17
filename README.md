# Imposter

[![Packagist](https://img.shields.io/packagist/v/typisttech/imposter.svg)](https://packagist.org/packages/typisttech/imposter)
[![Packagist](https://img.shields.io/packagist/dt/typisttech/imposter.svg)](https://packagist.org/packages/typisttech/imposter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/typisttech/imposter.svg)](https://packagist.org/packages/typisttech/imposter)
[![CircleCI](https://circleci.com/gh/TypistTech/imposter.svg?style=svg)](https://circleci.com/gh/TypistTech/imposter)
[![codecov](https://codecov.io/gh/TypistTech/imposter/branch/master/graph/badge.svg)](https://codecov.io/gh/TypistTech/imposter)
[![License](https://img.shields.io/github/license/TypistTech/imposter.svg)](https://github.com/TypistTech/imposter/blob/master/LICENSE.md)
[![GitHub Sponsor](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa)](https://github.com/sponsors/TangRufus)
[![Sponsor via PayPal](https://img.shields.io/badge/Sponsor-PayPal-blue.svg)](https://typist.tech/donate/imposter/)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg)](https://typist.tech/contact/)

Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins.


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Why?](#why)
- [Install](#install)
- [Config](#config)
  - [extra.imposter.namespace](#extraimposternamespace)
  - [extra.imposter.excludes](#extraimposterexcludes)
- [Usage](#usage)
- [Known Issues](#known-issues)
- [Frequently Asked Questions](#frequently-asked-questions)
  - [How can I integrate imposter with composer?](#how-can-i-integrate-imposter-with-composer)
  - [Does imposter support `PSR4`, `PSR0`, `Classmap` and `Files`?](#does-imposter-support-psr4-psr0-classmap-and-files)
  - [Can I exclude some of the packages from imposter?](#can-i-exclude-some-of-the-packages-from-imposter)
  - [Does imposter support `exclude-from-classmap`?](#does-imposter-support-exclude-from-classmap)
  - [How about `require-dev` packages?](#how-about-require-dev-packages)
  - [How about PHP built-in classes?](#how-about-php-built-in-classes)
  - [How about packages that don't use namespaces?](#how-about-packages-that-dont-use-namespaces)
  - [How about packages that use fully qualified name?](#how-about-packages-that-use-fully-qualified-name)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find some more goodies like this?](#it-looks-awesome-where-can-i-find-some-more-goodies-like-this)
  - [This package isn't on wp.org. Where can I give a :star::star::star::star::star: review?](#this-package-isnt-on-wporg-where-can-i-give-a-starstarstarstarstar-review)
- [Sponsoring :heart:](#sponsoring-heart)
  - [GitHub Sponsors Matching Fund](#github-sponsors-matching-fund)
  - [Why don't you hire me?](#why-dont-you-hire-me)
  - [Want to help in other way? Want to be a sponsor?](#want-to-help-in-other-way-want-to-be-a-sponsor)
- [Alternatives](#alternatives)
- [Running the Tests](#running-the-tests)
- [Feedback](#feedback)
- [Change log](#change-log)
- [Security](#security)
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

> If you want to hook Imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events), install [imposter-plugin](https://typist.tech/projects/imposter-plugin) instead.
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
All [composer-made packages](https://packagist.org/packages/composer/) are excluded by default.
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
use Composer;
use Composer\Plugin\PluginInterface;
use Dummy\SubOtherDummy;
use OtherDummy\SubOtherDummy;
use RuntimeException;
use \UnexpectedValueException;
use function OtherVendor\myFunc;
use const OtherVendor\MY_MAGIC_NUMBER;

$closure = function () use ($aaa) {
    // Just testing.
};

class DummyClass
{
    public function useClosure()
    {
        array_map(function () use ($xxx) {
            // Just testing.
        }, []);
    }
}

function dummyFunction(string $namespace = null, string $use = null): array
{
    if (! is_null($namespace) && $namespace === 'dummy string' && $use === 'dummy string') {
        // Just testing.
    }

    return [];
}

foreach ([] as $namespace => $prefix) {
    $aaaa = '{' . $namespace . '}' . $prefix;
}

/** Just a comment for testing $namespace transformation */
```

After:
```php
<?php

namespace MyPlugin\Vendor\Dummy\File;

use MyPlugin\Vendor\AnotherDummy\{
    SubAnotherDummy, SubOtherDummy
};
use Composer;
use Composer\Plugin\PluginInterface;
use MyPlugin\Vendor\Dummy\SubOtherDummy;
use MyPlugin\Vendor\OtherDummy\SubOtherDummy;
use RuntimeException;
use \UnexpectedValueException;
use function MyPlugin\Vendor\OtherVendor\myFunc;
use const MyPlugin\Vendor\OtherVendor\MY_MAGIC_NUMBER;

$closure = function () use ($aaa) {
    // Just testing.
};

class DummyClass
{
    public function useClosure()
    {
        array_map(function () use ($xxx) {
            // Just testing.
        }, []);
    }
}

function dummyFunction(string $namespace = null, string $use = null): array
{
    if (! is_null($namespace) && $namespace === 'dummy string' && $use === 'dummy string') {
        // Just testing.
    }

    return [];
}

foreach ([] as $namespace => $prefix) {
    $aaaa = '{' . $namespace . '}' . $prefix;
}

/** Just a comment for testing $namespace transformation */
```

## Known Issues

Help wanted. Pull requests are welcomed.

1. Traits are not transformed
1. Virtual packages are not supported
1. [`exclude-from-classmap` are not excluded from transformation](https://github.com/TypistTech/imposter/issues/154)

## Frequently Asked Questions

### How can I integrate imposter with composer?

Use [imposter-plugin](https://typist.tech/projects/imposter-plugin) instead.
It hooks imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events).

### Does imposter support `PSR4`, `PSR0`, `Classmap` and `Files`?

Yes for all. PSR-4 and PSR-0 autoloading, classmap generation and files includes are supported.

### Can I exclude some of the packages from imposter?

Yes, see [`extra.imposter.excludes`](#extraimposterexcludes).
All [composer made packages](https://packagist.org/packages/composer/) are excluded by default.

### Does imposter support `exclude-from-classmap`?

Not for now.
Pull requests are welcome.

### How about `require-dev` packages?

Imposter do nothing on `require-dev` packages because imposter is intended for avoiding production environment., not for development environment.

### How about PHP built-in classes?

Imposter skips classes that on global namespace, for example: `\ArrayObject`, `\RuntimeException`

### How about packages that don't use namespaces?

Not for now.
Tell me your idea by [opening an issue](https://github.com/TypistTech/imposter/issues/new).

### How about packages that use fully qualified name?

Not for now. We need a better regex(or something better than regex) in the [Transformer](src/Transformer.php) class.
Tell me your idea by [opening an issue](https://github.com/TypistTech/imposter/issues/new)

### Will you add support for older PHP versions?

Never! This package will only works on [actively supported PHP versions](https://secure.php.net/supported-versions.php).
Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this?

* Articles on Typist Tech's [blog](https://typist.tech)
* [Tang Rufus' WordPress plugins](https://profiles.wordpress.org/tangrufus#content-plugins) on wp.org
* More projects on [Typist Tech's GitHub profile](https://github.com/TypistTech)
* Stay tuned on [Typist Tech's newsletter](https://typist.tech/go/newsletter)
* Follow [Tang Rufus' Twitter account](https://twitter.com/TangRufus)
* Hire [Tang Rufus](https://typist.tech/contact) to build your next awesome site

### This package isn't on wp.org. Where can I give a :star::star::star::star::star: review?

Thanks!

Consider writing a blog post, submitting pull requests, [sponsoring](https://typist.tech/donation/) or [hiring me](https://typist.tech/contact/) instead.

## Sponsoring :heart:

Love `imposter`? Help me maintain it, a [sponsorship here](https://typist.tech/donation/) can help with it.

### GitHub Sponsors Matching Fund

Do you know [GitHub is going to match your sponsorship](https://help.github.com/en/github/supporting-the-open-source-community-with-github-sponsors/about-github-sponsors#about-the-github-sponsors-matching-fund)?

[Sponsor now via GitHub](https://github.com/sponsors/TangRufus) to double your greatness.

### Why don't you hire me?

Ready to take freelance WordPress jobs. Contact me via the contact form [here](https://typist.tech/contact/) or, via email [info@typist.tech](mailto:info@typist.tech)

### Want to help in other way? Want to be a sponsor?

Contact: [Tang Rufus](mailto:tangrufus@gmail.com)

## Alternatives

Here is a list of alternatives that I found. But none satisfied my requirements.

*If you know other similar projects, feel free to edit this section!*

* [Mozart](https://github.com/coenjacobs/mozart) by Coen Jacobs
    - Works with PSR0 and PSR4
    - Dependency packages store in a different directory

* [PHP Scoper](https://github.com/humbug/php-scoper)
    - Prefixes all PHP namespaces in a file/directory to isolate the code bundled in PHARs

## Running the Tests

Run the tests:

``` bash
$ composer test
$ composer style:check
```

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/TypistTech/imposter/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change log

Please see [CHANGELOG](./CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email imposter@typist.tech instead of using the issue tracker.

## Credits

[`imposter`](https://github.com/TypistTech/imposter) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://twitter.com/TangRufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/imposter/graphs/contributors).

## License

The MIT License (MIT). Please see [License File](./LICENSE) for more information.
