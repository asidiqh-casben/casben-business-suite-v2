<?php
/**
 * Invoices Database Schema
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Invoices {

	/**
	 * Create invoices table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'casben_invoices';
		$charset_collate = $wpdb->get_charset_collate();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$sql = "CREATE TABLE {$table_name} (

			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

			invoice_number VARCHAR(50) NOT NULL,

			customer_id BIGINT(20) UNSIGNED NOT NULL,

			invoice_date DATE NOT NULL,

			invoice_type ENUM(
				'SALE',
				'DEBIT_NOTE',
				'CREDIT_NOTE'
			) NOT NULL DEFAULT 'SALE',

			supply_type ENUM(
				'GOODS',
				'SERVICES'
			) NOT NULL DEFAULT 'GOODS',

			subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			tax_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			total_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			fbr_status ENUM(
				'PENDING',
				'SUBMITTED',
				'FAILED',
				'CANCELLED'
			) NOT NULL DEFAULT 'PENDING',

			fbr_reference_no VARCHAR(100) DEFAULT NULL,

			uuid VARCHAR(100) DEFAULT NULL,

			qr_code TEXT DEFAULT NULL,

			remarks TEXT DEFAULT NULL,

			status ENUM(
				'DRAFT',
				'FINAL',
				'CANCELLED'
			) NOT NULL DEFAULT 'DRAFT',

			created_by BIGINT(20) UNSIGNED DEFAULT NULL,

			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			PRIMARY KEY (id),

			UNIQUE KEY invoice_number_unique (invoice_number),

			KEY customer_id_idx (customer_id),

			KEY invoice_date_idx (invoice_date),

			KEY invoice_type_idx (invoice_type),

			KEY supply_type_idx (supply_type),

			KEY fbr_status_idx (fbr_status),

			KEY status_idx (status)

		) {$charset_collate};";

		dbDelta( $sql );
	}
}