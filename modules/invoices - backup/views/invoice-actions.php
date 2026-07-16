<?php
/**
 * Invoice Actions View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<hr>

<p class="submit">

	<?php

	submit_button(
		$is_edit
			? __( 'Update Invoice', 'casben-business-suite' )
			: __( 'Save Invoice', 'casben-business-suite' ),
		'primary',
		'submit',
		false
	);

	?>

	<a
		href="<?php echo esc_url(
			admin_url(
				'admin.php?page=casben-invoices'
			)
		); ?>"
		class="button"
	>

		<?php
		esc_html_e(
			'Cancel',
			'casben-business-suite'
		);
		?>

	</a>

</p>

<?php if ( $is_edit ) : ?>

	<hr>

	<p>

		<em>

			<?php
			esc_html_e(
				'More actions like Print, PDF and FBR Submission will be available here.',
				'casben-business-suite'
			);
			?>

		</em>

	</p>

<?php endif; ?>