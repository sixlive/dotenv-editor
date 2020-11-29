# Dotenv editing toolset

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sixlive/dotenv-editor.svg?style=flat-square)](https://packagist.org/packages/sixlive/dotenv-editor)
[![Total Downloads](https://img.shields.io/packagist/dt/sixlive/dotenv-editor.svg?style=flat-square)](https://packagist.org/packages/sixlive/dotenv-editor)
![run-tests](https://github.com/sixlive/dotenv-editor/workflows/run-tests/badge.svg)
[![StyleCI](https://github.styleci.io/repos/145056191/shield)](https://github.styleci.io/repos/145056191)

This package provides some basic tools for editing dotenv files.

## Installation
You can install the package via composer:

```bash
> composer require sixlive/dotenv-editor
```

## Usage

### Add a section
Given we have an existing file at `base_path('.env')`.
```
APP_KEY=supersecret
APP_FOO=BAR
```

We can add a new section to the existing configuration file.
``` php
$editor = new DotenvEditor;

$editor->load(base_path('.env'));
$editor->heading('Examples');
$editor->set('FOO', 'bar');
$editor->set('BAZ', 'bax');
$editor->unset('APP_FOO');
$editor->save();
```

This will result in the following changes.
```
APP_KEY=supersecret

# Examples
FOO=bar
BAZ=bax
```

## Testing
```bash
> vendor/bin/phpunit
```

## Code Style
StyleCI will apply the [Laravel preset](https://docs.styleci.io/presets#laravel).

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email oss@tjmiller.co instead of using the issue tracker.


## Credits
- [TJ Miller](https://github.com/sixlive)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
