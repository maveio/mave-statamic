# Statamic Mave

A Statamic plugin for mave.io.

Based on [statamic-iconify](https://github.com/eminos/statamic-iconify)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## How to Install

Run the following command from your project root:

``` bash
composer require maveio/statamic-mave
```

In order for the field to work, you must add a mave.io API key and collection ID to your .env file like this:
``` bash
MAVE_KEY=xxxxx
MAVE_SUB=xxxxx
```

## Development

vite build --watch

composer require maveio/statamic-mave