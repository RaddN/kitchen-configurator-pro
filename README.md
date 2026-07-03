# Kitchen Configurator Pro

WordPress/WooCommerce plugin for the Keukenkastenfabriek-style kitchen cabinet configurator.

## Requirements

- WordPress 6.0+
- WooCommerce 9.0+
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js/npm for Playwright checks

## LocalWP Runtime

Default local URL:

```text
http://configurator.local
```

LocalWP does not expose `php` or `wp` globally on this machine. Use LocalWP's PHP binary with the site MySQL port when running WP-CLI:

```powershell
$php = "$env:APPDATA\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe"
$wp = "C:\Program Files (x86)\Local\resources\extraResources\bin\wp-cli\wp-cli.phar"
$ext = "$env:APPDATA\Local\lightning-services\php-8.2.29+0\bin\win64\ext"

& $php -d "extension_dir=$ext" -d extension=php_mysqli.dll -d extension=php_pdo_mysql.dll -d mysqli.default_port=10017 -d pdo_mysql.default_port=10017 $wp --path="C:\Users\user\Local Sites\configurator\app\public" option get siteurl
```

## Development

Install dependencies:

```powershell
composer install
npm install
```

Run Playwright smoke checks:

```powershell
npm run test:e2e:chromium
```

Override the browser target when needed:

```powershell
$env:PLAYWRIGHT_BASE_URL = "http://configurator.local"
npm run test:e2e:chromium
```

## Shortcodes

Configurator landing:

```text
[kcp_configurator_landing]
```

Design step:

```text
[kcp_design_step]
```

Cabinet selection:

```text
[kcp_cabinet_select]
```

Legacy multi-step app:

```text
[kitchen_configurator]
```

## License

GPL-2.0-or-later
