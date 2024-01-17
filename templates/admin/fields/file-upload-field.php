<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'File Upload', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click.prevent="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="row">
			<div class="col-12">
				<div class="ccb-edit-field-switch">
					<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
						<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
					</div>
					<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'settings'}" @click="tab = 'settings'">
						<?php esc_html_e( 'Settings', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="container"  v-show="tab === 'main'">
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="fileUploadField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Description', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="fileUploadField.description" placeholder="<?php esc_attr_e( 'Enter field description', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="ccb-input-wrapper number">
						<span class="ccb-input-label"><?php esc_html_e( 'Maximum file size MB', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-input-box">
							<input type="text" class="ccb-heading-5 ccb-light" name="max_file_size" step="1" min="0" v-model="fileUploadField.max_file_size" max="<?php echo esc_attr( round( wp_max_upload_size() / 1024 / 1024 ) ); ?>" placeholder="<?php esc_attr_e( 'Enter size', 'cost-calculator-builder-pro' ); ?>">
							<span @click="numberCounterAction('max_file_size')" class="input-number-counter up"></span>
							<span @click="numberCounterAction('max_file_size', '-')" class="input-number-counter down"></span>
						</div>
						<span v-if="fieldErrors.hasOwnProperty('max_file_size') && fieldErrors.max_file_size != null" class="ccb-error-tip default" v-html="fieldErrors.max_file_size"></span>
					</div>
					<span class="ccb-field-description">
						<?php esc_html_e( 'Server file size limit: ', 'cost-calculator-builder-pro' ); ?>
						<?php echo esc_attr( size_format( wp_max_upload_size() ) ); ?>
						<a :href="wpFileSizeLink" target="_blank" class="ccb-desc-link"><?php esc_html_e( 'Read more', 'cost-calculator-builder-pro' ); ?></a>
					</span>
				</div>
				<div class="col-6">
					<div class="ccb-input-wrapper number">
						<span class="ccb-input-label"><?php esc_html_e( 'Maximum attached files', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-input-box">
							<input type="number" class="ccb-heading-5 ccb-light" step="1" min="0" name="max_attached_files" v-model="fileUploadField.max_attached_files" placeholder="<?php esc_attr_e( 'Enter attached value', 'cost-calculator-builder-pro' ); ?>">
							<span @click="numberCounterAction('max_attached_files')" class="input-number-counter up"></span>
							<span @click="numberCounterAction('max_attached_files', '-')" class="input-number-counter down"></span>
						</div>
						<span v-if="fieldErrors.hasOwnProperty('max_attached_files') && fieldErrors.max_attached_files != null" class="ccb-error-tip default" v-html="fieldErrors.max_attached_files"></span>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'File upload price $', 'cost-calculator-builder-pro' ); ?></span>
						<div class="ccb-input-box">
							<input type="text" class="ccb-heading-5 ccb-light" name="price" min="0" step="1" v-model="fileUploadField.price" placeholder="<?php esc_attr_e( 'Enter price', 'cost-calculator-builder-pro' ); ?>">
							<span @click="numberCounterAction('price')" class="input-number-counter up"></span>
							<span @click="numberCounterAction('price', '-')" class="input-number-counter down"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-select-box">
						<span class="ccb-select-label"><?php esc_html_e( 'Supported file formats', 'cost-calculator-builder-pro' ); ?></span>
						<div :class="['multiselect', {'error': fieldErrors.hasOwnProperty('fileFormats') && fieldErrors.fileFormats != null }]">
							<span v-if="fileUploadField.hasOwnProperty('fileFormats') && fileUploadField.fileFormats.length > 0 && fileUploadField.fileFormats.length <= 4" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShow(event)">
								<span class="selected-payment" v-for="chosenFileFormat in fileUploadField.fileFormats" >
									{{ chosenFileFormat }}
									<i class="ccb-icon-close" @click.self="removeFileFormat( chosenFileFormat )" ></i>
								</span>
							</span>
							<span v-else-if="fileUploadField.hasOwnProperty('fileFormats') && fileUploadField.fileFormats.length > 0 && fileUploadField.fileFormats.length > 4" class="anchor ccb-heading-5 ccb-light ccb-selected" @click.prevent="multiselectShow(event)">
								{{ fileUploadField.fileFormats.length }} <?php esc_attr_e( 'file formats selected', 'cost-calculator-builder-pro' ); ?>
							</span>
							<span v-else class="anchor ccb-heading-5 ccb-light-3" @click.prevent="multiselectShow(event)">
								<?php esc_html_e( 'Select File formats', 'cost-calculator-builder-pro' ); ?>
							</span>
							<ul class="items row-list">
								<li :class="['option-item', {disabled: !allowedFileFormats.includes(fileFormat.name)}]" v-for="(fileFormat, idx) in fileFormats" @click.prevent="multiselectChooseFileFormat(fileFormat.name)">
									<input name="fileFormat" :id="'calc_file_' + idx" class="index" type="checkbox" :value="fileFormat.name" v-model="fileUploadField.fileFormats" @change="fileFormatsHandler"/>
									<label :for="'calc_file_' + idx">
										{{ fileFormat.name }}
									</label>
								</li>
							</ul>
							<input name="options" type="hidden" />
							<span v-if="fieldErrors.hasOwnProperty('fileFormats') && fieldErrors.fileFormats != null" class="ccb-error-tip default" v-html="fieldErrors.fileFormats"></span>
						</div>
						<span class="ccb-select-description ccb-default-description">
							<?php esc_html_e( 'For enabling all file types, you need to edit wp-config.php file.', 'cost-calculator-builder-pro' ); ?>
							<a :href="wpConfigLink"><?php esc_html_e( 'Read more', 'cost-calculator-builder-pro' ); ?></a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-show="tab === 'settings'">
			<div class="row ccb-p-t-15">
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="fileUploadField.allowCurrency"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Currency Sign', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="fileUploadField.required"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="fileUploadField.hidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="fileUploadField.addToSummary"/>
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
						<textarea class="ccb-heading-5 ccb-light" v-model="fileUploadField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
