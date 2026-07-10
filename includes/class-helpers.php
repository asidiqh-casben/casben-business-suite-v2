<?php
/**
 * CASBEN Business Suite
 *
 * Helper Functions
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Helpers {

	/**
	 * Sanitize text input.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	public static function sanitize_text( $value ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Sanitize textarea input.
	 *
	 * @param string $value Input value.
	 * @return string
	 */
	public static function sanitize_textarea( $value ) {
		return sanitize_textarea_field( $value );
	}

	/**
	 * Format amount to two decimal places.
	 *
	 * @param float $amount Amount.
	 * @return string
	 */
	public static function format_amount( $amount ) {
		return number_format( (float) $amount, 2, '.', '' );
	}

	/**
	 * Generate the next invoice number.
	 *
	 * @return string
	 */
	public static function generate_invoice_number() {

		$settings = get_option(
			'casben_settings',
			array()
		);

		$prefix = ! empty( $settings['invoice_prefix'] )
			? $settings['invoice_prefix']
			: 'C';

		$counter = ! empty( $settings['invoice_counter'] )
			? absint( $settings['invoice_counter'] )
			: 1;

		$invoice_number = sprintf(
			'%s-%s-%05d',
			$prefix,
			date( 'Y' ),
			$counter
		);

		$settings['invoice_counter'] = $counter + 1;

		update_option(
			'casben_settings',
			$settings
		);

		return $invoice_number;
	}

}