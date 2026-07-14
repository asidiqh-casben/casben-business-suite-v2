<?php
/**
 * Invoice Calculator
 *
 * Performs invoice calculations.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Calculator {

	/**
	 * Calculate a single invoice item.
	 *
	 * @param array $item Invoice item.
	 *
	 * @return array
	 */
	public static function calculate_item( $item ) {

		$quantity = isset( $item['quantity'] )
			? (float) $item['quantity']
			: 0;

		$unit_price = isset( $item['unit_price'] )
			? (float) $item['unit_price']
			: 0;

		$discount = isset( $item['discount_amount'] )
			? (float) $item['discount_amount']
			: 0;

		$tax_rate = isset( $item['tax_rate'] )
			? (float) $item['tax_rate']
			: 0;

		$subtotal = $quantity * $unit_price;

		$taxable_amount = max( 0, $subtotal - $discount );

		$tax_amount = $taxable_amount * ( $tax_rate / 100 );

		$line_total = $taxable_amount + $tax_amount;

		$item['quantity'] = $quantity;
		$item['unit_price'] = $unit_price;
		$item['discount_amount'] = $discount;
		$item['tax_rate'] = $tax_rate;
		$item['tax_amount'] = round( $tax_amount, 2 );
		$item['line_total'] = round( $line_total, 2 );

		return $item;
	}

	/**
	 * Calculate complete invoice totals.
	 *
	 * @param array $items Invoice items.
	 *
	 * @return array
	 */
	public static function calculate_invoice( $items ) {

		$subtotal = 0;
		$total_discount = 0;
		$total_tax = 0;
		$grand_total = 0;

		$calculated_items = array();

		foreach ( $items as $item ) {

			/*
			 * Skip empty rows.
			 */
			if (
				empty( $item['description'] ) &&
				empty( $item['product_id'] )
			) {
				continue;
			}

			$item = self::calculate_item( $item );

			$line_subtotal = $item['quantity'] * $item['unit_price'];

			$subtotal += $line_subtotal;

			$total_discount += $item['discount_amount'];

			$total_tax += $item['tax_amount'];

			$grand_total += $item['line_total'];

			$calculated_items[] = $item;
		}

		return array(
			'subtotal'         => round( $subtotal, 2 ),
			'discount_amount'  => round( $total_discount, 2 ),
			'tax_amount'       => round( $total_tax, 2 ),
			'grand_total'      => round( $grand_total, 2 ),
			'items'            => $calculated_items,
		);
	}
}