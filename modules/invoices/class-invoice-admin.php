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
			? sanitize_key( wp_unslash( $_GET['action'] ) )
			: '';

		/*
		 * Add invoice form.
		 */
		if ( 'add' === $action ) {

			CASBEN_Invoice_Form::render();

			return;
		}


		/*
		 * Invoice list.
		 */
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
		}


		$list_table = new CASBEN_Invoice_List();

		$list_table->prepare_items();

		?>

		<div class="wrap">

			<h1 class="wp-heading-inline">
				<?php esc_html_e( 'Invoices', 'casben-business-suite' ); ?>
			</h1>


			<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-invoices&action=add' ) ); ?>" class="page-title-action">

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