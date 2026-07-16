<?php
/**
 * Invoice Module Loader
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoices {

	/**
	 * Invoice admin.
	 *
	 * @var CASBEN_Invoice_Admin
	 */
	public $admin;

	/**
	 * Invoice save handler.
	 *
	 * @var CASBEN_Invoice_Save
	 */
	public $save;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->includes();

		$this->admin = new CASBEN_Invoice_Admin();
		$this->save  = new CASBEN_Invoice_Save();
	}

	/**
	 * Include required files.
	 *
	 * @return void
	 */
	private function includes() {

		// Invoice Model.
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-number.php';
		// Admin UI.
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-data.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-admin.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-list.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-form.php';
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-calculator.php';

		// Invoice Processing.
		require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-save.php';
	}
}