<?php
/**
 * Dashboard Data
 *
 * Provides data for the dashboard widgets.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard Data Provider.
 */
class CASBEN_Dashboard_Data {

/**
 * Get recent invoices.
 *
 * @return array
 */
public function get_recent_invoices() {

		global $wpdb;

		return $wpdb->get_results(
			"
			SELECT
				i.invoice_number,
				c.company_name AS customer_name,
				i.invoice_date,
				i.grand_total,
				i.status
			FROM {$wpdb->prefix}casben_invoices i
			LEFT JOIN {$wpdb->prefix}casben_customers c
				ON i.customer_id = c.id
			ORDER BY i.id DESC
			LIMIT 10
			",
			ARRAY_A
		);
	}
	/**
	 * Get invoice status summary.
	 *
	 * @return array
	 */
	public function get_invoice_status() {

		global $wpdb;

		$rows = $wpdb->get_results(
			"
			SELECT status, COUNT(*) AS total
			FROM {$wpdb->prefix}casben_invoices
			GROUP BY status
			",
			ARRAY_A
		);

		$status = array();

		foreach ( $rows as $row ) {
			$status[ $row['status'] ] = (int) $row['total'];
		}

		return $status;
	}

	/**
	 * Get FBR status.
	 *
	 * @return array
	 */
	/**
 * Get FBR integration status.
 *
 * @return array
 */
public function get_fbr_status() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoice_logs';

		$pending = $wpdb->get_var(
			"
			SELECT COUNT(*)
			FROM {$table}
			WHERE fbr_status = 'PENDING'
			"
		);

		$failed = $wpdb->get_var(
			"
			SELECT COUNT(*)
			FROM {$table}
			WHERE fbr_status IN ('FAILED', 'ERROR')
			"
		);

		$success = $wpdb->get_var(
			"
			SELECT COUNT(*)
			FROM {$table}
			WHERE fbr_status IN ('SUCCESS', 'APPROVED')
			"
		);

		$last_sync = $wpdb->get_var(
			"
			SELECT created_at
			FROM {$table}
			ORDER BY created_at DESC
			LIMIT 1
			"
		);

		return array(
			'connected' => true,
			'last_sync' => $last_sync,
			'pending'   => (int) $pending,
			'failed'    => (int) $failed,
			'success'   => (int) $success,
		);
	}
	/**
	 * Get recent activity.
	 *
	 * @return array
	 */
	/**
	 * Get recent activity.
	 *
	 * @return array
	 */
	public function get_recent_activity() {

		return CASBEN_Activity_Log::get_recent( 5 );

	}
	/**
	 * Get dashboard statistics.
	 *
	 * @return array
	 */
	public function get_dashboard_stats() {

		global $wpdb;

		return array(
			'customers' => (int) $wpdb->get_var(
				"SELECT COUNT(*) FROM {$wpdb->prefix}casben_customers"
			),

			'products' => (int) $wpdb->get_var(
				"SELECT COUNT(*) FROM {$wpdb->prefix}casben_products"
			),

			'invoices' => (int) $wpdb->get_var(
				"SELECT COUNT(*) FROM {$wpdb->prefix}casben_invoices"
			),

			'sales' => (float) $wpdb->get_var(
				"SELECT SUM(grand_total) FROM {$wpdb->prefix}casben_invoices"
			),
		);
	}
	/**
 * Get invoice status summary.
 *
 * @return array
 */
public function get_invoice_status_summary() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_invoices';

		$results = $wpdb->get_results(
			"
			SELECT 
				status,
				COUNT(*) as total
			FROM {$table}
			GROUP BY status
			",
			ARRAY_A
		);

		$status = array(
			'paid'      => 0,
			'pending'   => 0,
			'cancelled' => 0,
		);

		foreach ( $results as $row ) {

			$key = strtolower( $row['status'] );

			if ( isset( $status[ $key ] ) ) {
				$status[ $key ] = (int) $row['total'];
			}
		}

		return $status;
	}
}