<?php
/**
 * Settings Database Schema
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Settings {

	/**
	 * Create settings table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'casben_settings';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			setting_key VARCHAR(100) NOT NULL,
			setting_value LONGTEXT NULL,
			autoload TINYINT(1) NOT NULL DEFAULT 1,
			updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			UNIQUE KEY setting_key (setting_key)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		error_log( 'START Settings dbDelta' );
		dbDelta( $sql );
		error_log( 'END Settings dbDelta' );
	}
}