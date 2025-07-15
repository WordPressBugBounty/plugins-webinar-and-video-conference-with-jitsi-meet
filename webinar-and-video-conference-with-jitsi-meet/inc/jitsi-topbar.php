<?php
/**
 * Jitsi Pro Topbar Notification
 *
 * @package JitsiMeetWP
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Jitsi_Topbar' ) ) {
	/**
	 * Jitsi Pro Topbar Notification
	 * Displays promotional topbar only on Jitsi plugin pages
	 *
	 * @since 1.0.0
	 */
	class Jitsi_Topbar {

		/**
		 * Plugin pages where topbar should show
		 *
		 * @var array
		 */
		private $plugin_pages = array();

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->init_plugin_pages();
			$this->init_hooks();
		}

		/**
		 * Initialize plugin pages where topbar should show
		 *
		 * @since 1.0.0
		 */
		private function init_plugin_pages() {
			$this->plugin_pages = array(
				'jitsi-meet',
				'jitsi-pro-apis',
				'jitsi-pro-admin',
				'jitsi-pro-config',
				'jitsi-pro-audio',
				'jitsi-pro-video',
				'jitsi-pro-frontend',
				'jitsi-pro-add-ons',
				'jitsi-meet-welcome',
				'jitsi-pro-settings',
				// Screen IDs for admin pages (usually prefixed with toplevel_page_ or admin_page_).
				'toplevel_page_jitsi-meet',
				'admin_page_jitsi-pro-apis',
				'admin_page_jitsi-pro-admin',
				'admin_page_jitsi-pro-config',
				'admin_page_jitsi-pro-audio',
				'admin_page_jitsi-pro-video',
				'admin_page_jitsi-pro-frontend',
				'admin_page_jitsi-pro-add-ons',
				'admin_page_jitsi-meet-welcome',
				'admin_page_jitsi-pro-settings',
				// Meeting post type pages.
				'meeting',
				'edit-meeting',
			);
		}

		/**
		 * Initialize WordPress hooks
		 *
		 * @since 1.0.0
		 */
		private function init_hooks() {
			add_action( 'admin_notices', array( $this, 'display_topbar' ), 1 );
			add_action( 'wp_ajax_jitsi_dismiss_topbar', array( $this, 'handle_dismiss' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'admin_init', array( $this, 'handle_reset' ) );
		}

		/**
		 * Check if we're on a Jitsi plugin page
		 *
		 * @since 1.0.0
		 * @return bool True if on Jitsi page, false otherwise.
		 */
		private function is_jitsi_page() {
			global $pagenow;
			$screen = get_current_screen();

			// Check for meeting post type pages first.
			if ( $screen && isset( $screen->id ) ) {
				if ( in_array( $screen->id, array( 'meeting', 'edit-meeting' ), true ) ) {
					return true;
				}

				// Check if screen base matches meeting post type.
				if ( 'post' === $screen->base && isset( $screen->post_type ) && 'meeting' === $screen->post_type ) {
					return true;
				}

				// Check if it's the edit.php page for meeting post type.
				if ( 'edit' === $screen->base && isset( $screen->post_type ) && 'meeting' === $screen->post_type ) {
					return true;
				}
			}

			// Check for admin pages - using screen-based detection to avoid $_GET.
			if ( 'admin.php' === $pagenow && $screen && isset( $screen->id ) ) {
				if ( in_array( $screen->id, $this->plugin_pages, true ) ) {
					return true;
				}
			}

			// Check for edit.php with meeting post type using screen.
			if ( 'edit.php' === $pagenow && $screen && isset( $screen->post_type ) && 'meeting' === $screen->post_type ) {
				return true;
			}

			// Additional screen-based checks for plugin admin pages.
			if ( $screen ) {
				// Check screen ID directly.
				if ( in_array( $screen->id, $this->plugin_pages, true ) ) {
					return true;
				}

				// Check parent_base.
				if ( isset( $screen->parent_base ) && in_array( $screen->parent_base, $this->plugin_pages, true ) ) {
					return true;
				}

				// Check base.
				if ( isset( $screen->base ) && in_array( $screen->base, $this->plugin_pages, true ) ) {
					return true;
				}

				// Check for Jitsi-specific screen patterns.
				if ( isset( $screen->id ) && false !== strpos( $screen->id, 'jitsi' ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Display the topbar notification
		 *
		 * @since 1.0.0
		 */
		public function display_topbar() {
			// Only show in admin for admins.
			if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Only show on Jitsi plugin pages.
			if ( ! $this->is_jitsi_page() ) {
				return;
			}

			// Check if dismissed.
			if ( get_user_meta( get_current_user_id(), 'jitsi_hosted_topbar_dismissed', true ) ) {
				return;
			}

			$this->render_topbar_html();
		}

		/**
		 * Render the topbar HTML
		 *
		 * @since 1.0.0
		 */
		private function render_topbar_html() {
			// Add body class for better CSS targeting.
			$current_screen = get_current_screen();
			$body_class     = '';

			if ( $current_screen && in_array( $current_screen->id, array( 'meeting', 'edit-meeting' ), true ) ) {
				$body_class = 'jitsi-topbar-meeting-page';
			}
			?>
			<div class="jitsi-topbar-notification <?php echo esc_attr( $body_class ); ?>" id="jitsi-topbar-notification">
				<div class="jitsi-topbar-container">
					<div class="jitsi-topbar-content">
						<span class="jitsi-topbar-icon">🎉</span>
						<span class="jitsi-topbar-message">
							<?php esc_html_e( 'New: Host Branded Jitsi Meetings - No Server Needed!', 'jitsi-pro' ); ?> 
							<a href="https://wppool.dev/webinar-and-video-conference-with-jitsi-meet/service/" 
								class="jitsi-topbar-cta" 
								target="_blank" 
								rel="noopener noreferrer">
								<?php esc_html_e( 'Explore now', 'jitsi-pro' ); ?> →
							</a>
						</span>
					</div>
					<button type="button" 
							class="jitsi-topbar-close" 
							id="jitsi-topbar-close"
							aria-label="<?php esc_attr_e( 'Close notification', 'jitsi-pro' ); ?>">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none">
								<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
							</svg>
					</button>
				</div>
			</div>
			<?php
		}

		/**
		 * Debug current screen information
		 * Remove this method in production
		 *
		 * @since 1.0.0
		 */
		public function debug_current_screen() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			global $pagenow;
			$screen = get_current_screen();

			// Safe way to get page parameter for debugging.
			$get_page = '';
			if ( 'admin.php' === $pagenow && $screen && isset( $screen->id ) ) {
				$get_page = $screen->id;
			}

			// Safe way to get post_type for debugging.
			$get_post_type = '';
			if ( $screen && isset( $screen->post_type ) ) {
				$get_post_type = $screen->post_type;
			}

			$debug_info = array(
				'pagenow'            => $pagenow,
				'screen'             => array(
					'id'          => $screen ? $screen->id : 'null',
					'base'        => $screen ? $screen->base : 'null',
					'parent_base' => $screen ? $screen->parent_base : 'null',
					'parent_file' => $screen ? $screen->parent_file : 'null',
					'post_type'   => $screen && isset( $screen->post_type ) ? $screen->post_type : 'null',
				),
				'detected_page'      => $get_page,
				'detected_post_type' => $get_post_type,
				'plugin_pages'       => $this->plugin_pages,
				'is_jitsi_page'      => $this->is_jitsi_page(),
			);
		}

		/**
		 * Enqueue CSS and JavaScript assets
		 *
		 * @since 1.0.0
		 */
		public function enqueue_assets() {

			// Only enqueue on Jitsi pages.
			if ( ! $this->is_jitsi_page() ) {
				return;
			}

			// Check if dismissed.
			if ( get_user_meta( get_current_user_id(), 'jitsi_hosted_topbar_dismissed', true ) ) {
				return;
			}

			// Enqueue CSS.
			wp_enqueue_style(
				'jitsi-topbar-style',
				JITSI_MEET_WP_URL . '/assets/css/jitsi-topbar.css',
				array(),
				JITSI_MEET_WP_VERSION
			);

			// Enqueue JavaScript.
			wp_enqueue_script(
				'jitsi-topbar-script',
				JITSI_MEET_WP_URL . '/assets/js/jitsi-topbar.js',
				array( 'jquery' ),
				JITSI_MEET_WP_VERSION,
				true
			);

			// Add nonce for AJAX.
			wp_localize_script(
				'jitsi-topbar-script',
				'jitsiTopbarData',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'jitsi_topbar_dismiss' ),
					'action'  => 'jitsi_dismiss_topbar',
				)
			);
		}

		/**
		 * Handle AJAX dismiss request
		 *
		 * @since 1.0.0
		 */
		public function handle_dismiss() {
			// Verify nonce.
			$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
			if ( ! wp_verify_nonce( $nonce, 'jitsi_topbar_dismiss' ) ) {
				wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
			}

			// Check permissions.
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( array( 'message' => 'Insufficient permissions' ) );
			}

			// Update user meta.
			$result = update_user_meta( get_current_user_id(), 'jitsi_hosted_topbar_dismissed', true );

			if ( $result ) {
				wp_send_json_success( array( 'message' => 'Topbar dismissed successfully' ) );
			} else {
				wp_send_json_error( array( 'message' => 'Failed to dismiss topbar' ) );
			}
		}

		/**
		 * Handle reset functionality for testing
		 *
		 * @since 1.0.0
		 */
		public function handle_reset() {
			// Check for reset parameter with nonce verification.
			if ( ! isset( $_GET['reset_topbar'] ) || ! isset( $_GET['_wpnonce'] ) ) {
				return;
			}

			// Verify nonce.
			$nonce = sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'jitsi_reset_topbar' ) ) {
				wp_die( esc_html__( 'Security check failed', 'jitsi-pro' ) );
			}

			// Check permissions.
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'jitsi-pro' ) );
			}

			// Delete user meta.
			delete_user_meta( get_current_user_id(), 'jitsi_hosted_topbar_dismissed' );

			// Redirect to clean URL.
			wp_safe_redirect( remove_query_arg( array( 'reset_topbar', '_wpnonce' ) ) );
			exit;
		}

		/**
		 * Generate reset URL with nonce
		 *
		 * @since 1.0.0
		 * @return string Reset URL with nonce
		 */
		public function get_reset_url() {
			$reset_url = add_query_arg(
				array(
					'reset_topbar' => '1',
					'_wpnonce'     => wp_create_nonce( 'jitsi_reset_topbar' ),
				),
				admin_url( 'admin.php' )
			);
			return $reset_url;
		}

		/**
		 * Add a page to show topbar on
		 *
		 * @since 1.0.0
		 * @param string $page Page identifier.
		 */
		public function add_page( $page ) {
			if ( ! in_array( $page, $this->plugin_pages, true ) ) {
				$this->plugin_pages[] = $page;
			}
		}

		/**
		 * Remove a page from showing topbar
		 *
		 * @since 1.0.0
		 * @param string $page Page identifier.
		 */
		public function remove_page( $page ) {
			$key = array_search( $page, $this->plugin_pages, true );
			if ( false !== $key ) {
				unset( $this->plugin_pages[ $key ] );
			}
		}

		/**
		 * Get all pages where topbar shows
		 *
		 * @since 1.0.0
		 * @return array Array of page identifiers.
		 */
		public function get_pages() {
			return $this->plugin_pages;
		}
	}
}

// Initialize the topbar.
new Jitsi_Topbar();