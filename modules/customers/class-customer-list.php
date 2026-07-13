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
	 * Table columns.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'             => '<input type="checkbox" />',
			'customer_code'  => __( 'Customer Code', 'casben-business-suite' ),
			'company_name'   => __( 'Company', 'casben-business-suite' ),
			'contact_person' => __( 'Contact Person', 'casben-business-suite' ),
			'mobile'         => __( 'Mobile', 'casben-business-suite' ),
			'email'          => __( 'Email', 'casben-business-suite' ),
			'ntn'            => __( 'NTN', 'casben-business-suite' ),
			'status'         => __( 'Status', 'casben-business-suite' ),
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
			'customer_code'  => array( 'customer_code', true ),
			'company_name'   => array( 'company_name', false ),
			'contact_person' => array( 'contact_person', false ),
			'created_at'     => array( 'created_at', false ),
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
			absint( $item['id'] )
		);
	}
		/**
	 * Get bulk actions.
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {

		return array(
			'bulk_delete'     => __( 'Delete', 'casben-business-suite' ),
			'bulk_activate'   => __( 'Activate', 'casben-business-suite' ),
			'bulk_deactivate' => __( 'Deactivate', 'casben-business-suite' ),
		);
	}

	/**
	 * Company name column.
	 *
	 * @param array $item Customer row.
	 * @return string
	 */
	protected function column_company_name( $item ) {
		$edit_url = admin_url(
			'admin.php?page=casben-customers&action=edit&customer=' . absint( $item['id'] )
		);

		$delete_url = wp_nonce_url(
			admin_url(
				'admin.php?page=casben-customers&action=delete&customer=' . absint( $item['id'] )
			),
			'delete_customer_' . absint( $item['id'] )
		);

		$actions = array(
			'edit' => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $edit_url ),
				__( 'Edit', 'casben-business-suite' )
			),
			'delete' => sprintf(
				'<a href="%s" onclick="return confirm(\'%s\');">%s</a>',
				esc_url( $delete_url ),
				esc_js( __( 'Are you sure you want to delete this customer?', 'casben-business-suite' ) ),
				__( 'Delete', 'casben-business-suite' )
			),
		);

		return sprintf(
			'<strong>%s</strong>%s',
			esc_html( $item['company_name'] ?? '' ),
			$this->row_actions( $actions )
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

				if ( (int) ( $item['status'] ?? 0 ) === 1 ) {
				return '<span style="color:green;font-weight:600;">● Active</span>';
			}

				return '<span style="color:#a00;font-weight:600;">● Inactive</span>';
		}

				return isset( $item[ $column_name ] ) ? esc_html( $item[ $column_name ] ) : '';
			}

	/**
	 * Render search box.
	 *
	 * @param string $which Position of the nav.
	 */
	public function extra_tablenav( $which ) {
		if ( 'top' === $which ) {
			$this->search_box( __( 'Search Customers', 'casben-business-suite' ), 'customer' );
		}
	}

	/**
	 * Get search term from request.
	 *
	 * @return string
	 */
	private function get_search_term() {
		$search = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';

		return $search;
	}

	/**
	 * Get current page size.
	 *
	 * @return int
	 */
