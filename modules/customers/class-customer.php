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
		require_once plugin_dir_path( __FILE__ ) . 'class-customer-save.php';

		// Initialize modules.
		
		new CASBEN_Customer_Save();
	}
}