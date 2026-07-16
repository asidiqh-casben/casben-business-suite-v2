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
	 * Render invoice form.
	 *
	 * @return void
	 */
	public static function render() {

	$model = new CASBEN_Invoice();

	$is_edit = false;

	$invoice = null;

	$invoice_items = array();

	if (
		isset( $_GET['action'], $_GET['id'] ) &&
		'edit' === sanitize_key( wp_unslash( $_GET['action'] ) )
	) {

		$is_edit = true;

		$invoice_id = absint(
			wp_unslash( $_GET['id'] )
		);

		$invoice = $model->get( $invoice_id );

		$invoice_items = $model->get_items( $invoice_id );
	}

	$customers = CASBEN_Invoice_Data::get_customers();

	$products = CASBEN_Invoice_Data::get_products();

		?>

		<div class="wrap">

			<h1>

	<?php

	echo esc_html(
		$is_edit
			? __( 'Edit Invoice', 'casben-business-suite' )
			: __( 'Add New Invoice', 'casben-business-suite' )
	);

	?>

	</h1>


			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">


				<?php

				wp_nonce_field(
					'casben_save_invoice',
					'casben_invoice_nonce'
				);

				?>


				<input type="hidden" name="action" value="casben_save_invoice">

				<?php if ( $is_edit ) : ?>

				<input
					type="hidden"
					name="invoice_id"
					value="<?php echo esc_attr( $invoice->id ); ?>"
					>

				<?php endif; ?>

					<?php

				self::load_view(
					'invoice-header',
					array(
						'invoice'   => $invoice,
						'customers' => $customers,
						'is_edit'   => $is_edit,
					)
				);

				?>



				<h2>
					<?php esc_html_e( 'Invoice Items', 'casben-business-suite' ); ?>
				</h2>



				<?php

				self::load_view(
					'invoice-items',
					array(
						'invoice'  => $invoice,
						'items'    => $invoice_items,
						'products' => $products,
						'is_edit'  => $is_edit,
					)
				);

				?>

				<?php

				self::load_view(
    'invoice-actions',
    array(
        'is_edit' => $is_edit,
    )
);

				?>


			</form>


		</div>


		<?php

	}


	/**
	 * Get customers.
	 *
	 * @return array
	 */
	private static function get_customers() {

	global $wpdb;

	$table = $wpdb->prefix . 'casben_customers';


	return $wpdb->get_results(
		"SELECT id, company_name
		FROM {$table}
		ORDER BY company_name ASC"
	);
}



	/**
	 * Get products.
	 *
	 * @return array
	 */
	private static function get_products() {

		global $wpdb;

		$table = $wpdb->prefix . 'casben_products';


		return $wpdb->get_results(
			"SELECT id, product_name
			FROM {$table}
			WHERE status = 1
			ORDER BY product_name ASC"
		);
	}
						/**
	 * Load invoice view file.
	 *
	 * @param string $view View name.
	 * @param array  $args Variables.
	 *
	 * @return void
	 */
	private static function load_view( $view, $args = array() ) {

	$file = CASBEN_PLUGIN_DIR . 'modules/invoices/views/' . $view . '.php';

	echo '<p><strong>Looking for:</strong> ' . esc_html( $file ) . '</p>';

	if ( file_exists( $file ) ) {

		echo '<p style="color:green;">FOUND: ' . esc_html( $view ) . '</p>';

		extract( $args );

		include $file;

	} else {

		echo '<p style="color:red;">NOT FOUND: ' . esc_html( $view ) . '</p>';
	}
}



}
