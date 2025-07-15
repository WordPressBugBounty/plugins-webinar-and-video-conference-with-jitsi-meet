/**
 * Jitsi Topbar JavaScript
 * Handles topbar interactions and AJAX functionality
 *
 * @package JitsiMeetWP
 * @since   1.0.0
 */

/* eslint-env browser, jquery */
/* global jitsiTopbarData */

( function( $ ) {
	'use strict';

	/**
	 * Jitsi Topbar Class
	 *
	 * @since 1.0.0
	 */
	class JitsiTopbar {
		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		constructor() {
			this.notification = null;
			this.closeBtn = null;
			this.isAnimating = false;
			
			this.init();
		}

		/**
		 * Initialize the topbar functionality
		 *
		 * @since 1.0.0
		 */
		init() {
			// Wait for DOM to be ready.
			if ( 'loading' === document.readyState ) {
				document.addEventListener( 'DOMContentLoaded', () => this.bindEvents() );
			} else {
				this.bindEvents();
			}
		}

		/**
		 * Bind event listeners
		 *
		 * @since 1.0.0
		 */
		bindEvents() {
			this.notification = document.getElementById( 'jitsi-topbar-notification' );
			this.closeBtn = document.getElementById( 'jitsi-topbar-close' );

			if ( ! this.notification || ! this.closeBtn ) {
				return;
			}

			// Close button click.
			this.closeBtn.addEventListener( 'click', ( e ) => this.handleClose( e ) );
			
			// Keyboard support.
			this.closeBtn.addEventListener( 'keydown', ( e ) => {
				if ( 'Enter' === e.key || ' ' === e.key ) {
					e.preventDefault();
					this.handleClose( e );
				}
			} );

			// ESC key support.
			document.addEventListener( 'keydown', ( e ) => {
				if ( 'Escape' === e.key && this.notification && ! this.isAnimating ) {
					this.handleClose( e );
				}
			} );

			// Track CTA clicks (optional analytics).
			const ctaLink = this.notification.querySelector( '.jitsi-topbar-cta' );
			if ( ctaLink ) {
				ctaLink.addEventListener( 'click', () => this.trackCTAClick() );
			}
		}

		/**
		 * Handle close button click
		 *
		 * @since 1.0.0
		 * @param {Event} event The event object
		 */
		handleClose( event ) {
			event.preventDefault();
			
			if ( this.isAnimating || ! this.notification ) {
				return;
			}

			this.isAnimating = true;
			this.animateOut()
				.then( () => this.sendDismissRequest() )
				.catch( ( error ) => {
					console.error( 'Error handling topbar close:', error );
					this.isAnimating = false;
				} );
		}

		/**
		 * Animate topbar out
		 *
		 * @since 1.0.0
		 * @return {Promise} Promise that resolves when animation completes
		 */
		animateOut() {
			return new Promise( ( resolve ) => {
				if ( ! this.notification ) {
					resolve();
					return;
				}

				// Add transition styles.
				this.notification.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
				this.notification.style.opacity = '0';
				this.notification.style.transform = 'translateY(-20px)';

				// Wait for animation to complete.
				setTimeout( () => {
					if ( this.notification ) {
						this.notification.remove();
					}
					resolve();
				}, 300 );
			} );
		}

		/**
		 * Send AJAX request to dismiss topbar
		 *
		 * @since 1.0.0
		 * @return {Promise} Promise that resolves when request completes
		 */
		sendDismissRequest() {
			// Check if WordPress AJAX data is available.
			if ( 'undefined' === typeof jitsiTopbarData ) {
				console.warn( 'Jitsi topbar AJAX data not found' );
				return Promise.resolve();
			}

			const formData = new URLSearchParams( {
				action: jitsiTopbarData.action,
				nonce: jitsiTopbarData.nonce
			} );

			return fetch( jitsiTopbarData.ajaxUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: formData
			} )
			.then( ( response ) => response.json() )
			.then( ( data ) => {
				if ( ! data.success ) {
					console.error( 'Failed to dismiss topbar:', data );
				}
				return data;
			} )
			.catch( ( error ) => {
				console.error( 'Error dismissing topbar:', error );
				throw error;
			} )
			.finally( () => {
				this.isAnimating = false;
			} );
		}

		/**
		 * Track CTA clicks (optional analytics)
		 *
		 * @since 1.0.0
		 */
		trackCTAClick() {
			// You can add analytics tracking here.
			console.log( 'Jitsi topbar CTA clicked' );
			
			// Example: Google Analytics.
			if ( 'undefined' !== typeof gtag ) {
				gtag( 'event', 'click', {
					event_category: 'jitsi_topbar',
					event_label: 'explore_hosted_service',
					value: 1
				} );
			}

			// Example: Custom analytics.
			if ( 'undefined' !== typeof jitsiAnalytics ) {
				jitsiAnalytics.track( 'topbar_cta_click', {
					source: 'admin_topbar',
					action: 'explore_hosted_service'
				} );
			}
		}

		/**
		 * Show topbar programmatically
		 *
		 * @since 1.0.0
		 */
		show() {
			if ( this.notification ) {
				this.notification.style.display = 'block';
				this.notification.style.opacity = '1';
				this.notification.style.transform = 'translateY(0)';
			}
		}

		/**
		 * Hide topbar programmatically
		 *
		 * @since 1.0.0
		 */
		hide() {
			if ( this.notification && ! this.isAnimating ) {
				this.handleClose( new Event( 'programmatic' ) );
			}
		}

		/**
		 * Check if topbar is visible
		 *
		 * @since 1.0.0
		 * @return {boolean} True if visible, false otherwise
		 */
		isVisible() {
			return this.notification && 
				   'none' !== this.notification.style.display && 
				   '0' !== this.notification.style.opacity;
		}
	}

	// Auto-initialize when script loads.
	const jitsiTopbar = new JitsiTopbar();

	// Expose globally for external access.
	window.JitsiTopbar = JitsiTopbar;
	window.jitsiTopbar = jitsiTopbar;

	// jQuery compatibility (if needed).
	$( document ).ready( function() {
		// Additional jQuery handling if needed.
		$( '.jitsi-topbar-cta' ).on( 'click', function() {
			// jQuery-specific handling can go here.
		} );
	} );

} )( jQuery );