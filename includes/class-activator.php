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
		 * Install default business settings.
		 */
		CASBEN_Settings::install_defaults();

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
		 * Refresh WordPress rewrite rules.
		 */
		flush_rewrite_rules();

	}

}