<?php
/**
 * Quick Actions Widget
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

CASBEN_UI::card_start(
	__( 'Quick Actions', 'casben-business-suite' ),
	'casben-widget-small',
	'dashicons-admin-tools'
);


CASBEN_UI::actions_start();

CASBEN_UI::action(
	__( 'Customer', 'casben-business-suite' ),
	admin_url( 'admin.php?page=casben-customers' ),
	'dashicons-groups'
);

CASBEN_UI::action(
	__( 'Product', 'casben-business-suite' ),
	admin_url( 'admin.php?page=casben-products' ),
	'dashicons-cart'
);

CASBEN_UI::action(
	__( 'Invoice', 'casben-business-suite' ),
	admin_url( 'admin.php?page=casben-invoices&action=add' ),
	'dashicons-media-spreadsheet'
);

CASBEN_UI::actions_end();



CASBEN_UI::card_end();