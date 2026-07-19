<?php
/**
 * FBR Status Widget
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

CASBEN_UI::card_start(
	__( 'FBR Integration Status', 'casben-business-suite' ),
	'casben-widget-small',
	'dashicons-cloud'
);
?>

<ul class="casben-status-list">

	<li>
		<strong>
			<?php esc_html_e( 'Connection:', 'casben-business-suite' ); ?>
		</strong>

		<?php echo $fbr_status['connected']
			? esc_html__( 'Ready', 'casben-business-suite' )
			: esc_html__( 'Not Connected', 'casben-business-suite' );
		?>
	</li>

	<li>
		<strong>
			<?php esc_html_e( 'Pending:', 'casben-business-suite' ); ?>
		</strong>

		<?php echo esc_html( $fbr_status['pending'] ); ?>
	</li>

	<li>
		<strong>
			<?php esc_html_e( 'Successful:', 'casben-business-suite' ); ?>
		</strong>

		<?php echo esc_html( $fbr_status['success'] ); ?>
	</li>

	<li>
		<strong>
			<?php esc_html_e( 'Failed:', 'casben-business-suite' ); ?>
		</strong>

		<?php echo esc_html( $fbr_status['failed'] ); ?>
	</li>

	<?php if ( ! empty( $fbr_status['last_sync'] ) ) : ?>

	<li>
		<strong>
			<?php esc_html_e( 'Last Activity:', 'casben-business-suite' ); ?>
		</strong>

		<?php
		echo esc_html(
			wp_date(
				get_option( 'date_format' ),
				strtotime( $fbr_status['last_sync'] )
			)
		);
		?>

	</li>

	<?php endif; ?>

</ul>

<?php CASBEN_UI::card_end(); ?>