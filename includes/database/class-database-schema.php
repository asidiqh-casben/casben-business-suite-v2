<?php
/**
 * CASBEN Business Suite
 *
 * Database Schema Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Database_Schema {

	/**
	 * Create or update plugin database tables.
	 *
	 * @return void
	 */
	public static function create_tables() {

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Customers Table
		 */
		$customers_table = $wpdb->prefix . 'casben_customers';

		$sql_customers = "CREATE TABLE {$customers_table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			customer_name varchar(255) NOT NULL,
			company_name varchar(255) DEFAULT '',
			ntn varchar(100) DEFAULT '',
			strn varchar(100) DEFAULT '',
			phone varchar(50) DEFAULT '',
			email varchar(100) DEFAULT '',
			address text,
			is_active tinyint(1) NOT NULL DEFAULT 1,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY customer_name (customer_name)
		) {$charset_collate};";

		/**
		 * Products Table
		 */
		$products_table = $wpdb->prefix . 'casben_products';

		$sql_products = "CREATE TABLE {$products_table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			product_name varchar(255) NOT NULL,
			sku varchar(100) DEFAULT '',
			unit_price decimal(10,2) DEFAULT 0.00,
			tax_rate decimal(5,2) DEFAULT 18.00,
			is_active tinyint(1) NOT NULL DEFAULT 1,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY sku (sku)
		) {$charset_collate};";

		/**
		 * Invoices Table
		 */
		$invoices_table = $wpdb->prefix . 'casben_invoices';

		$sql_invoices = "CREATE TABLE {$invoices_table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			invoice_number varchar(100) NOT NULL,
			customer_id bigint(20) unsigned NOT NULL,
			invoice_date date NOT NULL,
			subtotal decimal(10,2) DEFAULT 0.00,
			tax_amount decimal(10,2) DEFAULT 0.00,
			total_amount decimal(10,2) DEFAULT 0.00,
			status varchar(50) DEFAULT 'draft',
			fbr_status varchar(50) DEFAULT 'pending',
			fbr_response longtext,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY invoice_number (invoice_number),
			KEY customer_id (customer_id),
			KEY invoice_date (invoice_date),
			KEY status (status)
		) {$charset_collate};";

		/**
		 * Invoice Items Table
		 */
		$invoice_items_table = $wpdb->prefix . 'casben_invoice_items';

		$sql_invoice_items = "CREATE TABLE {$invoice_items_table} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			invoice_id bigint(20) unsigned NOT NULL,
			product_id bigint(20) unsigned NOT NULL,
			description text,
			quantity decimal(10,2) DEFAULT 1.00,
			price decimal(10,2) DEFAULT 0.00,
			tax decimal(10,2) DEFAULT 0.00,
			total decimal(10,2) DEFAULT 0.00,
			PRIMARY KEY (id),
			KEY invoice_id (invoice_id),
			KEY product_id (product_id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql_customers );
		dbDelta( $sql_products );
		dbDelta( $sql_invoices );
		dbDelta( $sql_invoice_items );
	}

}