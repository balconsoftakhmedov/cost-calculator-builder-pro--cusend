<?php
$is_admin          = ( isset( $_GET['page'] ) && 'cost_calculator_builder' === $_GET['page'] );
$settings_status   = isset( $settings );
$g_settings_status = false;
$general_settings  = get_option( 'ccb_general_settings' );

if ( isset( $settings ) ) {
	$paypal_status     = ! empty( $settings['paypal']['enable'] ) || ! ! $is_admin;
	$stripe_status     = ! empty( $settings['stripe']['enable'] ) || ! ! $is_admin;
	$g_settings_status = $paypal_status || $stripe_status;
}

if ( $is_admin ) {
	wp_enqueue_script( 'calc-stripe', 'https://js.stripe.com/v3/', array(), CALC_VERSION, false );
}

?>
<?php if ( $g_settings_status ) : ?>
	<div v-if="getStripeSettings.enable || getPayPalSettings.enable">
		<div class="calc-item">
			<div class="calc-item-title" style="margin-bottom: 10px" v-if="!form">
				<h4><?php esc_html_e( 'Payment methods', 'cost-calculator-builder-pro' ); ?></h4>
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
					</span>
				</span>
			</div>

			<div class="calc-item-title" style="margin-bottom: 25px" v-if="getHideCalc">
				<h4>
					<?php esc_html_e( 'Credit Card details', 'cost-calculator-builder-pro' ); ?>
				</h4>
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
					</span>
				</span>
			</div>

			<div class="calc-item ccb-field calc-payments">
				<div class="calc-radio-wrapper default">
					<label style="margin-right: 15px" :style="[disable_stripe ? {'opacity': '0.5'} : {'opacity': '1'}]" v-if="isPaymentEnabled('stripe')">
						<input type="radio" :disabled="disable_stripe" name="paymentMethods" value="stripe" v-model="getMethod">
						<span class="calc-radio-label"><?php esc_html_e( 'Credit Card', 'cost-calculator-builder-pro' ); ?></span>
						<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
					</label>
                    <label style="margin-right: 15px">
                        <input type="radio" name="paymentMethods" value="ach" v-model="getMethod">
                        <span class="calc-radio-label"><?php esc_html_e( 'ACH (check)', 'cost-calculator-builder-pro' ); ?></span>
                    </label>
					<label style="margin-right: 15px" v-if="isPaymentEnabled('paypal')">
						<input type="radio" name="paymentMethods" value="paypal" v-model="getMethod">
						<span class="calc-radio-label"><?php esc_html_e( 'PayPal', 'cost-calculator-builder-pro' ); ?></span>
						<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
					</label>
					<label class="ccb-payment-woo" style="margin-right: 15px" v-if="isPaymentEnabled('woo_checkout')">
						<input type="radio" name="paymentMethods" value="woocommerce_checkout" v-model="getMethod">
						<span class="calc-radio-label"><?php esc_html_e( 'Woocommerce Checkout', 'cost-calculator-builder-pro' ); ?></span>
						<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
					</label>
				</div>
				<div style="margin: 20px 0 10px" v-show="getMethod === 'stripe'" :id="'ccb_stripe_' + getSettings.calc_id" class="calc-stripe-wrapper"></div>
			</div>

			<div class="calc-form-wrapper" v-if="getMethod">
				<div class="calc-default-form">
					<?php if ( $settings_status ) : ?>
						<template v-if="$store.getters.getUnusedFields.length === 0 && getMethod && ['paypal', 'stripe'].includes(getMethod)">
							<div class="calc-item ccb-field ccb-field-quantity">
								<div class="calc-item__title">
									<span :class="{'require-fields': paymentForm.requires[0].required}"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
								</div>
								<div class="calc-input-wrapper ccb-field">
									<input type="text" v-model="paymentForm.sendFields[0].value" class="calc-input ccb-field ccb-appearance-field">
								</div>
							</div>

							<div class="calc-item ccb-field ccb-field-quantity">
								<div class="calc-item__title">
									<span :class="{'require-fields': paymentForm.requires[1].required}"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
								</div>
								<div class="calc-input-wrapper ccb-field">
									<input type="text" v-model="paymentForm.sendFields[1].value" class="calc-input ccb-field ccb-appearance-field">
								</div>
							</div>

							<div class="calc-item ccb-field ccb-field-quantity">
								<div class="calc-item__title">
									<span :class="{'require-fields': paymentForm.requires[2].required}"><?php esc_html_e( 'Phone', 'cost-calculator-builder-pro' ); ?></span>
								</div>
								<div class="calc-input-wrapper ccb-field">
									<input type="number" v-model="paymentForm.sendFields[2].value" class="calc-input ccb-field ccb-appearance-field">
								</div>
							</div>

							<div class="calc-item ccb-field ccb-field-quantity">
								<div class="calc-item__title">
									<span :class="{'require-fields': paymentForm.requires[3].required}"><?php esc_html_e( 'Message', 'cost-calculator-builder-pro' ); ?></span>
								</div>
								<div class="calc-input-wrapper ccb-field">
									<textarea v-model="paymentForm.sendFields[3].value" class="calc-input ccb-field ccb-appearance-field"></textarea>
								</div>
							</div>
						</template>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="ccb-btn-wrap" style="margin-top: 20px; position: relative">
			<loader-wrapper v-if="loader" :form="true" :idx="getPreloaderIdx" width="60px" height="60px" scale="0.8" :front="true"></loader-wrapper>
			<div class="ccb-btn-container calc-buttons <?php echo $general_settings['invoice']['emailButton'] && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ? esc_attr( 'pdf-enable' ) : ''; ?>" v-else>
				<button class="calc-btn-action success" v-if="getMethod === 'woocommerce_checkout'" @click="applyWoo(<?php the_ID(); ?>)">
					<?php esc_html_e( 'Add To Cart', 'cost-calculator-builder-pro' ); ?>
				</button>

				<button class="calc-btn-action success" v-else @click.prevent="<?php echo $settings_status ? 'false' : 'true'; ?> ? applyPayment() : OrderPayment() " :class="purchaseBtnClass">
					<?php esc_html_e( 'Purchase', 'cost-calculator-builder-pro' ); ?>
				</button>
				<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
					<button class="calc-btn-action invoice-button ispro-wrapper" @click="getInvoice">
						<span><?php echo isset( $general_settings['invoice']['buttonText'] ) ? esc_html( $general_settings['invoice']['buttonText'] ) : ''; ?></span>
						<div class="invoice-btn-loader"></div>
						<span class="is-pro">
								<span class="pro-tooltip">
									pro
									<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
								</span>
							</span>
					</button>

					<?php if ( isset( $general_settings['invoice']['emailButton'] ) && $general_settings['invoice']['emailButton'] ) : ?>
						<button class="calc-btn-action ispro-wrapper" @click="showSendPdf">
							<span><?php echo isset( $general_settings['invoice']['btnText'] ) ? esc_html( $general_settings['invoice']['btnText'] ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
									<span class="is-pro">
									<span class="pro-tooltip">
										pro
									<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
								</span>
							</span>
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
