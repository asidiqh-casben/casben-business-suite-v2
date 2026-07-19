<?php
/**
 * UI Facade
 *
 * Provides a single entry point for all UI components.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	require_once CASBEN_PLUGIN_DIR . 'includes/ui/components/class-page-toolbar.php';
/**
 * UI Facade.
 */
class CASBEN_UI {

	/**
	 * Start a card.
	 *
	 * @param string $title Card title.
	 * @param string $class Additional CSS classes.
	 * @param string $icon  Dashicon class.
	 * @return void
	 */
	public static function card_start(
		$title = '',
		$class = '',
		$icon = ''
	) {

		CASBEN_UI_Card::start(
			$title,
			$class,
			$icon
		);
	}

	/**
	 * End a card.
	 *
	 * @return void
	 */
	public static function card_end() {

		CASBEN_UI_Card::end();
	}
	/**
	 * Action Toolabar
	 */
		/**
	 * Render the standard page toolbar.
	 *
	 * @param array $args Toolbar configuration.
	 * @return void
	 */
	public static function page_toolbar( $args = array() ) {

		CASBEN_Page_Toolbar::render( $args );
	}
			/**
		 * Render a standard button.
		 *
		 * @param array $button Button definition.
		 *
		 * @return void
		 */
		public static function button( $button ) {

			if ( empty( $button ) ) {
				return;
			}

			$button = wp_parse_args(
				$button,
				array(
					'label'      => '',
					'icon'       => '',
					'url'        => '#',
					'class'      => 'button',
					'target'     => '_self',
					'confirm'    => '',
					'visible'    => true,
					'permission' => '',
				)
			);

			// Visibility.
			if ( ! $button['visible'] ) {
				return;
			}

			// Future capability support.
			if (
				! empty( $button['permission'] ) &&
				! current_user_can( $button['permission'] )
			) {
				return;
			}

			?>
			<a
				href="<?php echo esc_url( $button['url'] ); ?>"
				class="<?php echo esc_attr( $button['class'] ); ?>"
				target="<?php echo esc_attr( $button['target'] ); ?>"
				<?php if ( ! empty( $button['confirm'] ) ) : ?>
					onclick="return confirm('<?php echo esc_js( $button['confirm'] ); ?>');"
				<?php endif; ?>
			>

				<?php if ( ! empty( $button['icon'] ) ) : ?>

					<span class="dashicons dashicons-<?php echo esc_attr( $button['icon'] ); ?>"></span>

				<?php endif; ?>

				<?php echo esc_html( $button['label'] ); ?>

			</a>
			<?php
		}
	/**
	 * Render a statistics card.
	 *
	 * @param string $title Card title.
	 * @param mixed  $value Card value.
	 * @param string $icon  Dashicon class.
	 *
	 * @return void
	 */
					/**
 * Render a statistic card.
 *
 * @param array $args Card arguments.
 *
 * @return void
 */
		public static function stat_card( $args = array() ) {

			CASBEN_Stat_Card::render( $args );

		}
		/**
	 * Start actions container.
	 *
	 * @return void
	 */
	public static function actions_start() {

		CASBEN_UI_Actions::start();

	}

	/**
	 * End actions container.
	 *
	 * @return void
	 */
	public static function actions_end() {

		CASBEN_UI_Actions::end();

	}

	/**
	 * Render action tile.
	 *
	 * @param string $label Action label.
	 * @param string $url   URL.
	 * @param string $icon  Dashicon class.
	 *
	 * @return void
	 */
	public static function action( $label, $url, $icon ) {

		CASBEN_UI_Actions::action(
			$label,
			$url,
			$icon
		);

	}
}