private function get_per_page() {
	return max(
		1,
		(int) $this->get_items_per_page( 'customers_per_page', 10 )
	);
}
	/**
	 * Get total customers count.
	 *
	 * @param string $search Search term.
	 * @return int
	 */
	public function get_total_customers( $search = '' ) {
		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';
		$query = "SELECT COUNT(*) FROM {$table}";

		if ( '' !== $search ) {
			$like = '%' . $wpdb->esc_like( $search ) . '%';
			$query .= ' WHERE customer_code LIKE %s OR company_name LIKE %s OR contact_person LIKE %s';
			$query = $wpdb->prepare( $query, $like, $like, $like );
		}

		$count = $wpdb->get_var( $query );

		return is_numeric( $count ) ? (int) $count : 0;
	}

	/**
	 * Get customers from database with optional search and pagination.
	 *
	 * @param string $search Search term.
	 * @param int    $per_page Number of records per page.
	 * @param int    $page Current page.
	 * @return array
	 */
	public function get_customers( $search = '', $per_page = 2, $page = 1 ) {
		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';

		$query = "SELECT
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
			FROM {$table}";

		$args = array();

		if ( '' !== $search ) {
			$like = '%' . $wpdb->esc_like( $search ) . '%';
			$query .= ' WHERE customer_code LIKE %s OR company_name LIKE %s OR contact_person LIKE %s';
			$args[] = $like;
			$args[] = $like;
			$args[] = $like;
		}
				$allowed_orderby = array(
			'id',
			'customer_code',
			'company_name',
			'contact_person',
			'created_at',
		);

		$orderby = isset( $_GET['orderby'] )
			? sanitize_key( wp_unslash( $_GET['orderby'] ) )
			: 'id';

		if ( ! in_array( $orderby, $allowed_orderby, true ) ) {
			$orderby = 'id';
		}

		$order = isset( $_GET['order'] )
			? strtoupper( sanitize_key( wp_unslash( $_GET['order'] ) ) )
			: 'DESC';

		$order = ( 'ASC' === $order ) ? 'ASC' : 'DESC';

		$query .= " ORDER BY {$orderby} {$order} LIMIT %d OFFSET %d";
		$args[] = max( 1, (int) $per_page );
		$args[] = max( 0, (int) ( ( max( 1, (int) $page ) - 1 ) * max( 1, (int) $per_page ) ) );

		$query = $wpdb->prepare( $query, ...$args );

		$results = $wpdb->get_results( $query, ARRAY_A );

		return is_array( $results ) ? $results : array();
	}

	/**
	 * Prepare table items.
	 */
		/**
	 * Process bulk actions.
	 */
		/**
	 * Process bulk actions.
	 */
		/**
	 * Process bulk actions.
	 */
		/**
	 * Process bulk actions.
	 */
	public function process_bulk_action() {

		// Nothing selected.
		if ( empty( $_POST['customer'] ) ) {
			return;
		}

		// Verify nonce.
		check_admin_referer( 'bulk-' . $this->_args['plural'] );

		// Permission check.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die(
				esc_html__(
					'You do not have permission to perform this action.',
					'casben-business-suite'
				)
			);
		}

		$action = $this->current_action();

		if ( empty( $action ) ) {
			return;
		}

		$customer_ids = array_map(
			'absint',
			(array) wp_unslash( $_POST['customer'] )
		);

		if ( empty( $customer_ids ) ) {
			return;
		}

		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';

		foreach ( $customer_ids as $customer_id ) {

			switch ( $action ) {

				case 'bulk_delete':

					$wpdb->delete(
						$table,
						array(
							'id' => $customer_id,
						),
						array(
							'%d',
						)
					);

					break;

				case 'bulk_activate':

					$wpdb->update(
						$table,
						array(
							'status' => 1,
						),
						array(
							'id' => $customer_id,
						),
						array(
							'%d',
						),
						array(
							'%d',
						)
					);

					break;

				case 'bulk_deactivate':

					$wpdb->update(
						$table,
						array(
							'status' => 0,
						),
						array(
							'id' => $customer_id,
						),
						array(
							'%d',
						),
						array(
							'%d',
						)
					);

					break;
			}
		}

		$message = '';

		switch ( $action ) {

			case 'bulk_delete':
				$message = 'bulk_deleted';
				break;

			case 'bulk_activate':
				$message = 'bulk_activated';
				break;

			case 'bulk_deactivate':
				$message = 'bulk_deactivated';
				break;
		}

		wp_safe_redirect(
			admin_url(
				'admin.php?page=casben-customers&message=' . $message . '&count=' . count( $customer_ids )
			)
	);

	exit;
	}
	public function prepare_items() {
		
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array(
			$columns,
			$hidden,
			$sortable,
		);

		$per_page = $this->get_per_page();
		$page     = max( 1, (int) $this->get_pagenum() );
		$search   = $this->get_search_term();

		$this->items = $this->get_customers( $search, $per_page, $page );
		$total_items = $this->get_total_customers( $search );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => max( 1, (int) ceil( $total_items / $per_page ) ),
			)
		);
	}
}