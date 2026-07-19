<?php
/**
 * Customer Admin
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Customers_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Menu registration is handled by CASBEN_Admin_Menu.
	}

	/**
	 * Customers page.
	 */
	public function customers_page() {

		$action = isset( $_GET['action'] ) ? sanitize_key( wp_unslash( $_GET['action'] ) ) : '';

		?>

		<div class="wrap">

			<?php if ( empty( $action ) ) : ?>


		<?php endif; ?>

			<hr class="wp-header-end">

			<?php
		

		$message = isset( $_GET['message'] )
			? sanitize_key( wp_unslash( $_GET['message'] ) )
			: '';

		$count = isset( $_GET['count'] )
			? absint( wp_unslash( $_GET['count'] ) )
			: 0;

		if ( 'saved' === $message ) :
		?>

<div class="notice notice-success is-dismissible">
	<p><?php esc_html_e( 'Customer added successfully.', 'casben-business-suite' ); ?></p>
</div>

<?php elseif ( 'updated' === $message ) : ?>

<div class="notice notice-success is-dismissible">
	<p><?php esc_html_e( 'Customer updated successfully.', 'casben-business-suite' ); ?></p>
</div>

<?php elseif ( 'deleted' === $message ) : ?>

<div class="notice notice-success is-dismissible">
	<p><?php esc_html_e( 'Customer deleted successfully.', 'casben-business-suite' ); ?></p>
</div>

<?php elseif ( 'bulk_deleted' === $message ) : ?>

<div class="notice notice-success is-dismissible">
	<p>
		<?php
		printf(
			esc_html(
				_n(
					'%d customer deleted successfully.',
					'%d customers deleted successfully.',
					$count,
					'casben-business-suite'
				)
			),
			$count
		);
		?>
	</p>
</div>

<?php elseif ( 'bulk_activated' === $message ) : ?>

<div class="notice notice-success is-dismissible">
	<p>
		<?php
		printf(
			esc_html(
				_n(
					'%d customer activated successfully.',
					'%d customers activated successfully.',
					$count,
					'casben-business-suite'
				)
			),
			$count
		);
		?>
	</p>
</div>

<?php elseif ( 'bulk_deactivated' === $message ) : ?>

<div class="notice notice-success is-dismissible">
	<p>
		<?php
		printf(
			esc_html(
				_n(
					'%d customer deactivated successfully.',
					'%d customers deactivated successfully.',
					$count,
					'casben-business-suite'
				)
			),
			$count
		);
		?>
	</p>
</div>

<?php endif; ?>
			<?php

			if ( 'add' === $action || 'edit' === $action ) {

	$form = new CASBEN_Customer_Form();
	$form->display();

} else {

	$list_table = new CASBEN_Customer_List();

	//$list_table->process_bulk_action();
	
	$list_table->prepare_items();
	
	
	?>

			<?php

		CASBEN_UI::page_toolbar(
			array(
				'title'       => __( 'Customers', 'casben-business-suite' ),
				'description' => __( 'Manage your customer records.', 'casben-business-suite' ),

				'actions' => array(

					CASBEN_Btn::add(
						__( 'Customer', 'casben-business-suite' ),
						admin_url( 'admin.php?page=casben-customers&action=add' )
					),

					CASBEN_Btn::print_list( '#' ),

					CASBEN_Btn::export( '#' ),

					CASBEN_Btn::import( '#' ),

					CASBEN_Btn::dashboard(
						admin_url( 'admin.php?page=casben-business-suite' )
					),

				),
			)
		);

		?> 
		
		<?
		$list_table->display();

		
		?>

	</form>

	<?php
}

			?>

		</div>

		<?php
	}
}