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

global $wpdb;

$is_edit = false;
$customer = array();

$customer_id = isset( $_GET['customer'] )
	? absint( wp_unslash( $_GET['customer'] ) )
	: 0;

if ( $customer_id > 0 ) {

	$is_edit = true;

	$table = $wpdb->prefix . 'casben_customers';

	$customer = $wpdb->get_row(
		$wpdb->prepare(
			"SELECT * FROM {$table} WHERE id = %d",
			$customer_id
		),
		ARRAY_A
	);

	if ( ! is_array( $customer ) ) {
		$customer = array();
	}
}
		?>
		<div class="wrap">

			<h1>
				<?php
					echo esc_html(
					$is_edit
						? __( 'Edit Customer', 'casben-business-suite' )
						: __( 'Add Customer', 'casben-business-suite' )
					);
				?>
			</h1>

			<form method="post">

				<?php wp_nonce_field( 'casben_save_customer', 'casben_customer_nonce' ); ?>
<input
	type="hidden"
	name="customer_id"
	value="<?php echo esc_attr( $customer_id ); ?>"
>

				<table class="form-table">

					<tr>
						<th>
							<label for="customer_code">
								<?php esc_html_e( 'Customer Code', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="customer_code"
								name="customer_code"
								class="regular-text"
								value="<?php echo esc_attr( $customer['customer_code'] ?? '' ); ?>"
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="company_name">
								<?php esc_html_e( 'Company Name', 'casben-business-suite' ); ?>
								<span style="color:red">*</span>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="company_name"
								name="company_name"
								class="regular-text"
								value="<?php echo esc_attr( $customer['company_name'] ?? '' ); ?>"
								required
							>
						</td>
					</tr>

					<tr>
						<th><label for="contact_person"><?php esc_html_e( 'Contact Person', 'casben-business-suite' ); ?></label></th>
						<td>
							<input
								type="text"
								id="contact_person"
								name="contact_person"
								class="regular-text"
								value="<?php echo esc_attr( $customer['contact_person'] ?? '' ); ?>"
							>
						</td>
					</tr>

					<tr>
						<th><label for="designation"><?php esc_html_e( 'Designation', 'casben-business-suite' ); ?></label></th>
						<td><input 
								type="text" 
								id="designation" 
								name="designation" 
								class="regular-text"
								value="<?php echo esc_attr( $customer['designation'] ?? '' ); ?>"		
							>
						</td>
					</tr>

					<tr>
						<th><label for="phone"><?php esc_html_e( 'Phone', 'casben-business-suite' ); ?></label></th>
						<td>
							<input 
								type="text" 
								id="phone" 
								name="phone" 
								class="regular-text"
								value="<?php echo esc_attr( $customer['phone'] ?? '' ); ?>"
							>

						</td>
					</tr>

					<tr>
						<th><label for="mobile"><?php esc_html_e( 'Mobile', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="mobile" name="mobile" class="regular-text" value="<?php echo esc_attr( $customer['mobile'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="email"><?php esc_html_e( 'Email', 'casben-business-suite' ); ?></label></th>
						<td><input type="email" id="email" name="email" class="regular-text" value="<?php echo esc_attr( $customer['email'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="website"><?php esc_html_e( 'Website', 'casben-business-suite' ); ?></label></th>
						<td><input type="url" id="website" name="website" class="regular-text" value="<?php echo esc_attr( $customer['website'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="ntn"><?php esc_html_e( 'NTN', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="ntn" name="ntn" class="regular-text" value="<?php echo esc_attr( $customer['ntn'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="strn"><?php esc_html_e( 'STRN', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="strn" name="strn" class="regular-text" value="<?php echo esc_attr( $customer['strn'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="address"><?php esc_html_e( 'Address', 'casben-business-suite' ); ?></label></th>
						<td><textarea id="address" name="address" rows="4" class="large-text"><?php echo esc_textarea( $customer['address'] ?? '' ); ?></textarea></td>
					</tr>

					<tr>
						<th><label for="city"><?php esc_html_e( 'City', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="city" name="city" class="regular-text" value="<?php echo esc_attr( $customer['city'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="province"><?php esc_html_e( 'Province', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="province" name="province" class="regular-text" value="<?php echo esc_attr( $customer['province'] ?? '' ); ?>"></td>
					</tr>

					<tr>
						<th><label for="country"><?php esc_html_e( 'Country', 'casben-business-suite' ); ?></label></th>
						<td><input type="text" id="country" name="country" value="<?php echo esc_attr( $customer['country'] ?? 'Pakistan' ); ?>" class="regular-text" ></td>
					</tr>

				</table>

				<p class="submit">

					<button type="submit" name="casben_action" value="save" class="button button-primary">
						<?php
							echo esc_html(
							$is_edit
								? __( 'Update Customer', 'casben-business-suite' )
								: __( 'Save Customer', 'casben-business-suite' )
							);
						?>
					</button>

					<button type="submit" name="casben_action" value="save_new" class="button">
						<?php esc_html_e( 'Save & New', 'casben-business-suite' ); ?>
					</button>

					<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-customers' ) ); ?>" class="button">
						<?php esc_html_e( 'Cancel', 'casben-business-suite' ); ?>
					</a>

				</p>

			</form>

		</div>
		<?php
	}
}