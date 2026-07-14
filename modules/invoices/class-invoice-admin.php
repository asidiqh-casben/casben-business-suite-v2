<?php
/**
 * Invoice Admin
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Invoice_Admin {


	/**
	 * Display invoices page.
	 *
	 * @return void
	 */
	public function invoices_page() {


		$action = isset( $_GET['action'] )
			? sanitize_key(
				wp_unslash( $_GET['action'] )
			)
			: '';

			$message = isset( $_GET['message'] )
			? sanitize_key(
				wp_unslash( $_GET['message'] )
			)
			: '';

		if ( 'saved' === $message ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p>
					<?php esc_html_e(
						'Invoice saved successfully.',
						'casben-business-suite'
					); ?>
				</p>
			</div>
			<?php
		}

		if ( 'error' === $message ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php esc_html_e(
						'Unable to save invoice.',
						'casben-business-suite'
					); ?>
				</p>
			</div>
			<?php
		}

		/**
		 * Add invoice.
		 */
		if ( 'add' === $action ) {

			CASBEN_Invoice_Form::render();

			return;
		}


		/**
		 * Load list table.
		 */
		if ( ! class_exists( 'CASBEN_Invoice_List' ) ) {

			require_once CASBEN_PLUGIN_DIR . 'modules/invoices/class-invoice-list.php';
		}


		$list_table = new CASBEN_Invoice_List();


		$list_table->prepare_items();


		?>

		<div class="wrap">


			<h1 class="wp-heading-inline">

				<?php esc_html_e( 'Invoices', 'casben-business-suite' ); ?>

			</h1>


			<a href="<?php echo esc_url(
				admin_url(
					'admin.php?page=casben-invoices&action=add'
				)
			); ?>"
			class="page-title-action">

				<?php esc_html_e( 'Add New', 'casben-business-suite' ); ?>

			</a>


			<hr class="wp-header-end">


			<form method="get">


				<input type="hidden" name="page" value="casben-invoices">


				<?php

				$list_table->search_box(
					__( 'Search Invoices', 'casben-business-suite' ),
					'casben-invoices'
				);


				$list_table->display();

				?>


			</form>


		</div>


		<?php
	}
}