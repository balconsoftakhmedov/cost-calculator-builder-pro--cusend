<div class="ccb-grid-box captcha">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Captcha', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col col-3">
				<div class="ccb-select-box">
					<span class="ccb-select-label"><?php esc_html_e( 'reCAPTCHA version', 'cost-calculator-builder-pro' ); ?></span>
					<div class="ccb-select-wrapper">
						<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
						<select class="ccb-select" v-model="generalSettings.recaptcha.type">
							<option v-for="(option, key) in generalSettings.recaptcha.options" :key="key" :value="key">{{ option }}</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col col-3">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Site Key', 'cost-calculator-builder-pro' ); ?></span>
					<input type="text" v-model="generalSettings.recaptcha[generalSettings.recaptcha?.type || 'v2'].siteKey" placeholder="<?php esc_attr_e( 'Enter site key', 'cost-calculator-builder-pro' ); ?>">
				</div>
			</div>
			<div class="col col-3">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Secret Key', 'cost-calculator-builder-pro' ); ?></span>
					<input type="text" v-model="generalSettings.recaptcha[generalSettings.recaptcha?.type || 'v2'].secretKey" placeholder="<?php esc_attr_e( 'Enter secret key', 'cost-calculator-builder-pro' ); ?>">
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
