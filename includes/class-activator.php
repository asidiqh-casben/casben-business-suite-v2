<?php
/**
 * CASBEN Business Suite
 *
 * Plugin Activator
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Activator {

	/**
	 * Runs during plugin activation.
	 *
	 * @return void
	 */
	public static function activate() {

		/*
		 * Create database tables.
		 */
		CASBEN_Database::install();

		/*
		 * Save plugin version.
		 */
		update_option(
			'casben_version',
			CASBEN_VERSION
		);

		/*
		 * Save installation timestamp (only once).
		 */
		if ( ! get_option( 'casben_install_time' ) ) {

			update_option(
				'casben_install_time',
				current_time( 'timestamp' )
			);

		}

		/*
		 * Default plugin settings.
		 */
		if ( ! get_option( 'casben_settings' ) ) {

			update_option(
				'casben_settings',
				array(

					'company_name' => '',
					'company_address' => '',
					'company_phone' => '',
					'company_email' => '',

					'ntn' => '',
					'strn' => '',

					'fbr_mode' => 'sandbox',
					'fbr_api_url' => '',
					'fbr_bearer_token' => '',

					'invoice_prefix' => 'C',
					'invoice_counter' => 1,

				)
			);

		}

		/*
		 * Refresh WordPress rewrite rules.
		 */
		flush_rewrite_rules();

	}

}