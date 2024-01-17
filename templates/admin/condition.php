<div class="ccb-condition-content ccb-custom-scrollbar large" style="overflow: scroll">
	<flow-chart v-if="open" @update="change" :scene.sync="scene" @linkEdit="linkEdit" :height="height"/>
</div>
<div class="ccb-conditions-elements-wrapper" :style="{transform: collapse ? 'translateX(100%)' : ''}">
	<div class="ccb-condition-toggle" @click="collapseCondition">
		<i class="ccb-icon-Path-3398" :style="{transform: collapse ? 'rotate(0)' : ''}"></i>
	</div>
	<div class="ccb-condition-elements ccb-custom-scrollbar">
		<div class="ccb-sidebar-header">
			<span class="ccb-default-title large ccb-bold" v-if="getElements.length"><?php esc_html_e( 'Add elements', 'cost-calculator-builder-pro' ); ?></span>
			<span class="ccb-condition-elements-empty" v-else>
				<span class="ccb-default-title large ccb-bold" style="color: #878787"><?php esc_html_e( 'As per current', 'cost-calculator-builder-pro' ); ?></span>
				<span class="ccb-default-title large ccb-bold" style="color: #878787"><?php esc_html_e( 'Nothing will be changed', 'cost-calculator-builder-pro' ); ?></span>
			</span>
		</div>
		<div class="ccb-conditions-items">
			<template v-for="( field, index ) in getElements">
				<div class="ccb-conditions-item" @click.prevent="newNode(field)">
					<span class="ccb-conditions-item-icon">
						<i :class="field.icon"></i>
					</span>
					<span class="ccb-conditions-item-box">
						<span class="ccb-default-title ccb-bold" v-if="field.label && field.label.length">{{ field.label | to-short }}</span>
						<span class="ccb-default-description">{{ field.text }}</span>
					</span>
					<span class="ccb-icon-Path-3493 ccb-conditions-item-add" @click.prevent="newNode(field)"></span>
				</div>
			</template>
			<div class="ccb-sidebar-item-empty"></div>
		</div>
	</div>
</div>
