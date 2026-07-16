<?php
/**
 * Products Database Schema
 *
 * Creates the products table.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Products {

	/**
	 * Create products table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'casben_products';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (

			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

			product_code VARCHAR(100) NOT NULL,

			product_name VARCHAR(255) NOT NULL,

			grade VARCHAR(100) DEFAULT '',

			description TEXT DEFAULT NULL,

			category VARCHAR(100) DEFAULT '',

			unit VARCHAR(50) DEFAULT '',

			hs_code VARCHAR(50) DEFAULT '',

			tax_rate DECIMAL(5,2) DEFAULT 0.00,

			unit_price DECIMAL(12,2) DEFAULT 0.00,

			status TINYINT(1) DEFAULT 1,

			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
				ON UPDATE CURRENT_TIMESTAMP,


			PRIMARY KEY (id),

			KEY product_code (product_code),

			KEY product_name (product_name)

		) {$charset_collate};";


		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		error_log( 'START Products dbDelta' );
		dbDelta( $sql );
		error_log( 'END Products dbDelta' );
	}
}