<?php
/**
 * @file
 * Cost-time-picker component's template
 */
?>

<div :style="additionalCss" class="calc-item ccb-field" :class="[timePickerField.additionalStyles, {required: $store.getters.isUnused(timePickerField)}]" :data-id="timePickerField.alias">
	<div class="calc-item__title">
		<span> {{ timePickerField.label }} </span>
		<span class="ccb-required-mark" v-if="timePickerField.required">*</span>
		<span class="is-pro">
			<span class="pro-tooltip">
				pro
				<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
			</span>
		</span>
	</div>

	<div class="calc-item__description before">
		<span>{{ timePickerField.description }}</span>
	</div>
	<div :class="['calc_' + timePickerField.alias] " :style="getStyles">
		<div :class="['ccb-datetime', 'datetime', 'ccb-time-picker', timePickerField.alias, timePickerField.alias + '_datetime']">
			<span v-if="timePickerField.required" class="ccb-error-tip front default" :class="getTimePickerErrorClasses" >{{ $store.getters.getSettings.texts.required_msg }}</span>
			<span class="error-tip" :class=" {'hidden': !timeRangeSecond}" v-if="( errors.length > 0 && timePickerField.range && (this.selectedTime.end === '' || this.selectedTime.start === '') )">{{ errors.join('') }}</span>
			<div class="ccb-time-picker-wrapper " :class="getTimePickerClasses">
				<div v-if="!timePickerField.range" class="ccb-time-picker-basic">
					<vue-timepicker
						v-model="selectedTime.basic"
						:placeholder="this.placeholderText"
						:format="format"
						:minute-interval="5"
						drop-direction="auto"
						:class="getPickerControlBasic"
						:manual-input="manualInput"
						ref="timePickerBasic"
						@focus="basicFocusPicker = 'focused'"
						@close="basicFocusPicker = ''"
						fixed-dropdown-button
						@input="updateSelectedTime($event,'basic')"
					>
						<template v-slot:dropdownButton>
							<i class="ccb-icon-timepicker-light-clock"></i>
						</template>

					</vue-timepicker>
				</div>
				<div v-else class="ccb-time-picker-range">
					<div class="start">
						<vue-timepicker
							v-model="selectedTime.start"
							:placeholder="this.placeholderText"
							:class="getPickerControlStart"
							fixed-dropdown-button
							drop-direction="auto"
							:format="format"
							ref="timePickerStart"
							:manual-input="manualInput"
							@focus="basicFocusPicker = 'focused'"
							@close="basicFocusPicker = ''"
							:minute-interval="5"
							@input="updateSelectedTime($event,'start')"
						>
							<template v-slot:dropdownButton>
								<i class="ccb-icon-timepicker-light-clock"></i>
							</template>

						</vue-timepicker>
					</div>
					<span class="separator"><?php esc_html_e( 'to', 'cost-calculator-builder-pro' ); ?></span>
					<div class="end">
						<vue-timepicker
							v-model="selectedTime.end"
							:placeholder="placeholderText"
							:class="getPickerControlEnd"
							fixed-dropdown-button
							drop-direction="auto"
							ref="timePickerEnd"
							@focus="basicFocusPicker = 'focused'"
							@close="basicFocusPicker = ''"
							:format="format"
							:minute-interval="5"
							:manual-input="manualInput"
							@input="updateSelectedTime($event, 'end')"
						>
							<template v-slot:dropdownButton>
								<i class="ccb-icon-timepicker-light-clock"></i>
							</template>
						</vue-timepicker>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="calc-item__description after">
		<span>{{ timePickerField.description }}</span>
	</div>
</div>
