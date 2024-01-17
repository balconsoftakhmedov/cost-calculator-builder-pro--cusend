<div class="thank-you-page-notice" v-if="showNotice">
	<span v-html="'<?php echo esc_attr( sprintf( __( 'Note: %1$s will be shown only if %2$s is enabled or %3$s', 'cost-calculator-builder' ), '<b>“Confirmation page”</b>', '<b>Contact form</b>', '<b>Payment integration made</b>' ) ); ?>'"></span>
</div>
<div class="thank-you-page-wrapper" :style="{paddingTop: !showNotice ? '30px' : '0'}">
	<div class="ccb-grid-box" style="max-width: 380px" v-if="settingsField.thankYouPage">
		<div class="container" style="padding-left: 5px; padding-right: 5px">

			<div class="row ccb-p-t-15 ccb-p-b-10">
				<div class="col">
					<span class="ccb-tab-title"><?php esc_html_e( 'Confirmation page', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>

			<div class="row ccb-p-t-10">
				<div class="col-12">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Show this page on', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-wrapper">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="settingsField.thankYouPage.type">
								<option value="same_page"><?php esc_html_e( 'Same page as calculator', 'cost-calculator-builder-pro' ); ?></option>
								<option value="modal"><?php esc_html_e( 'Top of calculator as popup', 'cost-calculator-builder-pro' ); ?></option>
								<option value="separate_page"><?php esc_html_e( 'Separate page', 'cost-calculator-builder-pro' ); ?></option>
								<option value="custom_page"><?php esc_html_e( 'Custom page', 'cost-calculator-builder-pro' ); ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15" v-if="settingsField.thankYouPage.type === 'separate_page'">
				<div class="col-12">
					<div class="ccb-select-box">
						<span class="ccb-select-label">
							<?php esc_html_e( 'Select page', 'cost-calculator-builder-pro' ); ?>
							<span class="ccb-required-mark" v-if="isError('thankYouPage', 'page_id')">*</span>
						</span>
						<div class="ccb-select-wrapper" :class="{'ccb-input-required': isError('thankYouPage', 'page_id')}">
							<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
							<select class="ccb-select" v-model="settingsField.thankYouPage.page_id" @change="() => removeExactError('thankYouPage', 'custom_page_link')">
								<option value="" selected><?php esc_html_e( 'Select page', 'cost-calculator-builder-pro' ); ?></option>
								<option :value="page.id" v-for="page in $store.getters.getPages">{{ page.title }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row ccb-p-t-15" v-if="settingsField.thankYouPage.type === 'custom_page'">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label">
							<?php esc_html_e( 'Custom page Link', 'cost-calculator-builder-pro' ); ?>
							<span class="ccb-required-mark" v-if="isError('thankYouPage', 'custom_page_link')">*</span>
						</span>
						<input type="text" :class="{'ccb-input-required': isError('thankYouPage', 'custom_page_link')}" v-model="settingsField.thankYouPage.custom_page_link" @input="() => removeExactError('thankYouPage', 'custom_page_link')" placeholder="<?php esc_attr_e( 'Enter link', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>

			<template v-else>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Texts', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.title" placeholder="<?php esc_attr_e( 'Enter title', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<textarea class="ccb-heading-5" v-model="settingsField.thankYouPage.description" placeholder="<?php esc_attr_e( 'Enter body', 'cost-calculator-builder-pro' ); ?>"></textarea>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10">
					<div class="col-6">
						<div class="ccb-input-wrapper">
							<input type="text" v-model="settingsField.thankYouPage.order_title" placeholder="<?php esc_attr_e( 'Enter title', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
					<div class="col-6" style="padding-left: 0">
						<span>{ID number}</span>
					</div>
				</div>

				<div class="row ccb-p-t-15 ccb-p-b-15">
					<div class="col-12">
						<hr style="display: block; height: 1px; border: 0; border-top: 1px solid #dddddd; margin: 0; padding: 0;">
					</div>
				</div>

				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Back button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.back_button_text" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.thankYouPage.download_button"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Button to download receipt', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10" v-if="settingsField.thankYouPage.download_button">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.download_button_text" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.thankYouPage.share_button"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Button to share receipt', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10" v-if="settingsField.thankYouPage.share_button">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.share_button_text" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.thankYouPage.custom_button"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Add custom button', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10" v-if="settingsField.thankYouPage.custom_button">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Button text', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.custom_button_text" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>

				<div class="row ccb-p-t-10" v-if="settingsField.thankYouPage.custom_button">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Custom button Link', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="settingsField.thankYouPage.custom_button_link" placeholder="<?php esc_attr_e( 'Enter link', 'cost-calculator-builder-pro' ); ?>">
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>

	<div class="thank-you-page-preview" :style="{top: showNotice ? '60px' : '30px'}">
		<div v-if="settingsField.thankYouPage.type === 'custom_page'" class="thank-you-page-preview__custom_page">
			<img src="<?php echo esc_attr( esc_url( CALC_URL . '/frontend/dist/img/cf-placeholder.png' ) ); ?>" alt="custom page placeholder">
		</div>
		<default-wrapper :order="getOrder" :settings="getSettings" v-else>
			<?php require_once CCB_PRO_PATH . '/templates/frontend/partials/thank-you-page.php'; ?>
		</default-wrapper>
	</div>
</div>
