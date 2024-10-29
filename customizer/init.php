<?php
/**
 * Init Customizer
 */
if( ! function_exists( 'northe_customizer' ) ) {
	/**
	 * Initialize Customizer options
	 * @see    https://developer.wordpress.org/themes/customize-api/customizer-objects/
	 * @since  1.0.0
	 * @param  object $wp_customize WP_Customize_Manager instance
	 * @return void
	 */
	function northe_customizer( $wp_customize ) {

	}
}
add_action( 'customize_register', 'northe_customizer', 15 );
