<?php
/**
 * --------------------------------------
 * Initializes all sections and templates.
 *
 * @package Acosmin_North_Extensions
 * --------------------------------------
 */

add_action( 'widgets_init', 'northe_sections', 30 );
add_filter( 'north_customizer_js_settings', 'northe_sections___new', 15 );

if( ! function_exists( 'northe_sections' ) ) {
	/**
	 * Register some custom sections
	 *
	 * @return void
	 */
	function northe_sections() {
		// Do nothing if not North
		if( ! northe_theme_check() ) return;

		// Category
		require_once( NORTHE_SECTIONS_DIR . 'category/category.php' );
		require_once( NORTHE_SECTIONS_DIR . 'category/category-tmpl.php' );

		// Ads
		require_once( NORTHE_SECTIONS_DIR . 'ads/ads.php' );
		require_once( NORTHE_SECTIONS_DIR . 'ads/ads-tmpl.php' );

		// Instagram
		require_once( NORTHE_SECTIONS_DIR . 'instagram/instagram.php' );
		require_once( NORTHE_SECTIONS_DIR . 'instagram/instagram-tmpl.php' );
	}
}

if( ! function_exists( 'northe_sections___new' ) ) {
	/**
	 * Add new sections in the Customizer list
	 *
	 * @since  1.0.0
	 * @param  array $sections Current sections
	 * @return array           Updated sections list
	 */
	function northe_sections___new( $sections ) {
		$sections[ 'sections' ][] = 'das';
		$sections[ 'sections' ][] = 'instagram';
		return apply_filters( 'northe_sections___new', $sections );
	}
}
