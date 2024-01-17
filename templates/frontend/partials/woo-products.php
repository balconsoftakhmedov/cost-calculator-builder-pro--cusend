<?php if ( is_singular( 'product' ) ) :
	$product = wc_get_product( get_the_ID() ); ?>
	<input type="hidden" id="woo_price" data-value="<?php esc_attr_e( $product->get_price() ); // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>">
<?php endif; ?>
