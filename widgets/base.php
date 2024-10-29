<?php
if( ! class_exists( 'Northe_Widgets_Base' ) ) {
	/**
	 * Widgets Main Class
	 *
	 * All section widgets can extend this class
	 *
	 * @since 1.0.0
	 */
	class Northe_Widgets_Base extends WP_Widget {

		/**
		 * Form fields
		 *
		 * Outputs fields HTML based on their type
		 *
		 * @since  1.0.0
		 * @param  array  $args Checkbox arguments
		 * @return string       Input checkbox HTML
		 * @access public
		 */
		public function _fields( $args ) {
			// Defaults
			$defaults = [
				'type'       => '',
				'instance'   => '',
				'label'      => '',
				'desc'       => '',
				'option'     => '',
				'options'    => [],
				'wrap_start' => '<p>',
				'wrap_end'   => '</p>',
				'disabled'   => false,
				'css'        => '',
				'merge'      => []
			];

			// Do nothing
			if( empty( $args ) ) return;

			// Global formats
			$label_format = '<label for="%1$s">%2$s</label>';

			foreach( $args as $setting => $settings ) :
				// Parse settings
				$settings = wp_parse_args( $settings, $defaults );

				// Check if input is disabled
				$disabled = $settings[ 'disabled' ] ? 'disabled' : '';

				/**
				 * Output
				 */

				// Wrapper start
 				echo $settings[ 'wrap_start' ];

					/**
					 * Different output for certain input types
					 * ----------------------------------------
					 */
					switch( $settings[ 'type' ] ) :

						/**
						 * Title
						 */
						case 'title' :
							$settings[ 'wrap_start' ] = '';
							$settings[ 'wrap_end' ]   = '';

							printf( '<h4 class="north-h4">%s</h4>', esc_html( $settings[ 'label' ] ) );
							break;

						/**
						 * Text field
						 */
						case 'text_field' :
							$input_format = '<input %1$s type="text" class="widefat %2$s" id="%3$s" name="%4$s" value="%5$s" />';

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								esc_attr( $settings[ 'instance' ] )
							);
							break;

						/**
						 * Textarea
						 */
						case 'textarea' :
							$input_format = '<textarea %1$s class="widefat %2$s" rows="16" cols="20" id="%3$s" name="%4$s">%5$s</textarea>';
							$descr_format = '<span class="north-w-description">%s</span>';

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								esc_textarea( $settings[ 'instance' ] )
							);

							// Description
							if( ! empty( $settings[ 'desc' ] ) ) {
								printf(
									$descr_format,
									esc_html( $settings[ 'desc' ] )
								);
							}
							break;

						/**
						 * Number
						 */
						case 'number' :
							$input_format = '<input %1$s type="number" class="number %2$s" id="%3$s" name="%4$s" value="%5$s" min="%6$s" max="%7$s" />';

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Options
							$min = array_key_exists( 'min', $settings[ 'options' ] ) ? intval( $settings[ 'options' ][ 'min' ] ) : '';
							$max = array_key_exists( 'max', $settings[ 'options' ] ) ? intval( $settings[ 'options' ][ 'max' ] ) : '';

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								intval( $settings[ 'instance' ] ),
								$min,
								$max
							);
							break;

						/**
						 * Checkbox
						 */
						case 'checkbox' :
							$input_format = '<input %1$s type="checkbox" class="checkbox %2$s" id="%3$s" name="%4$s" %5$s />';
							$descr_format = '<br/><span class="north-w-description">%s</span>';

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								checked( $settings[ 'instance' ], true, false )
							);

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Description
							if( ! empty( $settings[ 'desc' ] ) ) {
								printf(
									$descr_format,
									esc_html( $settings[ 'desc' ] )
								);
							}
							break;

						/**
						 * Select
						 */
						case 'select' :
							$input_format  = '<select %1$s class="widefat %2$s" id="%3$s" name="%4$s">%5$s</select>';
							$options       = '';
							$option_format = '<option %1$s value="%2$s" %3$s>%4$s</option>';

							// Do nothing if we don't have options
							if( empty( $settings[ 'options' ] ) || ! is_array( $settings[ 'options' ] ) ) return;

							// Attach output to $options
							foreach( $settings[ 'options' ] as $option => $values ) {
								$option_disable = $values[ 'disabled' ] ? 'disabled' : '';

								// Generating options
								$options .= sprintf(
									$option_format,
									$option_disable,
									esc_attr( $values[ 'value' ] ),
									selected( $settings[ 'instance' ], $values[ 'value' ], false ),
									esc_html( $values[ 'title' ] )
								);
							}

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								$options
							);
							break;

						/**
						 * Select categories
						 */
						case 'categories' :
							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Arguments
							$categories = [
								'id'              => $this->get_field_id( $setting ),
								'name'            => $this->get_field_name( $setting ),
								'show_option_all' => __( 'All categories', 'acosmin-north-extensions' ),
								'selected'        => $settings[ 'instance' ],
							];

							// Change the arguments
							$merge      = $settings[ 'merge' ];
							$categories = empty( $merge ) ? $categories : array_merge( $categories, $merge );

							// Output a selectbox of categories.
							wp_dropdown_categories( $categories );
							break;

						/**
						 * Select navigation
						 */
						case 'navigation' :
							global $wp_customize;

							// Label
							if( ! empty( $settings[ 'label' ] ) ) {
								printf(
									$label_format,
									$this->get_field_id( $setting ),
									esc_html( $settings[ 'label' ] )
								);
							}

							// Some variables
							$menus         = wp_get_nav_menus();
							$input_format  = '<select %1$s class="%2$s" id="%3$s" name="%4$s">%5$s</select>';
							$options       = '';
							$option_format = '<option value="%1$s" %2$s>%3$s</option>';

							// In case we don't have any menus
							if( $wp_customize instanceof WP_Customize_Manager ) {
								$redirect = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
							} else {
								$redirect = admin_url( 'nav-menus.php' );
							}

							if( empty( $menus ) ) {
								printf(
									__( '<p>No menus have been created yet. <a href="%s">Create some</a>.</p>', 'acosmin-north-extensions' ),
									esc_attr( $redirect )
								);
							}

							$options .= sprintf( '<option value="">%s</option>', esc_html__( 'Select a menu', 'acosmin-north-extensions' ) );

							// Attach output to $options
							foreach( $menus as $menu ) {
								$options .= sprintf(
									$option_format,
									esc_attr( $menu->term_id ),
									selected( $settings[ 'instance' ], $menu->term_id, false ),
									esc_html( $menu->name )
								);
							}

							// Field
							printf(
								$input_format,
								$disabled,
								esc_attr( $settings[ 'css' ] ),
								$this->get_field_id( $setting ),
								$this->get_field_name( $setting ),
								$options
							);
							break;

					endswitch;

				// Wrapper end
				echo $settings[ 'wrap_end' ];

			endforeach;

		}

		/**
		 * Show widgets only on allowed pages or with any other conditions
		 *
		 * @see    https://developer.wordpress.org/themes/basics/conditional-tags/
		 * @since  1.0.0
		 * @param  array        $args A list of functions to check as conditions
		 * @return void|boolean       Will return `true` if condition is true or void if the `funcs` key doesn't exist/is empty
		 * @access public
		 */
		public function _conditioned( $args ) {
			// Check if `funcs` exists and is not empty
			if( array_key_exists( 'funcs', $args ) && ! empty( $args[ 'funcs' ] ) ) {
				// Call the functions
				foreach( $args[ 'funcs' ] as $condition => $parms ) {
					if( call_user_func( $condition, $parms ) ) {
						// Return true if condition is meet
						return true;
					} else {
						// Or continue to the next one
						continue;
					}
				}
			} else {
				// Do nothing if no `funcs`
				return;
			}
		}

	}
}
