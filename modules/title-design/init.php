<?php
/**
 * ---------------------------------------------------------------------------
 * Title design - changes how the title is outputed by inserting
 * some HTML tags, like strong or em. To do all this we use `the_title` filter
 * ---------------------------------------------------------------------------
 */

add_action( 'admin_menu', 'northe_title_design_metabox'         );
add_action( 'save_post',  'northe_title_design_save_meta'       );
add_filter( 'the_title',  'northe_title_design_output',   10, 2 );

if( ! function_exists( 'northe_title_design_metabox' ) ) {
	/**
	 * Add a metabox to display a textarea
	 *
	 * @see    https://developer.wordpress.org/reference/functions/add_meta_box/
	 * @since  1.0.0
	 * @return void
	 */
	function northe_title_design_metabox() {
		if( ! apply_filters( 'northe_title_design_init', true ) ) return;

		add_meta_box(
			'northe_title_design',                                            // ID
			__( 'Title Design:', 'acosmin-north-extensions' ),                  // Metabox title
			'northe_title_design_callback',                                   // Calback function
			apply_filters( 'northe_title_design_metabox___screens', 'post' ), // Screens
			'normal',                                                        // Context ('normal', 'side', and 'advanced')
			'high'                                                           // Priority
		);
	}
}

if( ! function_exists( 'northe_title_design_callback') ) {
	/**
	 * Displays a wp_editor instance allowing us to edit the
	 * post title with some HTML tags.
	 *
	 * @see    https://developer.wordpress.org/reference/classes/_wp_editors/parse_settings/
	 * @see    https://developer.wordpress.org/reference/functions/wp_editor/
	 * @since  1.0.0
	 * @return void  Returns and displays a wp_editor instance
	 */
	function northe_title_design_callback() {
		global $post;

		/* Do nothing if it's not a post */
		if( ! is_object( $post ) ) return;

		/* Some text before we had the editor */
		printf(
			'<p class="northe-tde-description">%s</p>',
			esc_html__( 'Change the way the title displays, with italic and bold parts. If you change the title in the main title input, you will need to redo the html tags.', 'acosmin-north-extensions' )
		);

		/* wp_editor() arguments */
		$postID    = $post->ID;
		$title     = get_post_meta( $postID, 'northe_title_design_output', true );
		$content   = isset( $title ) && $title !== '' ? $title : get_the_title( $postID );
		$editor_id = 'northe-tde';
		$settings  = apply_filters( 'northe_title_design_callback___args', array(
			'wpautop'          => false,
			'media_buttons'    => false,
			'drag_drop_upload' => false,
			'textarea_rows'    => 1,
			'tinymce'          => false,
			'quicktags'        => array(
			'buttons'          => 'strong,em',
			),
		), $postID );

		/* Nonce */
		wp_nonce_field( 'northe_title_design_nonce', 'northe_title_design_nonce' );

		/* Add the editor */
		wp_editor( $content, $editor_id, $settings );
	}
}

if( ! function_exists( 'northe_title_design_save_meta' ) ) {
	/**
	 * Save the post meta
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function northe_title_design_save_meta() {
		global $post;

		if( ! apply_filters( 'northe_title_design_init', true ) ) return;

		/* Do nothing if it's not a post */
		if( ! is_object( $post ) ) return;

		/* Verify credentials */
		if (
			! isset( $_POST[ 'northe_title_design_nonce' ] ) ||
			! wp_verify_nonce( $_POST[ 'northe_title_design_nonce' ], 'northe_title_design_nonce' )
		) return;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! current_user_can( 'edit_post', $post->ID ) )
			return;

		/* Meta */
		$title = isset( $_POST[ 'northe-tde' ] ) ? $_POST[ 'northe-tde' ] : '';

		/**
		 * Hook into this before we update the title
		 *
		 * @param $post Current post object
		 */
		do_action( 'northe_title_design__before_update', $post );

		/* Don't update meta and return */
		if( $title === '' || $title === get_the_title( $post->ID ) ) return;

		/* Update the post meta */
		update_post_meta( $post->ID, 'northe_title_design_output', wp_kses_post( $title ) );
	}
}

if( ! function_exists( 'northe_title_design_output' ) ) {
	/**
	 * Adds the designed title if it's set by the user
	 *
	 * @since  1.0.0
	 * @param  string $title Current title in `the_title` filter
	 * @param  int    $id    Post ID
	 * @return string        Returns the designed title or the current one
	 */
	function northe_title_design_output( $title, $id ) {
		if( ! apply_filters( 'northe_title_design_init', true ) ) return $title;

		/* If we're in the admin area, return the default title */
		if( is_admin() ) return $title;

		/* Get designed title, saved in meta */
		$newtitle = get_post_meta( $id, 'northe_title_design_output', true );

		/* Return one or the other */
		return $newtitle !== '' ? preg_replace('/<em>(.*?)<\/em>/', '<i>$1</i>', $newtitle) : $title;
	}
}
