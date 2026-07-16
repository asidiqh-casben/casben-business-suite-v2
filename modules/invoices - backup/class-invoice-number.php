<?php
/**
 * Invoice Number Generator
 *
 * Generates the next invoice number.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Number {

	/**
	 * Generate the next invoice number.
	 *
	 * Format:
	 * INV-YYYY-000001
	 *
	 * @return string
	 */
	public static function generate() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoices';

		$year = current_time( 'Y' );

		$prefix = 'INV-' . $year . '-';

		$sql = $wpdb->prepare(
			"
			SELECT invoice_number
			FROM {$table}
			WHERE invoice_number LIKE %s
			ORDER BY id DESC
			LIMIT 1
			",
			$prefix . '%'
		);

		$last_invoice = $wpdb->get_var( $sql );

		if ( empty( $last_invoice ) ) {
			$sequence = 1;
		} else {

			$parts = explode( '-', $last_invoice );

			$sequence = isset( $parts[2] )
				? (int) $parts[2] + 1
				: 1;
		}

		return sprintf(
			'INV-%s-%06d',
			$year,
			$sequence
		);
	}
}