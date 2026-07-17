<?php
/**
 * Invoice Form Controller
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Invoice Form Controller.
 */
class CASBEN_Invoice_Form {

	/**
	 * Render invoice form.
	 *
	 * @return void
	 */
	public static function render() {

		$is_edit       = false;
		$invoice_id    = 0;
		$invoice       = null;
		$invoice_items = array();

		/*
		 * Detect Add/Edit mode.
		 */
		if (
			isset( $_GET['action'], $_GET['id'] ) &&
			'edit' === sanitize_key( wp_unslash( $_GET['action'] ) )
		) {

			$is_edit = true;

			$invoice_id = absint(
				wp_unslash( $_GET['id'] )
			);

		}

				/*
		 * Load invoice when editing.
		 */
		if ( $is_edit ) {

			$invoice = self::get_invoice( $invoice_id );

			if ( $invoice ) {

				$invoice_items = self::get_invoice_items(
					$invoice_id
				);
			}
		}

		/*
		 * Load customers and products.
		 */
		$customers = CASBEN_Invoice_Data::get_customers();

		$products = CASBEN_Invoice_Data::get_products();

		/*
		 * Generate invoice number.
		 */
		if ( $is_edit && $invoice ) {

			$invoice_number = self::get_invoice_value(
				$invoice,
				'invoice_number',
				''
			);

		} else {

			$invoice_number = CASBEN_Invoice_Number::generate();

		}

				/*
		 * Prepare invoice object.
		 */
		if ( ! $invoice ) {

			$invoice = (object) array(
				'id'             => 0,
				'invoice_number' => $invoice_number,
				'customer_id'    => 0,
				'invoice_date'   => self::get_default_invoice_date(),
				'due_date'       => self::get_default_due_date(),
				'reference_no'   => '',
				'notes'          => '',
				'subtotal'       => 0,
				'tax_amount'     => 0,
				'total_amount'   => 0,
				'status'         => 'draft',
			);

		}

		/*
		 * Prepare invoice items.
		 */
		$invoice_items = self::prepare_invoice_items(
			$invoice_items
		);

		/*
 * Initialize default totals.
 *
 * Totals will be calculated when the invoice is
 * saved or updated via JavaScript.
 */
		$totals = array(
			'subtotal'       => 0,
			'discount_total' => 0,
			'taxable_total'  => 0,
			'tax_total'      => 0,
			'grand_total'    => 0,
			'items'          => $invoice_items,
		);

		/*
		 * Load invoice form view.
		 */
		self::load_view(
			'invoice-form.php',
			array(
				'is_edit'        => $is_edit,
				'invoice'        => $invoice,
				'invoice_items'  => $invoice_items,
				'customers'      => $customers,
				'products'       => $products,
				'totals'         => $totals,
				'invoice_number' => $invoice_number,
			)
		);

	}

		/**
	 * Get invoice.
	 *
	 * @param int $invoice_id Invoice ID.
	 * @return object|null
	 */
	private static function get_invoice( $invoice_id ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoices';

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE id = %d",
				$invoice_id
			)
		);
	}

	/**
	 * Get invoice items.
	 *
	 * @param int $invoice_id Invoice ID.
	 * @return array
	 */
	private static function get_invoice_items( $invoice_id ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoice_items';

		$items = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE invoice_id = %d ORDER BY id ASC",
				$invoice_id
			)
		);

		return is_array( $items ) ? $items : array();
	}

		/**
	 * Get default invoice date.
	 *
	 * @return string
	 */
	private static function get_default_invoice_date() {

		return current_time( 'Y-m-d' );
	}

	/**
	 * Get default due date.
	 *
	 * @return string
	 */
	private static function get_default_due_date() {

		return current_time( 'Y-m-d' );
	}

	/**
	 * Get a value from an invoice object.
	 *
	 * @param object $invoice Invoice object.
	 * @param string $key     Property name.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	private static function get_invoice_value( $invoice, $key, $default = '' ) {

		if (
			is_object( $invoice ) &&
			isset( $invoice->{$key} )
		) {
			return $invoice->{$key};
		}

		return $default;
	}

	/**
	 * Prepare invoice items for the view.
	 *
	 * @param array $items Invoice items.
	 * @return array
	 */
	private static function prepare_invoice_items( $items ) {

		if ( empty( $items ) ) {

			return array(
				(object) array(
					'id'          => 0,
					'product_id'  => 0,
					'description' => '',
					'quantity'    => 1,
					'unit_price'  => 0,
					'tax_rate'    => 0,
					'tax_amount'  => 0,
					'line_total'  => 0,
				),
			);
		}

		foreach ( $items as &$item ) {

			$item->id          = isset( $item->id ) ? absint( $item->id ) : 0;
			$item->product_id  = isset( $item->product_id ) ? absint( $item->product_id ) : 0;
			$item->description = isset( $item->description ) ? $item->description : '';
			$item->quantity    = isset( $item->quantity ) ? (float) $item->quantity : 1;
			$item->unit_price  = isset( $item->unit_price ) ? (float) $item->unit_price : 0;
			$item->tax_rate    = isset( $item->tax_rate ) ? (float) $item->tax_rate : 0;
			$item->tax_amount  = isset( $item->tax_amount ) ? (float) $item->tax_amount : 0;
			$item->line_total  = isset( $item->line_total ) ? (float) $item->line_total : 0;
		}

		unset( $item );

		return $items;
	}

		/**
	 * Load invoice form view.
	 *
	 * @param string $view View file name.
	 * @param array  $data View data.
	 *
	 * @return void
	 */
	private static function load_view( $view, $data = array() ) {

		$view_file = CASBEN_PLUGIN_DIR . 'modules/invoices/views/' . $view;

		if ( ! file_exists( $view_file ) ) {

			return;
		}

		if ( ! empty( $data ) ) {

			extract(
				$data,
				EXTR_SKIP
			);

		}

		include $view_file;

	}

}