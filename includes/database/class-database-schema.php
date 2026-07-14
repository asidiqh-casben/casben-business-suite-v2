<?php
/**
 * Database Schema Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Database_Schema {

	/**
	 * Database Version.
	 */
	const DB_VERSION = '1.0.1';

	/**
	 * Create or update all plugin tables.
	 *
	 * @return void
	 */
	public static function create_tables() {

		// Load schema classes.
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-customers.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-products.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-invoices.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-invoice-items.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-invoice-logs.php';
		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-schema-settings.php';

		// Create tables.
		CASBEN_Schema_Customers::create_table();
		CASBEN_Schema_Products::create_table();
		CASBEN_Schema_Invoices::create_table();
		CASBEN_Schema_Invoice_Items::create_table();
		CASBEN_Schema_Invoice_Logs::create_table();
		CASBEN_Schema_Settings::create_table();

		update_option(
			'casben_db_version',
			self::DB_VERSION
		);
	}

	/**
	 * Get current database version.
	 *
	 * @return string
	 */
	public static function get_version() {

		return get_option(
			'casben_db_version',
			'0.0.0'
		);
	}
}