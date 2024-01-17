<?php
/**
 * @file
 * Cost-date-picker component's template
 */

	$lang = get_bloginfo( 'language' );
?>
<div :style="additionalCss" class="calc-item ccb-field" :class="{rtl: rtlClass('<?php echo esc_attr( $lang ); ?>'),required: $store.getters.isUnused(multiRange), [multiRange.additionalStyles]: multiRange.additionalStyles}" :data-id="multiRange.alias">
	<div class="calc-range " :class="['calc_' + multiRange.alias, {'calc-field-disabled': getStep === 'finish'}]">
		<div class="calc-item__title ccb-range-field">
			<span>
				{{ multiRange.label }}
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
				<span class="ccb-required-mark" v-if="multiRange.required">*</span>
				<span v-if="multiRange.required" class="calc-required-field">
					<div class="ccb-field-required-tooltip">
						<span class="ccb-field-required-tooltip-text" :class="{active: $store.getters.isUnused(multiRange)}" style="display: none;">
							{{ $store.getters.getSettings.texts.required_msg }}
						</span>
					</div>
				</span>
			</span>
			<span> {{ leftVal }} - {{ rightVal }}  {{ multiRange.sign ? multiRange.sign : '' }}</span>
		</div>

		<div class="calc-item__description before">
			<span v-html="multiRange.description"></span>
		</div>

		<div :class="['range_' + multiRange.alias]" class="calc-range-slider" data-ticks-position="top" :style="getStyles">
			<input type="range" :min="min" :max="max" v-model="leftVal" :step="step" v-model="leftVal" @input="change">
			<output class="cost-calc-range-output-pro"></output>
			<input type="range" :min="min" :max="max" v-model="rightVal" :step="step" v-model="rightVal" @input="change">
			<output class="cost-calc-range-output-pro"></output>
			<div class='calc-range-slider__progress'></div>
		</div>

		<div class="calc-range-slider-min-max">
			<span>{{ min }}</span>
			<span>{{ max }}</span>
		</div>

		<div class="calc-item__description after">
			<span v-html="multiRange.description"></span>
		</div>
	</div>
</div>
