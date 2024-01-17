<div class="ccb-grid-box paypal">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'PayPal', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.paypal.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.paypal.use_in_all}">
			<div class="row ccb-p-t-15">
				<div class="col col-12">
					<div class="ccb-short-code">
						<span class="ccb-short-code-label">
							<span class="ccb-default-title"><?php esc_html_e( 'PayPal IPN Setup:', 'cost-calculator-builder-pro' ); ?></span>
							<span class="ccb-short-code-copy" style="max-width: 100%">
								<span class="code"><?php echo esc_url( get_site_url() ); ?>/?stm_ccb_check_ipn=1</span>
								<span class="ccb-copy-icon ccb-icon-Path-3400 ccb-tooltip" @click.prevent="copyShortCode('paypal-ipn')" @mouseleave="resetCopy">
									<span class="ccb-tooltip-text" style="right: 0; left: -100px">{{ shortCode.text }}</span>
									<input type="hidden" class="calc-short-code" data-id="paypal-ipn" value="<?php echo esc_url( get_site_url() ); ?>/?stm_ccb_check_ipn=1">
								</span>
							</span>
						</span>
						<span class="ccb-default-description"><?php esc_html_e( 'Use the URL for IPN Listener Settings', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.paypal.paypal_email" placeholder="<?php esc_attr_e( 'Enter PayPal email', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="generalSettings.paypal.currency_code">
								<option value=""><?php esc_html_e( 'Select currency sign', 'cost-calculator-builder-pro' ); ?></option>
								<option v-for="(element, index) in currencies" :key="index" :value="element.value">{{ element.alias }}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Account Type', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="generalSettings.paypal.paypal_mode">
								<option value="" disabled><?php esc_html_e( 'Not selected', 'cost-calculator-builder-pro' ); ?></option>
								<option value="live"><?php esc_html_e( 'Live', 'cost-calculator-builder-pro' ); ?></option>
								<option value="sandbox"><?php esc_html_e( 'Sandbox', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
