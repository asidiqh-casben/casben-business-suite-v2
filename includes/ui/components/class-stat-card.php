<?php
/**
 * Statistic Card Component
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Statistic Card Component.
 */
class CASBEN_Stat_Card {

	/**
	 * Render statistic card.
	 *
	 * @param array $args Card arguments.
	 *
	 * @return void
	 */
	public static function render( $args = array() ) {

		$args = wp_parse_args(
			$args,
			array(
				'title'       => '',
				'icon'        => '',
				'stat'        => '',
				'description' => '',
				'footer'      => array(),
			)
		);

		?>

		<div class="casben-stat-card">

			<div class="casben-stat-card__header">
                <?php if ( $args['icon'] ) : ?>

                    <span class="dashicons dashicons-<?php echo esc_attr( $args['icon'] ); ?>"></span>

                    <?php endif; ?>

                    <span class="casben-stat-card__title">

                        <?php echo esc_html( $args['title'] ); ?>

                    </span>

			</div>

			<div class="casben-stat-card__body">
                <div class="casben-stat-card__stat">

                    <?php if ( is_numeric( $args['stat'] ) ) {

                            echo esc_html(
                                number_format_i18n( (float) $args['stat'] )
                            );

                        } else {

                            echo esc_html( $args['stat'] );

                        }
                     ?>

                </div>

                <div class="casben-stat-card__description">

                    <?php echo esc_html( $args['description'] ); ?>

                </div>

			</div>

			<div class="casben-stat-card__footer">
                    <?php
                    foreach ( $args['footer'] as $button ) {

                        CASBEN_UI::button( $button );

                    }
                    ?>
			</div>

		</div>

		<?php
	}

}