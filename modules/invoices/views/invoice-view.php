<?php
/**
 * Invoice View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="casben-invoice-print">

	<div class="casben-invoice-container">


		<!-- Company Header -->
		<table width="100%">
			<tr>

				<td width="60%">

					<h1>
						Casben LLP Islamabad
					</h1>

					<p>
						<strong>NTN</strong> :      J083116
						<br>
						<strong>Phone</strong> : 0313-9444725
						<br>
						<strong>Email</strong> :     casben@pcamus.com
					</p>

				</td>


				<td align="right">

					<h2>
						INVOICE
					</h2>

					<p>

						<strong>
							Invoice No:
						</strong>

						<?php echo esc_html( $invoice_data->invoice_number ); ?>

						<br>


						<strong>
							Date:
						</strong>

						<?php echo esc_html( $invoice_data->invoice_date ); ?>


						<br>


						<strong>
							Status:
						</strong>

						<?php echo esc_html( ucfirst( $invoice_data->status ) ); ?>

					</p>

				</td>

			</tr>
		</table>


		<hr>


		<!-- Customer Information -->

		<h3>
			Bill To:
		</h3>


		<p>

			<strong>
				<?php echo esc_html( $invoice_data->company_name ); ?>
			</strong>

		</p>



		<hr>


		<!-- Invoice Items -->

		<table class="widefat fixed striped">
		
		<colgroup>

			<col style="width:8%;">
			<col style="width:37%;">
			<col style="width:10%;">
			<col style="width:15%;">
			<col style="width:10%;">
			<col style="width:20%;">

		</colgroup>

			<thead>

				<tr>

				<th>
					S/No
				</th>

				<th>
					Description
				</th>

				<th>
					Quantity
				</th>

				<th>
					Unit Price
				</th>

				<th>
					GST %
				</th>

				<th>
					Total
				</th>

				</tr>

				</thead>

			<tbody>


			<?php 
				$serial = 1;

				foreach ( $items as $item ) :
				?>


				<tr>

					<td>

						<?php echo esc_html( $serial ); ?>

					</td>

					<td>

						<?php echo esc_html( $item['description'] ); ?>

					</td>


					<td>

						<?php echo esc_html( $item['quantity'] ); ?>

					</td>


					<td>

						<?php echo esc_html( number_format_i18n( $item['unit_price'], 2 ) ); ?>

					</td>


					<td>

						<?php echo esc_html( $item['tax_rate'] ); ?>%

					</td>


					<td>

						<?php echo esc_html( number_format_i18n( $item['line_total'], 2 ) ); ?>

					</td>
					<?php $serial++; ?>

				</tr>


			<?php endforeach; ?>


			</tbody>


		</table>


		<br>


		<!-- Totals -->


		<table class="casben-invoice-totals">


			<tr>

				<td>
					<strong>
						Subtotal
					</strong>
				</td>

				<td align="right">

					<?php echo esc_html(
						number_format_i18n(
							$invoice_data->subtotal,
							2
						)
					); ?>

				</td>

			</tr>



			<tr>

				<td>
					<strong>
						Discount
					</strong>
				</td>

				<td align="right">

					<?php echo esc_html(
						number_format_i18n(
							$invoice_data->discount_amount,
							2
						)
					); ?>

				</td>

			</tr>



			<tr>

				<td>
					<strong>
						GST
					</strong>
				</td>

				<td align="right">

					<?php echo esc_html(
						number_format_i18n(
							$invoice_data->tax_amount,
							2
						)
					); ?>

				</td>

			</tr>



			<tr>

				<td>
					<strong>
						Grand Total
					</strong>
				</td>


				<td align="right">

					<strong>

					<?php echo esc_html(
						number_format_i18n(
							$invoice_data->grand_total,
							2
						)
					); ?>

					</strong>

				</td>

			</tr>


		</table>


		<div style="clear:both;"></div>


		<br>


		<!-- Notes -->


		<?php if ( ! empty( $invoice_data->notes ) ) : ?>

			<h3>
				Notes
			</h3>

			<p>

				<?php echo nl2br(
					esc_html(
						$invoice_data->notes
					)
				); ?>

			</p>

		<?php endif; ?>



		<hr>


		<!-- Actions -->


		<p class="casben-invoice-buttons">

			<a class="button"
				href="<?php echo esc_url(
					admin_url(
						'admin.php?page=casben-invoices'
					)
				); ?>">
				
				<?php esc_html_e(
					'Back',
					'casben-business-suite'
				); ?>

			</a>



			<a class="button button-primary"
				href="<?php echo esc_url(
					add_query_arg(
						array(
							'page'   => 'casben-invoices',
							'action' => 'edit',
							'id'     => $invoice_data->id,
						),
						admin_url( 'admin.php' )
					)
				); ?>">

				<?php esc_html_e(
					'Edit Invoice',
					'casben-business-suite'
				); ?>

			</a>



			<button class="button" onclick="window.print(); return false;">

				<?php esc_html_e(
					'Print Invoice',
					'casben-business-suite'
				); ?>

			</button>

		</p>


	</div>

</div>

<style>

/* ===========================
   SCREEN VIEW
=========================== */

.casben-invoice-print {
	padding:20px;
}


.casben-invoice-container {

	max-width:900px;

	background:#fff;

	padding:30px;

	border:1px solid #ddd;

}


/* ===========================
   PRINT VIEW
=========================== */

.casben-invoice-totals {

	width:30%;

	float:right;

}


@media print {
    /* 1. Reset page container and clear browser margin overrides */
    @page {
        size: auto;
        margin: 0 !important;
    }

		.casben-invoice-totals {

		width:30% !important;

		float:right !important;

	}


    /* 2. Completely eliminate the WordPress admin wrapper layout offsets */
    html, body, #wpwrap, #wpcontent, #wpbody, #wpbody-content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: static !important;
        left: 0 !important;
        transform: none !important;
    }

    /* 3. Hide all other WordPress admin elements completely from DOM layout */
    #adminmenuwrap, 
    #adminmenuback, 
    #wpadminbar, 
    #wpfooter, 
    .casben-invoice-buttons, 
    .button, 
    .page-title-action {
        display: none !important;
    }

    /* Alternative approach to 'visibility': Hide immediate siblings of the container if needed.
       However, resetting #wpwrap above usually strips the 2-inch left gap completely. */

    /* 4. Force your target element to the absolute top-left corner of the page */
    body .casben-invoice-print {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 220mm !important;
        margin: 0 !important;
        padding: 10mm !important;
        box-sizing: border-box !important;
        display: block !important;
    }

    .casben-invoice-container {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse;
    }
}
</style>