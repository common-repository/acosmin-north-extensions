<?php
/**
 * -----------------------------------
 * Functions needed to sanitize values
 *
 * @package Acosmin_North_Extensions
 * -----------------------------------
 */

if( ! function_exists( 'northe_sanitize_select' ) ) {
	/**
	 * Sanitize a selectbox in our outside the Customizer
	 *
	 * @since  1.0.0
	 * @param  string  $input      Inputed value
	 * @param  object  $setting    WP_Customize setting
	 * @param  string  $default    Default value
	 * @param  boolean $customizer If this function is intended to be used in the Customizer
	 * @return mixed               Depending on the choices
	 */
	function northe_sanitize_select( $input, $setting, $default = '', $customizer = true ) {
		global $wp_customize;

		if( $customizer ) {
			if( ! is_object( $wp_customize ) ) return;

			$control = $wp_customize->get_control( $setting->id );

			return array_key_exists( $input, $control->choices ) ? $input : $setting->default;
		} else {
			$choices = (array) $setting;

			return in_array( $input, $choices, true ) ? $input : $default;
		}
	}
}

if( ! function_exists( 'northe_sanitize_rgb' ) ) {
	/**
	 * Sanitize RGB color
	 *
	 * @since  1.0.0
	 * @param  string $color Hexadecimal color
	 * @return string        Sanitized color
	 */
	function northe_sanitize_rgb( $color ) {
		if ( '' === $color ) return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) return $color;
	}
}

if( ! function_exists( 'northe_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox input
	 *
	 * @since  1.0.0
	 * @param  boolean $input Current value
	 * @return boolean        Sanitized value
	 */
	function northe_sanitize_checkbox( $input ) {
		return $input === true ? true : false;
	}
}

if( ! function_exists( 'northe_sanitize_rgba' ) ) {
	/**
	 * Sanitize RGBA color input
	 *
	 * @since  1.0.0
	 * @param  string $color Current RGBA color
	 * @return string        Sanitized value
	 */
	function northe_sanitize_rgba( $color ) {
		if ( empty( $color ) || is_array( $color ) ) return 'rgba(0,0,0,0)';

		if ( false === strpos( $color, 'rgba' ) ) {
			return northe_sanitize_hex( $color );
		} else {
			$color = str_replace( ' ', '', $color );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
		}
	}
}

if( ! function_exists( 'northe_sanitize_css' ) ) {
	/**
	 * Sanitize CSS
	 *
	 * @since  1.0.0
	 * @param  string  $custom_css A bunch of CSS
	 * @param  boolean $format     Minified or as it is
	 * @return string              Sanitized CSS
	 */
	function northe_sanitize_css( $custom_css, $format = TRUE ) {
		if ( '' === $custom_css ) return '';

		return $format ? preg_replace('/\s\s+/', ' ', wp_strip_all_tags( $custom_css ) ) : esc_html( $custom_css );
	}
}
