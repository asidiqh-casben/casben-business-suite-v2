<?php
/**
 * Invoice Status Widget
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

CASBEN_UI::card_start(
	__( 'Invoice Status', 'casben-business-suite' ),
	'casben-widget-small',
	'dashicons-chart-pie'
);
?>

<?php if ( empty( $invoice_status ) ) : ?>

	<p>
		<?php esc_html_e(
			'No invoice status data available.',
			'casben-business-suite'
		); ?>
	</p>

<?php else : ?>

	<ul class="casben-status-list">

		<?php foreach ( $invoice_status as $status => $total ) : ?>

			<li>
				<strong>
					<?php echo esc_html( $status ); ?>:
				</strong>

				<?php echo esc_html( $total ); ?>
			</li>

		<?php endforeach; ?>

	</ul>

<?php endif; ?>

<?php CASBEN_UI::card_end(); ?>