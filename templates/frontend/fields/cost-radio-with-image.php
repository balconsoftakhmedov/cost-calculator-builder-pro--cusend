<?php
/**
 * @file
 * Cost-quantity component's template
 */
?>
<div :style="additionalCss" class="calc-item ccb-field" :class="{required: $store.getters.isUnused(radioField), [radioField.additionalStyles]: radioField.additionalStyles}" :data-id="radioField.alias">
	<component :is="getStyle" :price="'<?php esc_attr_e( 'Price:', 'cost-calculator-builder-pro' ); ?>'" :field="radioField" :value="value" @update="updateValue"></component>
</div>
