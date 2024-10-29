<?php
if( ! class_exists( 'Northe_Widget_Ads' ) ) {
	/**
	 * Ads widget for sidebars
	 *
	 * Will display a different sized ad in your sidebars
	 *
	 * @since 1.0.0
	 */
	class Northe_Widget_Ads extends Northe_Widgets_Base {

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
			$this->widget_title = __( 'NORTH Ads' , 'acosmin-north-extensions' );
			$this->widget_id    = 'das';

			// Settings
			$widget_ops = [
				'classname'   => 'north-w-das',
				'description' => esc_html__( 'Displays an ad. This needs to be used in a sidebar, not as a section.', 'acosmin-north-extensions' ),
				'customize_selective_refresh' => true
			];

			// Control settings
			$idBase = 'north-w-' . $this->widget_id;

			$control_ops = [
				'width'   => NULL,
				'height'  => NULL,
				'id_base' => $idBase
			];

			// Create the widget
			parent::__construct( $idBase, $this->widget_title, $widget_ops, $control_ops );

			// Set some widget defaults
			$this->defaults = apply_filters( 'northe_widget_ads___defaults', [
				'code' => '',
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
			];

			// Filter before we add them
			$widget_options = apply_filters( 'northe_widget_ads___options', $widget_options, $this, $instance, $instance_defaults );

			// Add some CSS classes
			$before = apply_filters( 'northe_widget_ads___before', [
				'bw'   => $args[ 'before_widget' ],
				'type' => 'ads',
				'css'  => []
			], $instance, $args );

			$before = northe_widget_css_classes( $before );

			// Use default if `$before` returns false.
			$args[ 'before_widget' ] = $before !== false ? $before : $args[ 'before_widget' ];

			// Show only where it's allowed
			$not_allowed = apply_filters( 'northe_widget_ads___conditions', [] );

			if( parent::_conditioned( $not_allowed ) ) return;

			// Widget template output
			echo $args['before_widget'];

				ob_start();
				/**
				 * Hooked:
				 * northe__widget_ads_output - 10
				 *
				 * @see ../widgets/ads/ads-tmpl.php
				 */
				do_action( 'northe__widget_ads', $widget_options );

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

			// Filter before we update
			$instance = apply_filters( 'northe_widget_ads___update', $instance, $new_instance );

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
					'desc'     => __( 'Maximum width: 320px', 'acosmin-north-extensions' ),
					'instance' => ! $instance[ 'code' ] ? $instance_defaults[ 'code' ] : $instance[ 'code' ],
				],

			]; // $fields

			// Add a filter
			$fields = apply_filters( 'northe_widget_ads___fields', $fields, $instance, $instance_defaults );

			// Output fields
			parent::_fields( $fields );

		} // form()

	} /* Northe_Widget_Ads class END */

	/**
	 * Register the section
	 */
	register_widget( 'Northe_Widget_Ads' );

} /* Northe_Widget_Ads class_exists END */
