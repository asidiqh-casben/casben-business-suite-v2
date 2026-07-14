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


			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">


				<?php
				wp_nonce_field(
					'casben_save_invoice',
					'casben_invoice_nonce'
				);
				?>


				<input
					type="hidden"
					name="action"
					value="casben_save_invoice"
				>


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
							<label for="due_date">
								<?php esc_html_e( 'Due Date', 'casben-business-suite' ); ?>
							</label>
						</th>

						<td>

							<input
								type="date"
								name="due_date"
								id="due_date"
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

							<select
								name="customer_id"
								id="customer_id"
								required
							>

								<option value="">
									<?php esc_html_e( 'Select Customer', 'casben-business-suite' ); ?>
								</option>


							</select>

						</td>

					</tr>



					<tr>

						<th>
							<label for="notes">
								<?php esc_html_e( 'Notes', 'casben-business-suite' ); ?>
							</label>
						</th>


						<td>

							<textarea
								name="notes"
								id="notes"
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

							<th>
								<?php esc_html_e( 'Product ID', 'casben-business-suite' ); ?>
							</th>

							<th>
								<?php esc_html_e( 'Description', 'casben-business-suite' ); ?>
							</th>

							<th>
								<?php esc_html_e( 'Quantity', 'casben-business-suite' ); ?>
							</th>

							<th>
								<?php esc_html_e( 'Unit Price', 'casben-business-suite' ); ?>
							</th>

							<th>
								<?php esc_html_e( 'Discount', 'casben-business-suite' ); ?>
							</th>

							<th>
								<?php esc_html_e( 'Tax %', 'casben-business-suite' ); ?>
							</th>

						</tr>


					</thead>



					<tbody>


						<tr>


							<td>

								<input
									type="number"
									name="items[0][product_id]"
									value=""
								>

							</td>



							<td>

								<input
									type="text"
									name="items[0][description]"
									value=""
									required
								>

							</td>



							<td>

								<input
									type="number"
									step="0.001"
									name="items[0][quantity]"
									value="1"
									required
								>

							</td>



							<td>

								<input
									type="number"
									step="0.01"
									name="items[0][unit_price]"
									value="0"
									required
								>

							</td>



							<td>

								<input
									type="number"
									step="0.01"
									name="items[0][discount_amount]"
									value="0"
								>

							</td>



							<td>

								<input
									type="number"
									step="0.01"
									name="items[0][tax_rate]"
									value="18"
								>

							</td>


						</tr>


					</tbody>


				</table>



				<?php
				submit_button(
					__( 'Save Invoice', 'casben-business-suite' )
				);
				?>


			</form>


		</div>


		<?php

	}

}