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

/**
 * Invoice List.
 */
class CASBEN_Invoice_List extends WP_List_Table {

	/**
	 * Database object.
	 *
	 * @var wpdb
	 */
	private $db;

	/**
	 * Invoice table.
	 *
	 * @var string
	 */
	private $table;

	/**
	 * Invoice items table.
	 *
	 * @var string
	 */
	private $items_table;

	/**
	 * Customers table.
	 *
	 * @var string
	 */
	private $customers_table;

	/**
	 * Constructor.
	 */
	public function __construct() {

		global $wpdb;

		$this->db = $wpdb;

		$this->table = $wpdb->prefix . 'casben_invoices';

		$this->items_table = $wpdb->prefix . 'casben_invoice_items';

		$this->customers_table = $wpdb->prefix . 'casben_customers';

		parent::__construct(
			array(
				'singular' => 'invoice',
				'plural'   => 'invoices',
				'ajax'     => false,
			)
		);
	}
	/**
	 * Get table columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		return array(
			'cb'             => '<input type="checkbox" />',
			'invoice_number' => __( 'Invoice #', 'casben-business-suite' ),
			'invoice_date'   => __( 'Date', 'casben-business-suite' ),
			'customer'       => __( 'Customer', 'casben-business-suite' ),
			'total_amount'   => __( 'Total', 'casben-business-suite' ),
			'status'         => __( 'Status', 'casben-business-suite' ),
			'created_at'     => __( 'Created', 'casben-business-suite' ),
		);
	}

	/**
	 * Get sortable columns.
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {

		return array(
			'invoice_number' => array( 'invoice_number', true ),
			'invoice_date'   => array( 'invoice_date', false ),
			'total_amount'   => array( 'total_amount', false ),
			'created_at'     => array( 'created_at', false ),
		);
	}

	/**
	 * Default column output.
	 *
	 * @param array  $item        Current item.
	 * @param string $column_name Column name.
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {

		switch ( $column_name ) {

			case 'invoice_date':
			case 'created_at':
				if ( empty( $item[ $column_name ] ) ) {
					return '&mdash;';
				}

				return esc_html(
					wp_date(
						get_option( 'date_format' ),
						strtotime( $item[ $column_name ] )
					)
				);

			case 'customer':
				return esc_html(
					$item['customer_name'] ?? __( 'Unknown', 'casben-business-suite' )
				);

			case 'total_amount':
				return esc_html(
					number_format_i18n(
						(float) $item['total_amount'],
						2
					)
				);

			default:
				return isset( $item[ $column_name ] )
					? esc_html( $item[ $column_name ] )
					: '';
		}
	}
	/**
	 * Checkbox column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_cb( $item ) {

		return sprintf(
			'<input type="checkbox" name="invoice_ids[]" value="%d" />',
			absint( $item['id'] )
		);
	}

	/**
	 * Invoice number column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_invoice_number( $item ) {

		$edit_url = add_query_arg(
			array(
				'page'   => 'casben-invoices',
				'action' => 'edit',
				'id'     => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);

		$delete_url = wp_nonce_url(
			add_query_arg(
				array(
					'page'   => 'casben-invoices',
					'action' => 'delete',
					'id'     => absint( $item['id'] ),
				),
				admin_url( 'admin.php' )
			),
			'delete_invoice_' . absint( $item['id'] )
		);

		$view_url = add_query_arg(
			array(
				'page'   => 'casben-invoices',
				'action' => 'view',
				'id'     => absint( $item['id'] ),
			),
			admin_url( 'admin.php' )
		);


		$actions = array(
			'view' => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $view_url ),
				esc_html__( 'View', 'casben-business-suite' )
			),

			'edit' => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $edit_url ),
				esc_html__( 'Edit', 'casben-business-suite' )
			),

			'delete' => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $delete_url ),
				esc_html__( 'Delete', 'casben-business-suite' )
			),
		);

		return sprintf(
			'<strong><a href="%1$s">%2$s</a></strong>%3$s',
			esc_url( $edit_url ),
			esc_html( $item['invoice_number'] ),
			$this->row_actions( $actions )
		);
	}

	/**
	 * Status column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_status( $item ) {

		$status = isset( $item['status'] ) ? sanitize_key( $item['status'] ) : '';

		$labels = array(
			'draft'    => __( 'Draft', 'casben-business-suite' ),
			'pending'  => __( 'Pending', 'casben-business-suite' ),
			'approved' => __( 'Approved', 'casben-business-suite' ),
			'sent'     => __( 'Sent', 'casben-business-suite' ),
			'cancelled'=> __( 'Cancelled', 'casben-business-suite' ),
		);

		$label = isset( $labels[ $status ] )
			? $labels[ $status ]
			: ucfirst( $status );

		return sprintf(
			'<span class="casben-status casben-status-%1$s">%2$s</span>',
			esc_attr( $status ),
			esc_html( $label )
		);
	}
	/**
	 * Get bulk actions.
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {

		return array(
			'delete' => __( 'Delete', 'casben-business-suite' ),
		);
	}

	/**
	 * Process current action.
	 *
	 * @return void
	 */
	public function process_bulk_action() {


				$action = '';

		if ( isset( $_REQUEST['action'] ) ) {

			$action = sanitize_text_field( wp_unslash( $_REQUEST['action'] ) );

		}


		if ( 'delete' !== $action ) {

			return;

		}

		/*
		 * Single delete.
		 */
//		if ( isset( $_REQUEST['id'] ) ) {
//
//			$invoice_id = absint( wp_unslash( $_REQUEST['id'] ) );
//

//			check_admin_referer(
//				'delete_invoice_' . $invoice_id
//			);

//			$this->delete_invoice( $invoice_id );

//			wp_safe_redirect(
//				remove_query_arg(
//					array( 'action', 'id', '_wpnonce' )
//				)
//			);

//			exit;
//		}

		/*
		 * Bulk delete.
		 */
		if ( empty( $_POST['invoice_ids'] ) ) {
			return;
		}

		check_admin_referer( 'bulk-' . $this->_args['plural'] );

		$invoice_ids = array_map(
			'absint',
			(array) wp_unslash( $_POST['invoice_ids'] )
		);

		foreach ( $invoice_ids as $invoice_id ) {

			if ( $invoice_id > 0 ) {
				$this->delete_invoice( $invoice_id );
			}
		}

		wp_safe_redirect(
			remove_query_arg(
				array( '_wp_http_referer', '_wpnonce' )
			)
		);

		exit;
	}

