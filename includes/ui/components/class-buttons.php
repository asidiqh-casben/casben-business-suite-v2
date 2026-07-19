<?php
/**
 * Button Factory
 *
 * Creates standard CASBEN button definitions.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Button Factory.
 */
class CASBEN_Btn {

	/**
	 * Build a standard button definition.
	 *
	 * @param string $label Button label.
	 * @param string $icon  Dashicon name.
	 * @param string $url   Button URL.
	 * @param string $class CSS class.
	 *
	 * @return array
	 */
	private static function make( $label, $icon, $url, $class = 'button' ) {

		return array(
			'label' => $label,
			'icon'  => $icon,
			'url'   => $url,
			'class' => $class,
		);
	}

	/**
	 * Add button.
	 *
	 * @param string $module Module name.
	 * @param string $url    Button URL.
	 *
	 * @return array
	 */
	public static function add( $module, $url ) {

		return self::make(
			sprintf(
				/* translators: %s: Module name */
				__( 'Add %s', 'casben-business-suite' ),
				$module
			),
			'plus',
			$url,
			'button button-primary'
		);
	}

	/**
	 * Save button.
	 *
	 * @param string $url Button URL.
	 * @return array
	 */
	public static function save( $url = '#' ) {

		return self::make(
			__( 'Save', 'casben-business-suite' ),
			'saved',
			$url,
			'button button-primary'
		);
	}

	/**
	 * Reset button.
	 *
	 * @return array
	 */
	public static function reset() {

		return self::make(
			__( 'Reset', 'casben-business-suite' ),
			'update',
			'#'
		);
	}

	/**
	 * Cancel button.
	 *
	 * @param string $url Return URL.
	 * @return array
	 */
	public static function cancel( $url ) {

		return self::make(
			__( 'Cancel', 'casben-business-suite' ),
			'no-alt',
			$url
		);
	}

	/**
	 * Print button.
	 *
	 * @param string $url Print URL.
	 * @return array
	 */
	public static function print( $url ) {

		return self::make(
			__( 'Print', 'casben-business-suite' ),
			'printer',
			$url
		);
	}

	/**
	 * Export button.
	 *
	 * @param string $url Export URL.
	 * @return array
	 */
	public static function export( $url ) {

		return self::make(
			__( 'Export', 'casben-business-suite' ),
			'download',
			$url
		);
	}

	/**
	 * Import button.
	 *
	 * @param string $url Import URL.
	 * @return array
	 */
	public static function import( $url ) {

		return self::make(
			__( 'Import', 'casben-business-suite' ),
			'upload',
			$url
		);
	}

	/**
	 * Dashboard button.
	 *
	 * @param string $url Dashboard URL.
	 * @return array
	 */
	public static function dashboard( $url ) {

		return self::make(
			__( 'Dashboard', 'casben-business-suite' ),
			'admin-home',
			$url
		);
	}

	/**
	 * Refresh button.
	 *
	 * @param string $url Refresh URL.
	 * @return array
	 */
	public static function refresh( $url ) {

		return self::make(
			__( 'Refresh', 'casben-business-suite' ),
			'update',
			$url
		);
	}
}