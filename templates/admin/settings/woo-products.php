<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) : ?>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="row ccb-p-t-15 ccb-p-b-15">
				<div class="col">
					<span class="ccb-tab-title"><?php esc_html_e( 'Woo Products', 'cost-calculator-builder-pro' ); ?></span>
				</div>
			</div>
			<div class="row ccb-p-t-15 ccb-p-b-15">
				<div class="col">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="settingsField.woo_products.enable"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculator for WooCommerce Products', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !settingsField.woo_products.enable}">
				<div class="row ccb-p-t-10">
					<div class="col-6">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Product Category', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<div class="ccb-multi-select" @click="multiselectShow(event)">
									<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
									<span v-if="settingsField.woo_products.category_ids.length > 0 && settingsField.woo_products.category_ids.length <= 3" class="anchor ccb-heading-5 ccb-light-3 ccb-selected" >
										<span class="selected" v-for="category_id in settingsField.woo_products.category_ids" >
											{{ getWooCategoryNameById(category_id) }}
											<i class="ccb-icon-close" @click.self="multiselectChooseWooCategories( category_id )"></i>
										</span>
									</span>
									<span v-else-if="settingsField.woo_products.category_ids.length > 0 && settingsField.woo_products.category_ids.length > 3" class="anchor ccb-heading-5 ccb-light ccb-selected" >
										{{ settingsField.woo_products.category_ids.length }} <?php esc_attr_e( ' selected', 'cost-calculator-builder-pro' ); ?>
									</span>
									<span v-else class="anchor ccb-heading-5 ccb-light-3">
										<?php esc_html_e( 'Select Product Category', 'cost-calculator-builder-pro' ); ?>
									</span>
									<ul class="items row-list settings-list totals">
										<li @click.prevent="multiselectChooseWooCategories('all')" class="option-item settings-item">
											<input id="woo_category_id_all" :checked="woo_category_id_all" name="" class="index" type="checkbox"/>
											<label for="woo_category_all" class="ccb-heading-5">
												<?php esc_html_e( 'All Categories', 'cost-calculator-builder-pro' ); ?>
											</label>
										</li>
										<li @click.prevent="multiselectChooseWooCategories(category.term_id)" class="option-item settings-item" v-for="category in $store.getters.getCategories" :key="category.term_id" :value="category.term_id" v-if="category">
											<input :id="'woo_category_id_' + category.term_id" :checked="settingsField.woo_products.category_ids.includes(category.term_id)" name="" class="index" type="checkbox"/>
											<label :for="'woo_category_id_' + category.term_id" class="ccb-heading-5">{{ category.name }}</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="ccb-select-box">
							<span class="ccb-select-label"><?php esc_html_e( 'Calculator Position', 'cost-calculator-builder-pro' ); ?></span>
							<div class="ccb-select-wrapper">
								<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
								<select class="ccb-select" v-model="settingsField.woo_products.hook_to_show">
									<option value="" selected disabled><?php esc_html_e( 'Select Hook For Showing Calculator', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_before_single_product"><?php esc_html_e( 'Before Single Product (At the Top of Product)', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_before_add_to_cart_form" v-if="!settingsField.woo_products.hide_woo_cart"><?php esc_html_e( 'Before Add To Cart Form', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_after_add_to_cart_form" v-if="!settingsField.woo_products.hide_woo_cart"><?php esc_html_e( 'After Add To Cart Form', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_product_meta_start"><?php esc_html_e( 'Before Product Meta', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_product_meta_end"><?php esc_html_e( 'After Product Meta', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_after_single_product_summary"><?php esc_html_e( 'After Single Product Summary (Before Tabs)', 'cost-calculator-builder-pro' ); ?></option>
									<option value="woocommerce_after_single_product"><?php esc_html_e( 'After Single Product (At the Bottom of Product)', 'cost-calculator-builder-pro' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row ccb-p-t-15">
					<div class="col">
						<div class="list-header">
							<div class="ccb-switch">
								<input type="checkbox" v-model="settingsField.woo_products.hide_woo_cart"/>
								<label></label>
							</div>
							<h6 class="ccb-heading-5"><?php esc_html_e( 'WooCommerce Add To Cart Form', 'cost-calculator-builder-pro' ); ?></h6>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="container">
			<div class="ccb-settings-property" :class="{'ccb-settings-disabled': !settingsField.woo_products.enable}">
				<div class="row ccb-p-t-15">
					<div class="col">
						<span class="ccb-tab-title"><?php esc_html_e( 'Connect WooCommerce Meta to Calculator Fields:', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="row ccb-p-t-20">
					<div class="col-12">
						<div class="ccb-options-container woo-links">
							<div class="ccb-options-header">
								<span class="settings-woo-tooltip"><?php esc_html_e( 'WooCommerce Meta', 'cost-calculator-builder-pro' ); ?>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text"><?php esc_html_e( 'WooCommerce Product Meta means the amount and the price of a product on WooCommerce.', 'cost-calculator-builder-pro' ); ?></span>
								</span></span>
								<span><?php esc_html_e( 'Action', 'cost-calculator-builder-pro' ); ?></span>
								<span><?php esc_html_e( 'Calculator Field', 'cost-calculator-builder-pro' ); ?></span>
							</div>
							<div class="ccb-options">
								<div class="ccb-option" v-for="(link, index) in $store.getters.getWooMetaLinks" v-if="$store.getters.getWooMetaLinks.length">
									<div class="ccb-option-delete" @click.prevent="removeWooMetaLink(index)">
										<i class="ccb-icon-close"></i>
									</div>
									<div class="ccb-option-inner">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="link.woo_meta">
													<option value=""><?php esc_html_e( 'Select WooCommerce Field', 'cost-calculator-builder-pro' ); ?></option>
													<option v-for="meta in $store.getters.getWooMetaFields" :value="meta">{{ meta }}</option>
												</select>
											</div>
										</div>
									</div>
									<div class="ccb-option-inner">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="link.action">
													<option value=""><?php esc_html_e( 'Select Action', 'cost-calculator-builder-pro' ); ?></option>
													<option v-for="(value, key) in $store.getters.getWooActions" :value="key">{{ value }}</option>
												</select>
											</div>
										</div>
									</div>
									<div class="ccb-option-inner">
										<div class="ccb-select-box">
											<div class="ccb-select-wrapper">
												<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
												<select class="ccb-select" v-model="link.calc_field">
													<option value=""><?php esc_html_e( 'Select Calculator Field', 'cost-calculator-builder-pro' ); ?></option>
													<option v-for="(element, index) in $store.getters.getBuilder" v-if="typeof element.alias !== 'undefined'" :key="index" :value="element.alias">{{ element.label }}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="ccb-option-actions">
								<button class="ccb-button success" @click.prevent="addWooMetaLink">
									<i class="ccb-icon-Path-3453"></i>
									<?php esc_html_e( 'Add new link', 'cost-calculator-builder-pro' ); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else : ?>
	<div class="ccb-woo-not-installed">
		<div class="ccb-woo-not-installed-container">
			<div class="ccb-woo-not-installed-logo">
				<img src="<?php echo esc_url( CALC_URL . '/frontend/dist/img/woo_logo.png' ); ?>" alt="woo logo">
			</div>
			<div class="ccb-woo-not-installed-title-box">
				<span class="ccb-woo-title"><?php esc_html_e( 'WooCommerce not installed', 'cost-calculator-builder-pro' ); ?></span>
				<span class="ccb-woo-description"><?php esc_html_e( 'To use WooProduct and WooCheckout, please install and activate WooCommerce Plugin', 'cost-calculator-builder-pro' ); ?></span>
			</div>
			<div class="ccb-woo-not-installed-action">
				<a class="ccb-button ccb-href success" href="<?php echo esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Install WooCommerce', 'cost-calculator-builder-pro' ); ?>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