	/**
	 * Delete invoice.
	 *
	 * @param int $invoice_id Invoice ID.
	 * @return void
	 */
	private function delete_invoice( $invoice_id ) {

		$invoice_id = absint( $invoice_id );

		if ( ! $invoice_id ) {
			return;
		}

		$this->db->delete(
			$this->items_table,
			array(
				'invoice_id' => $invoice_id,
			),
			array( '%d' )
		);

		$this->db->delete(
			$this->table,
			array(
				'id' => $invoice_id,
			),
			array( '%d' )
		);
	}
	/**
	 * Get total invoice count.
	 *
	 * @return int
	 */
	private function get_total_items() {

		$where = ' WHERE 1=1 ';
		$params = array();

		if ( ! empty( $_REQUEST['s'] ) ) {
			$search = '%' . $this->db->esc_like(
				sanitize_text_field( wp_unslash( $_REQUEST['s'] ) )
			) . '%';

			$where .= ' AND (i.invoice_number LIKE %s OR c.company_name LIKE %s)';
			$params[] = $search;
			$params[] = $search;
		}

		$sql = "
			SELECT COUNT(*)
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			{$where}
		";

		if ( ! empty( $params ) ) {
			$sql = $this->db->prepare( $sql, $params );
		}

		return (int) $this->db->get_var( $sql );
	}

