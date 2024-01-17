<?php

namespace cBuilder\Classes;

class CCBProSettings {
	public static function init() {
		// admin
		add_action( 'render-date-picker', array( self::class, 'render_date_picker' ) );
		add_action( 'render-time-picker', array( self::class, 'render_time_picker' ) );
		add_action( 'render-file-upload', array( self::class, 'render_file_upload' ) );
		add_action( 'render-multi-range', array( self::class, 'render_multi_range' ) );
		add_action( 'render-drop-down-with-img', array( self::class, 'render_drop_down_with_img' ) );
		add_action( 'render-radio-with-img', array( self::class, 'render_radio_with_img' ) );
		add_action( 'render-checkbox-with-img', array( self::class, 'render_checkbox_with_img' ) );

		// admin settings
		add_action( 'render-condition', array( self::class, 'render_condition' ) );

		add_action( 'render-general-invoice', array( self::class, 'render_general_invoice' ) );
		add_action( 'render-general-email', array( self::class, 'render_general_email' ) );
		add_action( 'render-general-email-template', array( self::class, 'render_general_email_template' ) );
		add_action( 'render-general-captcha', array( self::class, 'render_general_captcha' ) );
		add_action( 'render-general-stripe', array( self::class, 'render_general_stripe' ) );
		add_action( 'render-general-paypal', array( self::class, 'render_general_paypal' ) );

		add_action( 'render-notice', array( self::class, 'render_notice' ) );
		add_action( 'render-recaptcha', array( self::class, 'render_recaptcha' ) );
		add_action( 'render-default-form', array( self::class, 'render_default_form' ) );

		add_action( 'render-stripe', array( self::class, 'render_stripe' ) );
		add_action( 'render-paypal', array( self::class, 'render_paypal' ) );
		add_action( 'render-send-form', array( self::class, 'render_send_form' ) );
		add_action( 'render-woo-checkout', array( self::class, 'render_woo_checkout' ) );
		add_action( 'render-woo-products', array( self::class, 'render_woo_products' ) );
		add_action( 'render-webhooks', array( self::class, 'render_webhooks' ) );
		add_action( 'render-thank-you-page', array( self::class, 'render_thank_you_page' ) );

		add_filter(
			'calc-render-conditions',
			function ( $arr, $calc_id ) {
				return get_post_meta( $calc_id, 'stm-conditions', true );
			},
			10,
			2
		);
	}

	public static function render_general_invoice() {
		echo CCBProTemplate::load( 'admin/general-settings/invoice' ); //phpcs:ignore
	}

	public static function render_general_email() {
		echo CCBProTemplate::load( 'admin/general-settings/email' ); //phpcs:ignore
	}

	public static function render_general_email_template() {
		echo CCBProTemplate::load( 'admin/general-settings/email-template' ); //phpcs:ignore
	}

	public static function render_general_captcha() {
		echo CCBProTemplate::load( 'admin/general-settings/captcha' ); //phpcs:ignore
	}

	public static function render_general_stripe() {
		echo CCBProTemplate::load( 'admin/general-settings/stripe' ); //phpcs:ignore
	}

	public static function render_general_paypal() {
		echo CCBProTemplate::load( 'admin/general-settings/paypal' ); //phpcs:ignore
	}

	public static function render_condition() {
		echo CCBProTemplate::load( 'admin/condition' ); //phpcs:ignore
	}

	public static function render_date_picker() {
		echo CCBProTemplate::load( 'admin/fields/date-picker-field' ); //phpcs:ignore
	}

	public static function render_time_picker() {
		echo CCBProTemplate::load( 'admin/fields/time-picker-field' ); //phpcs:ignore
	}

	public static function render_multi_range() {
		echo CCBProTemplate::load( 'admin/fields/multi-range-field' ); //phpcs:ignore
	}

	public static function render_file_upload() {
		echo CCBProTemplate::load( 'admin/fields/file-upload-field' ); //phpcs:ignore
	}

	public static function render_drop_down_with_img() {
		echo CCBProTemplate::load( 'admin/fields/drop-down-with-image-field' ); //phpcs:ignore
	}

	public static function render_radio_with_img() {
		echo CCBProTemplate::load( 'admin/fields/radio-with-image-field' ); //phpcs:ignore
	}

	public static function render_checkbox_with_img() {
		echo CCBProTemplate::load( 'admin/fields/checkbox-with-image-field' ); //phpcs:ignore
	}

	public static function render_stripe() {
		echo CCBProTemplate::load( 'admin/settings/stripe' ); //phpcs:ignore
	}

	public static function render_notice() {
		echo CCBProTemplate::load( 'admin/settings/notice' ); //phpcs:ignore
	}

	public static function render_recaptcha() {
		echo CCBProTemplate::load( 'admin/settings/recaptcha' ); //phpcs:ignore
	}

	public static function render_default_form() {
		echo CCBProTemplate::load( 'admin/settings/default-form' ); //phpcs:ignore
	}

	public static function render_paypal() {
		echo CCBProTemplate::load( 'admin/settings/paypal' ); //phpcs:ignore
	}

	public static function render_send_form() {
		echo CCBProTemplate::load( 'admin/settings/send-form' ); //phpcs:ignore
	}

	public static function render_woo_products() {
		echo CCBProTemplate::load( 'admin/settings/woo-products' ); //phpcs:ignore
	}

	public static function render_woo_checkout() {
		echo CCBProTemplate::load( 'admin/settings/woo-checkout' ); //phpcs:ignore
	}

	public static function render_webhooks() {
		echo CCBProTemplate::load( 'admin/settings/webhooks' ); //phpcs:ignore
	}

	public static function render_thank_you_page() {
		echo CCBProTemplate::load( 'admin/settings/thank-you-page' ); //phpcs:ignore
	}
}
