<?php
/**
 * Payments template if 'Send Form' -> Contact Form is Enabled
 */
?>
<div :class="['ccb-form-payments', { 'disabled': loader }]">
	<div class="calc-item" v-if="payment.status != 'success'">
		<div class="calc-item-title" style="margin-bottom: 10px">
			<h4><?php esc_html_e( 'Payment methods', 'cost-calculator-builder-pro' ); ?></h4>
			<span class="is-pro">
				<span class="pro-tooltip">
					pro
					<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
				</span>
			</span>
		</div>

		<div class="calc-item-title" style="margin-bottom: 25px"  v-if="showStripeCard">
			<h4><?php esc_html_e( 'Credit Card details', 'cost-calculator-builder-pro' ); ?></h4>
			<span class="is-pro">
				<span class="pro-tooltip">
					pro
					<span class="pro-tooltiptext" style="visibility: hidden;">Feature Available <br> in Pro Version</span>
				</span>
			</span>
		</div>

		<div class="calc-item ccb-field calc-payments">
			<div class="calc-radio-wrapper default">
				<label style="margin-right: 15px" v-if="isPaymentEnabled('stripe')">
					<input type="radio" name="paymentMethods" value="stripe" v-model="paymentMethod">
					<span class="calc-radio-label"><?php esc_html_e( 'Credit Card', 'cost-calculator-builder-pro' ); ?></span>
					<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
				</label>
				<label style="margin-right: 15px" v-if="isPaymentEnabled('paypal')">
					<input type="radio" name="paymentMethods" value="paypal" v-model="paymentMethod">
					<span class="calc-radio-label"><?php esc_html_e( 'PayPal', 'cost-calculator-builder-pro' ); ?></span>
					<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
				</label>
				<label style="margin-right: 15px" v-if="isPaymentEnabled('woo_checkout')">
					<input type="radio" name="paymentMethods" value="woocommerce_checkout" v-model="paymentMethod">
					<span class="calc-radio-label"><?php esc_html_e( 'Woocommerce Checkout', 'cost-calculator-builder-pro' ); ?></span>
					<span class="is-pro">
							<span class="pro-tooltip">
								pro
								<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
							</span>
						</span>
				</label>
			</div>
			<div style="margin: 20px 0 10px" v-show="paymentMethod === 'stripe'" :id="'ccb_stripe_' + getSettings.calc_id" class="calc-stripe-wrapper"></div>
		</div>
	</div>

	<div v-if="payment.status != 'success'" class="ccb-btn-wrap" style="margin-top: 20px; position: relative">
		<loader-wrapper v-if="loader" :form="true" :idx="getPreloaderIdx" width="60px" height="60px" scale="0.8" :front="true"></loader-wrapper>
		<div class="ccb-btn-container calc-buttons" v-else>
			<button class="calc-btn-action success" v-if="paymentMethod === 'woocommerce_checkout'" @click="applyWoo(<?php the_ID(); ?>)" v-else >
				<?php esc_html_e( 'Add To Cart', 'cost-calculator-builder-pro' ); ?>
			</button>
			<button class="calc-btn-action success" v-else @click.prevent="applyPayment()" :class="{disabled: (!paymentMethod || loader )}" >
				<?php esc_html_e( 'Purchase', 'cost-calculator-builder-pro' ); ?>
			</button>
		</div>
	</div>
</div>
