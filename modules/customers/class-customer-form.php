<?php
/**
 * Customer Form
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Customer_Form {

	/**
	 * Display customer form.
	 */
	public function display() {
		?>
		<div class="wrap">

			<h1><?php esc_html_e( 'Add Customer', 'casben-business-suite' ); ?></h1>

			<form method="post">

				<?php wp_nonce_field( 'casben_save_customer', 'casben_customer_nonce' ); ?>

				<table class="form-table">

					<tr>
						<th><label for="customer_code">Customer Code</label></th>
						<td>
							<input type="text" id="customer_code" name="customer_code" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="company_name">Company Name <span style="color:red">*</span></label></th>
						<td>
							<input type="text" id="company_name" name="company_name" class="regular-text" required>
						</td>
					</tr>

					<tr>
						<th><label for="contact_person">Contact Person</label></th>
						<td>
							<input type="text" id="contact_person" name="contact_person" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="designation">Designation</label></th>
						<td>
							<input type="text" id="designation" name="designation" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="phone">Phone</label></th>
						<td>
							<input type="text" id="phone" name="phone" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="mobile">Mobile</label></th>
						<td>
							<input type="text" id="mobile" name="mobile" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="email">Email</label></th>
						<td>
							<input type="email" id="email" name="email" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="website">Website</label></th>
						<td>
							<input type="url" id="website" name="website" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="ntn">NTN</label></th>
						<td>
							<input type="text" id="ntn" name="ntn" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="strn">STRN</label></th>
						<td>
							<input type="text" id="strn" name="strn" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="address">Address</label></th>
						<td>
							<textarea id="address" name="address" rows="4" class="large-text"></textarea>
						</td>
					</tr>

					<tr>
						<th><label for="city">City</label></th>
						<td>
							<input type="text" id="city" name="city" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="province">Province</label></th>
						<td>
							<input type="text" id="province" name="province" class="regular-text">
						</td>
					</tr>

					<tr>
						<th><label for="country">Country</label></th>
						<td>
							<input type="text" id="country" name="country" value="Pakistan" class="regular-text">
						</td>
					</tr>

				</table>

				<?php submit_button( 'Save Customer' ); ?>

			</form>

		</div>
		<?php
	}
}