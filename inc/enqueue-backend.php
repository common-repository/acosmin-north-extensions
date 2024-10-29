<?php
/**
 * --------------------------------------------
 * Enqueue scripts and styles for the backend.
 * --------------------------------------------
 */

if ( ! function_exists( 'northe_scripts_admin' ) ) {
	/**
	 * Enqueue admin styles and scripts
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function northe_scripts_admin() {
		// Styles
		wp_enqueue_style(
			'northe-style-admin',
			NORTHE_PLUGIN_URL . 'assets/css/admin.css',
			[], NORTHE_VERSION, 'all'
		);

		// Scripts
		wp_enqueue_script(
			'northe-scripts-admin',
			NORTHE_PLUGIN_URL . 'assets/js/admin.js',
			[ 'jquery' ], NORTHE_VERSION, true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'northe_scripts_admin' );
