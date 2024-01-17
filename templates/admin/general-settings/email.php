<div class="ccb-grid-box email">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.form_fields.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.form_fields.use_in_all}">
			<div class="row ccb-p-t-15">
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
						<input type="email" v-model="generalSettings.form_fields.adminEmailAddress" placeholder="<?php esc_attr_e( 'Enter your email', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Subject', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.form_fields.emailSubject" placeholder="<?php esc_attr_e( 'Enter subject', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.form_fields.submitBtnText" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-if="generalSettings.invoice.use_in_all" class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.invoice.emailButton"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5 email-quote-preview"><?php esc_html_e( 'Email Quote Button', 'cost-calculator-builder-pro' ); ?>
						<div class="ccb-preview">
							<span class="ccb-preview__title">
								<?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?>
								<div class="ccb-preview__wrapper">
									<div class="ccb-preview__img" style="background-image: url('<?php echo esc_attr( CALC_URL . '/images/send-email.jpg' ); ?>')"></div>
								</div>
							</span>
						</div>
					</h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.invoice.emailButton}">
			<div class="row ccb-p-t-15">
				<div class="col col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Submit Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.invoice.submitBtnText" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-4">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Email Quote Button Text', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="generalSettings.invoice.btnText" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col col-4">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Sender Email', 'cost-calculator-builder-pro' ); ?></span>
					<input type="email" v-model="generalSettings.invoice.fromEmail" placeholder="<?php esc_attr_e( 'From Email', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
				</div>
			</div>
			<div class="col col-4">
				<div class="ccb-input-wrapper">
					<span class="ccb-input-label"><?php esc_html_e( 'Sender Name', 'cost-calculator-builder-pro' ); ?></span>
					<input type="text" v-model="generalSettings.invoice.fromName" placeholder="<?php esc_attr_e( 'From Name', 'cost-calculator-builder-pro' ); ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ccb-p-t-20">
			<div class="col-3">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
