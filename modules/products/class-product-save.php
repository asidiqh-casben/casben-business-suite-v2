<?php
/**
 * Product Save
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Product_Save {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_product' ) );
		add_action( 'admin_init', array( $this, 'delete_product' ) );
	}

	/**
	 * Save product.
	 */
	public function save_product() {

		$action = isset( $_POST['casben_action'] )
			? sanitize_key( wp_unslash( $_POST['casben_action'] ) )
			: '';

		if ( 'save' !== $action && 'save_new' !== $action ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission.', 'casben-business-suite' ) );
		}

		if ( ! isset( $_POST['casben_product_nonce'] ) ) {
			return;
		}

		if (
			! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['casben_product_nonce'] ) ),
				'casben_save_product'
			)
		) {
			wp_die( esc_html__( 'Security check failed.', 'casben-business-suite' ) );
		}

		global $wpdb;

		$table = $wpdb->prefix . 'casben_products';

		$product_id = isset( $_POST['product_id'] )
			? absint( wp_unslash( $_POST['product_id'] ) )
			: 0;

		$product_name = isset( $_POST['product_name'] )
			? sanitize_text_field( wp_unslash( $_POST['product_name'] ) )
			: '';

		if ( '' === $product_name ) {
			wp_die( esc_html__( 'Product Name is required.', 'casben-business-suite' ) );
		}

		$grade = isset( $_POST['grade'] )
			? sanitize_text_field( wp_unslash( $_POST['grade'] ) )
			: '';

		$description = isset( $_POST['description'] )
			? sanitize_textarea_field( wp_unslash( $_POST['description'] ) )
			: '';

		$unit = isset( $_POST['unit'] )
			? sanitize_text_field( wp_unslash( $_POST['unit'] ) )
			: '';

		if ( '' === $unit ) {
			wp_die( esc_html__( 'Unit is required.', 'casben-business-suite' ) );
		}
		$category = isset( $_POST['category'] )
	? sanitize_text_field( wp_unslash( $_POST['category'] ) )
	: '';

		$hs_code = isset( $_POST['hs_code'] )
		? sanitize_text_field( wp_unslash( $_POST['hs_code'] ) )
	: '';

		$unit_price_raw = isset( $_POST['unit_price'] )
			? sanitize_text_field( wp_unslash( $_POST['unit_price'] ) )
			: '';

		if ( '' === $unit_price_raw || ! is_numeric( $unit_price_raw ) || floatval( $unit_price_raw ) < 0 ) {
			wp_die( esc_html__( 'Unit Price is required and must be a valid number.', 'casben-business-suite' ) );
		}

		$unit_price = round( (float) $unit_price_raw, 2 );

		$tax_rate_raw = isset( $_POST['tax_rate'] )
			? sanitize_text_field( wp_unslash( $_POST['tax_rate'] ) )
			: '';

		if ( '' === $tax_rate_raw ) {
			$tax_rate = 18.00;
		} elseif ( ! is_numeric( $tax_rate_raw ) || floatval( $tax_rate_raw ) < 0 ) {
			wp_die( esc_html__( 'Sales Tax must be a valid number.', 'casben-business-suite' ) );
		} else {
			$tax_rate = round( (float) $tax_rate_raw, 2 );
		}

		$status = isset( $_POST['status'] )
			? absint( wp_unslash( $_POST['status'] ) )
			: 1;

		if ( 0 !== $status && 1 !== $status ) {
			$status = 1;
		}

		$data = array(
			'product_name' => $product_name,
			'grade'        => $grade,
			'description'  => $description,
			'unit'         => $unit,
			'unit_price'   => $unit_price,
			'tax_rate'     => $tax_rate,
			'status'       => $status,
			'category' 	   => $category,
			'hs_code'      => $hs_code,
		);

		$format = array( '%s', '%s', '%s', '%s', '%f', '%f', '%d' );

		if ( $product_id > 0 ) {
			$result = $wpdb->update(
	$table,
	$data,
	array( 'id' => $product_id ),
	$format,
	array( '%d' )
);

if ( false === $result ) {
	wp_die(
		esc_html__( 'Unable to update product.', 'casben-business-suite' )
	);
}

$message = 'updated';

		} else {
			$insert_format = array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%f',
				'%f',
				'%d',
			);

			$result = $wpdb->insert(
			$table,
			$data,
			$insert_format
			);

			if ( false === $result ) {
				wp_die(
					esc_html( $wpdb->last_error )
				);
			}

		/*
 		* Generate Product Code from the actual database ID.
 		*/
			$product_code = sprintf(
				'PRD-%06d',
				$wpdb->insert_id
			);

			$wpdb->update(
					$table,
				array(
					'product_code' => $product_code,
				),
				array(
					'id' => $wpdb->insert_id,
				),
				array(
					'%s',
				),
				array(
					'%d',
				)
			);

			$message = 'saved';
		}

		if ( 'save_new' === $action ) {
			wp_safe_redirect(
				admin_url( 'admin.php?page=casben-products&action=add&message=saved' )
			);
		} else {
			wp_safe_redirect(
				admin_url( 'admin.php?page=casben-products&message=' . $message )
			);
		}

		exit;
	}	
	/**
 * Delete product.
 */
public function delete_product() {

	$action = isset( $_GET['action'] )
		? sanitize_key( wp_unslash( $_GET['action'] ) )
		: '';

	if ( 'delete' !== $action ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__( 'You do not have permission.', 'casben-business-suite' )
		);
	}

	$product_id = isset( $_GET['id'] )
		? absint( wp_unslash( $_GET['id'] ) )
		: 0;

	if ( ! $product_id ) {
		return;
	}

	check_admin_referer( 'delete_product_' . $product_id );

	global $wpdb;

	$table = $wpdb->prefix . 'casben_products';

	$result = $wpdb->delete(
		$table,
		array(
			'id' => $product_id,
		),
		array(
			'%d',
		)
	);

	if ( false === $result ) {
		wp_die(
			esc_html__( 'Unable to delete product.', 'casben-business-suite' )
		);
	}

	wp_safe_redirect(
		admin_url( 'admin.php?page=casben-products&message=deleted' )
	);

	exit;
}
}