	/**
	 * Get invoices.
	 *
	 * @param int $per_page Number of items.
	 * @param int $page_number Page number.
	 * @return array
	 */
	private function get_invoices( $per_page = 20, $page_number = 1 ) {

		$order_by = 'invoice_date';

		$allowed = array(
			'invoice_number',
			'invoice_date',
			'total_amount',
			'created_at',
		);

		if (
			isset( $_REQUEST['orderby'] ) &&
			in_array( $_REQUEST['orderby'], $allowed, true )
		) {
			$order_by = sanitize_key(
				wp_unslash( $_REQUEST['orderby'] )
			);
		}

		$order = 'DESC';

		if (
			isset( $_REQUEST['order'] ) &&
			'asc' === strtolower(
				sanitize_text_field(
					wp_unslash( $_REQUEST['order'] )
				)
			)
		) {
			$order = 'ASC';
		}

		$where = ' WHERE 1=1 ';
		$params = array();

		if ( ! empty( $_REQUEST['s'] ) ) {

			$search = '%' . $this->db->esc_like(
				sanitize_text_field(
					wp_unslash( $_REQUEST['s'] )
				)
			) . '%';

			$where .= ' AND (i.invoice_number LIKE %s OR c.company_name LIKE %s)';

			$params[] = $search;
			$params[] = $search;
		}

		$offset = ( $page_number - 1 ) * $per_page;

		$sql = "
			SELECT
				i.*,
				c.company_name AS customer_name
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			{$where}
			ORDER BY {$order_by} {$order}
			LIMIT %d OFFSET %d
		";

		$params[] = $per_page;
		$params[] = $offset;

		$sql = $this->db->prepare( $sql, $params );

		return (array) $this->db->get_results(
			$sql,
			ARRAY_A
		);
	}
	/**
	 * Prepare list table items.
	 *
	 * @return void
	 */
	public function prepare_items() {

		$this->process_bulk_action();

		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array(
			$columns,
			$hidden,
			$sortable,
		);

		$per_page = $this->get_items_per_page(
			'casben_invoices_per_page',
			20
		);

		$current_page = $this->get_pagenum();

		$total_items = $this->get_total_items();

		$this->items = $this->get_invoices(
			$per_page,
			$current_page
		);

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => (int) ceil(
					$total_items / $per_page
				),
			)
		);
	}

	/**
	 * Display message when no invoices exist.
	 *
	 * @return void
	 */
	public function no_items() {

		esc_html_e(
			'No invoices found.',
			'casben-business-suite'
		);
	}
	/**
	 * Customer column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_customer_name( $item ) {

		if ( empty( $item['customer_name'] ) ) {
			return '&mdash;';
		}

		return esc_html( $item['customer_name'] );
	}

	/**
	 * Invoice date column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_invoice_date( $item ) {

		if ( empty( $item['invoice_date'] ) ) {
			return '&mdash;';
		}

		$timestamp = strtotime( $item['invoice_date'] );

		if ( false === $timestamp ) {
			return esc_html( $item['invoice_date'] );
		}

		return esc_html(
			wp_date(
				get_option( 'date_format' ),
				$timestamp
			)
		);
	}

	/**
	 * Total amount column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_total_amount( $item ) {

		$amount = isset( $item['total_amount'] )
			? (float) $item['total_amount']
			: 0;

		return esc_html(
			number_format_i18n(
				$amount,
				2
			)
		);
	}

	/**
	 * Created date column.
	 *
	 * @param array $item Current item.
	 * @return string
	 */
	protected function column_created_at( $item ) {

		if ( empty( $item['created_at'] ) ) {
			return '&mdash;';
		}

		$timestamp = strtotime( $item['created_at'] );

		if ( false === $timestamp ) {
			return esc_html( $item['created_at'] );
		}

		return esc_html(
			wp_date(
				get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
				$timestamp
			)
		);
	}
	

	/**
	 * Display extra controls above the table.
	 *
	 * @param string $which Position of the table.
	 * @return void
	 */
	protected function extra_tablenav( $which ) {

		if ( 'top' !== $which ) {
			return;
		}

		?>
		<div class="alignleft actions">

			<a href="<?php echo esc_url(
				add_query_arg(
					array(
						'page'   => 'casben-invoices',
						'action' => 'add',
					),
					admin_url( 'admin.php' )
				)
			); ?>" class="button button-primary">

				<?php esc_html_e(
					'Add New Invoice',
					'casben-business-suite'
				); ?>

			</a>

		</div>
		<?php
	}

}