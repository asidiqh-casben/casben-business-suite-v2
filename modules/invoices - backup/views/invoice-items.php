<?php
/**
 * Invoice Items View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2>

	<?php esc_html_e(
		'Invoice Items',
		'casben-business-suite'
	); ?>

</h2>

<table
	class="widefat striped"
	id="casben-invoice-items-table"
>

	<thead>

		<tr>

			<th style="width:22%;">

				<?php esc_html_e(
					'Product',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:25%;">

				<?php esc_html_e(
					'Description',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:8%;">

				<?php esc_html_e(
					'Qty',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:10%;">

				<?php esc_html_e(
					'Unit Price',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:10%;">

				<?php esc_html_e(
					'Discount',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:8%;">

				<?php esc_html_e(
					'Tax %',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:12%;">

				<?php esc_html_e(
					'Line Total',
					'casben-business-suite'
				); ?>

			</th>

			<th style="width:5%;">

				<?php esc_html_e(
					'',
					'casben-business-suite'
				); ?>

			</th>

		</tr>

	</thead>

	<tbody>

		<?php foreach ( $invoice_items as $index => $item ) : ?>

			<tr class="casben-item-row">

				<td>

					<select
						name="items[<?php echo esc_attr( $index ); ?>][product_id]"
						class="casben-product"
					>

						<option value="">

							<?php esc_html_e(
								'Select Product',
								'casben-business-suite'
							); ?>

						</option>

						<?php foreach ( $products as $product ) : ?>

							<option
								value="<?php echo esc_attr( $product->id ); ?>"
								<?php
								selected(
									$item->product_id,
									$product->id
								);
								?>
							>

								<?php
								echo esc_html(
									$product->product_name
								);
								?>

							</option>

						<?php endforeach; ?>

					</select>

				</td>

				<td>

					<input
						type="text"
						name="items[<?php echo esc_attr( $index ); ?>][description]"
						value="<?php echo esc_attr( $item->description ); ?>"
						class="regular-text"
					>

				</td>

				<td>

					<input
						type="number"
						name="items[<?php echo esc_attr( $index ); ?>][quantity]"
						value="<?php echo esc_attr( $item->quantity ); ?>"
						step="0.001"
						min="0"
						class="small-text casben-qty"
					>

				</td>

				<td>

					<input
						type="number"
						name="items[<?php echo esc_attr( $index ); ?>][unit_price]"
						value="<?php echo esc_attr( $item->unit_price ); ?>"
						step="0.01"
						min="0"
						class="small-text casben-price"
					>

				</td>

                				<td>

					<input
						type="number"
						name="items[<?php echo esc_attr( $index ); ?>][discount_amount]"
						value="<?php echo esc_attr( $item->discount ); ?>"
						step="0.01"
						min="0"
						class="small-text casben-discount"
					>

				</td>

				<td>

					<input
						type="number"
						name="items[<?php echo esc_attr( $index ); ?>][tax_rate]"
						value="<?php echo esc_attr( $item->tax_rate ); ?>"
						step="0.01"
						min="0"
						class="small-text casben-tax-rate"
					>

				</td>

				<td>

					<input
						type="number"
						name="items[<?php echo esc_attr( $index ); ?>][line_total]"
						value="<?php echo esc_attr( $item->line_total ); ?>"
						step="0.01"
						class="small-text casben-line-total"
						readonly
					>

				</td>

				<td>

					<button
						type="button"
						class="button casben-remove-row"
						title="<?php esc_attr_e(
							'Remove Item',
							'casben-business-suite'
						); ?>"
					>

						&times;

					</button>

				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>
<p class="submit">

	<button
		type="button"
		id="casben-add-item"
		class="button button-secondary"
	>

		<?php esc_html_e(
			'Add Item',
			'casben-business-suite'
		); ?>

	</button>

</p>

<script type="text/html" id="tmpl-casben-invoice-row">

<tr class="casben-item-row">

	<td>

		<select
			name="items[{{{data.index}}}][product_id]"
			class="casben-product"
		>

			<option value="">

				<?php
				esc_html_e(
					'Select Product',
					'casben-business-suite'
				);
				?>

			</option>

			<?php foreach ( $products as $product ) : ?>

				<option value="<?php echo esc_attr( $product->id ); ?>">

					<?php
					echo esc_html(
						$product->product_name
					);
					?>

				</option>

			<?php endforeach; ?>

		</select>

	</td>

	<td>

		<input
			type="text"
			name="items[{{{data.index}}}][description]"
			class="regular-text"
		>

	</td>

	<td>

		<input
			type="number"
			name="items[{{{data.index}}}][quantity]"
			value="1"
			step="0.001"
			min="0"
			class="small-text casben-qty"
		>

	</td>

	<td>

		<input
			type="number"
			name="items[{{{data.index}}}][unit_price]"
			value="0"
			step="0.01"
			min="0"
			class="small-text casben-price"
		>

	</td>

	<td>

		<input
			type="number"
			name="items[{{{data.index}}}][discount_amount]"
			value="0"
			step="0.01"
			min="0"
			class="small-text casben-discount"
		>

	</td>

	<td>

		<input
			type="number"
			name="items[{{{data.index}}}][tax_rate]"
			value="18"
			step="0.01"
			min="0"
			class="small-text casben-tax-rate"
		>

	</td>

	<td>

		<input
			type="number"
			name="items[{{{data.index}}}][line_total]"
			value="0.00"
			step="0.01"
			class="small-text casben-line-total"
			readonly
		>

	</td>

	<td>

		<button
			type="button"
			class="button casben-remove-row"
		>

			&times;

		</button>

	</td>

</tr>

</script>
