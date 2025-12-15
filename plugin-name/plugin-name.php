<?php
/**
 * Plugin Name: Plugin Name
 * Plugin URI: https://example.com
 * Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Author: Vendor Name
 * Author URI: https://example.com
 * Version: 1.0.0
 * Requires at least: 5.0.0
 * Requires PHP: 7.4.0
 * Domain Path: /i18n/languages/
 * Text Domain: plugin-name
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package PluginName
 */

declare( strict_types = 1 );

namespace VendorName\PluginName;

defined( 'ABSPATH' ) or exit;

require_once __DIR__ . '/vendor_prefixed/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

use VendorName\PluginName\Example_Class;
use VendorName\PluginName\Lifecycle\Activator;
use VendorName\PluginName\Lifecycle\Deactivator;
use VendorName\PluginName\Lifecycle\Installer;
use VendorName\PluginName\Lifecycle\Updater;

if ( ! class_exists( 'Plugin_Name' ) ) {

	/**
	 * Main class for the plugin.
	 *
	 * @since 1.0.0
	 */
	class Plugin_Name {

		/**
		 * Instance of the plugin.
		 *
		 * @var Plugin_Name|null
		 * @since 1.0.0
		 */
		private static $instance = null;

		/**
		 * Plugin version.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = '1.0.0';

		/**
		 * Main instance of the plugin.
		 *
		 * Ensures only one instance of the plugin is loaded or can be loaded.
		 *
		 * @return Plugin_Name Main instance.
		 * @since 1.0.0
		 */
		public static function instance(): Plugin_Name {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * Sets up the plugin and initializes hooks.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->define_constants();
			$this->init_hooks();
		}

		/**
		 * Define plugin constants.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		private function define_constants(): void {
			define( 'PLUGIN_NAME_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'PLUGIN_NAME_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
			define( 'PLUGIN_NAME_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
			define( 'PLUGIN_NAME_PLUGIN_VERSION', $this->version );
		}

		/**
		 * Initialize hooks for activation, deactivation, installation, updates, and textdomain loading.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		private function init_hooks(): void {
			register_activation_hook( __FILE__, array( Activator::class, 'activate' ) );
			register_deactivation_hook( __FILE__, array( Deactivator::class, 'deactivate' ) );
			add_action( 'init', array( $this, 'load_textdomain' ) );
			add_action( 'init', array( $this, 'install_or_update' ) ); // After load_textdomain as i18n strings maybe needed in install/update tasks.
		}

		/**
		 * Load plugin textdomain for translations.
		 *
		 * The load_plugin_textdomain function is not needed in WordPress v4.6+ for WordPress.org plugins (and v6.8+ for self-hosted).
		 * It is still included here to ensure compatibility with older WordPress versions.
		 * This will be flagged as an error by Plugin Check (https://wordpress.org/plugins/plugin-check/). You can remove it if you are not using it.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function load_textdomain(): void {
			load_plugin_textdomain(
				'plugin-name',
				false,
				dirname( plugin_basename( __FILE__ ) ) . '/i18n/languages/'
			);
		}

		/**
		 * Install or update the plugin.
		 *
		 * This method checks if the plugin is being installed for the first time or if it is being updated.
		 * It calls the appropriate method from the Installer or Updater class.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function install_or_update(): void {
			if ( ! get_option( 'plugin_name_version' ) ) {
				Installer::install();
			} elseif ( get_option( 'plugin_name_version' ) !== $this->version ) {
				Updater::update();
			}
		}

		/**
		 * Run the plugin.
		 *
		 * This method is called to run the plugin and initialize any necessary components.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function run(): void {
			new Example_Class();
		}
	}

}

if ( ! function_exists( 'plugin_name' ) ) {
	/**
	 * Returns the main instance of the plugin.
	 *
	 * @return Plugin_Name Main instance of the plugin.
	 * @since 1.0.0
	 */
	function plugin_name(): Plugin_Name {
		return Plugin_Name::instance();
	}
	plugin_name()->run();
}
