<?php
 /**
 * Plugin Name:       Flipbox - Awesomes Flip Boxes Image Overlay
 * Plugin URI:        https://wpkin.com
 * Description:       Flipbox - Awesomes Flip Boxes Image Overlay is the most easiest Flip builder Plugin. Create multiple Flip or  Flipboxes  with this.
 * Version:           2.10.0
 * Author:            WPKIN
 * Author URI:        https://wpkin.com
 * Text Domain:       oxi-flip-box-plugin
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'oxi-flip-box-plugin' ) );
}

/* *
 * Including composer autoloader globally.
 *
 * @since 2.10.0
 */
require_once __DIR__ . '/vendor/autoload.php';

if ( ! function_exists( 'wpkin_fb_v' ) ) {
    // Create a helper function for easy SDK access.
    function wpkin_fb_v() {
        global $wpkin_fb_v;

        if ( ! isset( $wpkin_fb_v ) ) {
            $wpkin_fb_v = fs_dynamic_init( array(
                'id'                  => '20098',
                'slug'                => 'oxi-flip-box-ultimate',
                'type'                => 'plugin',
                'public_key'          => 'pk_1332bbabb9a9c9654b5703b6cd244',
                'is_premium'          => false,
                'has_premium_version' => false,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'oxi-flip-box-ultimate',
                    'first-path'     => 'admin.php?page=flipbox-getting-started',
                    'contact'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $wpkin_fb_v;
    }

    // Init Freemius.
    wpkin_fb_v();
    // Signal that SDK was initiated.
    do_action( 'wpkin_fb_v_loaded' );
}

define('OXI_FLIP_BOX_FILE', __FILE__);
define('OXI_FLIP_BOX_BASENAME', plugin_basename(__FILE__));
define('OXI_FLIP_BOX_PATH', plugin_dir_path(__FILE__));
define('OXI_FLIP_BOX_URL', plugins_url('/', __FILE__));
define('OXI_FLIP_BOX_PLUGIN_VERSION', '2.10.0');
define('OXI_FLIP_BOX_TEXTDOMAIN', 'oxi-flip-box-plugin');


/**
 * Run plugin after all others plugins
 *
 * @since 2.3.0
 */
add_action('plugins_loaded', function () {
    \OXI_FLIP_BOX_PLUGINS\Classes\Bootstrap::instance();
});

/**
 * Activation hook
 *
 * @since 2.3.0
 */
register_activation_hook(__FILE__, function () {
    $Installation = new \OXI_FLIP_BOX_PLUGINS\Classes\Installation();
    $Installation->plugin_activation_hook();
});

/**
 * Upgrade hook
 *
 * @since 2.3.0
 */
add_action('upgrader_process_complete', function ($upgrader_object, $options) {
    $Installation = new \OXI_FLIP_BOX_PLUGINS\Classes\Installation();
    $Installation->plugin_upgrade_hook($upgrader_object, $options);
}, 10, 2);
