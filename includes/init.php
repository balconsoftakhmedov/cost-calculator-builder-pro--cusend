<?php
/**
 * add ajax action
 */
add_action(
	'init',
	function () {

		if ( isset( $_GET['stm_ccb_check_ipn'] ) && strval( $_GET['stm_ccb_check_ipn'] ) === "1" ) { // phpcs:ignore
			\cBuilder\Classes\Payments\CCBPayPal::check_payment( $_REQUEST );
		}

		\cBuilder\Classes\CCBProSettings::init();
		\cBuilder\Classes\CCBProAjaxActions::init();
		\cBuilder\Classes\CCBWooProducts::init();
		\cBuilder\Classes\CCBWebhooks::init();
	}
);

add_filter(
	'upload_mimes',
	function ( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}
);
