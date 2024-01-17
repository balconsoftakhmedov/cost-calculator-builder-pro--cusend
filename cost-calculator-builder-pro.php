<?php

/**
 * Plugin Name: Cost Calculator Builder PRO
 * Plugin URI: https://stylemixthemes.com/cost-calculator-plugin/
 * Description: WP Cost Calculator helps you to build any type of estimation forms on a few easy steps. The plugin offers its own calculation builder.
 * Author: Stylemix Themes
 * Author URI: https://stylemixthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cost-calculator-builder-pro
 * Version: 3.1.32
 * Update URI: https://api.freemius.com
 */
define( 'CCB_PRO', __FILE__ );
define( 'CCB_PRO_PATH', dirname( __FILE__ ) );
define( 'CCB_PRO_URL', plugins_url( __FILE__ ) );

if ( !function_exists( 'ccb_fs' ) && file_exists( dirname( __FILE__ ) . '/freemius/start.php' ) ) {
    function ccb_fs()
    {
        global  $ccb_fs ;
        
        if ( !isset( $ccb_fs ) ) {
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $args = array(
                'id'              => '4532',
                'slug'            => 'cost-calculator-builder-pro',
                'premium_slug'    => 'cost-calculator-builder-pro',
                'type'            => 'plugin',
                'public_key'      => 'pk_663aa5b416d36cc2e85d6dff5f7b6',
                'is_premium'      => true,
                'is_premium_only' => true,
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'has_affiliation' => 'all',
                'menu'            => array(
                'slug'       => 'cost_calculator_builder',
                'first-path' => 'admin.php?page=cost_calculator_builder',
                'support'    => false,
            ),
                'is_live'         => true,
            );
            if ( !defined( 'CALC_VERSION' ) && !empty($args['menu']['first-path']) ) {
                $args['menu']['first-path'] = 'plugins.php';
            }
            $ccb_fs = fs_dynamic_init( $args );
        }
        
        return $ccb_fs;
    }
    
    ccb_fs();
    do_action( 'ccb_fs_loaded' );
}

function ccb_verify()
{
    if ( function_exists( 'ccb_fs' ) ) {
        return ccb_fs()->is__premium_only() && ccb_fs()->can_use_premium_code();
    }
    return true;
}

register_activation_hook( CCB_PRO, 'set_stm_admin_notification_ccb' );
if ( is_admin() ) {
    require_once CCB_PRO_PATH . '/includes/admin-notices/admin-notices.php';
}

if ( ccb_verify() ) {
    define( 'CCB_PRO_VERSION', '3.1.32' );
    add_action( 'plugins_loaded', function () {
        $ccb_installed = defined( 'CALC_VERSION' );
        
        if ( !$ccb_installed ) {
            
            if ( is_admin() ) {
                $init_data = array(
                    'notice_type'          => 'ccb-pro-notice',
                    'notice_logo'          => 'ccb.svg',
                    'notice_title'         => __( 'Please install Cost-Calculator-Builder from <a href="https://wordpress.org/plugins/cost-calculator-builder/">WordPress.org</a>', 'cost-calculator-builder-pro' ),
                    'notice_btn_one'       => 'https://wordpress.org/plugins/cost-calculator-builder/',
                    'notice_btn_one_title' => esc_html__( 'Install', 'cost-calculator-builder-pro' ),
                );
                stm_admin_notices_init( $init_data );
            }
            
            require_once CCB_PRO_PATH . '/templates/admin/wizard.php';
            // phpcs:ignore
        } else {
            require_once CCB_PRO_PATH . '/includes/functions.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBProTemplate.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBProSettings.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBProAjaxCallbacks.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBProAjaxActions.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBPayments.php';
            require_once CCB_PRO_PATH . '/includes/classes/payments/CCBPayPal.php';
            require_once CCB_PRO_PATH . '/includes/classes/payments/CCBStripe.php';
            require_once CCB_PRO_PATH . '/includes/classes/payments/CCBWooCheckout.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBInvoice.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBWooProducts.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBContactForm.php';
            require_once CCB_PRO_PATH . '/includes/classes/CCBWebhooks.php';
            require_once CCB_PRO_PATH . '/includes/init.php';
        }
    
    } );
}

if ( is_admin() ) {
    require_once CCB_PRO_PATH . '/includes/item-announcements.php';
}
if ( !function_exists( 'set_stm_admin_notification_ccb' ) ) {
    function set_stm_admin_notification_ccb()
    {
        
        if ( empty(get_option( 'calc_hint_skipped' )) ) {
            update_option( 'calc_allow_hint', '1' );
            update_option( 'calc_hint_skipped', array() );
        }
        
        //set rate us notice
        set_transient( 'stm_cost-calculator-builder_notice_setting', array(
            'show_time'   => time(),
            'step'        => 0,
            'prev_action' => '',
        ) );
    }

}

if ( is_admin() && get_option( 'ccb_version' ) !== false && version_compare( get_option( 'ccb_version' ), '2.2.5', '<' ) ) {
    $init_data = array(
        'notice_type'          => 'animate-circle-notice',
        'notice_logo'          => 'attent_circle.svg',
        'notice_title'         => esc_html__( 'Please update Cost Calculator Builder plugin!', 'cost-calculator-builder-pro' ),
        'notice_desc'          => esc_html__( 'Cost Calculator Builder plugin update required. We added new features, and need to update your plugin to the latest version!', 'cost-calculator-builder-pro' ),
        'notice_btn_one'       => admin_url( 'plugins.php' ),
        'notice_btn_one_title' => esc_html__( 'Update Plugin', 'cost-calculator-builder-pro' ),
    );
    stm_admin_notices_init( $init_data );
    return;
}
