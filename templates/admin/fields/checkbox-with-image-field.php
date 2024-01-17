<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Image Checkbox', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save( checkboxField, id, index )"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ccb-edit-field-switch">
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
							<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
							<span class="ccb-fields-required" v-if="errorsCount > 0">{{ errorsCount }}</span>
						</div>
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'style'}" @click="tab = 'style'">
							<?php esc_html_e( 'Styles', 'cost-calculator-builder' ); ?>
						</div>
						<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'options'}" @click="tab = 'options'">
							<?php esc_html_e( 'Settings', 'cost-calculator-builder-pro' ); ?>
						</div>
					</div>
				</div>
				<div class="col-12" v-show="tab === 'style'" style="margin-top: 20px">
					<div class="ccb-field-styles-tooltip">
						<div class="ccb-field-styles-tooltip-content">
							<i class="ccb-icon-Path-3367"></i>
							<p class="ccb-default-title"><?php esc_html_e( 'You have chosen a style that requires filing in additional fields. For this, go to the "Element" tab.', 'cost-calculator-builder-pro' ); ?></p>
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
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="checkboxField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="checkboxField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-options-container ccb-with-img">
						<div class="ccb-options-header">
							<span><?php esc_html_e( 'Label', 'cost-calculator-builder-pro' ); ?></span>
							<span style="display: flex"><?php esc_html_e( 'Value', 'cost-calculator-builder-pro' ); ?>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text"><?php esc_html_e( 'This value can be used for calculation purposes, Use numbers only' ); ?></span>
								</span>
							</span>
							<span><?php esc_html_e( 'Image', 'cost-calculator-builder-pro' ); ?></span>
						</div>
						<draggable
							v-model="fieldOptions"
							class="ccb-options"
							draggable=".ccb-option"
							:animation="200"
							handle=".ccb-option-drag"
						>
							<div class="ccb-option" v-for="(option, index) in fieldOptions" :key="option">
								<div class="ccb-option-drag" :class="{disabled: fieldOptions.length === 1}">
									<i class="ccb-icon-drag-dots"></i>
								</div>
								<div class="ccb-option-delete" @click.prevent="removeOption(index, option.optionValue)" :class="{disabled: fieldOptions.length === 1}">
									<i class="ccb-icon-close"></i>
								</div>
								<div class="ccb-option-inner label-input">
									<div class="ccb-input-wrapper">
										<input type="text" class="ccb-heading-5 ccb-light" v-model="option.optionText" placeholder="<?php esc_attr_e( 'Option label', 'cost-calculator-builder-pro' ); ?>">
									</div>
								</div>
								<div class="ccb-option-inner value-input">
									<div class="ccb-input-wrapper number">
										<div class="ccb-input-box">
											<input type="text" class="ccb-heading-5 ccb-light" min="0" step="1" :name="'option_' + index" @keyup="checkRequired('errorOptionValue' + index)" v-model="option.optionValue" placeholder="<?php esc_attr_e( 'Option Value', 'cost-calculator-builder-pro' ); ?>">
											<span @click="numberCounterActionForOption(index)" class="input-number-counter up"></span>
											<span @click="numberCounterActionForOption(index, '-')" class="input-number-counter down"></span>
										</div>
									</div>
									<span :id="'errorOptionValue' + index"></span>
								</div>
								<img-selector v-if="checkboxField.styles && checkboxField.styles.style === 'with-icon'" :svg="true" :key="option.id + '_' + checkboxField.styles.style" :id="option.id" :index="index" :url="option.icon" @set="setThumbnail" :select_text="translations?.select_image"></img-selector>
								<img-selector v-else-if="checkboxField.styles" :key="option.id" :id="option.id + '_' + checkboxField.styles.style" :index="index" :url="option.src" @set="setThumbnail" :select_text="translations?.select_image"></img-selector>
							</div>
						</draggable>
						<div class="ccb-option-actions">
							<button class="ccb-button light" @click.prevent="addOption">
								<i class="ccb-icon-Path-3453"></i>
								<?php esc_html_e( 'Add new', 'cost-calculator-builder-pro' ); ?>
							</button>
						</div>
					</div>
				</div>
				<div class="col-12" style="margin-top: 20px">
					<div class="ccb-field-styles-tooltip ccb-info">
						<div class="ccb-field-styles-tooltip-content">
							<i class="ccb-icon-Path-3367"></i>
							<p class="ccb-default-title"><?php echo sprintf( __( 'You can find all the necessary icons in SVG format on %1$s or other services. %2$s', 'cost-calculator-builder-pro' ), '<a href="https://iconscout.com/" target="_blank">iconscout.com</a>', '<a href="https://iconscout.com/" target="_blank">Find out more.</a>'); // phpcs:ignore ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12 ccb-select-box">
					<span class="ccb-select-label"><?php esc_html_e( 'Default Value(s)', 'cost-calculator-builder' ); ?></span>
					<div class="ccb-multi-select" tabindex="100" @click.prevent="multiselectShow(event)">
						<i :class="['ccb-icon-Path-3485 ccb-select-arrow', {'ccb-arrow-up': multiselectOpened}]"></i>
						<span v-if="checkboxField.hasOwnProperty('default') && checkboxField.default.length > 0 && checkboxField.default.split(',').length <= 3" class="anchor ccb-heading-5 ccb-light-3 ccb-selected">
							<span class="selected" v-for="choosenOption in checkboxField.default.split(',')" >
								{{ getOptionTextByChoosenOption(choosenOption) }}
								<i class="ccb-icon-close" @click.self="removeFromDefaultValueByChoosenOption(choosenOption)" ></i>
							</span>
						</span>
						<span v-else-if="checkboxField.hasOwnProperty('default') && checkboxField.default.length > 0 && checkboxField.default.split(',').length > 3" class="anchor ccb-heading-5 ccb-light ccb-selected">
							{{ checkboxField.default.split(',').length }} <?php esc_html_e( 'options selected', 'cost-calculator-builder' ); ?>
						</span>
						<span v-else class="anchor ccb-heading-5 ccb-light-3">
								<?php esc_html_e( 'Select default values', 'cost-calculator-builder' ); ?>
						</span>
						<ul class="items">
							<li v-if="option.optionText.length > 0 && option.optionValue.length > 0" class="option-item" @click="chooseDefaultValues( optionIndex, option )"
								v-for="(option, optionIndex) in fieldOptions">
								<input :checked="( checkboxField.default.length > 0 && checkboxField.default.split(',').includes(option.optionValue + '_' + optionIndex) )"
										@change="chooseDefaultValues(optionIndex, option)"
										type="checkbox"/>
								{{ option.optionText }}
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15" v-if="errorsCount > 0">
				<div class="col-12">
					<div class="ccb-notice ccb-error">
						<span class="ccb-notice-title"><?php esc_html_e( 'Not Saved!', 'cost-calculator-builder-pro' ); ?></span>
						<span class="ccn-notice-description"><?php esc_html_e( 'Options tab contains errors, check the fields!', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'style' && typeof checkboxField.styles !== 'undefined'">
			<div class="row ccb-p-t-15" style="align-items: flex-end !important;" v-if="checkboxField.styles">
				<div class="col-6">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Style', 'cost-calculator-builder' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="checkboxField.styles.style" style="padding-right: 30px !important;">
								<option v-for="opt in getCheckboxStyles" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-6" v-if="checkboxField.styles.style !== 'default'">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Box style', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="checkboxField.styles.box_style" style="padding-right: 30px !important;">
								<option value="vertical"><?php esc_html_e( 'Vertical', 'cost-calculator-builder-pro' ); ?></option>
								<option value="horizontal"><?php esc_html_e( 'Horizontal', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-style-preview">
						<span class="ccb-style-preview-header"><?php esc_html_e( 'Style preview', 'cost-calculator-builder' ); ?></span>
						<img :src="getCurrentImage">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.apply_style_for_all"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5" style="font-size: 14px"><?php esc_html_e( 'Apply this image checkbox style to all image checkbox fields in this calculator', 'cost-calculator-builder' ); ?></h6>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'options'">
			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.allowCurrency"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Currency Sign', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.required"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.allowRound"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Round Value', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.hidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="checkboxField.addToSummary"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Allowed number of options to select', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="checkboxField.checkedLength" placeholder="<?php esc_attr_e( 'Set the max number of options allowed to select', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Additional Classes', 'cost-calculator-builder-pro' ); ?></span>
						<textarea class="ccb-heading-5 ccb-light" v-model="checkboxField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
