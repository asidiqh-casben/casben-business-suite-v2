<?php
/**
 * Invoice List
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class CASBEN_Invoice_List extends WP_List_Table {

	/**
	 * Constructor.
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => 'invoice',
				'plural'   => 'invoices',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Table columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		return array(
			'cb'             => '<input type="checkbox" />',
			'invoice_number' => __( 'Invoice No.', 'casben-business-suite' ),
			'invoice_date'   => __( 'Date', 'casben-business-suite' ),
			'customer_name'  => __( 'Customer', 'casben-business-suite' ),
			'subtotal'       => __( 'Subtotal', 'casben-business-suite' ),
			'tax_amount'     => __( 'Tax', 'casben-business-suite' ),
			'total_amount'   => __( 'Total', 'casben-business-suite' ),
			'status'         => __( 'Status', 'casben-business-suite' ),
			'created_at'     => __( 'Created', 'casben-business-suite' ),
		);
	}

	/**
	 * Checkbox column.
	 *
	 * @param array $item Row data.
	 * @return string
	 */
	protected function column_cb( $item ) {

		return sprintf(
			'<input type="checkbox" name="invoice[]" value="%d" />',
			$item['id']
		);
	}

	/**
	 * Invoice Number column.
	 *
	 * @param array $item Row data.
	 * @return string
	 */
	public function column_invoice_number( $item ) {

		$actions = array(
			'edit' => sprintf(
				'<a href="%s">%s</a>',
				admin_url(
					'admin.php?page=casben-invoices&action=edit&id=' . $item['id']
				),
				__( 'Edit', 'casben-business-suite' )
			),
		);

		return sprintf(
			'<strong>%1$s</strong>%2$s',
			esc_html( $item['invoice_number'] ),
			$this->row_actions( $actions )
		);
	}

	/**
	 * Default column.
	 *
	 * @param array  $item Row.
	 * @param string $column_name Column.
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {

		return isset( $item[ $column_name ] )
			? esc_html( $item[ $column_name ] )
			: '';
	}

	/**
	 * Bulk actions.
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {

		return array(
			'delete' => __( 'Delete', 'casben-business-suite' ),
		);
	}

	/**
	 * Prepare items.
	 *
	 * @return void
	 */
	public function prepare_items() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoices';

		$per_page = 20;

		$current_page = $this->get_pagenum();

		$total_items = (int) $wpdb->get_var(
			"SELECT COUNT(*) FROM {$table}"
		);

		$offset = ( $current_page - 1 ) * $per_page;

		$this->items = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM {$table}
				ORDER BY id DESC
				LIMIT %d OFFSET %d",
				$per_page,
				$offset
			),
			ARRAY_A
		);

		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			array(),
		);

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $total_items / $per_page ),
			)
		);
	}
}