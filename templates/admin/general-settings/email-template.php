<div class="ccb-grid-box email">
	<div class="container">
		<div class="row">
			<div class="col-6">
				<div class="row ccb-p-t-15">
					<div class="col">
						<span class="ccb-tab-title"><?php esc_html_e( 'Email Template', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-5">
						<div class="ccb-color">
							<span class="ccb-color__title"><?php esc_html_e( 'Template Background', 'cost-calculator-builder-pro' ); ?></span>
							<color-picker :element="generalSettings.email_templates.template_color" />
						</div>
					</div>
					<div class="col-5">
						<div class="ccb-color">
							<span class="ccb-color__title"><?php esc_html_e( 'Content Background', 'cost-calculator-builder-pro' ); ?></span>
							<color-picker :element="generalSettings.email_templates.content_bg"/>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-5">
						<div class="ccb-color">
							<span class="ccb-color__title"><?php esc_html_e( 'Main Text Color', 'cost-calculator-builder-pro' ); ?></span>
							<color-picker :element="generalSettings.email_templates.main_text_color" />
						</div>
					</div>
					<div class="col-5">
						<div class="ccb-color">
							<span class="ccb-color__title"><?php esc_html_e( 'Border Color', 'cost-calculator-builder-pro' ); ?></span>
							<color-picker :element="generalSettings.email_templates.border_color" />
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-5">
						<div class="ccb-color">
							<span class="ccb-color__title"><?php esc_html_e( 'Button Color', 'cost-calculator-builder-pro' ); ?></span>
							<color-picker :element="generalSettings.email_templates.button_color" />
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
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
					<div class="col col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Customer email title', 'cost-calculator-builder-pro' ); ?></span>
							<input type="text" v-model="generalSettings.email_templates.title" placeholder="<?php esc_attr_e( 'Enter customer email title', 'cost-calculator-builder-pro' ); ?>" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="ccb-input-wrapper">
							<span class="ccb-input-label"><?php esc_html_e( 'Customer email description', 'cost-calculator-builder-pro' ); ?></span>
							<ccb-editor v-model="generalSettings.email_templates.description" placeholder="<?php echo esc_attr__( 'Enter email description', 'cost-calculator-builder-pro' ); ?>" class="ccb-heading-5 ccb-light show-triangle"></ccb-editor>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col-12">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="generalSettings.email_templates.footer"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'Plugin branding in footer section', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-20">
					<div class="col-3">
						<button class="ccb-button success ccb-settings" @click="saveGeneralSettings"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="email-preview-wrapper" :style="{ color:  generalSettings.email_templates.main_text_color.value }">
					<div class="email-preview" :style="{ backgroundColor: generalSettings.email_templates.template_color.value }">
						<div class="email-preview__header" :style="{ backgroundColor: generalSettings.email_templates.content_bg.value }">
							<img :src="filePath" v-if="filePath" alt="Email Logo">
						</div>
						<div class="email-preview-body">
							<div class="email-preview-body-summary" :style="{ backgroundColor: generalSettings.email_templates.content_bg.value }">
								<div class="email-preview__title">
									<div class="title">
										{{ generalSettings.email_templates.title }}
									</div>
									<div class="date">
										15 Feb 2022
									</div>
								</div>
								<div class="email-preview-body-summary__list">
									<div class="calc-subtotal-list-header" :style="{ backgroundColor: generalSettings.email_templates.border_color.value }">
										<span class="calc-subtotal-list-header__name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
										<span class="calc-subtotal-list-header__value"><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></span>
									</div>
									<ul class="summary-list">
										<li class="summary-list__item" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
											<div><?php esc_html_e( 'Market Analysis', 'cost-calculator-builder-pro' ); ?></div>
											<div style="text-align: right">$ 220.00</div>
											<ul>
												<li class="summary-list__item">
													<div class="wrapper">
														<div class="summary-list__item-unit">22x10</div>
													</div>
												</li>
											</ul>
										</li>
										<li class="summary-list__item" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
											<div><?php esc_html_e( 'Marketing Strategy', 'cost-calculator-builder-pro' ); ?></div>
											<div style="text-align: right">$ 250.00</div>
											<ul>
												<li class="summary-list__item">
													<div class="wrapper">
														<div class="summary-list__item-unit">25x10</div>
													</div>
												</li>
											</ul>
										</li>
										<li class="summary-list__item" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
											<div><?php esc_html_e( 'Choose options', 'cost-calculator-builder-pro' ); ?></div>
											<div style="text-align: right">$ 250.00</div>
											<ul>
												<li class="summary-list__item">
													<div class="wrapper">
														<div><?php esc_html_e( 'Sales Audit', 'cost-calculator-builder-pro' ); ?></div>
														<div>$ 250.00</div>
													</div>
												</li>
												<li class="summary-list__item">
													<div class="wrapper">
														<div><?php esc_html_e( 'HR Services', 'cost-calculator-builder-pro' ); ?></div>
														<div>$ 200.00</div>
													</div>
												</li>
											</ul>
										</li>
									</ul>
								</div>

								<div class="email-preview__total" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
									<div><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></div>
									<div>
										$ 17,200.00
									</div>
								</div>

								<div class="email-preview__files">
									<div class="email-preview-file" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
										<div class="email-preview-file__icon">
											<img src="<?php echo esc_attr( CALC_URL . '/frontend/dist/img/file-text.png' ); ?>"/>
										</div>
										<div class="email-preview-file__info">
											<span><?php esc_html_e( 'Attach file:', 'cost-calculator-builder-pro' ); ?></span>
											<span><?php esc_html_e( 'Annual_report.pdf', 'cost-calculator-builder-pro' ); ?></span>
										</div>
										<div class="email-preview-file__button"  :style="{ backgroundColor: generalSettings.email_templates.button_color.value }">
											<?php esc_html_e( 'Download', 'cost-calculator-builder-pro' ); ?>
										</div>
									</div>
									<div class="email-preview-file" :style="{ borderColor: generalSettings.email_templates.border_color.value }">
										<div class="email-preview-file__icon">
											<img src="<?php echo esc_attr( CALC_URL . '/frontend/dist/img/file-text.png' ); ?> "/>
										</div>
										<div class="email-preview-file__info">
											<span><?php esc_html_e( 'Attach file:', 'cost-calculator-builder-pro' ); ?></span>
											<span><?php esc_html_e( 'Annual_report.pdf', 'cost-calculator-builder-pro' ); ?></span>
										</div>
										<div class="email-preview-file__button" :style="{ backgroundColor: generalSettings.email_templates.button_color.value }">
											<?php esc_html_e( 'Download', 'cost-calculator-builder-pro' ); ?>
										</div>
									</div>
								</div>
							</div>

							<div class="email-preview-description" v-html="generalSettings.email_templates.description">
							</div>
						</div>
						<div class="email-preview__footer" v-if="generalSettings.email_templates.footer">
							<span>
								<?php esc_html_e( 'Powered by:', 'cost-calculator-builder-pro' ); ?>
							</span>
							<span>
								<img src="<?php echo esc_attr( CALC_URL . '/frontend/dist/img/email_footer_logo.png' ); ?>">
							</span>
						</div>
					</div>
				</div>
				<div class="email-preview-docs">
					<span><?php esc_attr_e( 'Email not sending?' ); ?></span>
					<a href="https://docs.stylemixthemes.com/cost-calculator-builder/troubleshooting/email-not-sending" target="_blank"><?php esc_attr_e( 'Check out this article' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>


