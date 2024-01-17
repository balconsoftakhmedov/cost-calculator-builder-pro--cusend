<div class="sub-list-item next-btn">
	<div class="ccb-next-content">
		<div class="payment-methods">
			<?php if ( empty( $general_settings ) && $invoice['use_in_all'] && ! $invoice['showAfterPayment'] ) : ?>
				<div class="calc-form-wrapper">
					<div class="ccb-btn-wrap calc-buttons" v-if="type === 'invoiceBtn'">
						<button class="calc-btn-action success ispro-wrapper">
							<span><?php echo isset( $invoice['buttonText'] ) ? esc_html( $invoice['buttonText'] ) : ''; ?></span>
						</button>
						<?php if ( isset( $invoice['emailButton'] ) && $invoice['emailButton'] ) : ?>
							<button class="calc-btn-action" @click="showSendPdf">
								<span><?php echo isset( $invoice['btnText'] ) ? esc_html( $invoice['btnText'] ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
							</button>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<invoice-btn inline-template v-if="type === 'invoiceBtn'">
				<?php if ( isset( $general_settings['invoice']['showAfterPayment'] ) && ! $general_settings['invoice']['showAfterPayment'] && $general_settings['invoice']['use_in_all'] ) : ?>
					<div class="ccb-btn-wrap calc-buttons">
						<button class="calc-btn-action success ispro-wrapper" @click="getInvoice">
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
					</div>
				<?php endif; ?>
			</invoice-btn>
			<calc-payments inline-template v-if="type === 'payment'" :user-company-details="company_details" :company-details='<?php echo wp_json_encode($company_details); ?>'>
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/calc-payments', array( 'settings' => $settings, 'general_settings' => $general_settings ) ); // phpcs:ignore ?>
			</calc-payments>
			<calc-woo-checkout inline-template v-if="type === 'woo_checkout'">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/woo-checkout', array( 'general_settings' => $general_settings, 'invoice' => $invoice ) ); // phpcs:ignore ?>
			</calc-woo-checkout>

			<template v-if="settings.woo_products?.enable">
				<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/woo-products' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</template>

			<calc-form inline-template v-if="type === 'form'" :settings="settings">
				<div>
					<?php if ( ! empty( $settings ) && ! empty( $general_settings ) ) : ?>
						<template>
							<?php echo \cBuilder\Classes\CCBProTemplate::load( 'frontend/partials/calc-form', array( 'settings' => $settings, 'general_settings' => $general_settings ) ); // phpcs:ignore ?>
						</template>
					<?php elseif ( empty( $settings ) && empty( $general_settings ) ) : ?>
						<template>
							<div class="calc-form-wrapper">
								<div class="ccb-btn-wrap calc-buttons <?php echo isset( $invoice['showAfterPayment'] ) && $invoice['emailButton'] && ! $invoice['showAfterPayment'] ? 'pdf-enable' : ''; ?>" v-if="getSettings">
									<button class="calc-btn-action success"><?php esc_html_e( 'Submit', 'cost-calculator-builder-pro' ); ?></button>
									<?php if ( isset( $invoice['showAfterPayment'] ) && $invoice['use_in_all'] && ! $invoice['showAfterPayment'] ) : ?>
										<button class="calc-btn-action" @click="getInvoice">
											<?php echo isset( $invoice['buttonText'] ) ? esc_html( $invoice['buttonText'] ) : ''; ?>
											<div class="invoice-btn-loader"></div>
										</button>
										<?php if ( isset( $invoice['emailButton'] ) && $invoice['emailButton'] ) : ?>
											<button class="calc-btn-action" @click="showSendPdf">
												<span><?php echo isset( $invoice['btnText'] ) ? esc_html( $invoice['btnText'] ) : esc_html__( 'Send Quote', 'cost-calculator-builder-pro' ); ?></span>
											</button>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						</template>
					<?php endif; ?>
				</div>
			</calc-form>
		</div>
	</div>
</div>
