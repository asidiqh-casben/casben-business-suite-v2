<?php
/**
 * Product Module Loader
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Products {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Load Product classes.
		require_once plugin_dir_path( __FILE__ ) . 'class-product-list.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-product-form.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-product-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-product-save.php';

		// Initialize modules.
		new CASBEN_Product_Save();
	}
}