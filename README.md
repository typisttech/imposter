<div align="center">

# Imposter

</div>

<div align="center">


[![Packagist Version](https://img.shields.io/packagist/v/typisttech/imposter.svg?style=flat-square)](https://packagist.org/packages/typisttech/imposter)
[![Packagist Downloads](https://img.shields.io/packagist/dt/typisttech/imposter.svg?style=flat-square)](https://packagist.org/packages/typisttech/imposter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/TypistTech/imposter?style=flat-square)](https://packagist.org/packages/typisttech/imposter)
[![CircleCI](https://img.shields.io/circleci/build/gh/TypistTech/imposter?style=flat-square)](https://circleci.com/gh/TypistTech/imposter)
[![Codecov](https://img.shields.io/codecov/c/gh/typisttech/imposter?style=flat-square)](https://codecov.io/gh/TypistTech/imposter)
[![License](https://img.shields.io/github/license/TypistTech/imposter.svg?style=flat-square)](https://github.com/TypistTech/imposter/blob/master/LICENSE)
[![Twitter Follow @TangRufus](https://img.shields.io/twitter/follow/TangRufus?style=flat-square&color=1da1f2&logo=twitter)](https://twitter.com/tangrufus)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-ff69b4.svg?style=flat-square)](https://www.typist.tech/contact/)

</div>

<p align="center">
  <strong>Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins.</strong>
  <br />
  <br />
  Built with ♥ by <a href="https://www.typist.tech/">Typist Tech</a>
</p>

---

**Imposter** is an open source project and completely free to use.

However, the amount of effort needed to maintain and develop new features is not sustainable without proper financial backing. If you have the capability, please consider donating using the links below:

<div align="center">

[![GitHub via Sponsor](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?style=flat-square&logo=github)](https://github.com/sponsors/TangRufus)
[![Sponsor via PayPal](https://img.shields.io/badge/Sponsor-PayPal-blue.svg?style=flat-square&logo=paypal)](https://typist.tech/go/paypal-donate/)
[![More Sponsorship Information](https://img.shields.io/badge/Sponsor-More%20Details-ff69b4?style=flat-square)](https://typist.tech/donate/imposter/)

</div>

---

Wrapping all composer vendor packages inside your own namespace. Intended for WordPress plugins.

## Why?

Because of the lack of dependency management in WordPress, if two plugins bundled conflicting versions of the same package, hard-to-reproduce bugs arise.
Monkey patching composer vendor packages, wrapping them inside your own namespace is a less-than-ideal solution to avoid such conflicts.

See:
- [A Narrative of Using Composer in a WordPress Plugin](https://wptavern.com/a-narrative-of-using-composer-in-a-wordpress-plugin)
- [A Warning About Using Composer With WordPress](https://wppusher.com/blog/a-warning-about-using-composer-with-wordpress/)

## Install

> If you want to hook Imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events), install [Imposter Plugin](https://github.com/TypistTech/imposter-plugin) instead.
> See: [How can I integrate Imposter with composer?](#how-can-i-integrate-imposter-with-composer)

Installation should be done via composer, details of how to install composer can be found at [https://getcomposer.org/](https://getcomposer.org/).

```bash
composer require typisttech/imposter
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
1. Find out [vendor-dir](https://getcomposer.org/doc/06-config.md#vendor-dir)
1. Find out all [required packages](https://getcomposer.org/doc/04-schema.md#require), including those required by dependencies
1. Find out all [autoload paths](https://getcomposer.org/doc/04-schema.md#autoload) for all required packages
1. Prefix all namespaces with the imposter namespace defined in your `composer.json`

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

**Help Wanted.** Pull requests are welcomed.

1. Traits are not transformed
1. Virtual packages are not supported

## Frequently Asked Questions

### How can I integrate imposter with composer?

Use [Imposter Plugin](https://github.com/TypistTech/imposter-plugin) instead.
It hooks imposter into [composer command events](https://getcomposer.org/doc/articles/scripts.md#command-events).

### Does imposter support `PSR4`, `PSR0`, `Classmap` and `Files`?

Yes for all. PSR-4 and PSR-0 autoloading, classmap generation and files includes are supported.

### Can I exclude some of the packages from imposter?

Yes, see [`extra.imposter.excludes`](#extraimposterexcludes).
All [composer made packages](https://packagist.org/packages/composer/) are excluded by default.

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

### Which composer versions are supported?

Both v1 and v2.

### Will you add support for older PHP versions?

Never! This plugin will only work on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this

- Articles on [Typist Tech's blog](https://typist.tech)
- [Tang Rufus' WordPress plugins](https://profiles.wordpress.org/tangrufus#content-plugins) on wp.org
- More projects on [Typist Tech's GitHub profile](https://github.com/TypistTech)
- Stay tuned on [Typist Tech's newsletter](https://typist.tech/go/newsletter)
- Follow [Tang Rufus' Twitter account](https://twitter.com/TangRufus)
- **Hire [Tang Rufus](https://typist.tech/contact) to build your next awesome site**

### Where can I give 5-star reviews?

Thanks! Glad you like it. It's important to let me knows somebody is using this project. Please consider:

- [tweet](https://twitter.com/intent/tweet?url=https%3A%2F%2Fgithub.com%2FTypistTech%2Fimposter&via=tangrufus&text=Wrapping%20all%20%23composer%20vendor%20packages%20inside%20your%20own%20namespace.%20Intended%20for%20%23WordPress%20plugins&hashtags=php) something good with mentioning [@TangRufus](https://twitter.com/tangrufus)
- ★ star [the Github repo](https://github.com/TypistTech/imposter)
- [👀 watch](https://github.com/TypistTech/imposter/subscription) the Github repo
- write tutorials and blog posts
- **[hire](https://www.typist.tech/contact/) Typist Tech**

## Testing

```bash
composer test
composer style:check
```

## Alternatives

Here is a list of alternatives that I found. However, none of these satisfied my requirements.

*If you know other similar projects, feel free to edit this section!*

* [Mozart](https://github.com/coenjacobs/mozart) by Coen Jacobs
    - Works with PSR0 and PSR4
    - Dependency packages store in a different directory

* [PHP Scoper](https://github.com/humbug/php-scoper)
    - Prefixes all PHP namespaces in a file/directory to isolate the code bundled in PHARs

## Feedback

**Please provide feedback!** We want to make this project as useful as possible.
Please [submit an issue](https://github.com/TypistTech/imposter/issues/new) and point out what you do and don't like, or fork the project and [send pull requests](https://github.com/TypistTech/imposter/pulls/).
**No issue is too small.**

## Security Vulnerabilities

If you discover a security vulnerability within this project, please email us at [imposter@typist.tech](mailto:imposter@typist.tech).
All security vulnerabilities will be promptly addressed.

## Credits

[Imposter](https://github.com/TypistTech/imposter) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://twitter.com/TangRufus), freelance developer for [hire](https://www.typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/TypistTech/imposter/graphs/contributors).

## License

[Imposter](https://github.com/TypistTech/imposter) is released under the [MIT License](https://opensource.org/licenses/MIT).
