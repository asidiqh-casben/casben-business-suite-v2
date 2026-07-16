<?php
/**
 * Invoice Notes View
 *
 * @package CASBEN_Business_Suite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h2>

	<?php
	esc_html_e(
		'Notes',
		'casben-business-suite'
	);
	?>

</h2>

<table class="form-table">

	<tbody>

		<tr>

			<th>

				<label for="notes">

					<?php
					esc_html_e(
						'Notes',
						'casben-business-suite'
					);
					?>

				</label>

			</th>

			<td>

				<textarea
					id="notes"
					name="notes"
					rows="6"
					class="large-text"
				><?php
				echo esc_textarea(
					$invoice->notes
				);
				?></textarea>

				<p class="description">

					<?php
					esc_html_e(
						'Optional notes that will appear on the invoice.',
						'casben-business-suite'
					);
					?>

				</p>

			</td>

		</tr>

	</tbody>

</table>