<?php
/**
 * Admin notice for sites still using the discontinued Managed Branded Meeting option.
 *
 * BRANDED MEETING TEMPORARILY DISABLED
 * The managed branded meeting service has been stopped. Sites whose API setting is still saved as
 * `branded` fall back to the default public host, so their meetings no longer run on their branded
 * server. This notice tells them to pick another hosting option.
 *
 * Delete or disable this file when the branded service is restored.
 *
 * @package JITSI_MEET_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // phpcs:ignore
}

if ( ! class_exists( 'Jitsi_Branded_Deprecated_Notice' ) ) {

	/**
	 * Renders a dismissible admin notice for sites still saved as `branded`.
	 */
	class Jitsi_Branded_Deprecated_Notice {

		/**
		 * Option key storing the dismissed state.
		 *
		 * Site-wide (option, not user meta) on purpose: the required fix is a single site-wide
		 * setting change, so once any administrator has acknowledged it the remaining
		 * administrators do not need to be nagged about the same setting.
		 *
		 * @var string
		 */
		const DISMISS_OPTION = 'jitsi_branded_deprecated_notice_dismissed';

		/**
		 * AJAX action name used to dismiss the notice.
		 *
		 * @var string
		 */
		const AJAX_ACTION = 'jitsi_dismiss_branded_deprecated_notice';

		/**
		 * Nonce action name.
		 *
		 * @var string
		 */
		const NONCE_ACTION = 'jitsi_branded_deprecated_notice';

		/**
		 * Registers the hooks used by this notice.
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'render_notice' ) );
			add_action( 'wp_ajax_' . self::AJAX_ACTION, array( $this, 'handle_dismiss' ) );
			add_filter( 'pre_update_option_jitsi_opt_select_api', array( $this, 'block_branded_value' ), 10, 2 );
		}

		/**
		 * Prevents the discontinued `branded` value from being written to the database.
		 *
		 * The settings UI already hides and disables saving on the branded panel, but this guards
		 * the Settings API (options.php) path and any directly posted value.
		 *
		 * @param mixed $value     The new option value.
		 * @param mixed $old_value The existing option value.
		 * @return mixed The value to store.
		 */
		public function block_branded_value( $value, $old_value ) {
			if ( 'branded' === $value ) {
				return $old_value;
			}

			return $value;
		}

		/**
		 * Determines whether the notice should be displayed for the current request.
		 *
		 * @return bool True when the site still uses the branded option and has not dismissed it.
		 */
		private function should_display() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return false;
			}

			if ( 'branded' !== get_option( 'jitsi_opt_select_api', 'free' ) ) {
				return false;
			}

			if ( get_option( self::DISMISS_OPTION ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Outputs the admin notice.
		 *
		 * @return void
		 */
		public function render_notice() {
			if ( ! $this->should_display() ) {
				return;
			}

			$settings_url = admin_url( 'admin.php?page=jitsi-pro-settings' );
			$allowed_html = array(
				'a'      => array(
					'href' => true,
				),
				'strong' => array(),
			);
			?>
			<div class="notice notice-warning is-dismissible jitsi-branded-deprecated-notice">
				<p>
					<strong><?php esc_html_e( 'FlexMeeting: your meetings are not running on your branded server.', 'webinar-and-video-conference-with-jitsi-meet' ); ?></strong>
				</p>
				<p>
					<?php
					echo wp_kses(
						sprintf(
							/* translators: %s: link to the FlexMeeting settings page. */
							__( 'Hosted Branded Meetings are temporarily unavailable, but your API setting is still set to "Managed Branded Meeting". Your meetings currently fall back to the default public hosting. Please %s and switch to Default (Public Hosting) or Jitsi as a Service (8x8 JaaS), then save your changes.', 'webinar-and-video-conference-with-jitsi-meet' ),
							'<a href="' . esc_url( $settings_url ) . '"><strong>' . esc_html__( 'open FlexMeeting settings', 'webinar-and-video-conference-with-jitsi-meet' ) . '</strong></a>'
						),
						$allowed_html
					);
					?>
				</p>
			</div>
			<script>
				( function () {
					var notice = document.querySelector( '.jitsi-branded-deprecated-notice' );

					if ( ! notice ) {
						return;
					}

					notice.addEventListener( 'click', function ( event ) {
						if ( ! event.target.classList.contains( 'notice-dismiss' ) ) {
							return;
						}

						var body = new FormData();
						body.append( 'action', <?php echo wp_json_encode( self::AJAX_ACTION ); ?> );
						body.append( 'nonce', <?php echo wp_json_encode( wp_create_nonce( self::NONCE_ACTION ) ); ?> );

						window.fetch( <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>, {
							method: 'POST',
							credentials: 'same-origin',
							body: body
						} );
					} );
				}() );
			</script>
			<?php
		}

		/**
		 * Persists the dismissed state.
		 *
		 * @return void
		 */
		public function handle_dismiss() {
			$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

			if ( ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
				wp_send_json_error( array( 'message' => __( 'Invalid nonce', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Insufficient permissions', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
			}

			update_option( self::DISMISS_OPTION, true );

			wp_send_json_success( array( 'message' => __( 'Notice dismissed', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
		}
	}
}
