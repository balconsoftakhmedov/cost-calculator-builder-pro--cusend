<div class="thank-you-page" v-show="showThankYouPage" :class="{'loaded': showThankYouPage}">
	<span class="thank-you-page-close" v-if="showCloseBtn" @click.prevent="backToCalculatorAction">
		<span class="ccb-icon-close-x"></span>
	</span>
	<div class="thank-you-page-inner-container">
		<div class="thank-you-page__icon-box">
			<span class="icon-wrapper">
				<span class="icon-content">
					<i class="ccb-icon-Octicons"></i>
				</span>
			</span>
		</div>
		<div class="thank-you-page__title-box">
			<span class="thank-you-page__title-box-title">{{ thankYouPage.title }}</span>
			<span class="thank-you-page__title-box-desc">{{ thankYouPage.description }}</span>
		</div>
		<div class="thank-you-page__order">
			<span>
				<span>{{ thankYouPage.order_title }}</span>
				<span>{{ getOrder.orderId }}</span>
			</span>
		</div>

		<div class="thank-you-page__actions">
			<div class="thank-you-page__actions-wrapper">
				<div v-if="showBackToCalculators">
					<button class="calc-primary" @click.prevent="backToCalculatorAction">
						<span>
							<i class="ccb-icon-Arrow-Previous"></i>
							{{ thankYouPage.back_button_text }}
						</span>
					</button>
				</div>
				<div v-if="thankYouPage.custom_button">
					<a :href="thankYouPage.custom_button_link" target="_blank" class="calc-secondary">
						<span>{{ thankYouPage.custom_button_text }}</span>
					</a>
				</div>
				<div v-if="thankYouPage.download_button">
					<button class="calc-success" @click.prevent="downloadPdf">
						<span>{{ thankYouPage.download_button_text }}</span>
					</button>
				</div>
				<div v-if="thankYouPage.share_button">
					<button class="calc-secondary" @click.prevent="sendPdf">
						<span>{{ thankYouPage.share_button_text }}</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
