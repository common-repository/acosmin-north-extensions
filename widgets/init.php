<?php
/**
 * --------------------------------------
 * Initializes all widgets and templates.
 *
 * @package Acosmin_North_Extensions
 * --------------------------------------
 */

add_action( 'widgets_init', 'northe_widgets', 40 );

if( ! function_exists( 'northe_widgets' ) ) {
	/**
	 * Register some custom widgets
	 *
	 * @return void
	 */
	function northe_widgets() {
		// Ads
		require_once( NORTHE_WIDGETS_DIR . 'ads/ads.php' );
		require_once( NORTHE_WIDGETS_DIR . 'ads/ads-tmpl.php' );

		// Instagram
		require_once( NORTHE_WIDGETS_DIR . 'instagram/instagram.php' );
		require_once( NORTHE_WIDGETS_DIR . 'instagram/instagram-tmpl.php' );
	}
}

// Instagram API Class
require_once( NORTHE_WIDGETS_DIR . 'instagram/instagram-class.php' );
