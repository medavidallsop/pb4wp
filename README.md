<pre>
██████╗ ██████╗ ██╗  ██╗██╗    ██╗██████╗
██╔══██╗██╔══██╗██║  ██║██║    ██║██╔══██╗
██████╔╝██████╔╝███████║██║ █╗ ██║██████╔╝
██╔═══╝ ██╔══██╗╚════██║██║███╗██║██╔═══╝
██║     ██████╔╝     ██║╚███╔███╔╝██║
╚═╝     ╚═════╝      ╚═╝ ╚══╝╚══╝ ╚═╝
</pre>

# Plugin Boilerplate for WordPress (PB4WP)

A lightweight, best-practice boilerplate for building WordPress plugins quickly and cleanly.

Created by [David Allsop](https://davidallsop.com).

# Requirements

A POSIX compliant operating system (e.g. macOS, Linux) is assumed. If you're working on a Windows machine, the recommended approach is to use [WSL](https://learn.microsoft.com/en-us/windows/wsl/install) (available since Windows 10).

- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Node.js](https://nodejs.org/en)*
- [PHP](https://www.php.net/manual/en/install.php)\*
- [PNPM](https://pnpm.io/installation)*
- [WP-CLI](https://wp-cli.org/#installing) (as some included scripts use the `wp` command)

<small>*\* Some scripts included may require a recent PHP version.*</small>

# Features

## 🚀 **Modern Development Stack**
- ✅ **PSR-4 Autoloading** - Clean, standards-compliant class loading with Composer
- ✅ **Modern PHP** - Strict typing, namespaces, and modern PHP features
- ✅ **Webpack Asset Pipeline** - Advanced bundling, minification, and optimization
- ✅ **PNPM Package Manager** - Fast, efficient dependency management

## 🛠️ **Development Experience**
- ✅ **WordPress Coding Standards** - PHPCS integration with WPCS rules*
- ✅ **Prettier Code Formatting** - Consistent code style across PHP, JS, and CSS
- ✅ **Hot Reload Development** - Watch mode for instant asset rebuilding
- ✅ **Comprehensive Build Scripts** - One-command builds for development and production

## 🌐 **Internationalization**
- ✅ **Complete i18n Setup** - Automatic .pot, .mo, and .json generation
- ✅ **Translation-Ready** - Built-in text domain and language file structure

## 📦 **Production Ready**
- ✅ **Easy Zipping** - Production-ready distribution with proper file exclusion
- ✅ **Asset Optimization** - Minified CSS/JS bundles for optimal performance
- ✅ **Lifecycle Management** - Complete activation, deactivation, and update handling
- ✅ **Clean Uninstall** - Proper cleanup when plugin is removed

## 🔧 **Developer Tools**
- ✅ **Code Quality Checks** - PHPCS and Prettier validation
- ✅ **Example Code Structure** - Real-world class examples and patterns
- ✅ **Flexible Asset System** - Support for both bundled and static assets
- ✅ **Cross-Platform Compatible** - Works on macOS, Linux, and Windows (WSL)
- ✅ **Readme.txt Updater** - Updates tested up to version and latest changelog date
- ✅ **Version Checker** - Validates version numbers across plugin files and documentation

# Installation

1. Clone the repo, and rename the `plugin-name` folder, `plugin-name.php` and `/i18n/languages/plugin-name.pot` to your plugin name.

2. Do a find and replace of these terms, e.g., if the plugin is `Example Name` by `Example Vendor` then:

> ⚠️ **IMPORTANT: All these values are case-sensitive. Do not modify `Plugin Name:` in your plugin header.**

| Original Term  | Replace With     |
|----------------|------------------|
| `Plugin Name`  | `Example Name`   |
| `PluginName`   | `ExampleName`    |
| `plugin-name`  | `example-name`   |
| `plugin_name`  | `example_name`   |
| `Plugin_Name`  | `Example_Name`   |
| `PLUGIN_NAME`  | `EXAMPLE_NAME`   |
| `Vendor Name`  | `Example Vendor` |
| `VendorName`   | `ExampleVendor`  |
| `vendor-name`  | `example-vendor` |

3. Modify your renamed `plugin-name.php` to your requirements, e.g., plugin URI, description, etc.

4. Modify `readme.txt` to your requirements, e.g., contributors, tags, etc. Compare your readme.txt to the [WordPress.org example](https://wordpress.org/plugins/readme.txt), and [validate your readme.txt](https://wordpress.org/plugins/developers/readme-validator/).

5. Add your renamed `plugin-name` folder to your WordPress `/wp-content/plugins` folder, or symlink it from another location.

6. In your terminal from your renamed `plugin-name` folder, run these commands:

- `composer install`
- `pnpm install`

This will install the dependencies.

After the installation steps, you'll see various files; some of these are dev files that won't end up in the final built zip. Some folders/files are only generated upon certain development scripts being run.

# Assets

The `client` folder has 2 asset handling examples:

| Folder                           | Description                                                                   |
|----------------------------------|-------------------------------------------------------------------------------|
| `client/bundle`                  | Bundled assets. See the comments in `example-bundle.js` for import examples.  |
| `client/static`                  | Static assets. Includes examples of CSS/SCSS/JS files.                        |

Build them using `build:assets` to see the resulting files. The files will be added to `assets` to be enqueued.

You should replace these with your assets as per your requirements or remove them if not needed. Amend the `package.json` and `webpack.config.js` scripts/dependencies accordingly.

When enqueuing your assets, enqueue from `/assets`, not `/client` as these are the source files.

# PHP

General and lifecycle-based code examples are included. Amend or remove these as needed for your plugin.

| File                            | Description                                                     |
|---------------------------------|-----------------------------------------------------------------|
| `src/Example_Class.php`         | Example of a class, includes enqueue examples.                  |
| `src/Lifecycle/Activator.php`   | Can be used for activation, e.g., setting a transient.          |
| `src/Lifecycle/Deactivator.php` | Can be used for deactivation, e.g., clearing scheduled hooks.   |
| `src/Lifecycle/Installer.php`   | Can be used for installation, e.g., creating database tables.   |
| `src/Lifecycle/Updater.php`     | Can be used for updating, e.g., add a new option.               |
| `uninstall.php`                 | For uninstall scripts, e.g., delete database tables.            |

The classes are autoloaded by Composer and get instantiated from `plugin-name.php`.

# Scripts

There are several included PNPM scripts which can be run, some of which in turn run the associated Composer scripts. It is recommended to use these rather than the Composer scripts directly:

| Command                     | Description                                                                                                                | Usage                                |
|-----------------------------|----------------------------------------------------------------------------------------------------------------------------|--------------------------------------|
| `build`                     | Builds the plugin, including assets and i18n files.                                                                        | `pnpm run build`                     |
| `build:assets`              | Builds all assets.                                                                                                         | `pnpm run build:assets`              |
| `build:assets:bundle`       | Builds only bundled assets.                                                                                                | `pnpm run build:assets:bundle`       |
| `build:assets:static`       | Builds only static assets                                                                                                  | `pnpm run build:assets:static`       |
| `build:assets:static:css`   | Builds only static CSS assets.                                                                                             | `pnpm run build:assets:static:css`   |
| `build:assets:static:scss`  | Builds only static SCSS assets.                                                                                            | `pnpm run build:assets:static:scss`  |
| `build:assets:static:js`    | Builds only static JS assets.                                                                                              | `pnpm run build:assets:static:js`    |
| `build:i18n`                | Generates internationalization (i18n) files for the plugin.                                                                | `pnpm run build:i18n`                |
| `phpcs:check`               | Runs PHP CodeSniffer to check for coding standard violations, logged to phpcs-report.txt.                                  | `pnpm run phpcs:check`               |
| `phpcs:fix`                 | Runs PHP CodeSniffer (phpcbf) to automatically fix coding standard violations.                                             | `pnpm run phpcs:fix`                 |
| `prettier:check`            | Checks code formatting using Prettier.                                                                                     | `pnpm run prettier:check`            |
| `prettier:fix`              | Fixes code formatting issues using Prettier.                                                                               | `pnpm run prettier:fix`              |
| `readme:update`             | Updates readme.txt "Tested up to" to latest WordPress version and replaces changelog date placeholder 0000-00-00 to today. | `pnpm run readme:update`             |
| `version:check`             | Checks for matching version numbers in plugin header, readme.txt, etc.                                                     | `pnpm run version:check`             |
| `version:wp:check`          | Checks the minimum WordPress version requirement is accurate based on use of core WordPress functions, classes, etc.       | `pnpm run version:wp:check`          |
| `watch`                     | Watches for CSS/SCSS/JS changes in /client and rebuilds in /assets.                                                        | `pnpm run watch`                     |
| `zip`                       | Creates a zip file of the plugin.                                                                                          | `pnpm run zip`                       |
| `zip:release`               | Same as zip script, but checks version numbers and updates readme.txt before zipping.                                      | `pnpm run zip:release`               |

Amend/remove these scripts as required.

# Zip

To genrate a zip, run `pnpm run zip` or `pnp run zip:release` script, see differences in the scripts section above; to exclude specific files/folders, add them to `.distignore`.

The zip will be created in `/zip`. Note that the `build` script is run automatically before zipping.

# Recommendations

Consider the following recommendations when developing your plugin:

- [GitHub actions](https://github.com/features/actions) to perform checks on code.
- [Lefthook](https://lefthook.dev) to check code before it is committed.
- [PHPUnit](https://phpunit.de) to add unit tests.
- [WPify Scoper](https://github.com/wpify/scoper) if using non-dev composer dependencies.