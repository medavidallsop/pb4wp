<?php

declare( strict_types = 1 );

namespace VendorName\PluginName\Lifecycle;

defined( 'ABSPATH' ) or exit;

/**
 * Updater class.
 *
 * Handles the update tasks for the plugin.
 *
 * @since 1.0.0
 */
class Updater {

	/**
	 * Perform plugin update tasks.
	 *
	 * This method is called when the plugin is updated.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function update(): void {
		// Get the current version number.
		$version = get_option( 'plugin_name_version' );

		// If the current version number is not the same as the plugin version number.
		if ( PLUGIN_NAME_PLUGIN_VERSION !== $version ) {
			/*
			// Do any update tasks using version_compare.
			if ( version_compare( $version, '1.0.0', '<' ) ) {
				update_option( 'plugin_name_example_setting', 'example_value' );
			}
			*/
		}

		// Update the version number so in future the updater knows the current version to compare to.
		update_option( 'plugin_name_version', PLUGIN_NAME_PLUGIN_VERSION );
	}
}
