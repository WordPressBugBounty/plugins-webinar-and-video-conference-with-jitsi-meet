<?php //phpcs:ignore
/**
 * If direct access than exit the file.
 *
 * @package JITSI_MEET_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // phpcs:ignore
}
if ( ! function_exists( 'jitsi_free_is_moderator_api' ) ) {
	function jitsi_free_is_moderator_api() {
		$api = get_option( 'jitsi_opt_select_api', 'free' );
		return in_array( $api, array( 'branded', 'jaas' ), true );
	}
}

if ( ! class_exists( 'Jitsi_Pro_Admin_Settings' ) ) {
	/**
	 * The class creates admin settings
	 */
	class Jitsi_Pro_Admin_Settings {

		/**
		 * Settings
		 *
		 * @var object
		 */
		public $settings;
		/**
		 * Callbacks
		 *
		 * @var object
		 */
		public $callbacks;
		/**
		 * Prefix
		 *
		 * @var string
		 */
		public $prefix;
		/**
		 * Load all functions
		 *
		 * @return  void
		 */
		public function __construct() {
			include_once JITSI_MEET_WP_FILE_PATH . 'inc/admin/jitsi-pro-admin.php';
			include_once JITSI_MEET_WP_FILE_PATH . 'inc/admin/mannage-callback.php';

			$this->settings  = new Jitsi_Settings();
			$this->callbacks = new Mannage_Callback();
			$this->prefix    = 'jitsi_opt_';

			// Fields.
			$this->set_settings();
			$this->set_sections();
			$this->set_fields();

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_moderator_roles_assets' ) );
		}

		/**
		 * Enqueue styling for the "Allow Moderator Access For" upsell field.
		 *
		 * @param string $hook Current admin page hook.
		 * @return void
		 */
		public function enqueue_moderator_roles_assets( $hook ) {
			$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( 'jitsi-pro-settings' !== $page && false === strpos( (string) $hook, 'jitsi-pro-settings' ) && false === strpos( (string) $hook, 'jitsi-pro-admin' ) ) {
				return;
			}

			$inline_css = <<<CSS
.jitsi-moderator-roles-wrap select.jitsi-moderator-roles-select {
	min-width: 260px;
	max-width: 520px;
	width: 100%;
	min-height: 40px;
	padding: 8px 36px 8px 12px;
	border: 1px solid #d1d5db;
	border-radius: 8px;
	background-color: #f9fafb;
	font-size: 14px;
	color: #1f2937;
	line-height: 1.4;
	box-shadow: 0 1px 2px rgba(0,0,0,.04);
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'><path fill='%236b7280' d='M6 8L0 0h12z'/></svg>");
	background-repeat: no-repeat;
	background-position: right 12px center;
	background-size: 10px 7px;
}
.jitsi-moderator-roles-wrap.disabled select.jitsi-moderator-roles-select {
	background-color: #f3f4f6;
	cursor: not-allowed;
	opacity: .85;
}
.form-table tr:has(.jitsi-moderator-roles-wrap) > th,
.form-table tr:has(.jitsi-moderator-roles-wrap) > td {
	vertical-align: middle;
}
.form-table tr:has(.jitsi-moderator-roles-wrap) > th {
	min-width: 280px;
}
CSS;
			wp_register_style( 'jitsi-moderator-roles', false, array(), JITSI_MEET_WP_VERSION );
			wp_enqueue_style( 'jitsi-moderator-roles' );
			wp_add_inline_style( 'jitsi-moderator-roles', $inline_css );
		}

		/**
		 * Key
		 *
		 * @return  string  return key
		 */
		public static function key() {
			return 'webinar-and-video-conference-with-jitsi-meet';
		}

		/**
		 * Set Settings
		 *
		 * @return  void
		 */
		public function set_settings() {
			$args = [];

			$args[] = [
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'select_api',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'custom_domain',
			];

			$args[] = array(
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'api_key',
			);

			$args[] = array(
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'app_id',
			);

			$args[] = array(
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'private_key',
			);

			$args[] = [
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'free_domain',
			];

			$args[] = array(
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'subdomain_domain',
			);

			$args[] = array(
				'option_group' => 'jitsi-pro-api',
				'option_name'  => $this->prefix . 'subdomain_connected',
			);

			$args[] = [
				'option_group' => 'jitsi-pro-admin',
				'option_name'  => $this->prefix . 'user_email',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-admin',
				'option_name'  => $this->prefix . 'user_name',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-admin',
				'option_name'  => $this->prefix . 'user_avatar',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-admin',
				'option_name'  => $this->prefix . 'moderator_roles',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-admin',
				'option_name'  => $this->prefix . 'other_admin_config',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'enable_livestream',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'enable_recording',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-audio',
				'option_name'  => $this->prefix . 'start_audio_only',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-audio',
				'option_name'  => $this->prefix . 'start_audio_muted',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-audio',
				'option_name'  => $this->prefix . 'start_local_audio_muted',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-audio',
				'option_name'  => $this->prefix . 'start_silent',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-video',
				'option_name'  => $this->prefix . 'video_resolution',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-video',
				'option_name'  => $this->prefix . 'maxfullresolutionparticipant',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'hide_jitsi_sidebar',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'disableSimulcast',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-video',
				'option_name'  => $this->prefix . 'startVideoMuted',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-video',
				'option_name'  => $this->prefix . 'startWithVideoMuted',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-video',
				'option_name'  => $this->prefix . 'startScreenSharing',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'width',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'height',
			];

			$args[] = [
				'option_group' => 'jitsi-pro-config',
				'option_name'  => $this->prefix . 'invite',
			];

			$this->settings->set_settings( $args );
		}

		/**
		 * SetSections
		 *
		 * @return void
		 */
		public function set_sections() {
			$args = [
				[
					'id'    => $this->prefix . 'api_section',
					'title' => null,
					'page'  => 'jitsi-pro-api',
				],
				[
					'id'    => $this->prefix . 'admin_section',
					'title' => null,
					'page'  => 'jitsi-pro-admin',
				],
				[
					'id'    => $this->prefix . 'config_section',
					'title' => null,
					'page'  => 'jitsi-pro-config',
				],
				[
					'id'    => $this->prefix . 'audio_section',
					'title' => null,
					'page'  => 'jitsi-pro-audio',
				],
				[
					'id'    => $this->prefix . 'video_section',
					'title' => null,
					'page'  => 'jitsi-pro-video',
				],
			];

			$this->settings->set_sections( $args );
		}

		/**
		 * Set Fields
		 *
		 * @return  void
		 */
		public function set_fields() {
			$args = [];

			$args[] = array(
				'id'       => $this->prefix . 'select_api',
				'title'    => '',
				'callback' => array( $this->callbacks, 'jitsi_hosting_cards' ),
				'page'     => 'jitsi-pro-api',
				'section'  => $this->prefix . 'api_section',
				'args'     => array(
					'label_for' => $this->prefix . 'select_api',
					'default'   => 'free',
					'options'   => array(
						'free'      => array(
							'label' => __( 'Default (Public Hosting)', 'webinar-and-video-conference-with-jitsi-meet' ),
							'desc'  => __( 'Use the default public Jitsi', 'webinar-and-video-conference-with-jitsi-meet' ),
						),
						'branded' => array(
							'label' => __( 'Managed Branded Meeting', 'webinar-and-video-conference-with-jitsi-meet' ),
							'desc'  => __( 'We host and maintain your branded server', 'webinar-and-video-conference-with-jitsi-meet' ),
						),
						'jaas'      => array(
							'label' => __( 'Jitsi as a Service (8x8 JaaS)', 'webinar-and-video-conference-with-jitsi-meet' ),
							'desc'  => __( 'Use your JaaS credentials', 'webinar-and-video-conference-with-jitsi-meet' ),
						),
						'disable-self'      => array(
							'label' => __( 'Self-Hosted', 'webinar-and-video-conference-with-jitsi-meet' ),
							'desc'  => __( 'Connect your self-hosted server', 'webinar-and-video-conference-with-jitsi-meet' ),
						),
					),
				),
			);
			// unified panels.
			$args[] = array(
				'id'       => $this->prefix . 'panel_free',
				'title'    => '',
				'callback' => array( $this->callbacks, 'jitsi_api_panel_free' ),
				'page'     => 'jitsi-pro-api',
				'section'  => $this->prefix . 'api_section',
			);

			$args[] = array(
				'id'       => $this->prefix . 'panel_branded',
				'title'    => '',
				'callback' => array( $this->callbacks, 'jitsi_api_panel_branded' ),
				'page'     => 'jitsi-pro-api',
				'section'  => $this->prefix . 'api_section',
			);

			$args[] = array(
				'id'       => $this->prefix . 'panel_jaas',
				'title'    => '',
				'callback' => array( $this->callbacks, 'jitsi_api_panel_jaas' ),
				'page'     => 'jitsi-pro-api',
				'section'  => $this->prefix . 'api_section',
			);

			$args[] = array(
				'id'       => $this->prefix . 'panel_self',
				'title'    => '',
				'callback' => array( $this->callbacks, 'jitsi_api_panel_self' ),
				'page'     => 'jitsi-pro-api',
				'section'  => $this->prefix . 'api_section',
			);

			$args[] = [
				'id'       => $this->prefix . 'user_email',
				'title'    => __( 'User Email', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Email address of admin', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_general' ],
				'page'     => 'jitsi-pro-admin',
				'section'  => $this->prefix . 'admin_section',
				'args'     => [
					'label_for' => $this->prefix . 'user_email',
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'user_name',
				'title'    => __( 'User Username', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Username of the admin', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_general' ],
				'page'     => 'jitsi-pro-admin',
				'section'  => $this->prefix . 'admin_section',
				'args'     => [
					'label_for' => $this->prefix . 'user_name',
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'user_avatar',
				'title'    => __( 'User Avatar', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'The avatar url of the admin user', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_single_img' ],
				'page'     => 'jitsi-pro-admin',
				'section'  => $this->prefix . 'admin_section',
				'args'     => [
					'label_for' => $this->prefix . 'user_avatar',
					'default'   => JITSI_MEET_WP_URL . '/assets/img/avatar.png',
					'size'      => __( '280x70px png, up to 4MB', 'webinar-and-video-conference-with-jitsi-meet' ),
					'disabled'  => true,
				],
			];

			if ( jitsi_free_is_moderator_api() ) {
				$args[] = [
					'id'       => $this->prefix . 'moderator_roles',
					'title'    => __( 'Allow Moderator Access For', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Decide who can join the meeting as a moderator. Other users will join as regular participants and cannot end the meeting for everyone.', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
					'callback' => [ $this->callbacks, 'jitsi_moderator_roles' ],
					'page'     => 'jitsi-pro-admin',
					'section'  => $this->prefix . 'admin_section',
					'args'     => [
						'label_for' => $this->prefix . 'moderator_roles',
						'default'   => array(),
						'disabled'  => true,
					],
				];
			}

			$args[] = [
				'id'       => $this->prefix . 'other_admin_config',
				'title'    => __( 'Other Admin Config', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Those are on https://jaas.8x8.vc/#/branding', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_other_admin' ],
				'page'     => 'jitsi-pro-admin',
				'section'  => $this->prefix . 'admin_section',
				'args'     => [
					'label_for' => $this->prefix . 'other_admin_config',
					'default'   => 1,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'width',
				'title'    => __( 'Meeting Width', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Width in pixel when not on fullscreen', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_number' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'width',
					'default'   => 1080,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'height',
				'title'    => __( 'Meeting Height', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Height in pixel when not on fullscreen', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_number' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'height',
					'default'   => 720,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'invite',
				'title'    => __( 'Enable Inviting', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Attendee can invite people', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'invite',
					'default'   => 1,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'enableWelcomePage',
				'title'    => __( 'Welcome Page', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Enable/Disable welcome page', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'enableWelcomePage',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'start_local_audio_muted',
				'title'    => __( 'Yourself muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Start with yourself muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-audio',
				'section'  => $this->prefix . 'audio_section',
				'args'     => [
					'label_for' => $this->prefix . 'start_local_audio_muted',
					'default'   => 0,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'start_audio_only',
				'title'    => __( 'Audio Only', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Start conference on audio only', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-audio',
				'section'  => $this->prefix . 'audio_section',
				'args'     => [
					'label_for' => $this->prefix . 'start_audio_only',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'start_audio_muted',
				'title'    => __( 'Audio Muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Participant after nth will be muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_number' ],
				'page'     => 'jitsi-pro-audio',
				'section'  => $this->prefix . 'audio_section',
				'args'     => [
					'label_for' => $this->prefix . 'start_audio_muted',
					'default'   => 10,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'start_silent',
				'title'    => __( 'Start Silent', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Disable local audio output', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-audio',
				'section'  => $this->prefix . 'audio_section',
				'args'     => [
					'label_for' => $this->prefix . 'start_silent',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'startWithVideoMuted',
				'title'    => __( 'Start Video Muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Start call with video muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-video',
				'section'  => $this->prefix . 'video_section',
				'args'     => [
					'label_for' => $this->prefix . 'startWithVideoMuted',
					'default'   => 0,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'startScreenSharing',
				'title'    => __( 'Screen Sharing', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description">' . __( 'Enabling this feature allow you to share your screen while attending a meeting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-video',
				'section'  => $this->prefix . 'video_section',
				'args'     => [
					'label_for' => $this->prefix . 'startScreenSharing',
					'default'   => 0,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'video_resolution',
				'title'    => __( 'Video Resolution', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Start with preferred resolution', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_select' ],
				'page'     => 'jitsi-pro-video',
				'section'  => $this->prefix . 'video_section',
				'args'     => [
					'label_for' => $this->prefix . 'video_resolution',
					'default'   => 720,
					'options'   => [
						480  => '480p',
						720  => '720p',
						1440 => '1440p',
						1080 => '1080p',
						2160 => '2160p',
						4320 => '4320p',
					],
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'maxfullresolutionparticipant',
				'title'    => __( 'Max Full Resolution', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Number of participant with default resolution', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_number' ],
				'page'     => 'jitsi-pro-video',
				'section'  => $this->prefix . 'video_section',
				'args'     => [
					'label_for' => $this->prefix . 'maxfullresolutionparticipant',
					'default'   => 2,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'startVideoMuted',
				'title'    => __( 'Video Muted After', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Every participant after nth will start video muted', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_number' ],
				'page'     => 'jitsi-pro-video',
				'section'  => $this->prefix . 'video_section',
				'args'     => [
					'label_for' => $this->prefix . 'startVideoMuted',
					'default'   => 10,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'enable_livestream',
				'title'    => __( 'Enable Livestream', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Turn on livestreaming', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'enable_livestream',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'enable_recording',
				'title'    => __( 'Enable Recording', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Turn on to record the meeting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'enable_recording',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'enable_outbound',
				'title'    => __( 'Enable Outbound', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Allow outbound on the meeting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'enable_outbound',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'enable_transcription',
				'title'    => __( 'Enable Transcription', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Transcript the meeting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'enable_transcription',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'hide_jitsi_sidebar',
				'title'    => __( 'Hide Jitsi Sidebar', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Enable to hide Jitsi sidebar from Jitsi Meeting room', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for'    => $this->prefix . 'hide_jitsi_sidebar',
					'default'      => 0,
					'disabled'     => true,
					// 'feature_type' => 'new',
				],
			];

			$args[] = [
				'id'       => $this->prefix . 'disableSimulcast',
				'title'    => __( 'Simulcast', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Enable/Disable simulcast', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => [ $this->callbacks, 'jitsi_switch' ],
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => [
					'label_for' => $this->prefix . 'disableSimulcast',
					'default'   => 0,
					'disabled'  => true,
				],
			];

			$args[] = array(
				'id'       => $this->prefix . 'enable_whiteboard',
				'title'    => __( 'Enable Whiteboard', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'Enable to use the whiteboard on Jass 8x8', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => array( $this->callbacks, 'jitsi_switch' ),
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => array(
					'label_for'    => $this->prefix . 'enable_whiteboard',
					'default'      => 0,
					'feature_type' => 'new',
					'disabled'  => true,
				),
			);

			$args[] = array(
				'id'       => $this->prefix . 'update_post_type_slug',
				'title'    => __( 'Enable to Change Post-type Slug', 'webinar-and-video-conference-with-jitsi-meet' ) . '<span class="description desc-pro">' . __( 'You can enable/disable custom slug', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>',
				'callback' => array( $this->callbacks, 'jitsi_switch' ),
				'page'     => 'jitsi-pro-config',
				'section'  => $this->prefix . 'config_section',
				'args'     => array(
					'label_for' => $this->prefix . 'update_post_type_slug',
					'default'      => 0,
					'feature_type' => 'new',
					'disabled'  => true,
				),
			);

			$this->settings->set_fields( $args );
		}
	}

	new Jitsi_Pro_Admin_Settings();
}
