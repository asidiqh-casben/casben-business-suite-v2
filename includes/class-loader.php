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
 		* Settings Module
 		*/
		require_once CASBEN_PLUGIN_DIR . 'modules/settings/class-settings.php';

		/*
		 * Admin Menu
		 */
		require_once CASBEN_PLUGIN_DIR . 'includes/admin/class-admin-menu.php';

		/*
		 * Plugin Lifecycle
		 */
		require_once CASBEN_PLUGIN_DIR . 'includes/class-activator.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-deactivator.php';


		/*
		 * Customers Module
		 */
		require_once CASBEN_PLUGIN_DIR . 'modules/customers/class-customer.php';


		/*
		 * Products Module
		 */
		require_once CASBEN_PLUGIN_DIR . 'modules/products/class-product.php';


		/*
		 * Invoices Module
		 */
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoices.php';
		/*
		* Dashboard Module
		*/
		
		require_once CASBEN_PLUGIN_DIR . 'modules/dashboard/class-dashboard-admin.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/dashboard/class-dashboard-data.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/class-ui-card.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/class-ui-actions.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/class-ui.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/class-activity-log.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/components/class-btn.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/components/class-page-toolbar.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/ui/components/class-stat-card.php';

		/*
		 * Initialize Admin
		 */
		if ( is_admin() ) {

			CASBEN_Assets::init();

			CASBEN_Admin::init();


			// Initialize Customers Module
			new CASBEN_Customers();


			// Initialize Products Module
			new CASBEN_Products();


			// Initialize Invoices Module
			new CASBEN_Invoices();
			// Initialize Dashboard Module
			new CASBEN_Dashboard_Admin();

		}

	}

}