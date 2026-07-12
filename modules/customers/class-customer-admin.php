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

			<h1 class="wp-heading-inline">
				<?php esc_html_e( 'Customers', 'casben-business-suite' ); ?>
			</h1>

			<?php if ( empty( $action ) ) : ?>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-customers&action=add' ) ); ?>" class="page-title-action">
					<?php esc_html_e( 'Add New', 'casben-business-suite' ); ?>
				</a>

			<?php endif; ?>

			<hr class="wp-header-end">

			<?php
$message = isset( $_GET['message'] ) ? sanitize_key( wp_unslash( $_GET['message'] ) ) : '';

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

<?php endif; ?>
			<?php

			if ( 'add' === $action || 'edit' === $action ) {

	$form = new CASBEN_Customer_Form();
	$form->display();

} else {

	$list_table = new CASBEN_Customer_List();
	$list_table->prepare_items();
	?>

	<form method="post">

		<?php $list_table->display(); ?>

	</form>

	<?php
}

			?>

		</div>

		<?php
	}
}