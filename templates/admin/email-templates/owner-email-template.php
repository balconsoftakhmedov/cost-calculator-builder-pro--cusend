<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="x-apple-disable-message-reformatting">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="telephone=no" name="format-detection">
	<link rel="preconnect" href="https://stijndv.com">
	<link rel="stylesheet" href="https://stijndv.com/fonts/Eudoxus-Sans.css"> <?php // phpcs:ignore?>
	<title>Order</title>
	<style>
		h1, p, span {
			margin: 0;
			padding: 0;
		}

		a {
			text-transform: none;
			text-decoration: none;
		}

		.text-right {
			text-align: right;
		}

		.body {
			margin:0;
			font-family:-apple-system, 'Eudoxus Sans', Sans-serif;
			color:#001931;
		}

		.wrapper {
			background-color: #EEF1F7;
			max-width: 800px;
			margin: 0 auto;
			background-image: url(<?php echo esc_attr( CALC_URL . '/frontend/dist/img/email-bg.png' ); ?>);
			background-repeat: no-repeat;
			background-size: 100% 35%;
		}

		.table-body {
			max-width: 600px;
			margin: 0px auto;
			position: relative;
			z-index: 99999;
		}

		.table-body-row {
			max-width: 600px;
		}

		.table-header {
			margin: 0 auto;
			background: #001931;
		}

		.table-header-wrapper {
			max-width: 600px;
			margin: 0 auto;
			height: 80px;
			padding-top: 50px;
		}

		.header__logo img {
			max-height: 150px;
		}

		.email-title {
			font-family: 'Eudoxus Sans', Sans-serif;
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			color: #fff;
		}

		.order {
			width: 100%;
			color: #fff;
		}

		.order-link {
			padding: 10px 20px;
			border-radius: 4px;
			background-color: #00B163;
			color: #fff !important;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			transition: 300ms ease;
		}

		.order-link:hover {
			background-color: #029755;
		}

		.order-item {
			width: 49%;
			font-weight: 500;
			font-size: 16px;
			display: inline-block;
			line-height: 20px;
		}

		.summary {
			margin: 0 auto;
			max-width: 600px;
			background: #fff;
			margin-top: 30px;
		}

		.summary-container {
			padding: 40px;
			margin-bottom: 20px;
		}

		.summary-title {
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
		}

		.summary-list-item {
			padding: 15px 0;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
			border-bottom: 1px solid #EEEEEE;
		}

		.summary-list-item.break-border {
			border-bottom: none !important;
		}

		.summary-list-item-name {
			width: 49%;
			display: inline-block;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.summary-list-item-value {
			width: 50%;
			display: inline-block;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			text-align: right;
		}

		.summary-list-sub-items li::marker {
			color:  #00193180;
			opacity: 0.1;
		}

		.summary-list-sub-items li {
			margin-bottom: 10px;
		}

		.summary-total {
			max-width: 600px;
			padding: 7px 0;
			border-top: 2px solid #EEEEEE;
		}

		.summary-total-item {
			display: inline-block;
			font-style: normal;
			font-weight: 700;
			font-size: 18px;
			line-height: 23px;
		}

		.summary-files-list {
			list-style: none;
			margin: 20px 0;
			padding: 0;
		}

		.summary-files-list-item {
			padding: 3px 10px;
			border: 1px solid #EEEEEE;
			border-radius: 4px;
			margin-bottom: 10px;
		}

		.summary-files-icon {
			display: inline-block;
			margin-right: 15px;
		}

		.summary-files-icon img {
			margin-bottom: 3px;
		}

		.summary-files-info {
			display: inline-block;
		}

		.summary-files-info .title {
			display: inline-block;
			width: 100%;
			font-style: normal;
			font-weight: 700;
			font-size: 12px;
			line-height: 15px;
		}

		.summary-files-info .filename {
			display: inline-block;
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.summary-files-link {
			background-color: #EEF1F7;
			padding: 9px 20px;
			border-radius: 4px;
			text-decoration: none;
			text-transform: none;
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			color: #001931;
			transition: 300ms ease;
			float: right;
		}

		.summary-files-link:hover {
			background-color: #dbdbdb;
		}

		.table-contact {
			margin: 0px auto;
			max-width: 600px;
			background-color: #fff;
			margin-bottom: 50px;
		}

		.table-contact-container {
			padding: 40px;
		}

		.table-contact-title {
			font-style: normal;
			font-weight: 700;
			font-size: 24px;
			line-height: 30px;
			margin-bottom: 20px;
		}

		.table-contact-list {

		}

		.table-contact-item {
			margin-bottom: 10px;
		}

		.table-contact-label {
			font-style: normal;
			font-weight: 700;
			font-size: 13px;
			line-height: 16px;
			margin-right: 4px;
		}

		.table-contact-value {
			font-style: normal;
			font-weight: 500;
			font-size: 14px;
			line-height: 18px;
		}

		.table-contact-value.break {
			display: block;
		}

		.table-contact-value a {
			color: #1AB163;
		}

		.table-contact-value a:hover {
			color: #029755;
		}

		.show-unit .summary-list {
			padding: 0 10px;
		}

		.show-unit .summary-list .summary-list-item {
			padding: 5px 0 10px 0;
			border: none;
			border-bottom: 1px dashed #ccc;
			margin-bottom: 5px;
		}

		.show-unit .summary-list .summary-list-item:last-child {
			border: none;
		}

		.show-unit .summary-list .summary-list-item-name,
		.show-unit .summary-list .summary-list-item-value {
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			color: #001931;
		}

		.show-unit .summary-list-item-name {
			width: 49%;
		}

		.show-unit .summary-list-sub-items {
			padding: 5px 0 5px 35px;
			margin: 0px;
			list-style: none;
		}

		.show-unit .summary-list-sub-items li div {
			font-style: normal !important;
			font-weight: 500 !important;
			font-size: 12px !important;
			line-height: 15px !important;
			color: #000 !important;
			opacity: 0.7 !important;
		}

		.show-unit .summary-list-sub-items li {
			margin-bottom: 5px;
		}

		.show-unit .summary-list-sub-items li .summary-list-item-value {
			margin-left: 5px !important;
		}

		.show-unit .summary-list-item-value {
			width: 50%;
			display: inline-block;
			text-align: right;
			word-break: break-all;
		}

		.show-unit .summary-total {
			width: 500px;
			margin: 15px auto;
		}

		.summary-list-item-unit {
			width: 100%;
			display: none;
			font-style: normal;
			font-weight: 500;
			font-size: 12px;
			line-height: 18px;
			color: #000;
			opacity: 0.7;
			padding-left: 35px;
		}

		.calc-subtotal-list-header {
			display: flex;
			padding: 5px 10px;
			background-color: #EEEEEE;
			margin-bottom: 5px;
		}
		.calc-subtotal-list-header span {
			font-style: normal;
			font-weight: 700;
			font-size: 14px;
			line-height: 18px;
			display: inline-block;
		}

		.calc-subtotal-list-header__name {
			width: 49%;
		}


		.calc-subtotal-list-header__value {
			width: 49%;
			text-align: right;
		}

		.show-unit .summary-list-item-unit {
			display: inline-block !important;
		}

		.show-unit .summary-list-item-space {
			display: block;
		}

		.show-unit .summary-list-sub-items .summary-list-item-name,
		.show-unit .summary-list-sub-items .summary-list-item-value {
			width: auto !important;
		}

		@media (max-width: 540px) {
			.email-title {
				font-size: 20px;
			}

			.order-item {
				font-size: 14px;
			}

			.summary-container {
				padding: 20px 10px;
			}

			.summary-title {
				font-size: 20px;
			}

			.summary-list-item {
				padding: 10px 0;
			}

			.summary-list-item-name {
				font-size: 12px;
				line-height: 14px;
				width: 48%;
			}

			.summary-list-item-value {
				font-size: 12px;
				line-height: 14px;
			}

			.summary-list-sub-items {
				padding: 0 0 0 28px;
				margin: 4px 0;
			}

			.summary-list-sub-items li {
				margin-bottom: 6px;
			}

			.summary-total-item {
				font-size: 16px;
			}

			.summary-files-link {
				display: block;
				float: none;
				text-align: center;
				margin-top: 10px;
			}

			.footer-wrapper span {
				font-size: 12px;
			}
		}

	</style>
</head>

<body width="100%" class="body">
	<div class="wrapper">
		<div class="table-header">
			<div class="table-header-wrapper">
				<p class="email-title"><?php esc_html_e( 'Calculation result', 'cost-calculator-builder-pro' ); ?></p>
				<div class="order">
					<p class="order-item"><?php echo esc_html( date( 'F j Y' ) ); ?></p>
					<p class="order-item text-right">
						<a href="<?php echo esc_attr( home_url( '/' ) . 'wp-admin/admin.php?page=cost_calculator_orders' ); ?>" class="order-link"><?php esc_html_e( 'Manage Order', 'cost-calculator-builder-pro' ); ?></a>
					</p>
				</div>
			</div>
		</div>
		<table width="100%">
			<tbody class="table-body">
			<tr class="table-body-row">
				<td>
					<div class="summary <?php $show_unit ? esc_attr_e( 'show-unit' ) : ''; ?>">
						<div class="summary-container">
							<?php if ( $show_unit ) : ?>
								<div class="calc-subtotal-list-header">
									<span class="calc-subtotal-list-header__name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
									<span class="calc-subtotal-list-header__value"><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></span>
								</div>
							<?php endif; ?>
							<div class="summary-list">
								<?php
								if ( isset( $fields ) && count( $fields ) > 0 ) {
									foreach ( $fields as $key => $value ) {
										if ( 'total' !== substr( $value['alias'], 0, 5 ) && ! $value['hidden'] ) :
											?>
												<div class="summary-list-item <?php count( $fields ) - 1 === $key ? esc_attr_e( 'break-border' ) : ''; ?>" >
													<div class="summary-list-item-name">
														<?php echo esc_html( ucfirst( $value['label'] ) ); ?>
													</div>
													<?php if ( isset( $value['summary_view'] ) && 'show_value' !== $value['summary_view'] ) : ?>
														<div class="summary-list-item-value">
															<?php echo esc_html( $value['extraView'] ); ?>
														</div>
													<?php else : ?>
														<div class="summary-list-item-value">
															<?php echo esc_html( $value['converted'] ); ?>
														</div>
													<?php endif; ?>
													<?php if ( isset( $value['option_unit'] ) ) : ?>
														<div class="summary-list-item-unit">
															<?php echo isset( $value['option_unit'] ) ? esc_html( ucfirst( $value['option_unit'] ) ) : ''; ?>
														</div>
													<?php endif; ?>
													<?php if ( isset( $value['has_options'] ) ) : ?>
														<?php if ( count( $value['options'] ) ) : ?>
															<ul class="summary-list-sub-items">
																<?php foreach ( $value['options'] as $option ) : ?>
																	<li>
																		<div class="summary-list-item-name">
																			<?php echo esc_html( $option['label'] ); ?>
																		</div>
																		<?php
																		if ( isset( $value['summary_view'] ) && 'show_value' !== $value['summary_view'] ) :
																			?>
																				<div class="summary-list-item-value">
																					<?php echo esc_html( $option['label'] ); ?>
																				</div>
																			<?php else : ?>
																				<div class="summary-list-item-value">
																					<?php echo esc_html( $option['converted'] ); ?>
																				</div>
																			<?php endif; ?>
																	</li>
																<?php endforeach; ?>
															</ul>
														<?php endif; ?>
													<?php endif; ?>
												</div>
											<?php
											endif;
									}
								}
								?>
							</div>

							<div class="summary-total">
								<?php if ( isset( $totals ) && count( $totals ) > 0 ) : ?>
									<?php foreach ( $totals as $total ) : ?>
										<div class="summary-total-item" style="width: 48%;">
											<?php echo esc_html( $total['title'] ); ?>
										</div>
										<div class="summary-total-item text-right" style="width: 51%;">
											<?php echo esc_html( $total['value'] ); ?>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $files ) ) : ?>
								<div class="summary-files">
									<ul class="summary-files-list">
										<?php foreach ( $files as $file ) : ?>
											<?php if ( ! empty( $file ) ) : ?>
												<?php foreach ( $file as $item ) : ?>
													<li class="summary-files-list-item">
														<div class="summary-files-icon">
															<img src="<?php echo esc_attr( CALC_URL . '/frontend/dist/img/file-text.png' ); ?> ?>" width="20" alt="Email icon">
														</div>
														<div class="summary-files-info">
															<span class="title">Attach file:</span>
															<span class="filename"><?php echo esc_html( $item['filename'] ); ?></span>
														</div>
														<a href="<?php echo esc_url( $item['url'] ); ?>" class="summary-files-link">
															<?php esc_html_e( 'Download', 'cost-calculator-builder-pro' ); ?>
														</a>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</td>
			</tr>
			<tr class="table-body-row">
				<td>
					<div class="table-contact">
						<div class="table-contact-container">
							<div class="table-contact-title">
								<?php esc_html_e( 'Customer Info', 'cost-calculator-builder-pro' ); ?>
							</div>
							<div class="table-contact-list">
								<?php if ( ! empty( $send_fields ) ) : ?>
									<?php foreach ( $send_fields as $field ) : ?>
										<?php if ( 'phone' === $field['name'] || 'email' === $field['name'] ) : ?>
											<div class="table-contact-item">
												<span class="table-contact-label"><?php echo esc_html( ucfirst( $field['name'] ) ); ?>:</span>
												<span class="table-contact-value">
											<a href="<?php echo 'phone' === $field['name'] ? 'tel:' . esc_attr( $field['value'] ) : 'mailto:' . esc_attr( $field['value'] ); ?>">
												<?php echo esc_html( $field['value'] ); ?>
											</a>
										</span>
											</div>
										<?php else : ?>
											<div class="table-contact-item">
												<span class="table-contact-label"><?php echo esc_html( ucfirst( $field['name'] ) ); ?>:</span>
												<span class="table-contact-value <?php 'message' === $field['name'] ? esc_attr_e( 'break' ) : ''; ?>"><?php echo esc_html( $field['value'] ); ?></span>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</body>

</html>
