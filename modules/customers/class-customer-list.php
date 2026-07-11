<?php
/**
 * Customer List Table
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load WP_List_Table if not already loaded.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Customer List Table.
 */
class CASBEN_Customer_List extends WP_List_Table {

	/**
	 * Constructor.
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => 'customer',
				'plural'   => 'customers',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Table Columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		return array(
			'cb'              => '<input type="checkbox" />',
			'id'              => __( 'ID', 'casben-business-suite' ),
			'customer_code'   => __( 'Customer Code', 'casben-business-suite' ),
			'company_name'    => __( 'Company', 'casben-business-suite' ),
			'contact_person'  => __( 'Contact Person', 'casben-business-suite' ),
			'mobile'          => __( 'Mobile', 'casben-business-suite' ),
			'email'           => __( 'Email', 'casben-business-suite' ),
			'ntn'             => __( 'NTN', 'casben-business-suite' ),
			'strn'            => __( 'STRN', 'casben-business-suite' ),
			'status'          => __( 'Status', 'casben-business-suite' ),
			'created_at'      => __( 'Created', 'casben-business-suite' ),
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
			'<input type="checkbox" name="customer[]" value="%d" />',
			$item['id']
		);
	}

	/**
	 * Default column output.
	 *
	 * @param array  $item Row data.
	 * @param string $column_name Column name.
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {

		if ( 'status' === $column_name ) {
			return (int) $item['status'] === 1
				? __( 'Active', 'casben-business-suite' )
				: __( 'Inactive', 'casben-business-suite' );
		}

		return isset( $item[ $column_name ] )
			? esc_html( $item[ $column_name ] )
			: '';
	}

	/**
	 * Get customers from database.
	 *
	 * @return array
	 */
	private function get_customers() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';

		$results = $wpdb->get_results(
			"SELECT
				id,
				customer_code,
				company_name,
				contact_person,
				mobile,
				email,
				ntn,
				strn,
				status,
				created_at
			FROM {$table}
			ORDER BY id DESC",
			ARRAY_A
		);

		return is_array( $results ) ? $results : array();
	}

	/**
	 * Prepare table items.
	 */
	public function prepare_items() {

		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = array();

		$this->_column_headers = array(
			$columns,
			$hidden,
			$sortable,
		);

		$this->items = $this->get_customers();

		$this->set_pagination_args(
			array(
				'total_items' => count( $this->items ),
				'per_page'    => 20,
				'total_pages' => 1,
			)
		);
	}
}