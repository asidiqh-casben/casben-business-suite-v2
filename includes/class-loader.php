<?php
/**
 * CASBEN Business Suite
 *
 * Class Loader
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Loader {

	/**
	 * Load all required classes and initialize the plugin.
	 *
	 * @return void
	 */
	public static function load() {

		/*
		 * Core Classes
		 */
		require_once CASBEN_PLUGIN_DIR . 'includes/class-database.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-helpers.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-assets.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-admin.php';

		/*
		 * Admin Classes
		 */
		require_once CASBEN_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';

		/*
		 * Plugin Lifecycle
		 */
		require_once CASBEN_PLUGIN_DIR . 'includes/class-activator.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-deactivator.php';

		/*
		 * Initialize Admin Modules.
		 */
		if ( is_admin() ) {

			CASBEN_Assets::init();
			CASBEN_Admin::init();

		}

	}

}