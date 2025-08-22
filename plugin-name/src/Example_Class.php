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
		add_action( 'wp_footer', array( $this, 'example' ) );
	}

	/**
	 * Example method.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function example(): void {
		esc_html_e( 'Example_Class for Plugin Name.', 'plugin-name' );
	}
}
