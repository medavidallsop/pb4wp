<?php

declare( strict_types = 1 );

namespace VendorName\PluginName\Lifecycle;

defined( 'ABSPATH' ) or exit;

/**
 * Installer class.
 *
 * Handles the installation tasks for the plugin.
 *
 * @since 1.0.0
 */
class Installer {

	/**
	 * Perform plugin installation tasks.
	 *
	 * This method is called when the plugin is installed.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function install(): void {
		// Do any installation tasks, then update the version number so in future the installer doesn't run again and the updater knows the current version to compare to.
		update_option( 'plugin_name_version', PLUGIN_NAME_PLUGIN_VERSION );
	}
}
