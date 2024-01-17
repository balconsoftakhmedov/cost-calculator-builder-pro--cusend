<?php
$desc_url                = 'https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/custom-webhooks';
$form_submitted_desc_url = ' https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/custom-webhooks#when-contact-form-submitted';
$payment_btn_desc_url    = 'https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/custom-webhooks#when-a-user-clicks-the-payment-button';
$email_quote_desc_url    = 'https://docs.stylemixthemes.com/cost-calculator-builder/pro-plugin-features/custom-webhooks#when-pdf-quote-is-emailed';
?>
<div class="ccb-grid-wrapper">
	<div class="ccb-grid-wrapper-left">
		<div class="ccb-grid-box">
			<div class="container">
				<div class="ccb-p-b-15">
					<div>
						<span class="ccb-tab-title"><?php esc_html_e( 'Webhooks', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-select-description ccb-default-description">
							<?php esc_html_e( "Please note that if the action is not activated, the webhook setting won't be available.", 'cost-calculator-builder-pro' ); ?>
						</div>
					</div>
				</div>

				<div class="ccb-border-top" v-if="!settingsField.formFields.accessEmail && !generalSettings.form_fields.use_in_all"></div>
				<div class="ccb-p-t-b-20" v-if="!settingsField.formFields.accessEmail && !generalSettings.form_fields.use_in_all">

					<div class="list-header">
						<div class="ccb-locked">
							<span class="ccb-icon-Lock-filled"></span>
						</div>
						<div class="col">
							<div class="list-header">
								<h6 class="ccb-heading-5 ccb-heading-5-not-enabled">
									<?php esc_html_e( 'When user submits', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Send form', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
							<div class="ccb-select-box">
								<div class="ccb-select-description ccb-default-description">
									<?php esc_html_e( 'This webhook will be available after you', 'cost-calculator-builder-pro' ); ?>
									<span><?php esc_html_e( 'enable', 'cost-calculator-builder-pro' ); ?></span>
									<?php esc_html_e( 'Send Form.', 'cost-calculator-builder-pro' ); ?>
									<a href="<?php echo esc_attr( $form_submitted_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'cost-calculator-builder-pro' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>	

				<div class="ccb-border-top" v-if="!settingsField.paypal.enable && !settingsField.stripe.enable && !generalSettings.paypal.use_in_all && !generalSettings.stripe.use_in_all"></div>
				<div class="ccb-p-t-b-20" v-if="!settingsField.paypal.enable && !settingsField.stripe.enable && !generalSettings.paypal.use_in_all && !generalSettings.stripe.use_in_all">
					<div class="list-header">
						<div class="ccb-locked">
								<span class="ccb-icon-Lock-filled"></span>
						</div>
						<div class="col">
							<div class="list-header">
								<h6 class="ccb-heading-5 ccb-heading-5-not-enabled">
									<?php esc_html_e( 'When user clicks', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Payment button', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
							<div class="ccb-select-box">
								<div class="ccb-select-description ccb-default-description">
									<?php esc_html_e( 'This webhook will be available after you', 'cost-calculator-builder-pro' ); ?>
									<span><?php esc_html_e( 'enable', 'cost-calculator-builder-pro' ); ?></span>
									<?php esc_html_e( 'Payment method.', 'cost-calculator-builder-pro' ); ?>
									<a href="<?php echo esc_attr( $payment_btn_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'cost-calculator-builder-pro' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>	
				
				<div class="ccb-border-top" v-if="!generalSettings.invoice.emailButton"></div>
				<div class="ccb-p-t-b-20" v-if="!generalSettings.invoice.emailButton">
					<div class="list-header">
						<div class="ccb-locked">
							<span class="ccb-icon-Lock-filled"></span>
						</div>
						<div class="col">
							<div class="list-header">
								<h6 class="ccb-heading-5 ccb-heading-5-not-enabled">
									<?php esc_html_e( 'When user sends', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Email quote', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
							<div class="ccb-select-box">
								<div class="ccb-select-description ccb-default-description">
									<?php esc_html_e( 'This webhook will be available after you', 'cost-calculator-builder-pro' ); ?>
									<span><?php esc_html_e( 'enable', 'cost-calculator-builder-pro' ); ?></span>
									<?php esc_html_e( 'Email quote.', 'cost-calculator-builder-pro' ); ?>
									<a href="<?php echo esc_attr( $email_quote_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'cost-calculator-builder-pro' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>	


				<div class="ccb-sendform-webhook" v-if="settingsField.formFields.accessEmail || generalSettings.form_fields.use_in_all">
					<div class="ccb-border-top"></div>
					<div class="row ccb-p-t-b-20">
						<div class="col">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="settingsField.webhooks.enableSendForms"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-5">
									<?php esc_html_e( 'When user submits', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Send form', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
						</div>
					</div>
					<div class="ccb-settings-property" :class="{'ccb-webhook-send-block-hidden': !settingsField.webhooks.enableSendForms}">
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper"> 
								<span class="ccb-field-title"><?php esc_html_e( 'Webhook link', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper">
										<input type="text" v-model="settingsField.webhooks.send_form_url"/>
									</div>
									<button class="ccb-button ccb-href success" @click.prevent="sendDemoData('send-form')"><?php esc_html_e( 'Send demo data', 'cost-calculator-builder-pro' ); ?></button>
									<div class="ccb-select-box">
										<div class="ccb-select-description ccb-default-description">
												<?php esc_html_e( 'Enter the received link from the automation service and send the demo data to check the connection.', 'cost-calculator-builder-pro' ); ?>
												<a href="<?php echo esc_attr( $form_submitted_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Read guide', 'cost-calculator-builder-pro' ); ?></a>
										</div>
									</div>
									<div @click="toggleItem('sendFormVisible')" ref="sendForm" class="ccb-select-description ccb-default-description ccb-desc-left">
										<span class="ccb-icon-Path-3367"></span>
										<span class="ccb-wh-demo-text">
											<?php esc_html_e( 'What is demo data', 'cost-calculator-builder-pro' ); ?>
										</span>
										<div ref="sendFormDemoBox" class="ccb-demo-box" >
											<div v-if="sendFormVisible" class="ccb-demo-inner-list">
												<div class="ccb-demo-rectangle"></div>
												<div class="ccb-demo-inner-title">
													<h5><?php esc_html_e( 'What is demo data?', 'cost-calculator-builder-pro' ); ?></h5>
													<span class="ccb-demo-title-desc">
														<?php esc_html_e( 'The Demo Data is used for initial configuration of Webhooks. The demo data will be sent with a value of 100:', 'cost-calculator-builder-pro' ); ?>
													</span>	
												</div>
												<div class="ccb-demo-data-content" >
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">$100</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">John Doe</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">test@stylemixthemes.com</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Phone', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">+1 111 111 11 11</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Message', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value"><?php esc_html_e( 'This is a sample message', 'cost-calculator-builder-pro' ); ?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper">
								<span class="ccb-field-title"><?php esc_html_e( 'Secret key or Token (optional)', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper" >
										<input v-if="showPassword1" type="text" v-model="settingsField.webhooks.secret_key_send_form" class="ccb-key-password"/>
										<input v-else type="password" v-model="settingsField.webhooks.secret_key_send_form" class="ccb-key-password"/>
										<div @click="toggleItem('showPassword1')" class="ccb-hide-password"><span :class="{ 'ccb-icon-Eye': showPassword1, 'ccb-icon-Eye-Off': !showPassword1 }"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="ccb-payment-webhook" v-if="settingsField.paypal.enable || settingsField.stripe.enable || generalSettings.paypal.use_in_all || generalSettings.stripe.use_in_all">
					<div class="ccb-border-top"></div>	
					<div class="row ccb-p-t-b-20">
						<div class="col">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="settingsField.webhooks.enablePaymentBtn"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-5">
									<?php esc_html_e( 'When user clicks', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Payment button', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
						</div>
					</div>
					<div class="ccb-settings-property" :class="{'ccb-webhook-send-block-hidden': !settingsField.webhooks.enablePaymentBtn}">
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper"> 
								<span class="ccb-field-title"><?php esc_html_e( 'Webhook link', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper">
										<input type="text" v-model="settingsField.webhooks.payment_btn_url"/>
									</div>
									<button class="ccb-button ccb-href success" @click.prevent="sendDemoData('send-payment')"><?php esc_html_e( 'Send demo data', 'cost-calculator-builder-pro' ); ?></button>
									<div class="ccb-select-box">
										<div class="ccb-select-description ccb-default-description">
												<?php esc_html_e( 'Enter the received link from the automation service and send the demo data to check the connection.', 'cost-calculator-builder-pro' ); ?>
												<a href="<?php echo esc_attr( $payment_btn_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Read guide', 'cost-calculator-builder-pro' ); ?></a>
										</div>
									</div>
									<div @click="toggleItem('paymentButtonVisible')" ref="paymentButton" class="ccb-select-description ccb-default-description ccb-desc-left">
										<span class="ccb-icon-Path-3367"></span>
										<span class="ccb-wh-demo-text">
											<?php esc_html_e( 'What is demo data', 'cost-calculator-builder-pro' ); ?>
										</span>
										<div ref="paymentButtonDemoBox" class="ccb-demo-box" >
											<div v-if="paymentButtonVisible" class="ccb-demo-inner-list">
												<div class="ccb-demo-rectangle"></div>
												<div class="ccb-demo-inner-title">
													<h5><?php esc_html_e( 'What is demo data?', 'cost-calculator-builder-pro' ); ?></h5>
													<span class="ccb-demo-title-desc">
														<?php esc_html_e( 'The Demo Data is used for initial configuration of Webhooks. The demo data will be sent with a value of 100:', 'cost-calculator-builder-pro' ); ?>
													</span>	
												</div>
												<div class="ccb-demo-data-content" >
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Total', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">$100</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">John Doe</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Email', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">test@stylemixthemes.com</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Phone', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">+1 111 111 11 11</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Message', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value"><?php esc_html_e( 'This is a sample message', 'cost-calculator-builder-pro' ); ?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper">
								<span class="ccb-field-title"><?php esc_html_e( 'Secret key or Token (optional)', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper">
										<input  v-if="showPassword2" type="text" v-model="settingsField.webhooks.secret_key_payment_btn"/>
										<input v-else type="password" v-model="settingsField.webhooks.secret_key_payment_btn" class="ccb-key-password"/>
										<div @click="toggleItem('showPassword2')" class="ccb-hide-password"><span :class="{ 'ccb-icon-Eye': showPassword2, 'ccb-icon-Eye-Off': !showPassword2 }"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ccb-emailquote-webhook" v-if="generalSettings.invoice.emailButton">
					<div class="ccb-border-top"></div>
					<div class="row ccb-p-t-b-20">
						<div class="col">
							<div class="list-header">
								<div class="ccb-switch">
									<input type="checkbox" v-model="settingsField.webhooks.enableEmailQuote"/>
									<label></label>
								</div>
								<h6 class="ccb-heading-5">
									<?php esc_html_e( 'When user sends', 'cost-calculator-builder-pro' ); ?>
									<strong><?php esc_html_e( 'Email quote', 'cost-calculator-builder-pro' ); ?></strong>
								</h6>
							</div>
						</div>
					</div>
					<div class="ccb-settings-property" :class="{'ccb-webhook-send-block-hidden': !settingsField.webhooks.enableEmailQuote}">
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper"> 
								<span class="ccb-field-title"><?php esc_html_e( 'Webhook link', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper">
										<input type="text" v-model="settingsField.webhooks.email_quote_url"/>
									</div>
									<button class="ccb-button ccb-href success" @click.prevent="sendDemoData('send-email-quote')"><?php esc_html_e( 'Send demo data', 'cost-calculator-builder-pro' ); ?></button>
									<div class="ccb-select-box">
										<div class="ccb-select-description ccb-default-description">
												<?php esc_html_e( 'Enter the received link from the automation service and send the demo data to check the connection.', 'cost-calculator-builder-pro' ); ?>
												<a href="<?php echo esc_attr( $email_quote_desc_url ); ?>" target="_blank"><?php esc_html_e( 'Read guide', 'cost-calculator-builder-pro' ); ?></a>
										</div>
									</div>
									<div @click="toggleItem('emailQuoteVisible')" ref="emailQuote" class="ccb-select-description ccb-default-description ccb-desc-left">
										<span class="ccb-icon-Path-3367"></span>
										<span class="ccb-wh-demo-text">
											<?php esc_html_e( 'What is demo data', 'cost-calculator-builder-pro' ); ?>
										</span>
										<div ref="emailQuoteDemoBox" class="ccb-demo-box" >
											<div v-if="emailQuoteVisible" class="ccb-demo-inner-list">
												<div class="ccb-demo-rectangle"></div>
												<div class="ccb-demo-inner-title">
													<h5><?php esc_html_e( 'What is demo data?', 'cost-calculator-builder-pro' ); ?></h5>
													<span class="ccb-demo-title-desc">
														<?php esc_html_e( 'The Demo Data is used for initial configuration of Webhooks. The demo data will be sent with a value of 100:', 'cost-calculator-builder-pro' ); ?>
													</span>	
												</div>
												<div class="ccb-demo-data-content" >
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'User email', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">test@stylemixthemes.com</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Subject', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">This is a demo subject</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'Email body', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">This is a demo email body</span>
														</div>
													</div>
													<div class="ccb-item-field">
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-name"><?php esc_html_e( 'String attachment', 'cost-calculator-builder-pro' ); ?></span>
														</div>
														<div class="ccb-field-labels">
															<span class="ccb-demo-field-value">attachment.pdf</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ccb-p-b-20">
							<div class="ccb-webhook-wrapper">
								<span class="ccb-field-title"><?php esc_html_e( 'Secret key or Token (optional)', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-webhook-send-block">
									<div class="ccb-input-wrapper">
										<input v-if="showPassword3" type="text" v-model="settingsField.webhooks.secret_key_email_quote"/>
										<input v-else type="password" v-model="settingsField.webhooks.secret_key_email_quote" class="ccb-key-password"/>
										<div @click="toggleItem('showPassword3')" class="ccb-hide-password"><span :class="{ 'ccb-icon-Eye': showPassword3, 'ccb-icon-Eye-Off': !showPassword3 }"></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>

		<div class="ccb-notice-wrapper">
			<div class="ccb-notice-icon-wrapper">
				<span class="ccb-icon-Path-3367"></span>
			</div>
			<div class="ccb-notice-content">
				<strong><span class="ccb-notice-title"><?php esc_html_e( 'Important!', 'cost-calculator-builder-pro' ); ?></span></strong>
				<span class="ccb-notice-description"><?php esc_html_e( 'If you add or remove fields in your calculator, you must resubmit the data and update the settings in the automation service.', 'cost-calculator-builder-pro' ); ?></span>
				<a href="<?php echo esc_attr( $desc_url ); ?>" target="_blank"><?php esc_html_e( 'Find out more.', 'cost-calculator-builder-pro' ); ?></a>
			</div>
		</div>
	</div>

	<div class="ccb-grid-wrapper-right">
		<div class="ccb-banner-webhooks-wrapper">
			<div class="ccb-banner-img">
				<img src="<?php echo esc_attr( CALC_URL . '/frontend/dist/img/webhooks/banners/read-article.jpg' ); ?>">
			</div>
			<div class="ccb-banner-content">
				<div class="ccb-banner-content-header">
					<span class="ccb-banner-header-bold">
						<?php esc_html_e( 'Connect 5000+ apps', 'cost-calculator-builder-pro' ); ?>
					</span>
					<span class="ccb-banner-header-regular">
						<?php esc_html_e( 'with', 'cost-calculator-builder-pro' ); ?>
					</span>
					<div class="ccb-banner-header-regular">
						<?php esc_html_e( 'Cost Calculator', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
				<div class="ccb-banner-content-description">
					<span class="ccb-banner-content-description-text">
						<?php esc_html_e( 'Automate the calculation data sending to a wide range of popular apps.', 'cost-calculator-builder-pro' ); ?>
					</span>
				</div>
				<div class="ccb-banner-button-read-article">
					<a class="modal-open" href="#" data-youtube-id="ze_ie8Ctp60" @click="openModal">
						<span class="ccb-icon-watch"></span>
						<?php esc_html_e( 'Video', 'cost-calculator-builder' ); ?>
					</a>
					<a href="<?php echo esc_attr( $desc_url ); ?>" target="_blank" class="ccb-button ccb-href success">
						<?php esc_html_e( 'Read article', 'cost-calculator-builder-pro' ); ?>
					</a>

				</div>
			</div>
		</div>
	</div>

</div>
<div class="modal ccb-iframe-youtube-modal" v-if="modalVisible">
	<div class="background" @click="closeModal"></div>
	<div class="box">
		<div class="close" @click="closeModal"></div>
		<div class="content">
			<div class="responsive-video">
				<iframe :src="getIframeSrc()" id="ccb-upgrade-video" ref="modalIframe" allowscriptaccess="always" width="720" height="405" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" ></iframe>
			</div>
		</div>
	</div>
</div>
