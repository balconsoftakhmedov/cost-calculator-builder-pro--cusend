<?php
add_action( 'init', 'ccb_pro_installed' );

function ccb_pro_installed() {
	$transient_name = 'ccb_pro_installed';

	if ( false === ( $checked = get_transient( $transient_name ) ) ) { //phpcs:ignore
		set_transient( $transient_name, time() );
	}

	return $checked;

}

add_action( 'admin_footer', 'ccb_pro_install_page_cb' );

function ccb_pro_install_page_cb() {
	$checked      = ccb_pro_installed();
	$current_time = time();

	if ( $current_time - $checked >= 86000 ) {
		delete_transient( 'ccb_pro_installed' );
	}
}

add_action( 'admin_enqueue_scripts', 'ccb_pro_wizard_scripts' );
function ccb_pro_wizard_scripts() {
	wp_enqueue_style( 'ccb_wizard', plugins_url( '/assets/wizard.css', CCB_PRO ), array(), time() );
	wp_enqueue_script( 'ccb_wizard', plugins_url( '/assets/wizard.js', CCB_PRO ), array(), time(), true );

}
