<pre>
██████╗ ██████╗ ██╗  ██╗██╗    ██╗██████╗
██╔══██╗██╔══██╗██║  ██║██║    ██║██╔══██╗
██████╔╝██████╔╝███████║██║ █╗ ██║██████╔╝
██╔═══╝ ██╔══██╗╚════██║██║███╗██║██╔═══╝
██║     ██████╔╝     ██║╚███╔███╔╝██║
╚═╝     ╚═════╝      ╚═╝ ╚══╝╚══╝ ╚═╝
</pre>

# Plugin Boilerplate for WordPress (PB4WP)

A boilerplate you can use as a foundation for building object-orientated WordPress plugins, includes PHP code examples for activation, deactivation, install, update, and uninstall, and scripts for development tasks.

# Prerequisites

**TL;DR: Use a POSIX OS and ensure `php`, `composer`, `pnpm`, and `wp` terminal commands are available globally.**

A POSIX compliant operating system (e.g. macOS, Linux) is assumed. If you're working on a Windows machine, the recommended approach is to use [WSL](https://learn.microsoft.com/en-us/windows/wsl/install) (available since Windows 10).

- [PHP](https://www.php.net/manual/en/install.php)\*
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Node.js](https://nodejs.org/en)*
- [PNPM](https://pnpm.io/installation)*
- [WP-CLI](https://wp-cli.org/#installing) (as some included scripts use the `wp` command)

*\* Some scripts included may require a recent PHP version.*

# Features

- ✅ PSR4 autoloading
- ✅ Compliant with WordPress coding standards*
- ✅ Asset compilation and minification for bundles and static assets
- ✅ Translation ready and generates .pot, .mo, .json
- ✅ PHP code examples
- ✅ Scripts for development tasks
- ✅ Produces a production ready zip

*\*Checks and/or fixes issues with PHP, JS, CSS, etc, With the exception of PHPCS `Squiz.Commenting.FileComment.Missing` rule - but this can be removed from `phpcs.xml` if needed.*

# Installation

**TL;DR: Rename the folder, and the files and their contents to your plugin/vendor name, then run `composer install` then `pnpm install` from the folder.**

1. Rename the `plugin-name` folder, and the inner `plugin-name.php` file in the folder.

2. Find and replace the following **CASE SENSITIVE** terms, e.g. if the plugin is `Example Name` by `Example Vendor` then:

| Original Term       | Replace With    |
|---------------------|-----------------|
| `plugin-name`       | `example-name`  |
| `plugin_name`       | `example_name`  |
| `Plugin_Name`       | `Example_Name`  |
| `PLUGIN_NAME_`      | `EXAMPLE_NAME_` |
| `Plugin Name`*      | `Example Name`  |
| `VendorName`        | `ExampleVendor` |
| `Vendor Name`       | `Example Vendor`|

*\* **DO NOT** replace `Plugin Name:` in your renamed `plugin-name.php`.*

3. Modify your renamed `plugin-name.php` to your requirements, e.g. plugin URI, description, etc.

4. Modify `readme.txt` to your requirements, e.g. contributors, tags, etc. I recommend comparing your readme.txt to the [WordPress.org example](https://wordpress.org/plugins/readme.txt). You can also [validate your readme.txt](https://wordpress.org/plugins/developers/readme-validator/).

5. Add the folder to your WordPress `/wp-content/plugins` folder, or symlink it from another location.

6. In your terminal from your renamed `plugin-name` folder, run these commands:

- `composer install`
- `pnpm install`

This will install composer and PNPM dependencies.

# Structure

After the installation steps, you'll see the following structure. Some of these folders/files are only generated upon certain development scripts being run.

| Folder/File          | Description                                                                 | In Zip                          |
|----------------------|-----------------------------------------------------------------------------|---------------------------------|
| `assets`             | Generated during build containing output from `client`.                     | ✅                              |
| `build`              | Generated when a zip of the plugin is created.                              | ❌                              |
| `client`             | Handles user-facing side of the plugin, such as JS/CSS. Built to `assets`.  | ❌                              |
| `i18n`               | Contains translations.                                                      | ✅                              |
| `node_modules`       | Stores PNPM packages.                                                       | ❌                              |
| `src`                | Contains PHP classes, functions, etc.                                       | ✅                              |
| `vendor`             | Autoloader for dependencies.                                                | ✅ (only non-dev dependencies)  |
| `.distignore`        | Used by the zip process to determine which files should be excluded.        | ❌                              |
| `.prettierignore`    | Specifies files that Prettier will ignore.                                  | ❌                              |
| `.prettierrc.js`     | Configuration file for Prettier.                                            | ❌                              |
| `composer.json`      | Configuration file for Composer.                                            | ❌                              |
| `composer.lock`      | Configuration file for Composer.                                            | ❌                              |
| `LICENSE.txt`        | License information.                                                        | ✅                              |
| `package.json`       | Configuration file for NPM.                                                 | ❌                              |
| `phpcs-report.txt`   | Generated during phpcs scripts.                                             | ❌                              |
| `phpcs.xml`          | phpcs rule configuration.                                                   | ❌                              |
| `plugin-name.php`    | Root plugin file.                                                           | ✅                              |
| `pnpm-lock-yaml`     | PNPM configuration file.                                                    | ❌                              |
| `README.md`          | Plugin readme.                                                              | ✅                              |
| `uninstall.php`      | Uninstall functionality.                                                    | ✅                              |
| `webpack.config.js`  | Configuration file for Webpack.                                             | ❌                              |

# Assets

The `client` folder has 2 example folders:

| Folder                           | Description                                                                                                                                       |
|----------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------|
| `client/bundle`                  | Example of JS which bundles a PNPM library as both css/js, when the assets are built a combined JS file is included in `assets` to be enqueued.   |
| `client/static`                  | Example of static CSS/SCSS/JS, when the assets are built these are compiled and minified in `assets` to be enqueued.                              |

You should replace these with your assets as per your requirements, or remove entirely if no assets needed. (regardless of which, ensure you amend the scripts in `package.json` accordingly).

Note when enqueuing your assets, it is recommended to enqueue the compiled version in `/assets`, not `/client`, as the assets folder contains the compiled/minified assets, whereas client are the source files.

If your project relies on a JS library, rather than enqueing the JS library, it is recommended to bundle this with the script files which rely on it.

# PHP

I have included some PHP code examples. Amend or remove these as needed for your plugin.

| File                           | Description                                                    |
|--------------------------------|----------------------------------------------------------------|
| `src/Example_Class.php`        | Example of a class.                                            |
| `src/Lifecycle/Activator.php`  | Can be used for activation, e.g. setting a transient.          |
| `src/Lifecycle/Dectivator.php` | Can be used for deactivation, e.g. clearing scheduled hooks.   |
| `src/Lifecycle/Installer.php`  | Can be used for installation, e.g. creating database tables.   |
| `src/Lifecycle/Updater.php`    | Can be used for updating, e.g. add a new option.               |
| `uninstall.php`                | For uninstall scripts, e.g. delete database tables.            |

The classes are autoloaded by Composer, and get instantiated from `plugin-name.php`.

# Scripts

There are several included PNPM scripts which can be run, some of which in turn run the associated Composer scripts:

| Command                     | Description                                                                 | Usage                               |
|-----------------------------|-----------------------------------------------------------------------------|-------------------------------------|
| `build`                     | Builds the plugin, including assets and other necessary files.              | `pnpm run build`                    |
| `build:assets`              | Builds all assets (CSS, JS, etc.) for the plugin.                           | `pnpm run build:assets`             |
| `build:assets:bundle`       | Builds bundled assets (e.g., combined JS/CSS files).                        | `pnpm run build:assets:bundle`      |
| `build:assets:static`       | Builds static assets (e.g., standalone CSS/JS files).                       | `pnpm run build:assets:static`      |
| `build:assets:static:css`   | Builds static CSS assets.                                                   | `pnpm run build:assets:static:css`  |
| `build:assets:static:scss`  | Builds static SCSS assets.                                                  | `pnpm run build:assets:static:scss` |
| `build:assets:static:js`    | Builds static JS assets.                                                    | `pnpm run build:assets:static:js`   |
| `build:i18n`                | Generates internationalization (i18n) files for the plugin.                 | `pnpm run build:i18n`               |
| `phpcs:check`               | Runs PHP CodeSniffer to check for coding standard violations.               | `pnpm run phpcs:check`              |
| `phpcs:fix`                 | Runs PHP CodeSniffer to automatically fix coding standard violations.       | `pnpm run phpcs:fix`                |
| `prettier:check`            | Checks code formatting using Prettier.                                      | `pnpm run prettier:check`           |
| `prettier:fix`              | Fixes code formatting issues using Prettier.                                | `pnpm run prettier:fix`             |
| `test`                      | Runs tests for the plugin.                                                  | `pnpm run test`                     |
| `watch`                     | Watches for changes in assets and rebuilds them automatically.              | `pnpm run watch`                    |
| `zip`                       | Creates a zip file of the plugin for distribution.                          | `pnpm run zip`                      |

Feel free to amend/remove these scripts as required, e.g. your project might not have any static assets.

# Zip

To download a production ready zip, run the `pnpm run zip` script, this will result in only production files being included, to exclude specific folders/files, add them to `.distignore`.

# What you should check before deploying

- Check version numbers correct
- Checked version declarations correct (e.g. tested up to)

# Contribute

If you wish to contribute to this project, feel free to submit a PR.