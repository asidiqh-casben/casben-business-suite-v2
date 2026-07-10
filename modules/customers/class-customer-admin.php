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

		$action = isset( $_GET['action'] ) ? sanitize_key( $_GET['action'] ) : '';

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

			if ( 'add' === $action ) {

				echo '<h2>Add Customer Form (Coming Next Umar)</h2>';

			} else {

				echo '<p>Customer List (Coming Next Abdul)</p>';

			}

			?>

		</div>

		<?php
	}
}