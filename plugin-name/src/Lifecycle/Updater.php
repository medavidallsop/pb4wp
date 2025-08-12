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
		// Do any update tasks using version_compare of the plugin_name_version then update the version number so in future the updater knows the current version to compare to.
		update_option( 'plugin_name_version', PLUGIN_NAME_PLUGIN_VERSION );
	}
}
