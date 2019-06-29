# laravel-doc

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

## [中文文档](readme_zh_CN.md)

<p align="center">⛵<code>laravel-generator</code> is administrative interface builder for laravel which can help you build code template you want as soon as possiable.</p>

Requirements
------------
 - PHP >= 7.0.0
 - Laravel >= 5
 
## Installation

Via Composer

``` bash
$ composer require foryoufeng/laravel-doc
```

If you do not run Laravel 5.5 (or higher), then add the service provider in `config/app.php`:
```
Foryoufeng\Doc\DocServiceProvider::class
```

Then run the command to install the generator
```
php artisan vendor:publish --provider=Foryoufeng\Doc\DocServiceProvider::class
```


## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email 1906592238@qq.com instead of using the issue tracker.

## Credits

- [foryoufeng@gmail.com][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/foryoufeng/laravel-doc.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/foryoufeng/laravel-doc.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/foryoufeng/laravel-doc/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/foryoufeng/laravel-doc
[link-downloads]: https://packagist.org/packages/foryoufeng/laravel-doc
[link-travis]: https://travis-ci.org/foryoufeng/laravel-doc
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/foryoufeng
[link-contributors]: ../../contributors
