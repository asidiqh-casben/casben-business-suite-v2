<?php
/**
 * Invoice Logs Database Schema
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Invoice_Logs {

	/**
	 * Create invoice logs table.
	 *
	 * @return void
	 */
		public static function create_table() {

			global $wpdb;

			$table_name      = $wpdb->prefix . 'casben_invoice_logs';
			$charset_collate = $wpdb->get_charset_collate();

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

				$sql = "CREATE TABLE {$table_name} (

				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

				invoice_id BIGINT(20) UNSIGNED NOT NULL,

				reference_no VARCHAR(100) DEFAULT NULL,

				request_type VARCHAR(20) NOT NULL DEFAULT 'SUBMIT',

				request_payload LONGTEXT DEFAULT NULL,

				response_payload LONGTEXT DEFAULT NULL,

				http_status SMALLINT(5) UNSIGNED DEFAULT NULL,

				fbr_status VARCHAR(20) NOT NULL DEFAULT 'PENDING',

				error_message TEXT DEFAULT NULL,

				attempt_number INT(10) UNSIGNED NOT NULL DEFAULT 1,

				created_by BIGINT(20) UNSIGNED DEFAULT NULL,

				created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

				PRIMARY KEY (id),

				KEY invoice_id_idx (invoice_id),

				KEY reference_no_idx (reference_no),

				KEY request_type_idx (request_type),

				KEY fbr_status_idx (fbr_status),

				KEY created_at_idx (created_at)

			) {$charset_collate};";

			dbDelta( $sql );	
	}
}