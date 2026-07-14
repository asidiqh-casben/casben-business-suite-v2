<?php
/**
 * Customer Database Schema
 *
 * Creates the customers table.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Customers {

	/**
	 * Create customers table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'casben_customers';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (

			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

			customer_code VARCHAR(30) NOT NULL,

			company_name VARCHAR(255) NOT NULL,

			contact_person VARCHAR(255) DEFAULT NULL,

			designation VARCHAR(100) DEFAULT NULL,

			phone VARCHAR(50) DEFAULT NULL,

			mobile VARCHAR(50) DEFAULT NULL,

			email VARCHAR(255) DEFAULT NULL,

			website VARCHAR(255) DEFAULT NULL,

			ntn VARCHAR(30) DEFAULT NULL,

			strn VARCHAR(30) DEFAULT NULL,

			fbr_buyer_registration_type VARCHAR(50) DEFAULT NULL,

			fbr_buyer_registration_number VARCHAR(50) DEFAULT NULL,

			address TEXT DEFAULT NULL,

			city VARCHAR(100) DEFAULT NULL,

			province VARCHAR(100) DEFAULT NULL,

			country VARCHAR(100) DEFAULT 'Pakistan',

			payment_terms VARCHAR(100) DEFAULT NULL,

			credit_limit DECIMAL(15,2) DEFAULT 0.00,

			status TINYINT(1) DEFAULT 1,

			notes TEXT DEFAULT NULL,

			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
				ON UPDATE CURRENT_TIMESTAMP,


			PRIMARY KEY (id),

			UNIQUE KEY customer_code_idx (customer_code),

			KEY company_name_idx (company_name),

			KEY email_idx (email),

			KEY ntn_idx (ntn)

		) {$charset_collate};";


		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
	}
}