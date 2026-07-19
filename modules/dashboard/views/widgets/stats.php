<div class="casben-grid casben-grid-2">

	<?php

	CASBEN_UI::stat_card(
		array(
			'title'       => __( 'Customers', 'casben-business-suite' ),
			'icon'        => 'groups',
			'stat'        => $stats['customers'],
			'description' => __( 'Total Customers', 'casben-business-suite' ),
			'footer'      => array(
				CASBEN_Btn::view(
					__( 'Customers', 'casben-business-suite' ),
					admin_url( 'admin.php?page=casben-customers' )
				),
			),
		)
	);

	CASBEN_UI::stat_card(
		array(
			'title'       => __( 'Products', 'casben-business-suite' ),
			'icon'        => 'cart',
			'stat'        => $stats['products'],
			'description' => __( 'Total Products', 'casben-business-suite' ),
			'footer'      => array(
				CASBEN_Btn::view(
					__( 'Products', 'casben-business-suite' ),
					admin_url( 'admin.php?page=casben-products' )
				),
			),
		)
	);

	CASBEN_UI::stat_card(
		array(
			'title'       => __( 'Invoices', 'casben-business-suite' ),
			'icon'        => 'media-spreadsheet',
			'stat'        => $stats['invoices'],
			'description' => __( 'Total Invoices', 'casben-business-suite' ),
			'footer'      => array(
				CASBEN_Btn::view(
					__( 'Invoices', 'casben-business-suite' ),
					admin_url( 'admin.php?page=casben-invoices' )
				),
			),
		)
	);

	CASBEN_UI::stat_card(
		array(
			'title'       => __( 'Total Sales', 'casben-business-suite' ),
			'icon'        => 'chart-line',
			'stat'        => number_format_i18n( $stats['sales'], 2 ),
			'description' => __( 'Sales Value', 'casben-business-suite' ),
			'footer'      => array(
				CASBEN_Btn::view(
					__( 'Reports', 'casben-business-suite' ),
					'#'
				),
			),
		)
	);

	?>

</div>