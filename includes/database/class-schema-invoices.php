<?php
/**
 * Invoice Database Schema
 *
 * Creates the invoices table.
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

		$table_name = $wpdb->prefix . 'casben_invoices';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,

			invoice_number varchar(50) NOT NULL,

			customer_id bigint(20) unsigned NOT NULL,

			invoice_date date NOT NULL,

			due_date date NULL,

			status varchar(30) NOT NULL DEFAULT 'draft',

			subtotal decimal(12,2) NOT NULL DEFAULT 0.00,

			tax_amount decimal(12,2) NOT NULL DEFAULT 0.00,

			discount_amount decimal(12,2) NOT NULL DEFAULT 0.00,

			grand_total decimal(12,2) NOT NULL DEFAULT 0.00,

			notes text NULL,

			fbr_invoice_number varchar(100) NULL,

			fbr_status varchar(50) NULL,

			fbr_response text NULL,


			created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

			updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,


			PRIMARY KEY  (id),

			KEY customer_id (customer_id),

			KEY invoice_number (invoice_number),

			KEY status (status)

		) {$charset_collate};";


		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		}
}