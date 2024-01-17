<?php

namespace cBuilder\Classes;

class CCBWooProducts {

	/**
	* CCBWooProducts Init
	*/
	public static function init() {
		$woocommerce_calcs = get_option( 'stm_ccb_woocommerce_calcs', array() );

		if ( ! empty( $woocommerce_calcs ) && is_array( $woocommerce_calcs ) ) {
			foreach ( $woocommerce_calcs as $calc_id ) {
				$ccb_settings = get_option( 'stm_ccb_form_settings_' . $calc_id );
				$settings     = $ccb_settings['woo_products'];

				self::show_calculator( $calc_id, $settings );

				if ( empty( $settings['hide_woo_cart'] ) ) {
					self::remove_add_to_cart_button( $settings );
				}
			}
		}
	}

	/**
	* Show Calculator on WooCommerce Product page
	*
	* @param $calc_id
	* @param $settings
	*/
	public static function show_calculator( $calc_id, $settings ) {
		add_action(
			(string) $settings['hook_to_show'],
			function () use ( $calc_id, $settings ) {
				if ( self::is_category_included( $settings ) && ! self::product_is_in_out_of_stock() ) {
					echo do_shortcode( "[stm-calc id='" . esc_attr( $calc_id ) . "']" );
				}
			},
			5
		);
	}

	/**
	* Hide WooCommerce Add to Cart Button
	*
	* @param $settings
	*/
	public static function remove_add_to_cart_button( $settings ) {
		add_action(
			'woocommerce_simple_add_to_cart',
			function () use ( $settings ) {
				if ( self::is_category_included( $settings ) && ! $settings['hide_woo_cart'] ) {
					remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
				}
			},
			1
		);

		add_filter(
			'woocommerce_loop_add_to_cart_link',
			function ( $product ) use ( $settings ) {
				if ( self::is_category_included( $settings ) && ! $settings['hide_woo_cart'] ) {
					return '';
				}
				return $product;
			},
			10
		);
	}

	/**
	* Check if Current Product Category Included for Calculator
	*
	* @param $settings
	* @return bool
	*/
	public static function is_category_included( $settings ) {
		return has_term( $settings['category_ids'], 'product_cat', get_the_ID() );
	}

	public static function product_is_in_out_of_stock() {
		$status = get_post_meta( get_the_ID(), '_stock_status', true );
		return 'outofstock' === $status;
	}
}
