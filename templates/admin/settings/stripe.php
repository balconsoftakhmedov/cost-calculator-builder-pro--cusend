<?php
$desc_url = 'https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/woo-checkout';
?>
<div class="ccb-grid-box">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'Stripe', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="settingsField.stripe.enable"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Stripe', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !settingsField.stripe.enable}">
			<div class="row ccb-p-t-15" v-if="extended">
				<div class="col-12">
					<div class="ccb-extended-general">
						<span class="ccb-heading-4"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to', 'cost-calculator-builder-pro' ); ?> <b><?php esc_html_e( 'Settings → Stripe', 'cost-calculator-builder-pro' ); ?></b> <?php esc_html_e( ' and turn off the setting', 'cost-calculator-builder-pro' ); ?> <b><?php esc_html_e( '“Apply for all calculators”', 'cost-calculator-builder-pro' ); ?></b></span>
						<span class="ccb-extended-general-action ccb-light">
							<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=stripe' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
						</span>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15" :class="{disabled: extended}">
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Public Key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.stripe.publishKey" placeholder="<?php esc_attr_e( 'Enter stripe public key', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Secret Key', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.stripe.secretKey" placeholder="<?php esc_attr_e( 'Enter stripe secret key', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.stripe.currency" placeholder="<?php esc_attr_e( 'Enter currency for payment', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-9">
					<span class="ccb-field-title">
						<?php esc_html_e( 'Total Field Element', 'cost-calculator-builder-pro' ); ?>
					</span>
					<span class="ccb-field-totals">
						<label class="ccb-field-totals-item ccb-default-title" v-for="formula in getFormulaFields" :for="'stripe_' + formula.idx">{{ formula.title | to-short-description }}</label>
					</span>
					<div class="ccb-select-box">
						<div class="multiselect">
							<span v-if="formulas.length > 0 && formulas.length <= 3" class="anchor ccb-heading-5 ccb-selected" @click.prevent="multiselectShow(event)">
								<span class="selected-payment" v-for="formula in formulas">
									{{ formula.title | to-short-input }}
									<i class="ccb-icon-close" @click.self="removeIdx( formula )" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}"></i>
								</span>
							</span>
							<span v-else-if="formulas.length > 0 && formulas.length > 3" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShow(event)">
								{{ formulas.length }} <?php esc_attr_e( 'totals selected', 'cost-calculator-builder-pro' ); ?>
							</span>
							<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
								<?php esc_html_e( 'Select totals', 'cost-calculator-builder-pro' ); ?>
							</span>
							<ul class="items row-list settings-list totals">
								<li class="option-item settings-item" v-for="formula in getFormulaFields" :key="formula.idx" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}">
									<input :id="'stripe_' + formula.idx" :checked="getTotalsIdx.includes(+formula.idx)" name="stripeTotals" class="index" type="checkbox" @change="multiselectChooseTotals(formula)"/>
									<label :for="'stripe_' + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
								</li>
							</ul>
							<input name="options" type="hidden" />
						</div>
						<div class="ccb-select-description ccb-default-description">
							<?php esc_html_e( "Connect your selling service or product to online payment systems using the connection shortcode. Note that the 'Total Name' field will be renamed to 'Total'.", 'cost-calculator-builder-pro' ); ?>
							<a href="<?php echo esc_attr( $desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn More', 'cost-calculator-builder-pro' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
