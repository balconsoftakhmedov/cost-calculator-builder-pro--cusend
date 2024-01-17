<div class="ccb-grid-box invoice-settings-page">
	<div class="container">
		<div class="row">
			<div class="col">
				<span class="ccb-tab-title"><?php esc_html_e( 'PDF Entries', 'cost-calculator-builder-pro' ); ?></span>
				<span class="ccb-tab-subtitle"><?php esc_html_e( 'Data will be shown on the PDF and printed copies of the invoice', 'cost-calculator-builder-pro' ); ?></span>
			</div>
		</div>
		<div class="row ccb-p-t-20">
			<div class="col">
				<div class="list-header">
					<div class="ccb-switch">
						<input type="checkbox" v-model="generalSettings.invoice.use_in_all"/>
						<label></label>
					</div>
					<h6 class="ccb-heading-5"><?php esc_html_e( 'Apply for all calculators', 'cost-calculator-builder-pro' ); ?></h6>
				</div>
			</div>
		</div>
		<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !generalSettings.invoice.use_in_all}">
			<div class="row">
				<div class="col-6">
					<div class="row ccb-p-t-20">
						<div class="col col-6">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Company Name', 'cost-calculator-builder-pro' ); ?></span>
								<input type="text" placeholder="<?php esc_attr_e( 'Enter company name', 'cost-calculator-builder-pro' ); ?>" v-model="generalSettings.invoice.companyName">
							</div>
						</div>
						<div class="col col-6">
							<div class="ccb-select-box">
								<span class="ccb-select-label"><?php esc_html_e( 'Date Format', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-select-wrapper">
									<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
									<select class="ccb-select" v-model="generalSettings.invoice.dateFormat">
										<option value="MM/DD/YYYY HH:mm"><?php esc_html_e( ' MM DD YYYY ', 'cost-calculator-builder-pro' ); ?></option>
										<option value="DD/MM/YYYY HH:mm"><?php esc_html_e( ' DD MM YYYY ', 'cost-calculator-builder-pro' ); ?></option>
										<option value="YY/MM/DD HH:mm"><?php esc_html_e( ' YY MM DD ', 'cost-calculator-builder-pro' ); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15">
						<div class="col">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( ' Company Info ', 'cost-calculator-builder-pro' ); ?></span>
								<textarea placeholder="<?php echo esc_attr( 'Enter company info' ); ?>" class="ccb-heading-5 ccb-light show-triangle" v-model="generalSettings.invoice.companyInfo"></textarea>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15">
						<div class="col">
							<div class="ccb-image-upload">
								<input type="file" class="ccb-image-upload-input" ref="file" @change="addImg">
								<span class="ccb-image-upload-label"><?php esc_html_e( 'Logo', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-image-upload-buttons" :class="{disable: buttonDisable}">
									<button class="ccb-button success" @click="chooseFile"><?php esc_html_e( 'Choose file', 'cost-calculator-builder-pro' ); ?></button>
									<button class="ccb-button" @click="showUrl"><?php esc_html_e( 'Upload from URL', 'cost-calculator-builder-pro' ); ?></button>
								</div>
								<div class="ccb-image-upload-byurl" v-if="showUrlInput" :class="{ disable: buttonDisable }">
									<input type="text" v-model="fileUrl">
									<button class="ccb-button success" @click="downloadByUrl"><?php esc_html_e( 'Download', 'cost-calculator-builder-pro' ); ?></button>
								</div>
								<span class="ccb-image-upload-error" v-if="error">{{ error }}</span>
								<img :src="filePath" v-if="filePath" class="ccb-image-upload-preview" alt="Logo">
								<span class="ccb-image-upload-filename" v-if="filePath">
									{{ imgName }}
									<i class="remove ccb-icon-close" @click="clear"></i>
								</span>
								<span class="ccb-image-upload-info"><?php esc_html_e( 'Supported file formats: JPG, PNG — max 10mb', 'cost-calculator-builder-pro' ); ?></span>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15">
						<div class="col-12">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Button Text', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-preview">
									<span class="ccb-preview__title">
										<?php esc_html_e( 'Preview', 'cost-calculator-builder-pro' ); ?>
										<div class="ccb-preview__wrapper">
											<div class="ccb-preview__img" style="background-image: url('<?php echo esc_attr( CALC_URL . '/images/pdf.png' ); ?>')">
												<button>Purchase</button>
												<button>{{ buttonTextPreview }}</button>
											</div>
										</div>
									</span>
								</div>
								<input type="text" placeholder="<?php esc_attr_e( 'Enter button text', 'cost-calculator-builder-pro' ); ?>" v-model="generalSettings.invoice.buttonText">
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15">
						<div class="col">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="generalSettings.invoice.showAfterPayment"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-5"><?php esc_html_e( 'Show button only after making payment', 'cost-calculator-builder-pro' ); ?></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-15">
			<div class="col">
				<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>
	</div>
</div>
