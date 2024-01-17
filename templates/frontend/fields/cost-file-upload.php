<div :style="additionalCss" class="calc-item ccb-field" :class="{required: $store.getters.isUnused(fileUpload) || errors.fileUploadUrl, [fileUpload.additionalStyles]: fileUpload.additionalStyles}" :data-id="fileUpload.alias">
	<div class="calc-file-upload " :class="['calc_' + fileUpload.alias, {'calc-field-disabled': getStep === 'finish'}]">
		<div class="calc-item__title">
			<span class="ccb-label-span">
				{{ fileUpload.label }}
				<span v-if="(errors.hasOwnProperty('fileUploadUrl') && errors.fileUploadUrl) || $store.getters.isUnused(fileUpload)" class="calc-required-field">
					<div class="ccb-field-required-tooltip" style="margin-left: 35px">
						<span class="ccb-field-required-tooltip-text" :class="{active: $store.getters.isUnused(fileUpload) || errors.fileUploadUrl}">
							<template v-if="errors.hasOwnProperty('fileUploadUrl') && errors.fileUploadUrl">
								{{ errors.fileUploadUrl }}
							</template>
							<template v-if="$store.getters.isUnused(fileUpload)">
								{{ $store.getters.getSettings.texts.required_msg }}
							</template>
						</span>
					</div>
				</span>
				<span class="is-pro">
					<span class="pro-tooltip">
						pro
						<span style="visibility: hidden;" class="pro-tooltiptext">Feature Available <br> in Pro Version</span>
					</span>
				</span>
			</span>
			<div class="info-tip-block">
				<div class="info" v-if="showInfo">
					<div class="info-tip">
						<span>
							<?php esc_html_e( 'Supported file formats:', 'cost-calculator-builder-pro' ); ?>
						</span>
						<span class="bold uppercase">{{ fileUpload.fileFormats.join(', ') }}</span>
						<span class="lighter">
							<?php esc_html_e( 'max', 'cost-calculator-builder-pro' ); ?> {{ fileUpload.max_file_size }}mb
						</span>
					</div>
				</div>
				<span class="ccb-icon-Path-3367 info-icon" @mouseover="showInfo = true" @mouseleave="showInfo = false"></span>
			</div>
			<span class="ccb-required-mark" v-if="fileUpload.required">*</span>
		</div>

		<div class="calc-item__description before">
			<span v-html="fileUpload.description"></span>
		</div>

		<div class="calc-buttons">
			<input @change="addFiles" type="file" ref="file" :accept="allowedFormats.map(item=> `.${item}`).join(',')" :multiple="fileUpload.max_attached_files > 1" />
			<div class="calc-file-upload-actions">
				<button :disabled="fileUpload.max_attached_files <= parseInt(uploadedFiles.length)"  @click="chooseFileBtn" class="calc-btn-action success"><?php esc_html_e( 'Choose file', 'cost-calculator-builder-pro' ); ?></button>
				<button :disabled="fileUpload.max_attached_files <= parseInt(uploadedFiles.length)"  @click.prevent="uploadFromUrlBtn" class="calc-btn-action"><?php esc_html_e( 'Upload from URL', 'cost-calculator-builder-pro' ); ?></button>
			</div>
		</div>

		<div v-if="uploadFromUrl" class="calc-input-wrapper calc-buttons ccb-field url-file-upload">
			<div class="ccb-url-file-upload-input">
				<input :class="[{'error': ( errors.hasOwnProperty('fileUploadUrl') && errors.fileUploadUrl ) }, 'calc-input file-url-upload ccb-field cleanable', 'ccb-appearance-field']" v-model="fileUploadUrl" placeholder="<?php esc_html_e( 'Enter file url', 'cost-calculator-builder-pro' ); ?>" type="search"/>
			</div>
			<button class="calc-btn-action success" :class="{disabled: (fileUploadUrl.length <= 0 || ( errors.hasOwnProperty('fileUploadUrl') && errors.fileUploadUrl ))}" :disabled="fileUploadUrl.length <= 0" @click.prevent="uploadFileFromUrl()" ><?php esc_html_e( 'Upload', 'cost-calculator-builder-pro' ); ?></button>
		</div>

		<div v-if="uploadedFiles.length > 0" class="calc-uploaded-files">
			<div class="ccb-uploaded-file-list-info" v-if="uploadedFiles.length > 3" @click="openFileList = !openFileList;">
				<i class="ccb-icon-Path-3484"></i>
				<span>{{ uploadedFiles.length }} <?php esc_html_e( 'files uploaded', 'cost-calculator-builder-pro' ); ?></span>
				<i :class="['ccb-icon-Path-3485', 'ccb-select-anchor',{ 'open': openFileList}]" @click="openFileList = !openFileList;"></i>
			</div>
			<div class="ccb-uploaded-file-list" v-if="openFileList || uploadedFiles.length <= 3">
				<span v-for="(uploadedFile, uploadedFileIndex) in uploadedFiles" class="file-name">
					{{ uploadedFile.name }} <i @click.prevent="removeFile(uploadedFileIndex)" class="remove ccb-icon-close"></i>
				</span>
			</div>
		</div>

		<div class="calc-item__description after">
			<span v-html="fileUpload.description"></span>
		</div>
	</div>
</div>
