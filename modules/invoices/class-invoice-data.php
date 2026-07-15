<?php
/**
 * Invoice Data Provider
 *
 * Provides lookup data for invoice forms.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Data {

	/**
	 * Get customers.
	 *
	 * @return array
	 */
	public static function get_customers() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';

		return $wpdb->get_results(
			"SELECT id, company_name
			FROM {$table}
			ORDER BY company_name ASC"
		);
	}

	/**
	 * Get active products.
	 *
	 * @return array
	 */
	public static function get_products() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_products';

		return $wpdb->get_results(
			"SELECT id, product_name
			FROM {$table}
			WHERE status = 1
			ORDER BY product_name ASC"
		);
	}
}