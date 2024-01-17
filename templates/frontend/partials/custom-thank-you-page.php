<?php
// TODO mv all logic to controller
use cBuilder\Classes\Appearance\CCBAppearanceHelper;

$order_id   = null;
$order_data = array();

if ( isset( $_GET['order_id'] ) ) {
	$order_id = (int) sanitize_text_field( $_GET['order_id'] );
}

if ( $order_id ) {
	$order_data = apply_filters( 'ccb_order_data_by_id', $order_id );
}

if ( ! isset( $calc_id ) ) {
	return;
}

if ( ! isset( $language ) ) {
	$language = 'en';
}

if ( ! isset( $translations ) ) {
	$translations = array();
}

$settings         = get_option( 'stm_ccb_form_settings_' . $calc_id );
$general_settings = get_option( 'ccb_general_settings' );

$ccb_sync         = ccb_sync_settings_from_general_settings( $settings, $general_settings, true );
$settings         = $ccb_sync['settings'];
$general_settings = $ccb_sync['general_settings'];

if ( ! empty( $settings ) && isset( $settings[0] ) && isset( $settings[0]['general'] ) ) {
	$settings = $settings[0];
}

if ( empty( $settings['general'] ) ) {
	$settings = \cBuilder\Classes\CCBSettingsData::settings_data();
}

$settings['calc_id'] = $calc_id;
$settings['title']   = get_post_meta( $calc_id, 'stm-name', true );

if ( ! empty( $settings['formFields']['body'] ) ) {
	$settings['formFields']['body'] = str_replace( '<br>', PHP_EOL, $settings['formFields']['body'] );
}

$preset_key = get_post_meta( $calc_id, 'ccb_calc_preset_idx', true );
$preset_key = empty( $preset_key ) ? 0 : $preset_key;
$appearance = CCBAppearanceHelper::get_appearance_data( $preset_key );
$loader_idx = 0;

if ( ! empty( $appearance ) ) {
	$appearance = $appearance['data'];

	if ( isset( $appearance['desktop']['others']['data']['calc_preloader']['value'] ) ) {
		$loader_idx = $appearance['desktop']['others']['data']['calc_preloader']['value'];
	}
}

$fields = get_post_meta( $calc_id, 'stm-fields', true ) ?? array();
if ( ! empty( $fields ) ) {
	array_walk(
		$fields,
		function ( &$field_value, $k ) {
			if ( array_key_exists( 'required', $field_value ) ) {
				$field_value['required'] = $field_value['required'] ? 'true' : 'false';
			}
		}
	);
}

$data = array(
	'id'           => $calc_id,
	'settings'     => $settings,
	'currency'     => ccb_parse_settings( $settings ),
	'fields'       => $fields,
	'formula'      => get_post_meta( $calc_id, 'stm-formula', true ),
	'conditions'   => apply_filters( 'calc-render-conditions', array(), $calc_id ), // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
	'language'     => $language,
	'appearance'   => $appearance,
	'dateFormat'   => get_option( 'date_format' ),
	'pro_active'   => ccb_pro_active(),
	'default_img'  => CALC_URL . '/frontend/dist/img/default.png',
	'error_img'    => CALC_URL . '/frontend/dist/img/error.png',
	'success_img'  => CALC_URL . '/frontend/dist/img/success.png',
	'translations' => $translations,
	'order_data'   => $order_data,
);

$custom_defined = false;
if ( isset( $is_preview ) ) {
	$custom_defined = true;
}

$invoice_texts = array(
	'order'          => esc_html__( 'Order', 'cost-calculator-builder' ),
	'total_title'    => esc_html__( 'Total Summary', 'cost-calculator-builder' ),
	'payment_method' => esc_html__( 'Payment method:', 'cost-calculator-builder' ),
	'contact_title'  => esc_html__( 'Contact Information', 'cost-calculator-builder' ),
	'contact_form'   => array(
		'name'    => esc_html__( 'Name', 'cost-calculator-builder' ),
		'email'   => esc_html__( 'Email', 'cost-calculator-builder' ),
		'phone'   => esc_html__( 'Phone', 'cost-calculator-builder' ),
		'message' => esc_html__( 'Message', 'cost-calculator-builder' ),
	),
	'total_header'   => array(
		'name'  => esc_html__( 'Name', 'cost-calculator-builder' ),
		'unit'  => esc_html__( 'Composition', 'cost-calculator-builder' ),
		'total' => esc_html__( 'Total', 'cost-calculator-builder' ),
	),
);

$send_pdf_texts = array(
	'title'          => esc_html__( 'Email Quote', 'cost-calculator-builder' ),
	'name'           => esc_html__( 'Name', 'cost-calculator-builder' ),
	'name_holder'    => esc_html__( 'Enter name', 'cost-calculator-builder' ),
	'email'          => esc_html__( 'Email', 'cost-calculator-builder' ),
	'email_holder'   => esc_html__( 'Enter Email', 'cost-calculator-builder' ),
	'message'        => esc_html__( 'Message', 'cost-calculator-builder' ),
	'message_holder' => esc_html__( 'Enter message', 'cost-calculator-builder' ),
	'submit'         => isset( $general_settings['invoice']['submitBtnText'] ) ? $general_settings['invoice']['submitBtnText'] : esc_html__( 'Send', 'cost-calculator-builder' ),
	'close'          => esc_html__( 'Close', 'cost-calculator-builder' ),
	'success_text'   => esc_html__( 'Email Quote Successfully Sent!', 'cost-calculator-builder' ),
	'error_message'  => esc_html__( 'Fill in the required fields correctly.', 'cost-calculator-builder' ),
);

wp_localize_script( 'calc-builder-main-js', 'calc_data_' . $calc_id, $data );
?>

<?php if ( ! empty( $order_id ) ) : ?>
<div class="calculator-settings ccb-front ccb-wrapper-<?php echo esc_attr( $calc_id ); ?>">
	<calc-builder-front :custom="false" :content="<?php echo esc_attr( wp_json_encode( $data, 0, JSON_UNESCAPED_UNICODE ) ); ?>" inline-template :id="<?php echo esc_attr( $calc_id ); ?>">
		<div class="calc-container-wrapper">
			<?php if ( defined( 'CCB_PRO_PATH' ) ) : ?>
				<calc-thank-you-page v-if="$store.getters.getLastOrder" @reset="resetCalc" inline-template>
					<component :is="getWrapper" :order="getOrder" :settings="getSettings">
						<?php require_once CCB_PRO_PATH . '/templates/frontend/partials/thank-you-page.php'; ?>
					</component>
				</calc-thank-you-page>
			<?php endif; ?>
		</div>
	</calc-builder-front>
</div>
<?php endif; ?>
