<?php
/**
 * Page Toolbar Component
 *
 * Renders the standard action toolbar used throughout
 * CASBEN Business Suite.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page Toolbar Component.
 */
class CASBEN_Page_Toolbar {

	/**
	 * Render the toolbar.
	 *
	 * @param array $args Toolbar configuration.
	 * @return void
	 */
	public static function render( $args = array() ) {


		$defaults = array(
			'title'       => '',
			'description' => '',
			'actions'     => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		?>

		<div class="casben-page-toolbar">

			<div class="casben-page-toolbar__header">

				<?php if ( ! empty( $args['title'] ) ) : ?>
					<h1 class="casben-page-toolbar__title">
						<?php echo esc_html( $args['title'] ); ?>
					</h1>
				<?php endif; ?>

				<?php if ( ! empty( $args['description'] ) ) : ?>
					<p class="casben-page-toolbar__description">
						<?php echo esc_html( $args['description'] ); ?>
					</p>
				<?php endif; ?>

			</div>

			<div class="casben-page-toolbar__actions">

				<?php
				
				foreach ( $args['actions'] as $action ) {

					CASBEN_UI::button( $action );

				}

				?>

			</div>

		</div>

		<?php
	}
}