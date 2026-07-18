<?php
/**
 * Invoice Model
 *
 * Handles database operations related to invoices.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice {

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
	 * Customer table.
	 *
	 * @var string
	 */
	private $customers_table;

	/**
	 * Database object.
	 *
	 * @var wpdb
	 */
	private $db;


	/**
	 * Constructor.
	 */
	public function __construct() {

		global $wpdb;

		$this->db = $wpdb;

		$this->table = $wpdb->prefix . 'casben_invoices';

		$this->items_table = $wpdb->prefix . 'casben_invoice_items';

		$this->customers_table = $wpdb->prefix . 'casben_customers';
	}


	/**
	 * Create invoice.
	 *
	 * @param array $data Invoice data.
	 *
	 * @return int|false
	 */
	public function create( $data ) {

		$result = $this->db->insert(
			$this->table,
			$data
		);

		if ( false === $result ) {
			return false;
		}

		return (int) $this->db->insert_id;
	}

		/**
	 * Add invoice item.
	 *
	 * @param array $data Invoice item data.
	 *
	 * @return int|false
	 */
	public function add_item( $data ) {

		$result = $this->db->insert(
			$this->items_table,
			$data
		);

		if ( false === $result ) {
			return false;
		}

		return (int) $this->db->insert_id;
	}


	/**
	 * Add multiple invoice items.
	 *
	 * @param int   $invoice_id Invoice ID.
	 * @param array $items      Invoice items.
	 *
	 * @return bool
	 */
	public function add_items( $invoice_id, $items ) {

		$invoice_id = absint( $invoice_id );

		foreach ( $items as $item ) {

			$item['invoice_id'] = $invoice_id;

			$result = $this->add_item( $item );

			if ( false === $result ) {
				return false;
			}
		}

		return true;
	}


	/**
	 * Get invoice items.
	 *
	 * @param int $invoice_id Invoice ID.
	 *
	 * @return array
	 */
	public function get_items( $invoice_id ) {

		$sql = "
			SELECT *
			FROM {$this->items_table}
			WHERE invoice_id = %d
			ORDER BY id ASC
		";

		return $this->db->get_results(
			$this->db->prepare(
				$sql,
				absint( $invoice_id )
			),
			ARRAY_A
		);
	}

	/**
	 * Update invoice.
	 *
	 * @param int   $invoice_id Invoice ID.
	 * @param array $data Invoice data.
	 *
	 * @return bool
	 */
	public function update( $invoice_id, $data ) {

		$result = $this->db->update(
			$this->table,
			$data,
			array(
				'id' => absint( $invoice_id ),
			)
		);

		return false !== $result;
	}
		/**
	 * Delete invoice items.
	 *
	 * @param int $invoice_id Invoice ID.
	 *
	 * @return bool
	 */
	public function delete_items( $invoice_id ) {

		$result = $this->db->delete(
			$this->items_table,
			array(
				'invoice_id' => absint( $invoice_id ),
			),
			array(
				'%d',
			)
		);

		return false !== $result;
	}

	/**
	 * Delete invoice and invoice items.
	 *
	 * @param int $invoice_id Invoice ID.
	 *
	 * @return bool
	 */
	public function delete( $invoice_id ) {

		$invoice_id = absint( $invoice_id );


		$this->db->delete(
    		$this->items_table,
    		array(
        		'invoice_id' => $invoice_id,
    		),
    		array(
        		'%d',
    		)
		);


		$result = $this->db->delete(
			$this->table,
			array(
				'id' => $invoice_id,
			)
		);


		return false !== $result;
	}
		/**
	 * Delete multiple invoices.
	 *
	 * @param array $invoice_ids Invoice IDs.
	 *
	 * @return bool
	 */
	
	public function bulk_delete( $invoice_ids ) {

		$invoice_ids = array_map(
			'absint',
			(array) $invoice_ids
		);

		if ( empty( $invoice_ids ) ) {
			return false;
		}

		foreach ( $invoice_ids as $invoice_id ) {

			if ( ! $this->delete( $invoice_id ) ) {
				return false;
			}
		}

		return true;
	}
	/**
	 * Get invoice by ID.
	 *
	 * @param int $invoice_id Invoice ID.
	 *
	 * @return object|null
	 */
	public function get( $invoice_id ) {

		$sql = "
			SELECT 
				i.*,
				c.company_name
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			WHERE i.id = %d
		";


		return $this->db->get_row(
			$this->db->prepare(
				$sql,
				absint( $invoice_id )
			)
		);
	}


	/**
	 * Get invoice by invoice number.
	 *
	 * @param string $invoice_number Invoice number.
	 *
	 * @return object|null
	 */
	public function get_by_number( $invoice_number ) {

		$sql = "
			SELECT 
				i.*,
				c.company_name
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			WHERE i.invoice_number = %s
		";


		return $this->db->get_row(
			$this->db->prepare(
				$sql,
				sanitize_text_field( $invoice_number )
			)
		);
	}


	/**
	 * Get invoices.
	 *
	 * @param array $args Query arguments.
	 *
	 * @return array
	 */
	public function get_all( $args = array() ) {

		$defaults = array(
			'search'   => '',
			'status'   => '',
			'orderby'  => 'id',
			'order'    => 'DESC',
			'page'     => 1,
			'per_page' => 20,
		);


		$args = wp_parse_args(
			$args,
			$defaults
		);


		$where  = array( '1=1' );
		$params = array();


		if ( ! empty( $args['search'] ) ) {

			$search = '%' . $this->db->esc_like(
				$args['search']
			) . '%';


			$where[] = "
				(
					i.invoice_number LIKE %s
					OR c.company_name LIKE %s
				)
			";


			$params[] = $search;
			$params[] = $search;
		}


		if ( ! empty( $args['status'] ) ) {

			$where[] = 'i.status = %s';

			$params[] = sanitize_text_field(
				$args['status']
			);
		}


		$allowed_orderby = array(
			'id',
			'invoice_number',
			'invoice_date',
			'grand_total',
			'status',
		);


		if ( ! in_array( $args['orderby'], $allowed_orderby, true ) ) {
			$args['orderby'] = 'id';
		}


		$order = strtoupper(
			$args['order']
		);


		if ( ! in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
			$order = 'DESC';
		}


		$offset = (
			absint( $args['page'] ) - 1
		) * absint( $args['per_page'] );


		$sql = "
			SELECT
				i.*,
				c.company_name
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			WHERE " . implode( ' AND ', $where ) . "
			ORDER BY i.{$args['orderby']} {$order}
			LIMIT %d OFFSET %d
		";


		$params[] = absint( $args['per_page'] );
		$params[] = absint( $offset );


		return $this->db->get_results(
			$this->db->prepare(
				$sql,
				$params
			)
		);
	}


	/**
	 * Count invoices.
	 *
	 * @param string $search Search term.
	 * @param string $status Invoice status.
	 *
	 * @return int
	 */
	public function count( $search = '', $status = '' ) {

		$where  = array( '1=1' );
		$params = array();


		if ( ! empty( $search ) ) {

			$search = '%' . $this->db->esc_like(
				$search
			) . '%';


			$where[] = "
				(
					i.invoice_number LIKE %s
					OR c.company_name LIKE %s
				)
			";


			$params[] = $search;
			$params[] = $search;
		}


		if ( ! empty( $status ) ) {

			$where[] = 'i.status = %s';

			$params[] = $status;
		}


		$sql = "
			SELECT COUNT(*)
			FROM {$this->table} i
			LEFT JOIN {$this->customers_table} c
				ON i.customer_id = c.id
			WHERE " . implode( ' AND ', $where );


		if ( ! empty( $params ) ) {

	$sql = $this->db->prepare(
		$sql,
		$params
	);
	}

		return (int) $this->db->get_var( $sql );
	}


	/**
	 * Update invoice status.
	 *
	 * @param int    $invoice_id Invoice ID.
	 * @param string $status Status.
	 *
	 * @return bool
	 */
	public function update_status( $invoice_id, $status ) {

		$result = $this->db->update(
			$this->table,
			array(
				'status' => sanitize_text_field(
					$status
				),
			),
			array(
				'id' => absint( $invoice_id ),
			)
		);


		return false !== $result;
	}
}