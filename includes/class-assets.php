<?php
/**
 * CASBEN Business Suite
 *
 * Assets Manager
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Assets Manager.
 */
class CASBEN_Assets {

	/**
	 * CSS files.
	 *
	 * @var array
	 */
	private static $styles = array(
		'variables',
		'layout',
		'buttons',
		'forms',
		'tables',
		'badges',
		'alerts',
		'modal',
		'utilities',
		'responsive',
	);

	/**
	 * JavaScript files.
	 *
	 * @var array
	 */
		private static $scripts = array(
		'admin',
		'menu',
		'forms',
		'tables',
		'modal',
		'notifications',
		'dashboard-widgets',
		'invoice-form',
	);

	/**
	 * Initialize assets.
	 *
	 * @return void
	 */
	public static function init() {

		add_action(
			'admin_enqueue_scripts',
			array(
				__CLASS__,
				'enqueue_admin_assets',
			)
		);

	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook Current admin page hook.
	 *
	 * @return void
	 */
	public static function enqueue_admin_assets( $hook ) {

		// Load only CASBEN admin pages.
		if ( false === strpos( $hook, 'casben' ) ) {
			return;
		}

		self::enqueue_styles();

		self::enqueue_scripts();

	}

	/**
	 * Enqueue CSS files.
	 *
	 * @return void
	 */
	private static function enqueue_styles() {

		foreach ( self::$styles as $style ) {

			wp_enqueue_style(
				'casben-' . $style,
				CASBEN_PLUGIN_URL . 'assets/css/' . $style . '.css',
				array(),
				CASBEN_VERSION
			);

		}

	}

	/**
	 * Enqueue JavaScript files.
	 *
	 * @return void
	 */
	private static function enqueue_scripts() {

		foreach ( self::$scripts as $script ) {

			wp_enqueue_script(
				'casben-' . $script,
				CASBEN_PLUGIN_URL . 'assets/js/' . $script . '.js',
				array( 'jquery' ),
				CASBEN_VERSION,
				true
			);

		}

	}

}