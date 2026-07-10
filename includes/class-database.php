<?php
/**
 * CASBEN Business Suite
 *
 * Database Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Database {

	/**
	 * Create or upgrade database tables.
	 *
	 * @return void
	 */
	public static function install() {

		require_once CASBEN_PLUGIN_DIR . 'includes/database/class-database-schema.php';

		CASBEN_Database_Schema::create_tables();

	}

	/**
	 * Get full table name.
	 *
	 * Example:
	 * CASBEN_Database::table( 'customers' )
	 * returns:
	 * wp_casben_customers
	 *
	 * @param string $table Table name.
	 *
	 * @return string
	 */
	public static function table( $table ) {

		global $wpdb;

		return $wpdb->prefix . 'casben_' . $table;

	}

	/**
	 * Insert a record.
	 *
	 * @param string $table Table name.
	 * @param array  $data  Data.
	 *
	 * @return int|false
	 */
	public static function insert( $table, $data ) {

		global $wpdb;

		return $wpdb->insert(
			self::table( $table ),
			$data
		);

	}

	/**
	 * Update records.
	 *
	 * @param string $table Table name.
	 * @param array  $data  Data.
	 * @param array  $where Where clause.
	 *
	 * @return int|false
	 */
	public static function update( $table, $data, $where ) {

		global $wpdb;

		return $wpdb->update(
			self::table( $table ),
			$data,
			$where
		);

	}

	/**
	 * Delete records.
	 *
	 * @param string $table Table name.
	 * @param array  $where Where clause.
	 *
	 * @return int|false
	 */
	public static function delete( $table, $where ) {

		global $wpdb;

		return $wpdb->delete(
			self::table( $table ),
			$where
		);

	}

	/**
	 * Get all rows.
	 *
	 * @param string $table Table name.
	 *
	 * @return array
	 */
	public static function get_all( $table ) {

		global $wpdb;

		return $wpdb->get_results(
			"SELECT * FROM " . self::table( $table ),
			ARRAY_A
		);

	}

	/**
	 * Get one row by ID.
	 *
	 * @param string $table Table name.
	 * @param int    $id    Record ID.
	 *
	 * @return array|null
	 */
	public static function get_by_id( $table, $id ) {

		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM " . self::table( $table ) . " WHERE id = %d",
				$id
			),
			ARRAY_A
		);

	}

}