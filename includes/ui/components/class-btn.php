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
	 * Primary button CSS class.
	 */
	private const PRIMARY = 'button button-primary';

	/**
	 * Secondary button CSS class.
	 */
	private const SECONDARY = 'button';

	/**
	 * Danger button CSS class.
	 */
	private const DANGER = 'button button-link-delete';

	/**
	 * Build a standard button definition.
	 *
	 * @param string $label      Button label.
	 * @param string $icon       Dashicon name.
	 * @param string $url        Button URL.
	 * @param string $class      CSS class.
	 * @param string $permission Required capability.
	 * @param string $confirm    Confirmation message.
	 * @param string $target     Link target.
	 * @param bool   $visible    Visibility flag.
	 *
	 * @return array
	 */
	private static function make(
		$label,
		$icon,
		$url,
		$class = self::SECONDARY,
		$permission = '',
		$confirm = '',
		$target = '_self',
		$visible = true
	) {

		return array(
			'label'      => $label,
			'icon'       => $icon,
			'url'        => $url,
			'class'      => $class,
			'permission' => $permission,
			'confirm'    => $confirm,
			'target'     => $target,
			'visible'    => $visible,
		);
	}

	/**
	 * Add button.
	 */
	public static function add( $module, $url ) {

		return self::make(
			sprintf(
				__( 'Add %s', 'casben-business-suite' ),
				$module
			),
			'plus',
			$url,
			self::PRIMARY
		);
	}

			/**
		 * View button.
		 */
		public static function view( $label, $url ) {

			return self::make(
				$label,
				'visibility',
				$url,
				self::SECONDARY
			);
		}
	/**
	 * Save button.
	 */
	public static function save( $url = '#' ) {

		return self::make(
			__( 'Save', 'casben-business-suite' ),
			'saved',
			$url,
			self::PRIMARY
		);
	}

	/**
	 * Reset button.
	 */
	public static function reset() {

		return self::make(
			__( 'Reset', 'casben-business-suite' ),
			'update',
			'#',
			self::SECONDARY
		);
	}

	/**
	 * Cancel button.
	 */
	public static function cancel( $url ) {

		return self::make(
			__( 'Cancel', 'casben-business-suite' ),
			'no-alt',
			$url,
			self::SECONDARY
		);
	}

	/**
	 * Print List button.
	 */
	public static function print_list( $url ) {

		return self::make(
			__( 'Print', 'casben-business-suite' ),
			'printer',
			$url,
			self::SECONDARY
		);
	}

	/**
	 * Export button.
	 */
	public static function export( $url ) {

		return self::make(
			__( 'Export', 'casben-business-suite' ),
			'download',
			$url,
			self::SECONDARY
		);
	}

	/**
	 * Import button.
	 */
	public static function import( $url ) {

		return self::make(
			__( 'Import', 'casben-business-suite' ),
			'upload',
			$url,
			self::SECONDARY
		);
	}

	/**
	 * Dashboard button.
	 */
	public static function dashboard( $url ) {

		return self::make(
			__( 'Dashboard', 'casben-business-suite' ),
			'admin-home',
			$url,
			self::SECONDARY
		);
	}

	/**
	 * Refresh button.
	 */
	public static function refresh( $url ) {

		return self::make(
			__( 'Refresh', 'casben-business-suite' ),
			'update',
			$url,
			self::SECONDARY
		);
	}

}