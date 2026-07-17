<?php
/**
 * Invoice Items Database Schema
 *
 * Creates the invoice items table.
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

		$table_name = $wpdb->prefix . 'casben_invoice_items';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (

			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,


			invoice_id bigint(20) unsigned NOT NULL,

			product_id bigint(20) unsigned NULL,


			description text NOT NULL,


			quantity decimal(12,3) NOT NULL DEFAULT 1.000,

			unit_price decimal(12,2) NOT NULL DEFAULT 0.00,


			discount_amount decimal(12,2) NOT NULL DEFAULT 0.00,


			tax_rate decimal(5,2) NOT NULL DEFAULT 18.00,

			tax_amount decimal(12,2) NOT NULL DEFAULT 0.00,


			line_total decimal(12,2) NOT NULL DEFAULT 0.00,


			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,


			PRIMARY KEY (id),


			KEY invoice_id (invoice_id),

			KEY product_id (product_id)


		) {$charset_collate};";


		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
	}
}