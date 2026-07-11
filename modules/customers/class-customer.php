<?php
/**
 * Customer Module Loader
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Customers {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Load Customer classes.
		require_once plugin_dir_path( __FILE__ ) . 'class-customer-list.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-customer-form.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-customer-admin.php';

		// Initialize Customer Admin.
		new CASBEN_Customers_Admin();
	}
}