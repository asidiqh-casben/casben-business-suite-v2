<?php
/**
 * Invoice Form View
 *
 * Main wrapper for the invoice form.
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">

	<h1 class="wp-heading-inline">

		<?php
		echo esc_html(
			$is_edit
				? __( 'Edit Invoice', 'casben-business-suite' )
				: __( 'Add New Invoice', 'casben-business-suite' )
		);
		?>

	</h1>

	<hr class="wp-header-end">

	<form
		method="post"
		action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
		id="casben-invoice-form"
	>

		<?php
		wp_nonce_field(
			'casben_save_invoice',
			'casben_invoice_nonce'
		);
		?>

		<input
			type="hidden"
			name="action"
			value="casben_save_invoice"
		>

		<input
			type="hidden"
			name="invoice_id"
			value="<?php echo esc_attr( $invoice->id ); ?>"
		>

		<?php
		require __DIR__ . '/invoice-header.php';
		?>

		<?php
		require __DIR__ . '/invoice-items.php';
		?>

		<?php
		require __DIR__ . '/invoice-totals.php';
		?>

		<?php
		require __DIR__ . '/invoice-notes.php';
		?>

		<?php
		require __DIR__ . '/invoice-actions.php';
		?>

	</form>

</div>