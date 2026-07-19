<?php
/**
 * UI Card Component
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * UI Card Component.
 */
class CASBEN_UI_Card {

	/**
	 * Open card.
	 *
	 * @param string $title Card title.
	 * @param string $class Additional CSS classes.
	 * @return void
	 */
	public static function start( $title = '', $class = '', $icon = '' ) {
		?>

		<div class="casben-card <?php echo esc_attr( $class ); ?>">

			<?php if ( ! empty( $title ) ) : ?>

				<div class="casben-card-header">

					<?php if ( ! empty( $icon ) ) : ?>

						<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>

					<?php endif; ?>

					<h2><?php echo esc_html( $title ); ?></h2>

				</div>

			<?php endif; ?>

			<div class="casben-card-body">

		<?php
	}

	/**
	 * Close card.
	 *
	 * @return void
	 */
	public static function end() {
		?>

			</div>

		</div>

		<?php
	}
}