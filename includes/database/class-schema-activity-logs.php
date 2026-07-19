<?php
/**
 * Activity Logs Database Schema
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Schema_Activity_Logs {

	/**
	 * Create activity logs table.
	 *
	 * @return void
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'casben_activity_logs';
		$charset_collate = $wpdb->get_charset_collate();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$sql = "CREATE TABLE {$table_name} (

			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

			user_id BIGINT(20) UNSIGNED DEFAULT NULL,

			module VARCHAR(50) NOT NULL,

			action VARCHAR(50) NOT NULL,

			reference_id BIGINT(20) UNSIGNED DEFAULT NULL,

			description TEXT NOT NULL,

			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

			PRIMARY KEY (id),

			KEY module_idx (module),

			KEY action_idx (action),

			KEY reference_id_idx (reference_id),

			KEY created_at_idx (created_at)

		) {$charset_collate};";

		dbDelta( $sql );
	}
}