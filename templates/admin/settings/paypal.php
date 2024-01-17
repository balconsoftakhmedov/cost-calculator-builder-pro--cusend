<?php
$desc_url = 'https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/woo-checkout';
?>

<div class="ccb-grid-box">
	<div class="container">
		<div class="row ccb-p-t-15">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'PayPal', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="settingsField.paypal.enable"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'PayPal', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !settingsField.paypal.enable}">
			<div class="row ccb-p-t-15" v-if="extended">
				<div class="col-12">
					<div class="ccb-extended-general">
						<span class="ccb-heading-4 ccb-bold"><?php esc_html_e( 'Global settings applied', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-extended-general-description ccb-default-title ccb-light"><?php esc_html_e( 'If you want to set up a specific calculator, please go to', 'cost-calculator-builder-pro' ); ?><b><?php esc_html_e( 'Settings → PayPal', 'cost-calculator-builder-pro' ); ?></b> <?php esc_html_e( 'and turn off the setting', 'cost-calculator-builder-pro' ); ?><b><?php esc_html_e( '“Apply for all calculators”', 'cost-calculator-builder-pro' ); ?></b></span>
						<span class="ccb-extended-general-action">
							<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings&option=paypal' ); ?>" class="ccb-button ccb-href success"><?php esc_html_e( 'Go to Settings', 'cost-calculator-builder-pro' ); ?></a>
						</span>
					</div>
				</div>
			</div>
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
			<div class="row ccb-p-t-15" :class="{disabled: extended}">
				<div class="col col-3">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" v-model="settingsField.paypal.paypal_email" placeholder="<?php esc_attr_e( 'Enter PayPal email', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Currency', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="settingsField.paypal.currency_code">
								<option value="" selected disabled><?php esc_html_e( 'Select Currency Symbol', 'cost-calculator-builder-pro' ); ?></option>
								<option v-for="(element, index) in currencies" :key="index" :value="element.value">{{element.alias}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col col-3">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Account Type', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="settingsField.paypal.paypal_mode">
								<option value="" selected disabled><?php esc_html_e( '- Select type of .... -', 'cost-calculator-builder-pro' ); ?></option>
								<option v-for="(element, index) in modes" :key="index" :value="element.value">{{ element.alias }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-9">
					<span class="ccb-field-title">
						<?php esc_html_e( 'Total Field Element', 'cost-calculator-builder-pro' ); ?>
					</span>
					<span class="ccb-field-totals">
						<label class="ccb-field-totals-item ccb-default-title" v-for="formula in getFormulaFields" :for="'paypal_' + formula.idx">{{ formula.title | to-short-description }}</label>
					</span>
					<div class="ccb-select-box">
						<div class="multiselect">
							<span v-if="formulas.length > 0 && formulas.length <= 3" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" @click.prevent="multiselectShow(event)">
								<span class="selected-payment" v-for="formula in formulas">
									{{ formula.title | to-short-input  }}
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
								<li class="option-item settings-item" v-for="formula in getFormulaFields" :class="{'settings-item-disabled': getTotalsIdx.length === 1 && getTotalsIdx.includes(+formula.idx)}">
									<input :id="'paypal_' + formula.idx" :checked="getTotalsIdx.includes(+formula.idx)" name="paypalTotals" class="index" type="checkbox" @change="multiselectChooseTotals(formula)"/>
									<label :for="'paypal_' + formula.idx" class="ccb-heading-5">{{ formula.title | to-short }}</label>
								</li>
							</ul>
							<input name="options" type="hidden" />
						</div>
						<div class="ccb-select-description ccb-default-description">
							<?php esc_html_e( "Connect your selling service or product to online payment systems using the connection shortcode. Note that the 'Total Name' field will be renamed to ‘Total'.", 'cost-calculator-builder-pro' ); ?>
							<a href="<?php echo esc_attr( $desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn More', 'cost-calculator-builder-pro' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
