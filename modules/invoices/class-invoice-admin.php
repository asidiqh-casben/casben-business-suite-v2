<?php
/**
 * Invoice Admin Controller
 *
 * Handles invoice admin pages and routing.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Invoice Admin.
 */
class CASBEN_Invoice_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action(
			'admin_init',
			array(
				$this,
				'handle_actions',
			)
		);

		add_action(
			'admin_notices',
			array(
				$this,
				'admin_notices',
			)
		);

	}

	/**
	 * Register invoice menu.
	 *
	 * @return void
	 */
	public function register_menu() {

		add_submenu_page(
			'casben-business-suite',
			__( 'Invoices', 'casben-business-suite' ),
			__( 'Invoices', 'casben-business-suite' ),
			'manage_options',
			'casben-invoices',
			array(
				$this,
				'invoices_page',
			)
		);

	}

	/**
	 * Invoice admin page.
	 *
	 * Handles list, add, edit and view pages.
	 *
	 * @return void
	 */
	public function invoices_page() {

		if ( ! current_user_can( 'manage_options' ) ) {

			wp_die(
				esc_html__(
					'You do not have permission to access invoices.',
					'casben-business-suite'
				)
			);

		}

		$action = isset( $_GET['action'] )
			? sanitize_key(
				wp_unslash( $_GET['action'] )
			)
			: 'list';

		switch ( $action ) {

			case 'add':
			case 'edit':
				$this->render_form();
				break;

			case 'view':
				$this->render_view();
				break;

			default:
				$this->render_list();
				break;

		}

	}

	/**
	 * Render invoice list.
	 *
	 * @return void
	 */
	private function render_list() {

		if ( ! class_exists( 'CASBEN_Invoice_List' ) ) {

			echo '<div class="notice notice-error"><p>';

			esc_html_e(
				'Invoice list class could not be loaded.',
				'casben-business-suite'
			);

			echo '</p></div>';

			return;

		}

		$list_table = new CASBEN_Invoice_List();

		$list_table->prepare_items();

		?>

				<div class="wrap">

			<?php
			CASBEN_UI::page_toolbar(
				array(
					'title'       => __( 'Invoices', 'casben-business-suite' ),
					'description' => __(
						'Manage your invoices.',
						'casben-business-suite'
					),
					'actions'     => array(

						CASBEN_Btn::add(
							'Invoice',
							$this->get_invoice_url( 'add' ),
							'New'
						),

						CASBEN_Btn::print_list( '#' ),

						CASBEN_Btn::export( '#' ),

						CASBEN_Btn::dashboard(
							admin_url(
								'admin.php?page=casben-business-suite'
							)
						),

					),
				)
			);
			?>

			<form method="post">

				<?php

				$list_table->search_box(
					__( 'Search Invoices', 'casben-business-suite' ),
					'search_invoice'
				);

				$list_table->display();

				?>

			</form>

		</div>
		<?php

	}
		/**
	 * Render invoice form.
	 *
	 * @return void
	 */
	private function render_form() {

		if ( ! class_exists( 'CASBEN_Invoice_Form' ) ) {

			echo '<div class="notice notice-error"><p>';

			esc_html_e(
				'Invoice form class could not be loaded.',
				'casben-business-suite'
			);

			echo '</p></div>';

			return;

		}

		$invoice_id = isset( $_GET['id'] )
			? absint(
				wp_unslash( $_GET['id'] )
			)
			: 0;

		CASBEN_Invoice_Form::render(
			$invoice_id
		);

	}

	/**
	 * Handle invoice actions.
	 *
	 * Currently handles invoice deletion.
	 *
	 * @return void
	 */
	public function handle_actions() {

		if ( ! is_admin() ) {
			return;
		}

		if ( empty( $_GET['page'] ) ) {
			return;
		}

		$page = sanitize_key(
			wp_unslash( $_GET['page'] )
		);

		if ( 'casben-invoices' !== $page ) {
			return;
		}

		if ( empty( $_GET['action'] ) ) {
			return;
		}

		$action = sanitize_key(
			wp_unslash( $_GET['action'] )
		);

		if ( 'delete' !== $action ) {
			return;
		}

		if ( empty( $_GET['id'] ) ) {
			return;
		}

		$invoice_id = absint(
			wp_unslash( $_GET['id'] )
		);

		if ( ! $invoice_id ) {
			return;
		}

		if ( empty( $_GET['_wpnonce'] ) ) {
			return;
		}

		$nonce = sanitize_text_field(
			wp_unslash( $_GET['_wpnonce'] )
		);

		if (
			! wp_verify_nonce(
				$nonce,
				'delete_invoice_' . $invoice_id
			)
		) {

			wp_die(
				esc_html__(
					'Security check failed.',
					'casben-business-suite'
				)
			);

		}

		$this->delete_invoice(
			$invoice_id
		);

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'casben-invoices',
					'deleted' => 1,
				),
				admin_url( 'admin.php' )
			)
		);

		exit;

	}
		/**
	 * Delete invoice.
	 *
	 * Deletes the invoice items first, then the invoice.
	 *
	 * @param int $invoice_id Invoice ID.
	 * @return bool True on success, false on failure.
	 */
	private function delete_invoice( $invoice_id ) {

		global $wpdb;

		$invoice_id = absint( $invoice_id );

		if ( ! $invoice_id ) {
			return false;
		}

		$invoice_table = $wpdb->prefix . 'casben_invoices';
		$items_table   = $wpdb->prefix . 'casben_invoice_items';

		// Delete invoice items.
		$items_deleted = $wpdb->delete(
			$items_table,
			array(
				'invoice_id' => $invoice_id,
			),
			array(
				'%d',
			)
		);

		if ( false === $items_deleted ) {
			return false;
		}

		// Delete invoice.
		$invoice_deleted = $wpdb->delete(
			$invoice_table,
			array(
				'id' => $invoice_id,
			),
			array(
				'%d',
			)
		);

		if ( false === $invoice_deleted ) {
			return false;
		}

		return true;

	}

	/**
	 * Display admin notices.
	 *
	 * @return void
	 */
	public function admin_notices() {

		if (
			! isset( $_GET['page'] ) ||
			'casben-invoices' !== sanitize_key(
				wp_unslash( $_GET['page'] )
			)
		) {
			return;
		}

		if (
			isset( $_GET['deleted'] ) &&
			1 === absint(
				wp_unslash( $_GET['deleted'] )
			)
		) {
			?>

			<div class="notice notice-success is-dismissible">

				<p>

					<?php
					esc_html_e(
						'Invoice deleted successfully.',
						'casben-business-suite'
					);
					?>

				</p>

			</div>

			<?php
		}

	}
		/**
	 * Get invoice admin URL.
	 *
	 * Helper method for generating invoice admin URLs.
	 *
	 * @param string $action Action name.
	 * @param int    $id     Invoice ID.
	 * @return string
	 */
	private function get_invoice_url( $action = '', $id = 0 ) {

		$args = array(
			'page' => 'casben-invoices',
		);

		if ( ! empty( $action ) ) {

			$args['action'] = sanitize_key( $action );

		}

		if ( $id > 0 ) {

			$args['id'] = absint( $id );

		}

		return add_query_arg(
			$args,
			admin_url( 'admin.php' )
		);

	}
		/**
	 * Render invoice view page.
	 *
	 * @return void
	 */
	private function render_view() {

		$invoice_id = isset( $_GET['id'] )
			? absint(
				wp_unslash( $_GET['id'] )
			)
			: 0;

		if ( ! $invoice_id ) {

			wp_die(
				esc_html__(
					'Invalid invoice.',
					'casben-business-suite'
				)
			);

		}

		$invoice = new CASBEN_Invoice();

		$invoice_data = $invoice->get(
			$invoice_id
		);

		if ( ! $invoice_data ) {

			wp_die(
				esc_html__(
					'Invoice not found.',
					'casben-business-suite'
				)
			);

		}

		$items = $invoice->get_items(
			$invoice_id
		);

		include CASBEN_PLUGIN_DIR .
			'modules/invoices/views/invoice-view.php';

	}

}