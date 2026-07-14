<?php
/**
 * Settings Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Settings {

	/**
	 * Get a setting value.
	 *
	 * @param string $key     Setting key.
	 * @param mixed  $default Default value.
	 *
	 * @return mixed
	 */
	public static function get( $key, $default = '' ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_settings';

		$value = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT setting_value
				FROM {$table}
				WHERE setting_key = %s",
				$key
			)
		);

		return null !== $value ? $value : $default;
	}

	/**
	 * Save a setting.
	 *
	 * @param string $key   Setting key.
	 * @param mixed  $value Setting value.
	 *
	 * @return void
	 */
	public static function set( $key, $value ) {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_settings';

		$exists = self::get( $key, null );

		if ( null === $exists ) {

			$wpdb->insert(
				$table,
				array(
					'setting_key'   => $key,
					'setting_value' => $value,
				),
				array(
					'%s',
					'%s',
				)
			);

		} else {

			$wpdb->update(
				$table,
				array(
					'setting_value' => $value,
				),
				array(
					'setting_key' => $key,
				),
				array(
					'%s',
				),
				array(
					'%s',
				)
			);
		}
	}

	/**
	 * Initialize default settings.
	 *
	 * @return void
	 */
	public static function install_defaults() {

		$defaults = array(
			'invoice_prefix'           => 'CBS',
			'invoice_next_number'      => '1',
			'invoice_default_tax_rate' => '18',
		);

		foreach ( $defaults as $key => $value ) {

			if ( null === self::get( $key, null ) ) {
				self::set( $key, $value );
			}
		}
	}
}