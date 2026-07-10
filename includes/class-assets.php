<?php
/**
 * CASBEN Business Suite
 *
 * Assets Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class CASBEN_Assets {


	/**
	 * Initialize assets.
	 *
	 * @return void
	 */
	public static function init() {

		add_action(
			'admin_enqueue_scripts',
			array(
				__CLASS__,
				'enqueue_admin_assets'
			)
		);

	}



	/**
	 * Load admin CSS and JavaScript files.
	 *
	 * @return void
	 */
	public static function enqueue_admin_assets( $hook ) {


		// Load only CASBEN pages.
		if ( strpos( $hook, 'casben' ) === false ) {
			return;
		}


		wp_enqueue_style(
			'casben-admin-style',
			CASBEN_PLUGIN_URL . 'assets/css/admin-style.css',
			array(),
			CASBEN_VERSION
		);


		wp_enqueue_script(
			'casben-admin-script',
			CASBEN_PLUGIN_URL . 'assets/js/admin-script.js',
			array( 'jquery' ),
			CASBEN_VERSION,
			true
		);

	}

}