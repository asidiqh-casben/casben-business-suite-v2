<?php
/**
 * Invoice Header View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2>
	<?php esc_html_e(
		'Invoice Information',
		'casben-business-suite'
	); ?>
</h2>

<table class="form-table">

	<tbody>

		<tr>

			<th>
				<label for="invoice_number">
					<?php esc_html_e(
						'Invoice Number',
						'casben-business-suite'
					); ?>
				</label>
			</th>

			<td>

				<input
					type="text"
					id="invoice_number"
					value="<?php echo esc_attr( $invoice->invoice_number ); ?>"
					class="regular-text"
					readonly
				>

			</td>

		</tr>

		<tr>

			<th>
				<label for="invoice_date">
					<?php esc_html_e(
						'Invoice Date',
						'casben-business-suite'
					); ?>
				</label>
			</th>

			<td>

				<input
					type="date"
					id="invoice_date"
					name="invoice_date"
					value="<?php echo esc_attr( $invoice->invoice_date ); ?>"
					required
				>

			</td>

		</tr>

		<tr>

			<th>
				<label for="due_date">
					<?php esc_html_e(
						'Due Date',
						'casben-business-suite'
					); ?>
				</label>
			</th>

			<td>

				<input
					type="date"
					id="due_date"
					name="due_date"
					value="<?php echo esc_attr( $invoice->due_date ); ?>"
				>

			</td>

		</tr>

		<tr>

			<th>
				<label for="customer_id">
					<?php esc_html_e(
						'Customer',
						'casben-business-suite'
					); ?>
				</label>
			</th>

			<td>

				<select
					id="customer_id"
					name="customer_id"
					required
				>

					<option value="">
						<?php esc_html_e(
							'Select Customer',
							'casben-business-suite'
						); ?>
					</option>

					<?php foreach ( $customers as $customer ) : ?>

						<option
							value="<?php echo esc_attr( $customer->id ); ?>"
							<?php selected(
								$invoice->customer_id,
								$customer->id
							); ?>
						>

							<?php
							echo esc_html(
								$customer->company_name
							);
							?>

						</option>

					<?php endforeach; ?>

				</select>

			</td>

		</tr>

		<tr>

			<th>
				<label for="status">
					<?php esc_html_e(
						'Status',
						'casben-business-suite'
					); ?>
				</label>
			</th>

			<td>

				<select
					id="status"
					name="status"
				>

					<option value="draft"
						<?php selected(
							$invoice->status,
							'draft'
						); ?>
					>
						<?php esc_html_e(
							'Draft',
							'casben-business-suite'
						); ?>
					</option>

					<option value="sent"
						<?php selected(
							$invoice->status,
							'sent'
						); ?>
					>
						<?php esc_html_e(
							'Sent',
							'casben-business-suite'
						); ?>
					</option>

					<option value="paid"
						<?php selected(
							$invoice->status,
							'paid'
						); ?>
					>
						<?php esc_html_e(
							'Paid',
							'casben-business-suite'
						); ?>
					</option>

					<option value="cancelled"
						<?php selected(
							$invoice->status,
							'cancelled'
						); ?>
					>
						<?php esc_html_e(
							'Cancelled',
							'casben-business-suite'
						); ?>
					</option>

				</select>

			</td>

		</tr>

	</tbody>

</table>