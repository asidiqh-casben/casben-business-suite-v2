<?php
/**
 * Recent Invoices Widget
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

CASBEN_UI::card_start(
	__( 'Recent Invoices', 'casben-business-suite' ),
	'casben-widget-large',
	'dashicons-media-spreadsheet'
);
?>

<?php if ( empty( $recent_invoices ) ) : ?>

	<p>
		<?php esc_html_e(
			'No invoices found.',
			'casben-business-suite'
		); ?>
	</p>

<?php else : ?>

	<table class="widefat striped">

		<thead>

			<tr>
				<th><?php esc_html_e( 'Invoice', 'casben-business-suite' ); ?></th>
				<th><?php esc_html_e( 'Customer', 'casben-business-suite' ); ?></th>
				<th><?php esc_html_e( 'Date', 'casben-business-suite' ); ?></th>
				<th><?php esc_html_e( 'Total', 'casben-business-suite' ); ?></th>
				<th><?php esc_html_e( 'Status', 'casben-business-suite' ); ?></th>
			</tr>

		</thead>

		<tbody>

		<?php foreach ( $recent_invoices as $invoice ) : ?>

			<tr>

				<td>
					<?php echo esc_html( $invoice['invoice_number'] ); ?>
				</td>

				<td>
					<?php
					echo esc_html(
						! empty( $invoice['customer_name'] )
							? $invoice['customer_name']
							: __( 'Unknown Customer', 'casben-business-suite' )
					);
					?>
				</td>

				<td>
					<?php
					echo esc_html(
						wp_date(
							get_option( 'date_format' ),
							strtotime( $invoice['invoice_date'] )
						)
					);
					?>
				</td>

				<td>
					<?php
					echo esc_html(
						number_format_i18n(
							(float) $invoice['grand_total'],
							2
						)
					);
					?>
				</td>

				<td>
					<?php echo esc_html( $invoice['status'] ); ?>
				</td>

			</tr>

		<?php endforeach; ?>

		</tbody>

	</table>

	<p class="casben-widget-footer">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-invoices' ) ); ?>">
			<?php esc_html_e( 'View All Invoices', 'casben-business-suite' ); ?>
		</a>
	</p>

<?php endif; ?>

<?php CASBEN_UI::card_end(); ?>