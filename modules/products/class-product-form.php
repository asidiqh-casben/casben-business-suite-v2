<?php
/**
 * Product Form
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Product_Form {

	/**
	 * Display product form.
	 */
	public function display() {

		global $wpdb;

		$is_edit = false;
		$product = array();

		$product_id = isset( $_GET['product'] )
			? absint( wp_unslash( $_GET['product'] ) )
			: 0;

		if ( $product_id > 0 ) {

			$is_edit = true;

			$table = $wpdb->prefix . 'casben_products';

			$product = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM {$table} WHERE id = %d",
					$product_id
				),
				ARRAY_A
			);

			if ( ! is_array( $product ) ) {
				$product = array();
			}
		}

		$product_code_value = $is_edit
			? ( $product['product_code'] ?? '' )
			: __( 'Auto Generated', 'casben-business-suite' );
		?>

		<div class="wrap">

			<h1>
				<?php
				echo esc_html(
					$is_edit
						? __( 'Edit Product', 'casben-business-suite' )
						: __( 'Add Product', 'casben-business-suite' )
				);
				?>
			</h1>

			<form method="post">

				<?php wp_nonce_field( 'casben_save_product', 'casben_product_nonce' ); ?>

				<input
					type="hidden"
					name="product_id"
					value="<?php echo esc_attr( $product_id ); ?>"
				>

				<table class="form-table">

					<tr>
						<th>
							<label for="product_code">
								<?php esc_html_e( 'Product Code', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="product_code"
								name="product_code"
								class="regular-text"
								value="<?php echo esc_attr( $product_code_value ); ?>"
								readonly
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="product_name">
								<?php esc_html_e( 'Product Name', 'casben-business-suite' ); ?>
								<span style="color:red">*</span>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="product_name"
								name="product_name"
								class="regular-text"
								value="<?php echo esc_attr( $product['product_name'] ?? '' ); ?>"
								required
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="grade">
								<?php esc_html_e( 'Grade', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<input
								type="text"
								id="grade"
								name="grade"
								class="regular-text"
								value="<?php echo esc_attr( $product['grade'] ?? '' ); ?>"
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="description">
								<?php esc_html_e( 'Description', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<textarea
								id="description"
								name="description"
								rows="4"
								class="large-text"
							><?php echo esc_textarea( $product['description'] ?? '' ); ?></textarea>
						</td>
					</tr>

					<tr>
						<th>
							<label for="unit">
								<?php esc_html_e( 'Unit', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<select id="unit" name="unit" required>
								<option value="Piece" <?php selected( $product['unit'] ?? '', 'Piece' ); ?>>
									<?php esc_html_e( 'Piece', 'casben-business-suite' ); ?>
								</option>
								<option value="Kg" <?php selected( $product['unit'] ?? '', 'Kg' ); ?>>
									<?php esc_html_e( 'Kg', 'casben-business-suite' ); ?>
								</option>
								<option value="M.Ton" <?php selected( $product['unit'] ?? '', 'M.Ton' ); ?>>
									<?php esc_html_e( 'M.Ton', 'casben-business-suite' ); ?>
								</option>
								<option value="Meter" <?php selected( $product['unit'] ?? '', 'Meter' ); ?>>
									<?php esc_html_e( 'Meter', 'casben-business-suite' ); ?>
								</option>
								<option value="Foot" <?php selected( $product['unit'] ?? '', 'Foot' ); ?>>
									<?php esc_html_e( 'Foot', 'casben-business-suite' ); ?>
								</option>
								<option value="Inch" <?php selected( $product['unit'] ?? '', 'Inch' ); ?>>
									<?php esc_html_e( 'Inch', 'casben-business-suite' ); ?>
								</option>
								<option value="Sheet" <?php selected( $product['unit'] ?? '', 'Sheet' ); ?>>
									<?php esc_html_e( 'Sheet', 'casben-business-suite' ); ?>
								</option>
								<option value="Bundle" <?php selected( $product['unit'] ?? '', 'Bundle' ); ?>>
									<?php esc_html_e( 'Bundle', 'casben-business-suite' ); ?>
								</option>
								<option value="Box" <?php selected( $product['unit'] ?? '', 'Box' ); ?>>
									<?php esc_html_e( 'Box', 'casben-business-suite' ); ?>
								</option>
								<option value="Roll" <?php selected( $product['unit'] ?? '', 'Roll' ); ?>>
									<?php esc_html_e( 'Roll', 'casben-business-suite' ); ?>
								</option>
								<option value="Set" <?php selected( $product['unit'] ?? '', 'Set' ); ?>>
									<?php esc_html_e( 'Set', 'casben-business-suite' ); ?>
								</option>
							</select>
						</td>
					</tr>

					<tr>
						<th>
							<label for="unit_price">
								<?php esc_html_e( 'Unit Price', 'casben-business-suite' ); ?>
								<span style="color:red">*</span>
							</label>
						</th>
						<td>
							<input
								type="number"
								step="0.01"
								min="0"
								id="unit_price"
								name="unit_price"
								class="regular-text"
								value="<?php echo esc_attr( $product['unit_price'] ?? '' ); ?>"
								required
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="sales_tax">
								<?php esc_html_e( 'Sales Tax (%)', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<input
								type="number"
								step="0.01"
								min="0"
								id="sales_tax"
								name="sales_tax"
								class="regular-text"
								value="<?php echo esc_attr( $product['sales_tax'] ?? '18.00' ); ?>"
							>
						</td>
					</tr>

					<tr>
						<th>
							<label for="status">
								<?php esc_html_e( 'Status', 'casben-business-suite' ); ?>
							</label>
						</th>
						<td>
							<select id="status" name="status">
								<option value="1" <?php selected( $product['status'] ?? 1, 1 ); ?>>
									<?php esc_html_e( 'Active', 'casben-business-suite' ); ?>
								</option>
								<option value="0" <?php selected( $product['status'] ?? 1, 0 ); ?>>
									<?php esc_html_e( 'Inactive', 'casben-business-suite' ); ?>
								</option>
							</select>
						</td>
					</tr>

				</table>

				<p class="submit">

					<button type="submit" name="casben_action" value="save" class="button button-primary">
						
					<?php
						echo esc_html(
						$is_edit
						? __( 'Update Product', 'casben-business-suite' )
						: __( 'Save Product', 'casben-business-suite' )
						);
					?>
					</button>

					<button type="submit" name="casben_action" value="save_new" class="button">
						<?php esc_html_e( 'Save & New', 'casben-business-suite' ); ?>
					</button>

					<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-products' ) ); ?>" class="button">
						<?php esc_html_e( 'Cancel', 'casben-business-suite' ); ?>
					</a>

				</p>

			</form>

		</div>

		<?php
	}
}