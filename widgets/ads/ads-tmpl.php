<?php
/**
 * --------------------------------
 * Ads widget template partials
 *
 * @package Acosmin_North_Extensions
 * --------------------------------
 */

/**
 * Hook some template actions ;)
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
add_action( 'northe__widget_ads', 'northe__widget_ads_output', 10 );

/**
 * Called functions
 *
 * @see https://developer.wordpress.org/reference/functions/do_action/
 */

// Widget output
if( ! function_exists( 'northe__widget_ads_output' ) ) {
	function northe__widget_ads_output( $o ) {
		echo $o[ 'code' ];
	}
}
