# Stub Template

![Coding Style Actions](https://github.com/cable8mm/stub-template/actions/workflows/code-style.yml/badge.svg)
![Run Tests Actions](https://github.com/cable8mm/stub-template/actions/workflows/run-tests.yml/badge.svg)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/cable8mm/stub-template.svg)](https://packagist.org/packages/cable8mm/stub-template)
[![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/cable8mm/stub-template/php?logo=PHP&logoColor=white&color=777BB4)](https://packagist.org/packages/cable8mm/stub-template)
[![Total Downloads](https://img.shields.io/packagist/dt/cable8mm/stub-template.svg)](https://packagist.org/packages/cable8mm/stub-template)
[![Packagist Stars](https://img.shields.io/packagist/stars/cable8mm/stub-template)](https://github.com/cable8mm/stub-template/stargazers)

Generate PHP source files from Twig-powered stubs without executing the PHP code inside them. Use it to fill in values such as namespaces and class names while keeping the generated PHP code intact.

It needs to be used with [Twig template syntax](https://twig.symfony.com/doc/3.x/templates.html).

## Installation

You can install the package via composer:

```bash
composer require cable8mm/stub-template
```

## Usage

```php
$rendered = Stub::of(__DIR__.'/stubs/model.stub',
  [
    'namespace' => 'App\\Models',
    'class_name' => 'Product',
  ]
)->render();
```

or

```php
$rendered = Stub::of('stubs/model.stub',
  [
    'namespace' => 'App\\Models',
    'class_name' => 'Product',
  ],
  __DIR__
)->render();
```

`stubs/model.stub`:

```twig filename="stubs/model.stub"
<?php

namespace {{ namespace }};

final class {{ class_name }}
{
    public function __construct(
        private string $name,
    ) {}
}
```

The result is a PHP source string:

```php
<?php

namespace App\Models;

final class Product
{
    public function __construct(
        private string $name,
    ) {}
}
```

Twig renders the template syntax, but PHP code in the stub is output as text
and is **not executed**.

Twig can HTML-escape interpolated values when HTML autoescaping is enabled. If
you are generating PHP or another source file, make sure the escaping mode
matches that output. You can use Twig's `raw` filter for trusted values that
must be inserted without escaping, or configure autoescaping for the template
as needed. Only use `raw` with values you trust, since it bypasses escaping.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email <cable8mm@gmail.com> instead of using the issue tracker.

## Credits

- [Samgu Lee](https://github.com/cable8mm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com) by [Beyond Code](http://beyondco.de/).
