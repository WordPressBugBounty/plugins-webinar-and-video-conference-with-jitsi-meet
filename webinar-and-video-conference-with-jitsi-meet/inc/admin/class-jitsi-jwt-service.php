<?php
/**
 * Jitsi JWT Service — handles meeting token generation via the hosted service API.
 *
 * @package JITSI_MEET_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Service API token (hardcoded — never exposed to frontend).
if ( ! defined( 'JITSI_SERVICE_API_TOKEN' ) ) {
	define( 'JITSI_SERVICE_API_TOKEN', 'fcB1ilcNL9ZzjG35iOsgCRrdFHSaToQxxw0prvUNBWI' );
}

// Base URL for the hosted service API.
if ( ! defined( 'JITSI_SERVICE_API_BASE_URL' ) ) {
	define( 'JITSI_SERVICE_API_BASE_URL', 'https://jitsihosted.app' );
}

/**
 * Class Jitsi_JWT_Service
 *
 * Provides server-side JWT token generation for the Hosted Subdomain mode.
 * Uses the /api/meeting/token endpoint to generate tokens on-demand.
 */
class Jitsi_JWT_Service {

	/**
	 * Get a meeting JWT token for the given WordPress user.
	 *
	 * For guest (not logged-in) users, returns an empty string so the
	 * Jitsi iframe loads without JWT (anonymous, moderator=false).
	 *
	 * @param int    $wp_user_id   WordPress user ID. 0 = guest.
	 * @param string $full_domain  Full subdomain domain, e.g. nextlevel.jitsihosted.app.
	 * @param string $room_name    Meeting room name / slug.
	 * @param bool   $is_moderator Whether this user is the meeting host.
	 *
	 * @return string|WP_Error JWT token string, empty string for guest, or WP_Error on API failure.
	 */
	public static function get_meeting_token( $wp_user_id, $full_domain, $room_name, $is_moderator = false ) {
		// Guest users: no JWT needed.
		if ( empty( $wp_user_id ) || ! is_user_logged_in() ) {
			return new WP_Error( 'not_logged_in', sprintf( 'Debug: Not logged in. wp_user_id=%s, logged_in=%d', $wp_user_id, is_user_logged_in() ) );
		}

		if ( empty( $full_domain ) ) {
			return new WP_Error( 'empty_domain', __( 'Domain is required to generate a JWT token.', 'webinar-and-video-conference-with-jitsi-meet' ) );
		}



		// Get user info.
		$user = get_userdata( $wp_user_id );
		if ( ! $user ) {
			return new WP_Error( 'no_user_found', 'Debug: get_userdata returned false for user ID: ' . $wp_user_id );
		}

		// Check if user has a custom email set in admin settings.
		$custom_email = get_user_meta( $wp_user_id, 'jitsi_user_email', true );

		// Priority: custom email from admin settings > WordPress user email.
		if ( ! empty( $custom_email ) && is_email( $custom_email ) ) {
			$user_email = $custom_email;
		} else {
			$user_email = $user->user_email;
		}

		// Handle invalid/local email domains.
		$invalid_domains = array( '.local', '.localhost', '.test', '.invalid', '.example' );
		foreach ( $invalid_domains as $invalid_domain ) {
			if ( false !== strpos( $user_email, $invalid_domain ) ) {
				$email_parts = explode( '@', $user_email );
				$user_email  = $email_parts[0] . '_u' . $wp_user_id . '@jitsi-wp-users.com';
				break;
			}
		}

		// Extract subdomain from full domain (e.g., 'nextlevel' from 'nextlevel.jitsihosted.app').
		$subdomain = self::extract_subdomain( $full_domain );

		// Prepare API request data.
		$api_data = array(
			'subdomain' => $subdomain,
			'user_id'   => $wp_user_id,
			'name'      => $user->display_name,
			'email'     => $user_email,
			'moderator' => $is_moderator ? 'true' : 'false',
		);

		// Build URL with query parameters (API expects params in URL, not body).
		$api_url = JITSI_SERVICE_API_BASE_URL . '/api/meeting/token?' . http_build_query( $api_data );

		// Generate JWT token using the meeting token API.
		$response = wp_remote_post(
			$api_url,
			array(
				'timeout'   => 20,
				'sslverify' => false,
				'headers'   => array(
					'accept'        => 'application/json',
					'Authorization' => 'Bearer ' . JITSI_SERVICE_API_TOKEN,
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			self::debug( 'FAIL: API request failed. Error: ' . $response->get_error_message() );
			// Usually due to firewall blocking outbound port 8090
			return new WP_Error( 
				'api_unreachable', 
				__( 'Could not connect to the token server. Your hosting provider may be blocking outbound connections to port 8090. Please contact your host support.', 'webinar-and-video-conference-with-jitsi-meet' )
			);
		}

		$code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );

		if ( 200 !== $code ) {
			self::debug( 'FAIL: API returned HTTP ' . $code . '. Body: ' . $body );
			return new WP_Error( 
				'api_error', 
				sprintf(
					/* translators: 1: HTTP code, 2: API response body */
					__( 'Token generation failed. The server returned HTTP %1$d: %2$s', 'webinar-and-video-conference-with-jitsi-meet' ),
					$code,
					esc_html( $body ? $body : 'Empty response' )
				)
			);
		}

		$data = json_decode( $body, true );

		// The API returns the token in the 'token' field.
		if ( isset( $data['token'] ) && ! empty( $data['token'] ) ) {
			$token = sanitize_text_field( $data['token'] );
			self::debug( 'SUCCESS: JWT token generated (first 40 chars): ' . substr( $token, 0, 40 ) . '...' );



			return $token;
		}

		self::debug( 'FAIL: API returned HTTP 200 but no "token" field in response. Body: ' . $body );
		return new WP_Error( 'invalid_response', __( 'Invalid response from token server.', 'webinar-and-video-conference-with-jitsi-meet' ) );
	}

	/**
	 * Decode JWT token and extract expiry time.
	 *
	 * @param string $token JWT token.
	 * @return int Unix timestamp of token expiry, or 0 if unable to decode.
	 */
	private static function get_jwt_expiry( $token ) {
		$parts = explode( '.', $token );
		if ( count( $parts ) !== 3 ) {
			return 0;
		}

		// Decode the payload (second part)
		$payload = base64_decode( strtr( $parts[1], '-_', '+/' ) );
		$payload_data = json_decode( $payload, true );

		if ( isset( $payload_data['exp'] ) ) {
			return (int) $payload_data['exp'];
		}

		return 0;
	}

	/**
	 * Verify if a JWT token is still valid using the API.
	 *
	 * @param string $token JWT token to verify.
	 * @return bool True if token is valid, false otherwise.
	 */
	private static function verify_token( $token ) {
		$verify_url = JITSI_SERVICE_API_BASE_URL . '/api/auth/verify';

		$response = wp_remote_get(
			$verify_url,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'headers'   => array(
					'accept'        => 'application/json',
					'Authorization' => 'Bearer ' . $token,
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$code = wp_remote_retrieve_response_code( $response );

		// Token is valid if API returns 200.
		return ( 200 === $code );
	}

	/**
	 * Verify if the branded server is active and reachable.
	 *
	 * @param string $full_domain Full domain, e.g. nextlevel.jitsihosted.app.
	 * @return bool|WP_Error True if active, WP_Error with message on failure.
	 */
	public static function verify_server_active( $full_domain ) {
		$subdomain = self::extract_subdomain( $full_domain );
		if ( ! $subdomain ) {
			return new WP_Error( 'invalid_url', __( 'Please enter a valid URL (include https://).', 'webinar-and-video-conference-with-jitsi-meet' ) );
		}

		// 1. Public Reachability Check (Verify the subdomain actually exists and responds)
		$is_live = self::check_domain_live( $full_domain );

		// 2. Platform Status Check (Verify authorization in our system)
		$api_url = JITSI_SERVICE_API_BASE_URL . '/api/server/status?subdomain=' . $subdomain;

		$response = wp_remote_get(
			$api_url,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'headers'   => array(
					'accept'        => 'application/json',
					'Authorization' => 'Bearer ' . JITSI_SERVICE_API_TOKEN,
				),
			)
		);

		$code = wp_remote_retrieve_response_code( $response );

		// If API check is successful, we are good.
		if ( 200 === $code ) {
			return true;
		}

		// If API fails or is pending, but we confirmed it's live in browser/DNS,
		// we allow the connection to proceed as the user can see it's active.
		if ( $is_live ) {
			return true;
		}

		if ( is_wp_error( $response ) ) {
			return new WP_Error( 'connection_failed', __( 'We couldn\'t reach the verification server. Please try again.', 'webinar-and-video-conference-with-jitsi-meet' ) );
		}

		// Only show pending_setup if we can't find it publicly AND the API says no.
		return new WP_Error( 'pending_setup', __( 'Your hosted server isn\'t active yet. If you just requested it, wait for our email.', 'webinar-and-video-conference-with-jitsi-meet' ) );
	}

	/**
	 * Publicly check if a Jitsi domain is live and responding.
	 * It checks for the presence of config.js which every Jitsi instance has.
	 *
	 * @param string $domain The domain to check.
	 * @return bool True if responding.
	 */
	public static function check_domain_live( $domain ) {
		$input = trim( $domain );
		if ( strpos( $input, 'https//' ) === 0 ) {
			$input = 'https://' . substr( $input, 7 );
		}
		if ( strpos( $input, 'http' ) !== 0 ) {
			$input = 'https://' . $input;
		}
		
		$host = parse_url( $input, PHP_URL_HOST );
		if ( ! $host ) {
			$host = $input;
		}

		$check_url = 'https://' . untrailingslashit( $host ) . '/config.js';
		
		$response = wp_remote_head( $check_url, array(
			'timeout'    => 10,
			'sslverify'  => false,
		) );

		return ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response );
	}

	/**
	 * Extract the subdomain prefix from a full domain or URL.
	 * Supports:
	 * - https://nextlevel.jitsihosted.app
	 * - https//nextlevel.jitsihosted.app
	 * - nextlevel.jitsihosted.app
	 *
	 * @param string $input Full domain or URL string.
	 * @return string|false Subdomain prefix, or false if invalid.
	 */
	public static function extract_subdomain( $input ) {
		$input = trim( $input );
		if ( empty( $input ) ) {
			return false;
		}

		// Fix common typos like https//
		if ( strpos( $input, 'https//' ) === 0 ) {
			$input = 'https://' . substr( $input, 7 );
		}

		// Add https:// if missing for parser
		if ( strpos( $input, 'http' ) !== 0 ) {
			$input = 'https://' . $input;
		}

		$host = parse_url( $input, PHP_URL_HOST );
		if ( ! $host ) {
			$host = $input;
		}

		$parts = explode( '.', $host );
		return ! empty( $parts[0] ) ? $parts[0] : false;
	}

	/**
	 * Validate that a domain is reachable and is a live Jitsi server.
	 *
	 * Step 1 — DNS check: Verify hostname resolves to a real IP address.
	 *   A domain like 'grtytry' with no TLD or a non-existent hostname will
	 *   fail DNS resolution immediately without making any HTTP request.
	 *
	 * Step 2 — HTTP liveness check: Verify the domain responds on HTTPS and
	 *   serves Jitsi's /config.js (present on every Jitsi installation).
	 *
	 * @param string $normalized_domain Full URL, already normalised with https://.
	 * @return true|WP_Error True if valid and live, WP_Error with message otherwise.
	 */
	public static function validate_domain_reachable( $normalized_domain ) {
		$host = parse_url( $normalized_domain, PHP_URL_HOST );
		if ( ! $host ) {
			self::debug( 'validate_domain_reachable() ABORT: could not parse host from: ' . $normalized_domain );
			return new WP_Error(
				'invalid_url',
				__( 'Invalid URL. Please enter a full domain like https://yourbrand.jitsihosted.app', 'webinar-and-video-conference-with-jitsi-meet' )
			);
		}

		self::debug( 'validate_domain_reachable() -- checking host: ' . $host );

		// Step 1: DNS resolution.
		// gethostbyname() returns the original string unchanged if DNS fails.
		$resolved_ip = gethostbyname( $host );
		$dns_ok      = ( $resolved_ip !== $host ) && filter_var( $resolved_ip, FILTER_VALIDATE_IP );

		self::debug( 'DNS check -- host=' . $host . ', resolved_ip=' . $resolved_ip . ', dns_ok=' . ( $dns_ok ? 'YES' : 'NO' ) );

		if ( ! $dns_ok ) {
			return new WP_Error(
				'dns_failure',
				sprintf(
					/* translators: %s = the domain hostname the user typed */
					__( 'Domain "%s" could not be found (DNS lookup failed). Please check the URL and try again.', 'webinar-and-video-conference-with-jitsi-meet' ),
					esc_html( $host )
				)
			);
		}

		// Step 2: HTTP liveness -- look for Jitsi's /config.js file.
		// Every Jitsi instance serves this file; its presence confirms the server is a live Jitsi installation.
		$check_url = 'https://' . untrailingslashit( $host ) . '/config.js';
		self::debug( 'HTTP liveness check -- fetching: ' . $check_url );

		$response = wp_remote_head(
			$check_url,
			array(
				'timeout'   => 15,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $response ) ) {
			self::debug( 'HTTP liveness WP_Error: ' . $response->get_error_message() );
			return new WP_Error(
				'unreachable',
				sprintf(
					/* translators: %s = the domain hostname */
					__( 'Domain "%s" resolved but the server did not respond. It may be offline or not a Jitsi server.', 'webinar-and-video-conference-with-jitsi-meet' ),
					esc_html( $host )
				)
			);
		}

		$http_code = wp_remote_retrieve_response_code( $response );
		self::debug( 'HTTP liveness response code: ' . $http_code );

		if ( 200 !== $http_code ) {
			return new WP_Error(
				'not_jitsi',
				sprintf(
					/* translators: 1: domain hostname, 2: HTTP status code */
					__( '"%1$s" is reachable but does not appear to be a Jitsi server (expected HTTP 200 from /config.js, got %2$d). Please double-check the URL.', 'webinar-and-video-conference-with-jitsi-meet' ),
					esc_html( $host ),
					$http_code
				)
			);
		}

		self::debug( 'validate_domain_reachable() PASS: domain is a live Jitsi server.' );
		return true;
	}

	/**
	 * AJAX Handler: Save & Test Connection
	 *
	 * Every click always deletes the old JWT cache first, then tries to
	 * generate a fresh token. Connection is only marked as successful when
	 * a new JWT is successfully returned by the API.
	 */
	public static function ajax_connect_server() {
		check_ajax_referer( 'jitsi_jwt_service_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
		}

		$domain = isset( $_POST['domain'] ) ? sanitize_text_field( wp_unslash( $_POST['domain'] ) ) : '';
		self::debug( 'ajax_connect_server() -- raw domain from POST: ' . $domain );

		if ( empty( $domain ) ) {
			self::debug( 'ajax_connect_server() ABORT: empty domain.' );
			wp_send_json_error( array( 'message' => __( 'Please enter a valid URL (include https://).', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
		}

		// Normalize domain input.
		if ( 0 === strpos( $domain, 'https//' ) ) {
			$domain = 'https://' . substr( $domain, 7 );
		}
		if ( 0 !== strpos( $domain, 'http' ) ) {
			$domain = 'https://' . $domain;
		}
		self::debug( 'ajax_connect_server() -- normalized domain: ' . $domain );

		$wp_user_id = get_current_user_id();
		self::debug( 'ajax_connect_server() -- current user_id: ' . $wp_user_id );

		// Step 1: Domain validation (DNS + HTTP liveness).
		// Run this BEFORE calling the JWT API. The JWT API issues tokens for any
		// subdomain string (even fake ones), so we must gate on whether the actual
		// domain resolves in DNS and serves a live Jitsi instance.
		self::debug( 'Running domain validation (DNS + liveness check)...' );
		$domain_check = self::validate_domain_reachable( $domain );

		if ( is_wp_error( $domain_check ) ) {
			self::debug( 'Domain validation FAILED: ' . $domain_check->get_error_message() );
			
			// If validation fails, ensure we are disconnected.
			update_option( 'jitsi_opt_subdomain_connected', '0' );

			wp_send_json_error( array(
				'message' => $domain_check->get_error_message(),
				'code'    => $domain_check->get_error_code(),
			) );
		}
		self::debug( 'Domain validation PASSED -- proceeding to JWT generation.' );



		// Reset connected state before attempting fresh token generation.
		update_option( 'jitsi_opt_subdomain_connected', '0' );
		self::debug( 'jitsi_opt_subdomain_connected reset to 0.' );

		// Step 3: Generate fresh JWT token.
		self::debug( 'Calling get_meeting_token() for domain: ' . $domain );
		$token_or_error = self::get_meeting_token( $wp_user_id, $domain, 'test-connection', true );
		
		$is_error = is_wp_error( $token_or_error );
		$is_empty = empty( $token_or_error );
		
		self::debug( 'get_meeting_token() returned: ' . ( $is_error ? 'WP_Error (' . $token_or_error->get_error_message() . ')' : ( $is_empty ? '(empty -- FAILED)' : 'TOKEN OK (len=' . strlen( $token_or_error ) . ')' ) ) );

		if ( ! $is_error && ! empty( $token_or_error ) ) {
			// JWT generated -- connection works, but we DON'T save it here.
			// Saving is reserved for the 'Save Changes' button submit action.

			self::debug( 'CONNECTED: domain verified, but NOT saved to DB until form submission. Sending success.' );
			wp_send_json_success( array(
				'message' => __( 'Connected successfully!', 'webinar-and-video-conference-with-jitsi-meet' ),
			) );
		}

		// JWT generation failed but domain was live -- unexpected.
		self::debug( 'FAIL (server reachable but JWT generation failed). Sending error.' );
		
		// Ensure disconnection if token generation fails.
		update_option( 'jitsi_opt_subdomain_connected', '0' );

		if ( $is_error ) {
			$error_message = $token_or_error->get_error_message();
		} elseif ( $is_empty ) {
			// This covers the generic empty return (if it wasn't caught by our WP_Error modifications)
			$error_message = __( 'Connection failed: The token server did not return a valid response. Your hosting provider may be blocking outbound connections to port 8090. Please contact your host support.', 'webinar-and-video-conference-with-jitsi-meet' );
		} else {
			$error_message = __( 'Connection failed: An unknown error occurred while generating the JWT token. Please check your server setup or contact support.', 'webinar-and-video-conference-with-jitsi-meet' );
		}

		wp_send_json_error( array(
			'message' => $error_message,
		) );
	}

	/**
	 * AJAX Handler: Disconnect Server
	 */
	public static function ajax_disconnect_server() {
		check_ajax_referer( 'jitsi_jwt_service_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
		}

		// Reset connection status.
		update_option( 'jitsi_opt_subdomain_connected', '0' );

		// Clear the cached JWT token for the current admin user.
		// The meta key is 'jitsi_jwt_token_cache' (not domain-specific).
		delete_user_meta( get_current_user_id(), 'jitsi_jwt_token_cache' );

		wp_send_json_success( array( 'message' => __( 'Disconnected successfully.', 'webinar-and-video-conference-with-jitsi-meet' ) ) );
	}

	/**
	 * Log a message to the WordPress debug log if WP_DEBUG is enabled.
	 *
	 * @param string $message Message to log.
	 */
	private static function debug( $message ) {
		// Silenced for production.
	}
}
