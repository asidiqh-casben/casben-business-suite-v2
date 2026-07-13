<?php
/**
 * Product List
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class CASBEN_Product_List extends WP_List_Table {

	/**
	 * Constructor.
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => 'product',
				'plural'   => 'products',
				'ajax'     => false,
			)
		);

	}

	/**
	 * Prepare items.
	 */
	public function prepare_items() {

	global $wpdb;

	$table = $wpdb->prefix . 'casben_products';

	$this->items = $wpdb->get_results(
		"SELECT * FROM $table ORDER BY id DESC",
		ARRAY_A
	);

	$this->_column_headers = array(
		$this->get_columns(),
		array(),
		array()
	);

	}
	/**
	 * Columns.
	 */
	public function get_columns() {

		return array(
			'product_code' => 'Product Code',
			'product_name' => 'Product Name',
			'category'     => 'Category',
			'unit'         => 'Unit',
			'unit_price'   => 'Sale Price',
			'tax_rate'     => 'Tax Rate',
			'status'       => 'Status',
		);

	}
/**
 * Default column display.
 */
public function column_default( $item, $column_name ) {

	switch ( $column_name ) {

		case 'product_code':
		case 'product_name':
		case 'category':
		case 'unit':
		case 'unit_price':
		case 'tax_rate':

			return esc_html( $item[ $column_name ] );


		case 'status':

			if ( 1 == $item['status'] ) {

				return '<span style="color:green;font-weight:bold;">Active</span>';

			} else {

				return '<span style="color:red;font-weight:bold;">Deactive</span>';

			}


		default:

			return '';

	}

}
				/**
	 * Product name column with row actions.
	 */
	public function column_product_name( $item ) {

		$edit_url = add_query_arg(
			array(
				'page'   => 'casben-products',
				'action' => 'edit',
				'id'     => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);

		$delete_url = wp_nonce_url(
			add_query_arg(
				array(
					'page'   => 'casben-products',
					'action' => 'delete',
					'id'     => absint( $item['id'] ),
				),
				admin_url( 'admin.php' )
			),
			'delete_product_' . absint( $item['id'] )
		);

		$actions = array(
			'edit' => sprintf(
				'<a href="%s">Edit</a>',
				esc_url( $edit_url )
			),

			'delete' => sprintf(
				'<a href="%s" onclick="return confirm(\'Are you sure you want to delete this product?\');">Delete</a>',
				esc_url( $delete_url )
			),
		);

		return sprintf(
			'%1$s %2$s',
			esc_html( $item['product_name'] ),
			$this->row_actions( $actions )
		);

	}
}