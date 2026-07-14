<?php
/**
 * Invoice Items Database Schema
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Invoice_Items {

	/**
	 * Create invoice items table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'casben_invoice_items';
		$charset_collate = $wpdb->get_charset_collate();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$sql = "CREATE TABLE {$table_name} (

			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

			invoice_id BIGINT(20) UNSIGNED NOT NULL,

			product_id BIGINT(20) UNSIGNED DEFAULT NULL,

			description TEXT NOT NULL,

			hs_code VARCHAR(20) DEFAULT NULL,

			quantity DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			unit VARCHAR(20) DEFAULT NULL,

			unit_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0.00,

			tax_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			line_total DECIMAL(15,2) NOT NULL DEFAULT 0.00,

			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			PRIMARY KEY (id),

			KEY invoice_id_idx (invoice_id),

			KEY product_id_idx (product_id),

			KEY hs_code_idx (hs_code)

		) {$charset_collate};";

		dbDelta( $sql );
	}
}