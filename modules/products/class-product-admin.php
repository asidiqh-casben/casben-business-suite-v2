<?php
/**
 * Product Admin
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Product_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Menu registration is handled by CASBEN_Admin_Menu.
	}

	/**
	 * Products page.
	 */
	public function products_page() {

		$action = isset( $_GET['action'] )
		? sanitize_key( wp_unslash( $_GET['action'] ) )
		: '';

		?>

		<div class="wrap">

			<h1 class="wp-heading-inline">
				<?php esc_html_e( 'Products', 'casben-business-suite' ); ?>
			</h1>

			<?php if ( empty( $action ) ) : ?>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=casben-products&action=add' ) ); ?>" class="page-title-action">
					<?php esc_html_e( 'Add New', 'casben-business-suite' ); ?>
				</a>

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
					<p><?php esc_html_e( 'Product added successfully.', 'casben-business-suite' ); ?></p>
				</div>

			<?php elseif ( 'updated' === $message ) : ?>

				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Product updated successfully.', 'casben-business-suite' ); ?></p>
				</div>

			<?php elseif ( 'deleted' === $message ) : ?>

				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Product deleted successfully.', 'casben-business-suite' ); ?></p>
				</div>

			<?php elseif ( 'bulk_deleted' === $message ) : ?>

				<div class="notice notice-success is-dismissible">
					<p>
						<?php
						printf(
							esc_html(
								_n(
									'%d product deleted successfully.',
									'%d products deleted successfully.',
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
									'%d product activated successfully.',
									'%d products activated successfully.',
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
									'%d product deactivated successfully.',
									'%d products deactivated successfully.',
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

				$form = new CASBEN_Product_Form();
				$form->display();

			} else {

								$list_table = new CASBEN_Product_List();

				$list_table->process_bulk_action();

				$list_table->prepare_items();

				?>

				<form method="post">

					<?php
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