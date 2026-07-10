<?php
/**
 * CASBEN Business Suite
 *
 * Admin Controller
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Admin {

	/**
	 * Initialize admin modules.
	 *
	 * @return void
	 */
	public static function init() {

		// Register WordPress admin menus.
		add_action(
			'admin_menu',
			array(
				'CASBEN_Admin_Menu',
				'register_menu'
			)
		);

		/*
		 * Future initialization:
		 *
		 * Dashboard
		 * Settings
		 * Customers
		 * Products
		 * Invoices
		 * Reports
		 * FBR API
		 */

	}

}