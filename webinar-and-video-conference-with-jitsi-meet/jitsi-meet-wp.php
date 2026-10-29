<?php //phpcs:ignore
/**
 * Plugin Name:       FlexMeeting - Webinar & Meeting Plugin for Jitsi Meet
 * Plugin URI:        https://wppool.dev/webinar-and-video-conference-with-jitsi-meet/
 * Description:       Host live webinars, conferences, online classes, video calls directly on your WordPress website with gutenberg block
 * Version:           2.9.10
 * Author:            WPPOOL
 * Author URI:        https://wppool.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webinar-and-video-conference-with-jitsi-meet
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Tested up to:      7.1
 *
 *  @package JITSI_MEET_WP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit(); // phpcs:ignore
}

define( 'JITSI_MEET_WP_VERSION', '2.9.10' );
define( 'JITSI_MEET_WP__FILE__', __FILE__ );
define( 'JITSI_MEET_WP_DIR_PATH', plugin_dir_path( JITSI_MEET_WP__FILE__ ) );
define( 'JITSI_MEET_WP_FILE_PATH', plugin_dir_path( __FILE__ ) );
define( 'JITSI_MEET_WP_URL', plugins_url( '', __FILE__ ) );
define( 'JITSI_MEET_WP_TEMPLATES', JITSI_MEET_WP_DIR_PATH . '/templates' );
define( 'JITSI_MEET_WP_ASSETS', JITSI_MEET_WP_URL . '/assets' );

/**
 * BRANDED MEETING TEMPORARILY DISABLED
 *
 * The managed Hosted Branded Meeting service has been stopped. The branded configuration UI is
 * replaced by an "unavailable" notice card and all branded API/JWT code paths are neutralised.
 * Set this to true and search the codebase for "BRANDED MEETING TEMPORARILY DISABLED" to restore.
 */
if ( ! defined( 'JITSI_BRANDED_MEETING_ENABLED' ) ) {
	define( 'JITSI_BRANDED_MEETING_ENABLED', false );
}


/**
 * [jitsi_meet_wp_begin]
 *
 * @return  void
 */
function jitsi_meet_wp_begin() {
	$plugin_list    = (array) get_option( 'active_plugins', array() );
	$jitsi_pro      = 'webinar-and-video-conference-jitsi-meet-pro/jitsi-meet-wp.php';
	$jitsi_ultimate = 'webinar-and-video-conference-with-jitsi-meet-ultimate/jitsi-meet-wp.php';
	$jitsi_premium  = 'webinar-and-video-conference-with-jitsi-meet-premium/jitsi-meet-wp.php';

	if ( ! in_array( $jitsi_pro, $plugin_list, true ) && ! in_array( $jitsi_ultimate, $plugin_list, true ) && ! in_array( $jitsi_premium, $plugin_list, true ) ) {
		/**
		 * Check for Gutenberg existence
		 * And prevent further execution if doesn't exist.
		 */
		if ( ! function_exists( 'register_block_type' ) ) {
			include_once JITSI_MEET_WP_DIR_PATH . 'init.php';
		} else {
			include_once JITSI_MEET_WP_DIR_PATH . 'init.php';
			include_once JITSI_MEET_WP_DIR_PATH . 'gutenberg-init.php';
			Jitsi_Meet_WP_Gutenberg::instance();
		}
	}

	if ( ! get_user_meta( get_current_user_id(), 'jitsi_hosted_topbar_dismissed', true ) ) {
		include_once JITSI_MEET_WP_FILE_PATH . 'inc/jitsi-topbar.php';
	}
}


function jitsi_meet_wp_is_any_premium_active() {
	$active_plugins  = (array) get_option( 'active_plugins', [] );
	$network_plugins = (array) get_site_option( 'active_sitewide_plugins', [] );

	$pro_plugins = [
		'webinar-and-video-conference-with-jitsi-meet-pro/jitsi-meet-wp.php',
		'webinar-and-video-conference-with-jitsi-meet-ultimate/jitsi-meet-wp.php',
		'webinar-and-video-conference-with-jitsi-meet-premium/jitsi-meet-wp.php',
	];

	foreach ( $pro_plugins as $plugin ) {
		if ( in_array( $plugin, $active_plugins, true ) || isset( $network_plugins[ $plugin ] ) ) {
			return true;
		}
	}

	return false;
}


/**
 * Jitsi meet plugin activate.
 *
 * @return  void
 */
