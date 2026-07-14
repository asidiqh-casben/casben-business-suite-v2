<?php
/**
 * Invoice List Table
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
	 * Invoice model.
	 *
	 * @var CASBEN_Invoice
	 */
	private $model;


	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->model = new CASBEN_Invoice();

		parent::__construct(
			array(
				'singular' => 'invoice',
				'plural'   => 'invoices',
				'ajax'     => false,
			)
		);
	}


	/**
	 * Columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		return array(
			'cb'             => '<input type="checkbox" />',
			'invoice_number' => __( 'Invoice No.', 'casben-business-suite' ),
			'company_name'   => __( 'Customer', 'casben-business-suite' ),
			'invoice_date'   => __( 'Date', 'casben-business-suite' ),
			'subtotal'       => __( 'Subtotal', 'casben-business-suite' ),
			'tax_amount'     => __( 'Tax', 'casben-business-suite' ),
			'discount_amount'=> __( 'Discount', 'casben-business-suite' ),
			'grand_total'    => __( 'Grand Total', 'casben-business-suite' ),
			'status'         => __( 'Status', 'casben-business-suite' ),
			'fbr_status'     => __( 'FBR Status', 'casben-business-suite' ),
			'created_at'     => __( 'Created', 'casben-business-suite' ),
		);
	}


	/**
	 * Sortable columns.
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {

		return array(
			'invoice_number' => array(
				'invoice_number',
				false,
			),
			'invoice_date' => array(
				'invoice_date',
				true,
			),
			'grand_total' => array(
				'grand_total',
				false,
			),
			'status' => array(
				'status',
				false,
			),
		);
	}


	/**
	 * Checkbox column.
	 *
	 * @param object $item Row item.
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {

		return sprintf(
			'<input type="checkbox" name="invoice[]" value="%d" />',
			$item->id
		);
	}


	/**
	 * Invoice number column.
	 *
	 * @param object $item Row item.
	 *
	 * @return string
	 */
	public function column_invoice_number( $item ) {

		$actions = array(
			'edit' => sprintf(
				'<a href="%s">%s</a>',
				esc_url(
					admin_url(
						'admin.php?page=casben-invoices&action=edit&id=' . absint( $item->id )
					)
				),
				__( 'Edit', 'casben-business-suite' )
			),

			'delete' => sprintf(
				'<a href="%s">%s</a>',
				wp_nonce_url(
					admin_url(
						'admin.php?page=casben-invoices&action=delete&id=' . absint( $item->id )
					),
					'delete_invoice_' . absint( $item->id )
				),
				__( 'Delete', 'casben-business-suite' )
			),
		);


		return sprintf(
			'<strong>%s</strong>%s',
			esc_html( $item->invoice_number ),
			$this->row_actions( $actions )
		);
	}


	/**
	 * Currency formatting helper.
	 *
	 * @param object $item Row item.
	 * @param string $column_name Column.
	 *
	 * @return string
	 */
	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {

			case 'subtotal':
			case 'tax_amount':
			case 'discount_amount':
			case 'grand_total':

				return number_format(
					(float) $item->$column_name,
					2
				);


			case 'status':

				return ucfirst(
					esc_html( $item->$column_name )
				);


			case 'fbr_status':

				return $item->$column_name
					? esc_html( $item->$column_name )
					: __( 'Pending', 'casben-business-suite' );


			default:

				return isset( $item->$column_name )
					? esc_html( $item->$column_name )
					: '';
		}
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


		$per_page = 20;


		$current_page = $this->get_pagenum();


		$search = '';

		if ( isset( $_REQUEST['s'] ) ) {

			$search = sanitize_text_field(
				wp_unslash(
					$_REQUEST['s']
				)
			);
		}


		$orderby = isset( $_GET['orderby'] )
			? sanitize_key( $_GET['orderby'] )
			: 'id';


		$order = isset( $_GET['order'] )
			? sanitize_text_field( $_GET['order'] )
			: 'DESC';


		$this->items = $this->model->get_all(
			array(
				'search'   => $search,
				'orderby'  => $orderby,
				'order'    => $order,
				'page'     => $current_page,
				'per_page' => $per_page,
			)
		);


		$total_items = $this->model->count(
			$search
		);


		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			$this->get_sortable_columns(),
		);


		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil(
					$total_items / $per_page
				),
			)
		);
	}
}