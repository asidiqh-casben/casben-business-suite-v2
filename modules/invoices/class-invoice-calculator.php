<?php
/**
 * Invoice Calculator
 *
 * Performs all invoice financial calculations.
 *
 * This class is intentionally independent from the UI, database,
 * and form handling so that the same calculation logic can be used
 * by:
 *
 * - Add Invoice
 * - Edit Invoice
 * - Print
 * - PDF
 * - FBR Digital Invoice
 * * Future API endpoints
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Invoice Calculator Class.
 */
class CASBEN_Invoice_Calculator {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Reserved for future dependency injection.
	}

	/**
	 * Calculate invoice totals.
	 *
	 * Expected array structure:
	 *
	 * <code>
	 * array(
	 *     'discount_type'  => 'fixed'|'percentage',
	 *     'discount_value' => 0,
	 *     'tax_rate'       => 18,
	 *     'items'          => array(
	 *         array(
	 *             'quantity'   => 1,
	 *             'unit_price' => 100,
	 *         ),
	 *     ),
	 * )
	 * </code>
	 *
	 * @param array $invoice Invoice data.
	 * @return array
	 */
	public function calculate( $invoice ) {

		$results = array(
			'subtotal'       => 0,
			'discount_total' => 0,
			'taxable_total'  => 0,
			'tax_total'      => 0,
			'grand_total'    => 0,
			'items'          => array(),
		);

		if ( empty( $invoice['items'] ) || ! is_array( $invoice['items'] ) ) {
			return $results;
		}

		/*
		 * ---------------------------------------------------------
		 * Calculate line totals.
		 * ---------------------------------------------------------
		 */

		foreach ( $invoice['items'] as $item ) {

		$calculated_item = $this->calculate_item( $item );

		$results['items'][] = $calculated_item;

		$results['subtotal'] += $calculated_item['line_total'];

	}

		$results['subtotal'] = $this->round_amount(
			$results['subtotal']
		);

		/*
		 * ---------------------------------------------------------
		 * Invoice Discount
		 * ---------------------------------------------------------
		 */

		$results['discount_total'] = $this->calculate_discount(
			$results['subtotal'],
			$invoice
		);

		/*
		 * ---------------------------------------------------------
		 * Taxable Amount
		 * ---------------------------------------------------------
		 */

		$results['taxable_total'] = $this->round_amount(
			$results['subtotal'] - $results['discount_total']
		);

		/*
		 * ---------------------------------------------------------
		 * Tax
		 * ---------------------------------------------------------
		 */

		$results['tax_total'] = $this->calculate_tax(
			$results['taxable_total'],
			$invoice
		);

		/*
		 * ---------------------------------------------------------
		 * Grand Total
		 * ---------------------------------------------------------
		 */

		$results['grand_total'] = $this->round_amount(
			$results['taxable_total'] + $results['tax_total']
		);

		return $results;
	}
	/**
 	* Calculate a single invoice item.
 	*
 	* @param array $item Invoice item.
 	* @return array
 	*/
	private function calculate_item( $item ) {

		$quantity = isset( $item['quantity'] )
			? (float) $item['quantity']
			: 0;

		$unit_price = isset( $item['unit_price'] )
			? (float) $item['unit_price']
			: 0;

		$line_total = $this->round_amount(
			$quantity * $unit_price
		);

		$item['quantity']   = $quantity;
		$item['unit_price'] = $unit_price;
		$item['line_total'] = $line_total;

		return $item;

	}	/**
	 * Calculate invoice discount.
	 *
	 * Supported discount types:
	 *
	 * - fixed
	 * - percentage
	 *
	 * @param float $subtotal Invoice subtotal.
	 * @param array $invoice  Invoice data.
	 * @return float
	 */
	private function calculate_discount( $subtotal, $invoice ) {

		$discount_type = isset( $invoice['discount_type'] )
			? sanitize_key( $invoice['discount_type'] )
			: '';

		$discount_value = isset( $invoice['discount_value'] )
			? (float) $invoice['discount_value']
			: 0;

		if ( $discount_value <= 0 ) {
			return 0;
		}

		switch ( $discount_type ) {

			case 'percentage':
				$discount = ( $subtotal * $discount_value ) / 100;
				break;

			case 'fixed':
				$discount = $discount_value;
				break;

			default:
				$discount = 0;
				break;
		}

		/*
		 * Discount cannot exceed subtotal.
		 */
		$discount = min( $discount, $subtotal );

		return $this->round_amount( $discount );
	}

	/**
	 * Calculate tax.
	 *
	 * @param float $taxable_total Taxable amount.
	 * @param array $invoice       Invoice data.
	 * @return float
	 */
	private function calculate_tax( $taxable_total, $invoice ) {

		$tax_rate = isset( $invoice['tax_rate'] )
			? (float) $invoice['tax_rate']
			: 0;

		if ( $tax_rate <= 0 ) {
			return 0;
		}

		$tax = ( $taxable_total * $tax_rate ) / 100;

		return $this->round_amount( $tax );
	}

	/**
	 * Round monetary values.
	 *
	 * All financial calculations should pass through this
	 * method to ensure consistent precision throughout
	 * the plugin.
	 *
	 * @param float $amount Amount.
	 * @return float
	 */
	private function round_amount( $amount ) {

		return round( (float) $amount, 2 );
	}
}