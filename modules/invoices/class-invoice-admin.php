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
	 * Invoice model.
	 *
	 * @var CASBEN_Invoice
	 */
	private $invoice;


	/**
	 * Constructor.
	 */
	public function __construct() {

		//$this->includes();

		add_action(
			'admin_menu',
			array(
				$this,
				'register_menu',
			)
		);

		add_action(
			'admin_init',
			array(
				$this,
				'handle_actions',
			)
		);

	}


	/**
	 * Include required files.
	 *
	 * @return void
	 */

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
	 * Handles list, add, and edit views.
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

				$this->render_form();

				break;


			case 'edit':

				$this->render_form();

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

			<h1 class="wp-heading-inline">
				<?php esc_html_e(
					'Invoices',
					'casben-business-suite'
				); ?>
			</h1>

			<a href="<?php echo esc_url(
				add_query_arg(
					array(
						'page'   => 'casben-invoices',
						'action' => 'add',
					),
					admin_url( 'admin.php' )
				)
			); ?>" class="page-title-action">

				<?php esc_html_e(
					'Add New',
					'casben-business-suite'
				); ?>

			</a>


			<hr class="wp-header-end">


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


		$invoice_id = 0;


		if ( isset( $_GET['id'] ) ) {

			$invoice_id = absint(
				wp_unslash( $_GET['id'] )
			);

		}


		CASBEN_Invoice_Form::render(
			$invoice_id
		);

	}
	/**
	 * Handle invoice actions.
	 *
	 * Handles delete requests before page rendering.
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


		if (
			empty( $_GET['action'] ) ||
			'delete' !== sanitize_key(
				wp_unslash( $_GET['action'] )
			)
		) {
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


		check_admin_referer(
			'delete_invoice_' . $invoice_id
		);


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
	 * @param int $invoice_id Invoice ID.
	 * @return void
	 */
	private function delete_invoice( $invoice_id ) {

		global $wpdb;


		$invoice_id = absint( $invoice_id );


		if ( ! $invoice_id ) {
			return;
		}


		$invoice_table = $wpdb->prefix . 'casben_invoices';

		$items_table = $wpdb->prefix . 'casben_invoice_items';


		$wpdb->delete(
			$items_table,
			array(
				'invoice_id' => $invoice_id,
			),
			array(
				'%d',
			)
		);


		$wpdb->delete(
			$invoice_table,
			array(
				'id' => $invoice_id,
			),
			array(
				'%d',
			)
		);

	}


	/**
	 * Display admin notices.
	 *
	 * @return void
	 */
	public function admin_notices() {

		if (
			isset( $_GET['deleted'] ) &&
			1 === absint( $_GET['deleted'] )
		) {

			?>
			<div class="notice notice-success is-dismissible">

				<p>
					<?php esc_html_e(
						'Invoice deleted successfully.',
						'casben-business-suite'
					); ?>
				</p>

			</div>
			<?php

		}

	}
	/**
	 * Get invoice URL.
	 *
	 * Helper method for generating invoice admin URLs.
	 *
	 * @param string $action Action name.
	 * @param int    $id Invoice ID.
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


}
