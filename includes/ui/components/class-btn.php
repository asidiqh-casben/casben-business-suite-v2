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
		$visible = true,
		$onclick = ''
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
			'onclick'    => $onclick,
		);
	}

	/**
 * Add/New button.
 *
 * @param string $module Module name.
 * @param string $url    Button URL.
 * @param string $verb   Button verb (Add/New).
 *
 * @return array
 */
	public static function add(
		$module,
		$url,
		$verb = 'Add'
	) {

		return self::make(
			sprintf(
				__( '%1$s %2$s', 'casben-business-suite' ),
				$verb,
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
	 * Back button.
	 */
	public static function back( $url ) {

		return self::make(
			__( 'Back', 'casben-business-suite' ),
			'arrow-left-alt',
			$url,
			self::SECONDARY
		);

	}

	/**
	 * Edit button.
	 */
	public static function edit( $url ) {

		return self::make(
			__( 'Edit', 'casben-business-suite' ),
			'edit',
			$url,
			self::SECONDARY
		);

	}

	/**
	 * Delete button.
	 */
	public static function delete( $url, $confirm = '' ) {

		if ( empty( $confirm ) ) {

			$confirm = __(
				'Are you sure you want to delete this item?',
				'casben-business-suite'
			);

		}

		return self::make(
			__( 'Delete', 'casben-business-suite' ),
			'trash',
			$url,
			self::DANGER,
			'',
			$confirm
		);

	}

	/**
	 * Print document button.
	 */
	public static function print_document() {

		return self::make(
			__( 'Print', 'casben-business-suite' ),
			'printer',
			'#',
			self::SECONDARY,
			'',
			'',
			'_self',
			true,
			'window.print(); return false;'
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