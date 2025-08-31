<?php

declare( strict_types = 1 );

namespace VendorName\PluginName;

defined( 'ABSPATH' ) or exit;

/**
 * Example class.
 *
 * @since 1.0.0
 */
class Example_Class {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'method_example' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_example' ) );
	}

	/**
	 * Method example.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function method_example(): void {
		esc_html_e( 'Example method for Plugin Name.', 'plugin-name' );
	}

	/**
	 * Enqueue example.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function enqueue_example(): void {
		// Enqueue the bundled CSS.
		wp_enqueue_style(
			'plugin-name-bundle',
			PLUGIN_NAME_PLUGIN_DIR_URL . 'assets/bundle/example-bundle.min.css',
			array(),
			PLUGIN_NAME_PLUGIN_VERSION
		);

		// Enqueue the bundled JavaScript.
		wp_enqueue_script(
			'plugin-name-bundle',
			PLUGIN_NAME_PLUGIN_DIR_URL . 'assets/bundle/example-bundle.min.js',
			array( 'wp-i18n' ), // Dependencies.
			PLUGIN_NAME_PLUGIN_VERSION,
			true // Load in footer.
		);

		// Set script translations.
		wp_set_script_translations(
			'plugin-name-bundle',
			'plugin-name',
			PLUGIN_NAME_PLUGIN_DIR_PATH . 'i18n/languages'
		);

		// Enqueue the static CSS.
		wp_enqueue_style(
			'plugin-name-static',
			PLUGIN_NAME_PLUGIN_DIR_URL . 'assets/static/example-css.min.css',
			array(),
			PLUGIN_NAME_PLUGIN_VERSION
		);

		// Enqueue the static JavaScript.
		wp_enqueue_script(
			'plugin-name-static',
			PLUGIN_NAME_PLUGIN_DIR_URL . 'assets/static/example-js.min.js',
			array( 'wp-i18n' ), // Dependencies.
			PLUGIN_NAME_PLUGIN_VERSION,
			true // Load in footer.
		);

		// Set script translations.
		wp_set_script_translations(
			'plugin-name-static',
			'plugin-name',
			PLUGIN_NAME_PLUGIN_DIR_PATH . 'i18n/languages'
		);
	}
}
