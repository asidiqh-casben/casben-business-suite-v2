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

		add_menu_page(
			__( 'CASBEN Business Suite', 'casben-business-suite' ),
			__( 'CASBEN Suite', 'casben-business-suite' ),
			'manage_options',
			'casben-business-suite',
			array( __CLASS__, 'dashboard_page' ),
			'dashicons-businessman',
			25
		);

		add_submenu_page(
			'casben-business-suite',
			__( 'Customers', 'casben-business-suite' ),
			__( 'Customers', 'casben-business-suite' ),
			'manage_options',
			'casben-customers',
			array( __CLASS__, 'customers_page' )
		);

		add_submenu_page(
			'casben-business-suite',
			__( 'Invoices', 'casben-business-suite' ),
			__( 'Invoices', 'casben-business-suite' ),
			'manage_options',
			'casben-invoices',
			array( __CLASS__, 'invoices_page' )
		);

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
	public static function dashboard_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'CASBEN Business Suite', 'casben-business-suite' ); ?></h1>
			<p><?php esc_html_e( 'Welcome to CASBEN Business Management System.', 'casben-business-suite' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Customers page.
	 *
	 * @return void
	 */
	public static function customers_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Customers', 'casben-business-suite' ); ?></h1>
			<p><?php esc_html_e( 'Customer management module will be added here.', 'casben-business-suite' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Invoices page.
	 *
	 * @return void
	 */
	public static function invoices_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Invoices', 'casben-business-suite' ); ?></h1>
			<p><?php esc_html_e( 'Invoice management module will be added here.', 'casben-business-suite' ); ?></p>
		</div>
		<?php
	}

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