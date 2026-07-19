<?php

/**
 * Dashboard View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap casben-dashboard">

	<h1 class="wp-heading-inline">
		<?php esc_html_e( 'CASBEN Business Suite', 'casben-business-suite' ); ?>
	</h1>

	<p class="description">
		<?php esc_html_e( 'Welcome to your business dashboard.', 'casben-business-suite' ); ?>
	</p>

	<div class="casben-dashboard-grid">

	

	<!-- Statistics -->
	<?php require __DIR__ . '/widgets/stats.php'; ?>

	<!-- Full Width: Recent Invoices -->
	<div class="casben-grid">
		<?php require __DIR__ . '/widgets/recent-invoices.php'; ?>
	</div>

	<!-- Row 1 -->
	<div class="casben-grid casben-grid-2">
		<?php require __DIR__ . '/widgets/invoice-status.php'; ?>
		<?php require __DIR__ . '/widgets/quick-actions.php'; ?>
	</div>

	<!-- Row 2 -->
	<div class="casben-grid casben-grid-2">
		<?php require __DIR__ . '/widgets/fbr-status.php'; ?>
		<?php require __DIR__ . '/widgets/recent-activity.php'; ?>
	</div>

</div>

</div>