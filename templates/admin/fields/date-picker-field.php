<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Date Picker', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="saveField"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>

	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-edit-field-switch">
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
							<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
						</div>
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'settings'}" @click="tab = 'settings'">
							<?php esc_html_e( 'Settings', 'cost-calculator-builder' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'main'">
			<div class="row ccb-p-t-15">
				<div class="col">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
				<div class="col">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Placeholder', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.placeholder" placeholder="<?php esc_attr_e( 'Enter field placeholder', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="dateField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-6" :class="{'disabled': !dateField.min_date}">
					<div class="ccb-input-wrapper number">
						<span class="ccb-input-label"><?php esc_html_e( 'Starts from the current date', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccb-help-tip-block">
							<i class="ccb-icon-Path-3367"></i>
							<span class="ccb-help" >
								<span class="ccb-help-tip ccb-default-title">
									<span><?php esc_attr_e( 'Set 0 for current date to be a', 'cost-calculator-builder-pro' ); ?></span>
									<span><?php esc_attr_e( 'minimum date for selection', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</span>
						</span>
						<div class="ccb-input-box">
							<input type="number" class="ccb-heading-5 ccb-light" name="min_date_days" step="1" min="0" v-model="dateField.min_date_days" @input="validate" placeholder="<?php esc_attr_e( 'Set 0 for current date to be a minimum date for selection', 'cost-calculator-builder-pro' ); ?>">
							<span @click="numberCounterAction('min_date_days')" class="input-number-counter up"></span>
							<span @click="numberCounterAction('min_date_days', '-')" class="input-number-counter down"></span>
						</div>
						<span v-if="errors.hasOwnProperty('min_date_days') && errors.min_date_days == true" class="ccb-error-tip default"><?php esc_attr_e( 'Value must be integer', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="col-6">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Calendar Option', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="dateField.range">
								<option value="1"><?php esc_html_e( 'With range', 'cost-calculator-builder-pro' ); ?></option>
								<option value="0"><?php esc_html_e( 'No range', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'settings'">
			<div class="row ccb-p-t-20">
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.required"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.hidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-12 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.min_date"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Toggle Date Picking Restrictions', 'cost-calculator-builder-pro' ); ?></h6>
						<span class="ccb-help-tip-block">
							<i class="ccb-icon-Path-3367"></i>
							<span class="ccb-help">
								<span class="ccb-help-tip ccb-default-title">
									<span><?php esc_attr_e( 'Disable for no restrictions set', 'cost-calculator-builder-pro' ); ?></span>
									<span><?php esc_attr_e( '(i.e. for date of birth)', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</span>
						</span>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="dateField.addToSummary"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Additional Classes', 'cost-calculator-builder-pro' ); ?></span>
						<textarea class="ccb-heading-5 ccb-light" v-model="dateField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
