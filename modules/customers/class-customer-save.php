<?php
/**
 * Customer Save
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CASBEN_Customer_Save {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_customer' ) );
		add_action( 'admin_init', array( $this, 'delete_customer' ) );

	}

	/**
	 * Save customer.
	 */
	public function save_customer() {

		// Only process our form.
		if ( ! isset( $_POST['casben_customer_nonce'] ) ) {
			return;
		}

		// Verify nonce.
		if (
			! wp_verify_nonce(
				sanitize_text_field(
					wp_unslash( $_POST['casben_customer_nonce'] )
				),
				'casben_save_customer'
			)
		) {
			wp_die( esc_html__( 'Security check failed.', 'casben-business-suite' ) );
		}

		global $wpdb;

		$table = $wpdb->prefix . 'casben_customers';
			$customer_id = isset( $_POST['customer_id'] )
			? absint( wp_unslash( $_POST['customer_id'] ) )
			: 0;

		$data = array(
			'customer_code'  => sanitize_text_field( wp_unslash( $_POST['customer_code'] ?? '' ) ),
			'company_name'   => sanitize_text_field( wp_unslash( $_POST['company_name'] ?? '' ) ),
			'contact_person' => sanitize_text_field( wp_unslash( $_POST['contact_person'] ?? '' ) ),
			'designation'    => sanitize_text_field( wp_unslash( $_POST['designation'] ?? '' ) ),
			'phone'          => sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ),
			'mobile'         => sanitize_text_field( wp_unslash( $_POST['mobile'] ?? '' ) ),
			'email'          => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
			'website'        => esc_url_raw( wp_unslash( $_POST['website'] ?? '' ) ),
			'ntn'            => sanitize_text_field( wp_unslash( $_POST['ntn'] ?? '' ) ),
			'strn'           => sanitize_text_field( wp_unslash( $_POST['strn'] ?? '' ) ),
			'address'        => sanitize_textarea_field( wp_unslash( $_POST['address'] ?? '' ) ),
			'city'           => sanitize_text_field( wp_unslash( $_POST['city'] ?? '' ) ),
			'province'       => sanitize_text_field( wp_unslash( $_POST['province'] ?? '' ) ),
			'country'        => sanitize_text_field( wp_unslash( $_POST['country'] ?? 'Pakistan' ) ),
		);

		if ( $customer_id > 0 ) {

			$wpdb->update(
				$table,
				$data,
				array(
				'id' => $customer_id,
				)
			);

				$message = 'updated';

			} else {

				$wpdb->insert( $table, $data );

				$message = 'saved';
			}

		$action = isset( $_POST['casben_action'] )
			? sanitize_key( wp_unslash( $_POST['casben_action'] ) )
			: 'save';

		if ( 'save_new' === $action ) {

			wp_safe_redirect(
				admin_url(
					'admin.php?page=casben-customers&action=add&message=saved'
				)
			);

		} else {

			wp_safe_redirect(
				admin_url(
					'admin.php?page=casben-customers&message=' . $message
				)
			);

		}

		exit;
	}
/**
 * Delete customer.
 */
public function delete_customer() {

	// Only process delete requests.
	if (
		! isset( $_GET['action'] ) ||
		'delete' !== sanitize_key( wp_unslash( $_GET['action'] ) )
	) {
		return;
	}

	// Permission check.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission.', 'casben-business-suite' ) );
	}

	// Customer ID.
	$customer_id = isset( $_GET['customer'] )
		? absint( wp_unslash( $_GET['customer'] ) )
		: 0;

	if ( $customer_id <= 0 ) {
		return;
	}

	// Verify nonce.
	check_admin_referer( 'delete_customer_' . $customer_id );

	global $wpdb;

	$table = $wpdb->prefix . 'casben_customers';

	$wpdb->delete(
		$table,
		array(
			'id' => $customer_id,
		),
		array(
			'%d',
		)
	);

	wp_safe_redirect(
		admin_url(
			'admin.php?page=casben-customers&message=deleted'
		)
	);

	exit;
	}
}