# Stub Template

![Coding Style Actions](https://github.com/cable8mm/stub-template/actions/workflows/code-style.yml/badge.svg)
![Run Tests Actions](https://github.com/cable8mm/stub-template/actions/workflows/run-tests.yml/badge.svg)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/cable8mm/stub-template.svg)](https://packagist.org/packages/cable8mm/stub-template)
[![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/cable8mm/stub-template/php?logo=PHP&logoColor=white&color=777BB4)](https://packagist.org/packages/cable8mm/stub-template)
[![Total Downloads](https://img.shields.io/packagist/dt/cable8mm/stub-template.svg)](https://packagist.org/packages/cable8mm/stub-template)
[![Packagist Stars](https://img.shields.io/packagist/stars/cable8mm/stub-template)](https://github.com/cable8mm/stub-template/stargazers)

The package is not a template engine, but you can use it like one to create stub files when needed.

It needs to be used with [Twig template syntax](https://twig.symfony.com/doc/3.x/templates.html).

## Installation

You can install the package via composer:

```bash
composer require cable8mm/stub-template
```

## Usage

```php
$stub = Stub::of(__DIR__.'/stubs/sample.stub',
  [
    'title' => 'Home Page',
    'colors' => ['red', 'blue', 'green'],
  ]
)->render()
```

or

```php
$stub = Stub::of('stubs/sample.stub',
  [
    'title' => 'Home Page',
    'colors' => ['red', 'blue', 'green'],
  ],
  __DIR__
)->render()
```

stubs/sample.stub :

```twig filename="stubs/sample.stub"
{{ title }} - <?php echo date('Y-m-d') ?>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
{% for color in colors %}
    <li>{{ color }}</li>
{% endfor %}
</ul>

```

Then,

```html
Home Page - <?php echo date('Y-m-d') ?>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
    <li>red</li>
    <li>blue</li>
    <li>green</li>
</ul>
```

It make sure that php codes have **NOT** been executed.

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
