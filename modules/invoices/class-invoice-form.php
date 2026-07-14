<?php
/**
 * Invoice Form
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Form {

	/**
	 * Display invoice form.
	 *
	 * @return void
	 */
	public static function render() {

		?>

		<div class="wrap">

			<h1>
				<?php esc_html_e( 'Add New Invoice', 'casben-business-suite' ); ?>
			</h1>


			<form method="post" action="">

				<table class="form-table">

					<tr>
						<th>
							<label for="invoice_date">
								<?php esc_html_e( 'Invoice Date', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>
							<input
								type="date"
								name="invoice_date"
								id="invoice_date"
								value="<?php echo esc_attr( current_time( 'Y-m-d' ) ); ?>"
								required
							>
						</td>
					</tr>


					<tr>
						<th>
							<label for="customer_id">
								<?php esc_html_e( 'Customer', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>
							<select name="customer_id" id="customer_id" required>

								<option value="">
									<?php esc_html_e( 'Select Customer', 'casben-business-suite' ); ?>
								</option>

							</select>
						</td>

					</tr>


					<tr>
						<th>
							<label for="invoice_type">
								<?php esc_html_e( 'Invoice Type', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>

							<select name="invoice_type">

								<option value="SALE">
									<?php esc_html_e( 'Sale', 'casben-business-suite' ); ?>
								</option>

								<option value="DEBIT_NOTE">
									<?php esc_html_e( 'Debit Note', 'casben-business-suite' ); ?>
								</option>

								<option value="CREDIT_NOTE">
									<?php esc_html_e( 'Credit Note', 'casben-business-suite' ); ?>
								</option>

							</select>

						</td>

					</tr>


					<tr>

						<th>
							<label for="supply_type">
								<?php esc_html_e( 'Supply Type', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>

							<select name="supply_type">

								<option value="GOODS">
									<?php esc_html_e( 'Goods', 'casben-business-suite' ); ?>
								</option>

								<option value="SERVICES">
									<?php esc_html_e( 'Services', 'casben-business-suite' ); ?>
								</option>

							</select>

						</td>

					</tr>


					<tr>

						<th>
							<label for="remarks">
								<?php esc_html_e( 'Remarks', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>

							<textarea
								name="remarks"
								id="remarks"
								rows="4"
								cols="50"
							></textarea>

						</td>

					</tr>

				</table>


				<h2>
					<?php esc_html_e( 'Invoice Items', 'casben-business-suite' ); ?>
				</h2>


				<table class="widefat">

					<thead>

						<tr>
							<th><?php esc_html_e( 'Product', 'casben-business-suite' ); ?></th>
							<th><?php esc_html_e( 'Quantity', 'casben-business-suite' ); ?></th>
							<th><?php esc_html_e( 'Unit Price', 'casben-business-suite' ); ?></th>
							<th><?php esc_html_e( 'Tax %', 'casben-business-suite' ); ?></th>
							<th><?php esc_html_e( 'Total', 'casben-business-suite' ); ?></th>
						</tr>

					</thead>


					<tbody>

						<tr>

							<td>
								<select name="product_id[]">
									<option value="">
										<?php esc_html_e( 'Select Product', 'casben-business-suite' ); ?>
									</option>
								</select>
							</td>


							<td>
								<input type="number" name="quantity[]" value="1">
							</td>


							<td>
								<input type="number" step="0.01" name="unit_price[]" value="0">
							</td>


							<td>
								<input type="number" step="0.01" name="tax_rate[]" value="18">
							</td>


							<td>
								<input type="number" step="0.01" name="line_total[]" value="0">
							</td>

						</tr>

					</tbody>

				</table>


				<?php submit_button( __( 'Save Invoice', 'casben-business-suite' ) ); ?>


			</form>

		</div>

		<?php

	}

}