<?php
////////////////////////
/// Needed Functions ///
////////////////////////

if( ! function_exists( 'northe_theme' ) ) {
	/**
	 * Get current theme name
	 *
	 * @since  1.0.0
	 * @param  boolean $parent Return child name if false
	 * @return string          Current theme name
	 */
	function northe_theme( $parent = false ) {
		$theme = wp_get_theme();

		return $parent ? $theme->parent_theme : $theme->name;
	}
}

if( ! function_exists( 'northe_theme_check' ) ) {
	/**
	 * Checks if the current theme is `North`
	 *
	 * @since  1.0.0
	 * @param  string  $name Theme name
	 * @return boolean       Returns true if `$name` is the current theme name
	 */
	function northe_theme_check( $name = 'North' ) {
		$name = apply_filters( 'northe_theme_check___filter', $name );
		return ( northe_theme() === $name || northe_theme( true ) === $name ) ? true : false;
	}
}

if( ! function_exists( 'northe_widget_css_classes' ) ) {
	/**
	 * Adds custom CSS classes to the `$args[ 'before_widget' ]` argument
	 *
	 * @since  1.0.0
	 * @param  array        $args `bw` => current before_widget, `type` => widget type, `css` => custom classes
	 * @return string|false        A `string` with new classes or `false` if `bw` is not set or empty $classes
	 */
	function northe_widget_css_classes( $args ) {
		/* Defaults */
		$defaults = [
			'bw'   => [],
			'type' => 'default',
			'css'  => []
		];

		/* Do nothing if we don't have `before_widget` */
		if( empty( $args[ 'bw' ] ) ) return false;

		/* Parse arguments */
		$args = wp_parse_args( $args, $defaults );

		/* Get classes and filter them */
		$classes = empty( $args[ 'css' ] ) ? array() : $args[ 'css' ];
		$classes = apply_filters( 'northe___widget_' . $args[ 'type' ] . '_css_classes', $args[ 'css' ], $args );

		/* Do nothing if we don't have classes */
		if( empty( $classes ) ) return false;

		/* Stringify them :) */
		$classes = join( ' ', array_unique( array_map( 'esc_attr', $classes ) ) );

		/* Return the new `before_widget` */
		if( strpos( $args[ 'bw' ], 'class' ) === false ) {
			return str_replace( '>', ' class="' . $classes . '">', $args[ 'bw' ] );
		} else {
			return str_replace( 'class="', 'class="' . $classes . ' ', $args[ 'bw' ] );
		}
	}
}
