<?php
/**
 * Plugin Deactivator
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Deactivator {

	/**
	 * Runs when plugin is deactivated.
	 *
	 * @return void
	 */
	public static function deactivate() {

		// Reserved for future cleanup tasks.
		// We intentionally do not delete any data here.

		flush_rewrite_rules();

	}
}