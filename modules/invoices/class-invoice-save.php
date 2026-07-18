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
		error_log(
			'Invoice ID: ' .
			(
				isset( $_POST['invoice_id'] )
					? absint( $_POST['invoice_id'] )
					: 0
			)
		);
		$invoice_id = isset( $_POST['invoice_id'] )
		? absint( $_POST['invoice_id'] )
		: 0;

		$is_edit = $invoice_id > 0;

		$invoice_model = new CASBEN_Invoice();


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

			$invoice = array(
				'discount_type'  => isset( $_POST['discount_type'] )
					? sanitize_key( wp_unslash( $_POST['discount_type'] ) )
					: 'fixed',

				'discount_value' => isset( $_POST['discount_value'] )
					? (float) wp_unslash( $_POST['discount_value'] )
					: 0,

				'tax_rate'       => isset( $_POST['tax_rate'] )
					? (float) wp_unslash( $_POST['tax_rate'] )
					: 18,

				'items'          => $items,
			);

		$calculator = new CASBEN_Invoice_Calculator();

		$totals = $calculator->calculate( $invoice );

		$subtotal        = $totals['subtotal'];
		$discount_amount = $totals['discount_total'];
		$tax_amount      = $totals['tax_total'];
		$grand_total     = $totals['grand_total'];


		/*
		 * Generate invoice number.
		 */

				/*
		 * Save invoice header.
		 */

		$wpdb->query( 'START TRANSACTION' );

		if ( $is_edit ) {

			$result = $wpdb->update(

				$invoice_table,

				array(

					'customer_id'     => $customer_id,

					'invoice_date'    => $invoice_date,

					'due_date'        => $due_date,

					'status'          => 'draft',

					'subtotal'        => $subtotal,

					'tax_amount'      => $tax_amount,

					'discount_amount' => $discount_amount,

					'grand_total'     => $grand_total,

					'notes'           => $notes,

				),

				array(

					'id' => $invoice_id,

				),

				array(

					'%d',

					'%s',

					'%s',

					'%s',

					'%f',

					'%f',

					'%f',

					'%f',

					'%s',

				),

				array(

					'%d',

				)

			);

		} else {

			$invoice_number = CASBEN_Helpers::generate_invoice_number();

			$result = $wpdb->insert(

				$invoice_table,

				array(

					'invoice_number'  => $invoice_number,

					'customer_id'     => $customer_id,

					'invoice_date'    => $invoice_date,

					'due_date'        => $due_date,

					'status'          => 'draft',

					'subtotal'        => $subtotal,

					'tax_amount'      => $tax_amount,

					'discount_amount' => $discount_amount,

					'grand_total'     => $grand_total,

					'notes'           => $notes,

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

			$invoice_id = $wpdb->insert_id;

		}

		if ( false === $result ) {

			$wpdb->query( 'ROLLBACK' );

			wp_die( 'Invoice could not be saved.' );

		}



		/*
		 * Insert invoice items.
		 */
		/*
		 * Remove existing items when editing.
		 */

		if ( $is_edit ) {

			$invoice_model->delete_items( $invoice_id );

		}
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