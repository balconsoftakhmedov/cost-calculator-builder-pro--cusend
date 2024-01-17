<div class="ccb-grid-box stripe">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Stripe', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.stripe.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.stripe.use_in_all}">
			<div class="row ccb-p-t-15">
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Public Key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.stripe.publishKey" placeholder="<?php esc_attr_e( 'Enter stripe public key', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Secret Key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.stripe.secretKey" placeholder="<?php esc_attr_e( 'Enter stripe secret key', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.stripe.currency" placeholder="<?php esc_attr_e( 'Enter currency', 'cost-calculator-builder-pro' ); ?>">
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
