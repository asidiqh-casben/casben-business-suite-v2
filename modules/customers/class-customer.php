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

		require_once CASBEN_PLUGIN_DIR . 'modules/customers/class-customers-admin.php';

		new CASBEN_Customers_Admin();

	}

}