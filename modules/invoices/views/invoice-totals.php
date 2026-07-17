<?php
/**
 * Invoice Totals View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2>

	<?php
	esc_html_e(
		'Invoice Totals',
		'casben-business-suite'
	);
	?>

</h2>

<table
	class="widefat"
	style="max-width:500px;margin-left:auto;"
>

	<tbody>

		<tr>

			<th>

				<?php
				esc_html_e(
					'Subtotal',
					'casben-business-suite'
				);
				?>

			</th>

			<td>

				<input
					type="number"
					id="casben-subtotal"
					name="subtotal"
					value="<?php echo esc_attr( $totals['subtotal'] ); ?>"
					step="0.01"
					class="regular-text"
					readonly
				>

			</td>

		</tr>

		<tr>

			<th>

				<?php
				esc_html_e(
					'Discount',
					'casben-business-suite'
				);
				?>

			</th>

			<td>

				<input
					type="number"
					id="casben-discount-total"
					name="discount_total"
					value="<?php echo esc_attr( $totals['discount_total'] ); ?>"
					step="0.01"
					class="regular-text"
					readonly
				>

			</td>

		</tr>

		<tr>

			<th>

				<?php
				esc_html_e(
					'Tax',
					'casben-business-suite'
				);
				?>

			</th>

			<td>

				<input
					type="number"
					id="casben-tax-total"
					name="tax_total"
					value="<?php echo esc_attr( $totals['tax_total'] ); ?>"
					step="0.01"
					class="regular-text"
					readonly
				>

			</td>

		</tr>

		<tr>

			<th>

				<strong>

					<?php
					esc_html_e(
						'Grand Total',
						'casben-business-suite'
					);
					?>

				</strong>

			</th>

			<td>

				<input
					type="number"
					id="casben-grand-total"
					name="grand_total"
					value="<?php echo esc_attr( $totals['grand_total'] ); ?>"
					step="0.01"
					class="regular-text"
					readonly
				>

			</td>

		</tr>

	</tbody>

</table>