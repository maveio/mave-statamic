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

Add the following to your Antlers template:

``` html
<script type="module">
  import { Player } from "//cdn.video-dns.com/npm/@maveio/components/+esm";
</script>
<mave-player embed="{{ mave_field }}"></mave-player>
```

## Development

``` bash
vite build --watch
```

``` bash
composer require maveio/statamic-mave
```
