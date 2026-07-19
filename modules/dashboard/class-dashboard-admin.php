<?php
/**
 * Dashboard Admin Controller
 *
 * Handles the CASBEN Business Suite dashboard.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard Admin Controller.
 */
class CASBEN_Dashboard_Admin {

	/**
	 * Dashboard data provider.
	 *
	 * @var CASBEN_Dashboard_Data
	 */
	private $data;

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Load dashboard data provider.
		$this->data = new CASBEN_Dashboard_Data();
	}

	/**
	 * Display dashboard page.
	 *
	 * @return void
	 */
	public function dashboard_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die(
				esc_html__(
					'You do not have permission to access this page.',
					'casben-business-suite'
				)
			);
		}

		// Retrieve dashboard data.
		$stats             = $this->data->get_dashboard_stats();
		$recent_invoices   = $this->data->get_recent_invoices();
		$invoice_status    = $this->data->get_invoice_status();
		$fbr_status        = $this->data->get_fbr_status();
		$recent_activity   = $this->data->get_recent_activity();

		// Load dashboard view.
		require CASBEN_PLUGIN_DIR .
			'modules/dashboard/views/dashboard.php';
	}
}