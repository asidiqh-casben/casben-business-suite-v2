<?php
/**
 * Customer Admin
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Customers_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
	}

	/**
	 * Register Customers submenu.
	 */
	public function register_menu() {

		add_submenu_page(
			'casben-suite',
			__( 'Customers', 'casben-business-suite' ),
			__( 'Customers', 'casben-business-suite' ),
			'manage_options',
			'casben-customers',
			array( $this, 'customers_page' )
		);

	}

	/**
	 * Customers page.
	 */
	public function customers_page() {
		?>
		<div class="wrap">
			<h1>Customers</h1>

			<p>Welcome to the Customer Management Module.</p>

			<p>This page will soon display the customer list.</p>
		</div>
		<?php
	}

}