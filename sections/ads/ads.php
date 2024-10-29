<?php
if( ! class_exists( 'Northe_Section_Ads' ) ) {
	/**
	 * Ads section
	 *
	 * Will display a different sized ad section
	 *
	 * @since 1.0.0
	 */
	class Northe_Section_Ads extends Northe_Widgets_Base {

		/**
		 * Widget defaults
		 *
		 * @var    array
		 * @since  1.0.0
		 * @access protected
		 */
		protected $defaults;

		/**
		 * Widget instance
		 *
		 * @since  1.0.0
		 * @access public
		 */
		function __construct() {
			// Variables
			$this->widget_title = __( 'Ads' , 'acosmin-north-extensions' );
			$this->widget_id    = 'das';

			// Settings
			$widget_ops = [
				'classname'   => 'section-bannad',
				'description' => esc_html__( 'Displays an ad section.', 'acosmin-north-extensions' ),
				'customize_selective_refresh' => true
			];

			// Control settings
			$idBase = 'north-section-' . $this->widget_id;

			$control_ops = [
				'width'   => NULL,
				'height'  => NULL,
				'id_base' => $idBase
			];

			// Create the widget
			parent::__construct( $idBase, $this->widget_title, $widget_ops, $control_ops );

			// Set some widget defaults
			$this->defaults = apply_filters( 'northe_section_ads___defaults', [
				'code'   => '',
				'border' => true,
				'mbot'   => true,
				'padd'   => true,
				'type'   => 's980',
			], $this );
		}

		/**
		 * Widget output
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function widget( $args, $instance ) {
			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );

			// Pass arguments to our template
			$widget_options = [
				// General
				'widget' => $this,
				// Ad code
				'code'   => ! empty( $instance[ 'code' ] ) ? $instance[ 'code' ] : $instance_defaults[ 'code' ],
				// Options
				'type'   => isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : $instance_defaults[ 'type' ],
				'border' => isset( $instance[ 'border' ] ) ? $instance[ 'border' ] : false,
				'mbot'   => isset( $instance[ 'mbot' ] ) ? $instance[ 'mbot' ] : false,
				'padd'   => isset( $instance[ 'padd' ] ) ? $instance[ 'padd' ] : false,
			];

			// Filter before we add them
			$widget_options = apply_filters( 'northe_section_ads___options', $widget_options, $this, $instance, $instance_defaults );

			// Add some CSS classes
			$mbot   = ! $widget_options[ 'mbot' ] ? 'nombot' : '';
			$before = apply_filters( 'northe_section_ads___before', [
				'bw'   => $args[ 'before_widget' ],
				'type' => 'section_ads',
				'css'  => [ 'wrap', $mbot ]
			], $instance, $args );

			$before = northe_widget_css_classes( $before );

			// Use default if `$before` returns false.
			$args[ 'before_widget' ] = $before !== false ? $before : $args[ 'before_widget' ];

			// Show only where it's allowed
			$not_allowed = apply_filters( 'northe_section_ads___conditions', [
				'funcs' => [
					'is_paged' => null
				]
			] );

			if( parent::_conditioned( $not_allowed ) ) return;

			// Widget template output
			echo $args['before_widget'];

				ob_start();
				/**
				 * Hooked:
				 * northe_section_ads_output - 10
				 *
				 * @see ../sections/ads/ads-tmpl.php
				 */
				do_action( 'northe__section_ads', $widget_options );

				echo ob_get_clean();

			echo $args['after_widget'];
		}

		/**
		 * Widget update instance
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Textarea
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance[ 'code' ] = $new_instance[ 'code' ];
			} else {
				$instance[ 'code' ] = wp_kses_post( $new_instance[ 'code' ] );
			}

			// Select
			$instance[ 'type' ]  = (string) northe_sanitize_select(
				$new_instance[ 'type' ],
				[ 's980', 's728', 's468' ],
				$this->defaults[ 'type' ],
				false
			);

			// Checkboxes
			$instance[ 'border' ] = isset( $new_instance[ 'border' ] ) ? (bool) $new_instance[ 'border' ] : false;
			$instance[ 'mbot' ]   = isset( $new_instance[ 'mbot' ] ) ? (bool) $new_instance[ 'mbot' ] : false;
			$instance[ 'padd' ]   = isset( $new_instance[ 'padd' ] ) ? (bool) $new_instance[ 'padd' ] : false;

			// Filter before we update
			$instance = apply_filters( 'northe_section_ads___update', $instance, $new_instance );

			// Return updated instance
			return $instance;
		}

		/**
		 * Widget form
		 *
		 * @since  1.0.0.
		 * @access public
		 */
		public function form( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			/**
			 * Form inputs
			 */

			$fields = [

				// Title
				'ads_code_option' => [
					'type'         => 'title',
					'label'        => __( 'Ad Code:', 'acosmin-north-extensions' ),
					'instance'     => 'ads_code_options',
				],

				// Ad code
				'code'      => [
					'type'     => 'textarea',
					'label'    => '',
					'desc'     => __( 'Maximum width: 980px', 'acosmin-north-extensions' ),
					'instance' => ! $instance[ 'code' ] ? $instance_defaults[ 'code' ] : $instance[ 'code' ],
				],

				// Banner type/width
				'type'       => [
					'type'      => 'select',
					'label'     => __( 'Banner type/width', 'acosmin-north-extensions' ),
					'instance'  => $instance[ 'type' ],
					'options'   => [
						[
							'value' 	=> 's980',
							'title' 	=> esc_html_x( '980px', 'Ad size in banner section', 'acosmin-north-extensions' ),
							'disabled'	=> false
						],
						[
							'value' 	=> 's728',
							'title' 	=> esc_html_x( '728px', 'Ad size in banner section', 'acosmin-north-extensions' ),
							'disabled'	=> false
						],
						[
							'value' 	=> 's468',
							'title' 	=> esc_html_x( '468px', 'Ad size in Ads section', 'acosmin-north-extensions' ),
							'disabled'	=> false
						],
					]
				],

				'border'  => [
					'type'      => 'checkbox',
					'label'     => __( 'Show border', 'acosmin-north-extensions' ),
					'instance'  => isset( $instance[ 'border' ] ) ? (bool) $instance[ 'border' ] : false,
				],

				'padd'  => [
					'type'      => 'checkbox',
					'label'     => __( 'Padding top/bottom', 'acosmin-north-extensions' ),
					'instance'  => isset( $instance[ 'padd' ] ) ? (bool) $instance[ 'padd' ] : false,
				],

				'mbot'  => [
					'type'      => 'checkbox',
					'label'     => __( 'Margin bottom', 'acosmin-north-extensions' ),
					'instance'  => isset( $instance[ 'mbot' ] ) ? (bool) $instance[ 'mbot' ] : false,
				],

			]; // $fields

			// Add a filter
			$fields = apply_filters( 'northe_section_ads___fields', $fields, $instance, $instance_defaults );

			// Output fields
			parent::_fields( $fields );

		} // form()

	} /* Northe_Section_Ads class END */

	/**
	 * Register the section
	 */
	register_widget( 'Northe_Section_Ads' );

} /* Northe_Section_Ads class_exists END */
