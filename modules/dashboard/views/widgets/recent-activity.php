<?php
/**
 * Recent Activity Widget
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

CASBEN_UI::card_start(
	__( 'Recent Activity', 'casben-business-suite' ),
	'casben-widget-small',
	'dashicons-clock'
);
?>

<?php if ( empty( $recent_activity ) ) : ?>

	<p>
		<?php esc_html_e(
			'No recent activity found.',
			'casben-business-suite'
		); ?>
	</p>

<?php else : ?>

	<ul class="casben-activity-list">

	<?php foreach ( $recent_activity as $activity ) : ?>

		<li>

			<strong>
				<?php echo esc_html( ucfirst( $activity->module ) ); ?>
			</strong>

			<br>

			Action:
			<?php echo esc_html( ucfirst( $activity->action ) ); ?>

			<br>

			<?php echo esc_html( $activity->description ); ?>

			<br>

			<small>
				<?php
				echo esc_html(
					wp_date(
						get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
						strtotime( $activity->created_at )
					)
				);
				?>
			</small>

		</li>

	<?php endforeach; ?>
	</ul>

<?php endif; ?>

<?php CASBEN_UI::card_end(); ?>