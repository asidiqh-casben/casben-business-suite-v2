<?php
/**
 * CASBEN Business Suite
 *
 * Admin Menu Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Admin_Menu {

	/**
	 * Register plugin admin menu.
	 *
	 * @return void
	 */
	public static function register_menu() {

		$dashboard_admin = new CASBEN_Dashboard_Admin();

		add_menu_page(
			__( 'CASBEN Business Suite', 'casben-business-suite' ),
			__( 'CASBEN Suite', 'casben-business-suite' ),
			'manage_options',
			'casben-business-suite',
			array( $dashboard_admin, 'dashboard_page' ),
			'dashicons-businessman',
			25
		);


		/*
		 * Dashboard
		 */
		add_submenu_page(
			'casben-business-suite',
			__( 'Dashboard', 'casben-business-suite' ),
			__( 'Dashboard', 'casben-business-suite' ),
			'manage_options',
			'casben-business-suite',
			array( $dashboard_admin, 'dashboard_page' )
		);


		/*
		 * Customers
		 */
		$customers_admin = new CASBEN_Customers_Admin();

		add_submenu_page(
			'casben-business-suite',
			__( 'Customers', 'casben-business-suite' ),
			__( 'Customers', 'casben-business-suite' ),
			'manage_options',
			'casben-customers',
			array( $customers_admin, 'customers_page' )
		);


		/*
		 * Products
		 */
		$products_admin = new CASBEN_Product_Admin();

		add_submenu_page(
			'casben-business-suite',
			__( 'Products', 'casben-business-suite' ),
			__( 'Products', 'casben-business-suite' ),
			'manage_options',
			'casben-products',
			array( $products_admin, 'products_page' )
		);


		/*
		* Invoices
		*/
				error_log(
			'Invoice admin object: ' .
			(
				isset( $GLOBALS['casben_invoice_admin'] )
					? get_class( $GLOBALS['casben_invoice_admin'] )
					: 'NOT FOUND'
			)
		);
		add_submenu_page(
			'casben-business-suite',
			__( 'Invoices', 'casben-business-suite' ),
			__( 'Invoices', 'casben-business-suite' ),
			'manage_options',
			'casben-invoices',
			array(
				$GLOBALS['casben_invoice_admin'],
				'invoices_page'
			)
		);

		/*
		 * Settings
		 */
		add_submenu_page(
			'casben-business-suite',
			__( 'Settings', 'casben-business-suite' ),
			__( 'Settings', 'casben-business-suite' ),
			'manage_options',
			'casben-settings',
			array( __CLASS__, 'settings_page' )
		);

	}


	/**
	 * Dashboard page.
	 *
	 * @return void
	 */


	/**
	 * Settings page.
	 *
	 * @return void
	 */
	public static function settings_page() {
		?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Settings', 'casben-business-suite' ); ?></h1>
			<p><?php esc_html_e( 'Company information and FBR configuration will be added here.', 'casben-business-suite' ); ?></p>
		</div>

		<?php
	}

}