function jitsi_meet_plugin_activate() {
	// update_option( 'jitsi_meet_wp_version', JITSI_MEET_WP_VERSION );
	// set_transient( 'jitsi_meet_wp_review_notice_interval', 'off', 7 * DAY_IN_SECONDS );
	// set_transient( 'jitsi_meet_wp_affiliate_notice_interval', 'off', 14 * DAY_IN_SECONDS );.

	$install_date = get_option( 'jitsi_meet_wp_install_time' );

	if ( empty( $install_date ) ) {
		update_option( 'jitsi_meet_wp_install_time', time() );
	}

	if ( get_option( 'jitsi_meet_welcome_redirect' ) !== 'occured' ) {
		add_option( 'jitsi_meet_welcome_redirect', true );
	}
}

register_activation_hook( __FILE__, 'jitsi_meet_plugin_activate' );

// WordPress 4.6+ auto-loads translations from wordpress.org — no manual call needed.

add_action( 'init', 'jitsi_meet_wp_begin', 20 );


/**
 * Initialize the plugin tracker
 *
 * @return mixed
 */
function jitsi_meet_wp_appsero_init_tracker() {
	if ( ! class_exists( 'JitsiMeetWP\Appsero\Client' ) ) {
		require_once __DIR__ . '/vendor/autoload.php';
	}

	$client = new \JitsiMeetWP\Appsero\Client( '00788961-f5f7-4117-8a26-a99508aa506b', 'FlexMeeting', JITSI_MEET_WP__FILE__ );

	// Active insights.
	$client->insights()->init();
}

/**
 * Initialize the wppool sdk
 *
 * @return void
 */
function jitsi_meet_wppool_sdk_init() {
	// Require WPPOOL SDK files.

	if ( file_exists( JITSI_MEET_WP_FILE_PATH . 'inc/wppool/class-plugin.php' ) ) {
		require_once JITSI_MEET_WP_FILE_PATH . 'inc/wppool/class-plugin.php';
	}

	if ( function_exists( 'wppool_plugin_init' ) ) {
		wppool_plugin_init( 'webinar_and_video_conference_with_jitsi_meet', plugin_dir_url( JITSI_MEET_WP__FILE__ ) . '/inc/wppool/background-image.png' );
	}
}

/**
 * Set up wppool sdk campaign
 *
 * @return void
 */
function jitsi_meet_wppool_sdk_campaign() {
	if ( function_exists( 'wppool_plugin_init' ) ) {
		$jitsi_meet_plugin = wppool_plugin_init( 'webinar_and_video_conference_with_jitsi_meet', plugin_dir_url( JITSI_MEET_WP__FILE__ ) . '/inc/wppool/background-image.png' );

		if ( $jitsi_meet_plugin && is_object( $jitsi_meet_plugin ) && method_exists( $jitsi_meet_plugin, 'set_campaign' ) ) {
			// BFCM 2026: 9 Nov 5 PM to 5 Dec 5 PM, Bangladesh Standard Time (UTC+6).
			$from        = '2026-11-09T17:00:00+06:00';
			$to          = '2026-12-05T17:00:00+06:00';
			$cta_text    = esc_html__( 'Claim The Deal →', 'webinar-and-video-conference-with-jitsi-meet' );
			$button_link = 'https://lnk.wppool.dev/kD6qsDm';
			$repeat      = 3 * DAY_IN_SECONDS; // Timer shows 3 days and restarts every 3 days until $to.

			$campain_image = plugin_dir_url( JITSI_MEET_WP__FILE__ ) . 'inc/wppool/bfcm-2026.jpg';
			$jitsi_meet_plugin->set_campaign( $campain_image, $to, $from, $cta_text, $button_link, $repeat );

			$now = time();

			if ( $now < strtotime( $from ) || $now > strtotime( $to ) ) {
				return;
			}

			$plugin_id = 'webinar_and_video_conference_with_jitsi_meet';

			// CTA button background (#FFD23F). The SDK also uses this color for the close icon.
			add_filter(
				'wppool_plugins',
				function ( $plugins ) use ( $plugin_id ) {
					$plugins[ $plugin_id ]['color'] = '#FFD23F';
					return $plugins;
				},
				20
			);

			// CTA text color (#111111); SDK hardcodes white.
			add_action(
				'admin_enqueue_scripts',
				function () use ( $plugin_id ) {
					if ( ! wp_script_is( 'wppool-plugins', 'enqueued' ) ) {
						return;
					}

					$selector = '._wppool-popup[data-plugin="' . $plugin_id . '"] ._wppool-popup-button';
					wp_add_inline_style( 'wppool-plugins', $selector . ', ' . $selector . ':hover { color: #111111; }' );
				},
				20
			);
		}
	}
}

jitsi_meet_wppool_sdk_init();
add_action( 'init', 'jitsi_meet_wppool_sdk_campaign' );
add_action( 'init', 'jitsi_meet_wp_appsero_init_tracker' );
