<?php
/**
 * Activity Log Manager
 *
 * Handles system activity logging.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class CASBEN_Activity_Log
 */
class CASBEN_Activity_Log {

	/**
	 * Add activity log entry.
	 *
	 * @param string $module Module name.
	 * @param string $action Action performed.
	 * @param string $message Description.
	 * @param int    $user_id User ID.
	 *
	 * @return bool
	 */
	public static function add( $module, $action, $message, $reference_id = null, $user_id = 0 ) {
		global $wpdb;

		$table = $wpdb->prefix . 'casben_activity_logs';

		if ( empty( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$result = $wpdb->insert(
			$table,
			array(
				'module'       => sanitize_text_field( $module ),
				'action'       => sanitize_text_field( $action ),
				'reference_id' => absint( $reference_id ),
				'description'  => sanitize_textarea_field( $message ),
				'user_id'      => absint( $user_id ),
				'created_at'   => current_time( 'mysql' ),
			),
			array(
				'%s',
				'%s',
				'%d',
				'%s',
				'%d',
				'%s',
			)
		);

		return false !== $result;
	}


	/**
	 * Get recent activities.
	 *
	 * @param int $limit Number of records.
	 *
	 * @return array
	 */
	public static function get_recent( $limit = 10 ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_activity_logs';

		return $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT *
				FROM {$table}
				ORDER BY id DESC
				LIMIT %d
				",
				absint( $limit )
			)
		);
	}


	/**
	 * Delete old logs.
	 *
	 * @param int $days Number of days.
	 *
	 * @return int|false
	 */
	public static function cleanup( $days = 90 ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_activity_logs';

		return $wpdb->query(
			$wpdb->prepare(
				"
				DELETE FROM {$table}
				WHERE created_at < %s
				",
				date(
					'Y-m-d H:i:s',
					strtotime( '-' . absint( $days ) . ' days' )
				)
			)
		);
	}
}