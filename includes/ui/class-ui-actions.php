<?php
/**
 * UI Actions Component
 *
 * Renders CASBEN action tiles.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * UI Actions.
 */
class CASBEN_UI_Actions {

	/**
	 * Start actions container.
	 *
	 * @return void
	 */
	public static function start() {

		echo '<div class="casben-quick-actions">';

	}

	/**
	 * End actions container.
	 *
	 * @return void
	 */
	public static function end() {

		echo '</div>';

	}

	/**
	 * Render one action tile.
	 *
	 * @param string $label Action label.
	 * @param string $url   Action URL.
	 * @param string $icon  Dashicon class.
	 *
	 * @return void
	 */
	public static function action( $label, $url, $icon ) {
		?>

		<a class="casben-quick-action"
			href="<?php echo esc_url( $url ); ?>">

			<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>

			<span><?php echo esc_html( $label ); ?></span>

		</a>

		<?php
	}
}