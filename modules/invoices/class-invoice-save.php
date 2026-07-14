<?php
/**
 * Invoice Save Handler
 *
 * Handles invoice form submission and database insertion.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Save {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action(
			'admin_post_casben_save_invoice',
			array( $this, 'save_invoice' )
		);
	}


	/**
	 * Save invoice.
	 *
	 * @return void
	 */
	public function save_invoice() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized access.' );
		}


		check_admin_referer(
			'casben_save_invoice',
			'casben_invoice_nonce'
		);


		global $wpdb;


		$invoice_table = $wpdb->prefix . 'casben_invoices';

		$item_table = $wpdb->prefix . 'casben_invoice_items';


		/*
		 * Invoice data.
		 */

		$customer_id = isset( $_POST['customer_id'] )
			? absint( $_POST['customer_id'] )
			: 0;


		$invoice_date = isset( $_POST['invoice_date'] )
			? sanitize_text_field( wp_unslash( $_POST['invoice_date'] ) )
			: current_time( 'Y-m-d' );


		$due_date = isset( $_POST['due_date'] )
			? sanitize_text_field( wp_unslash( $_POST['due_date'] ) )
			: null;


		$notes = isset( $_POST['notes'] )
			? sanitize_textarea_field( wp_unslash( $_POST['notes'] ) )
			: '';


		if ( ! $customer_id ) {

			wp_die( 'Customer is required.' );

		}


		/*
		 * Invoice items.
		 */

		$items = isset( $_POST['items'] )
			? wp_unslash( $_POST['items'] )
			: array();


		if ( empty( $items ) || ! is_array( $items ) ) {

			wp_die( 'Invoice items are required.' );

		}


		/*
		 * Calculate totals.
		 */

		$subtotal = 0;

		$tax_amount = 0;

		$discount_amount = 0;


		foreach ( $items as $item ) {

			$quantity = isset( $item['quantity'] )
				? floatval( $item['quantity'] )
				: 0;


			$unit_price = isset( $item['unit_price'] )
				? floatval( $item['unit_price'] )
				: 0;


			$discount = isset( $item['discount_amount'] )
				? floatval( $item['discount_amount'] )
				: 0;


			$tax_rate = isset( $item['tax_rate'] )
				? floatval( $item['tax_rate'] )
				: 18;


			$line_total = ( $quantity * $unit_price ) - $discount;


			$item_tax = ( $line_total * $tax_rate ) / 100;


			$subtotal += $line_total;

			$tax_amount += $item_tax;

			$discount_amount += $discount;

		}


		$grand_total = $subtotal + $tax_amount - $discount_amount;


		/*
		 * Generate invoice number.
		 */

		/*
 		* Generate invoice number.
 		*/

		$invoice_number = CASBEN_Helpers::generate_invoice_number();


		/*
		 * Insert invoice header.
		 */

		$wpdb->query( 'START TRANSACTION' );


		$result = $wpdb->insert(

			$invoice_table,

			array(

				'invoice_number'    => $invoice_number,

				'customer_id'       => $customer_id,

				'invoice_date'      => $invoice_date,

				'due_date'          => $due_date,

				'status'            => 'draft',

				'subtotal'          => $subtotal,

				'tax_amount'        => $tax_amount,

				'discount_amount'   => $discount_amount,

				'grand_total'       => $grand_total,

				'notes'             => $notes,

			),

			array(

				'%s',

				'%d',

				'%s',

				'%s',

				'%s',

				'%f',

				'%f',

				'%f',

				'%f',

				'%s',

			)

		);



		if ( false === $result ) {

			$wpdb->query( 'ROLLBACK' );

			wp_die( 'Invoice could not be saved.' );

		}


		$invoice_id = $wpdb->insert_id;



		/*
		 * Insert invoice items.
		 */

		foreach ( $items as $item ) {


			$product_id = isset( $item['product_id'] )
				? absint( $item['product_id'] )
				: null;


			$description = isset( $item['description'] )
				? sanitize_text_field( $item['description'] )
				: '';


			$quantity = isset( $item['quantity'] )
				? floatval( $item['quantity'] )
				: 1;


			$unit_price = isset( $item['unit_price'] )
				? floatval( $item['unit_price'] )
				: 0;


			$discount = isset( $item['discount_amount'] )
				? floatval( $item['discount_amount'] )
				: 0;


			$tax_rate = isset( $item['tax_rate'] )
				? floatval( $item['tax_rate'] )
				: 18;


			$line_total = ( $quantity * $unit_price ) - $discount;


			$item_tax = ( $line_total * $tax_rate ) / 100;



			$item_result = $wpdb->insert(

				$item_table,

				array(

					'invoice_id'       => $invoice_id,

					'product_id'       => $product_id,

					'description'      => $description,

					'quantity'         => $quantity,

					'unit_price'       => $unit_price,

					'discount_amount'  => $discount,

					'tax_rate'         => $tax_rate,

					'tax_amount'       => $item_tax,

					'line_total'       => $line_total,

				),

				array(

					'%d',

					'%d',

					'%s',

					'%f',

					'%f',

					'%f',

					'%f',

					'%f',

					'%f',

				)

			);



			if ( false === $item_result ) {

				$wpdb->query( 'ROLLBACK' );

				wp_die( 'Invoice items could not be saved.' );

			}

		}


		$wpdb->query( 'COMMIT' );


		/*
		 * Redirect after save.
		 */

		wp_safe_redirect(

			admin_url(
				'admin.php?page=casben-invoices&message=saved'
			)

		);

		exit;

	}
}