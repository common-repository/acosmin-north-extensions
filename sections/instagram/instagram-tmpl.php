<?php
/**
 * --------------------------------
 * Ads section template partials
 *
 * @package Acosmin_North_Extensions
 * --------------------------------
 */

/**
 * Hook some template actions ;)
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
add_action( 'northe__section_instagram', 'northe__section_instagram_start',  10 );
add_action( 'northe__section_instagram', 'northe__section_instagram_header', 20 );
add_action( 'northe__section_instagram', 'northe__section_instagram_init',   30 );
add_action( 'northe__section_instagram', 'northe__section_instagram_end',    999 );

add_action( 'northe__section_instagram_header', 'northe__section_instagram_header_start',       10 );
add_action( 'northe__section_instagram_header', 'northe__section_instagram_header_title',       20 );
add_action( 'northe__section_instagram_header', 'northe__section_instagram_header_description', 30 );
add_action( 'northe__section_instagram_header', 'northe__section_instagram_header_link',        40 );
add_action( 'northe__section_instagram_header', 'northe__section_instagram_header_end',         999 );

add_action( 'northe__section_instagram_init', 'northe__section_instagram_init_start', 10 );
add_action( 'northe__section_instagram_init', 'northe__section_instagram_init_title', 20 );
add_action( 'northe__section_instagram_init', 'northe__section_instagram_init_items', 30 );
add_action( 'northe__section_instagram_init', 'northe__section_instagram_init_end',   999 );

/**
 * Called functions
 *
 * @see https://developer.wordpress.org/reference/functions/do_action/
 */

// Section start
if( ! function_exists( 'northe__section_instagram_start' ) ) {
	function northe__section_instagram_start( $o ) {
		?>
		<div class="container">
			<div class="row-display grid-1">
		<?php
	}
}

// Section end
if( ! function_exists( 'northe__section_instagram_end' ) ) {
	function northe__section_instagram_end( $o ) {
		?>
			</div><!-- .row-display -->
		</div><!-- .container -->
		<?php
	}
}

// Section header
if( ! function_exists( 'northe__section_instagram_header' ) ) {
	function northe__section_instagram_header( $o ) {
		if( ! $o[ 'header' ] ) return;

		/**
		 * Hooked:
		 * northe__section_instagram_header_start       - 10
		 * northe__section_instagram_header_title       - 20
		 * northe__section_instagram_header_description - 30
		 * northe__section_instagram_header_link        - 40
		 * northe__section_instagram_header_end         - 999
		 */
		do_action( 'northe__section_instagram_header', $o );
	}
}

	// Section header start
	if( ! function_exists( 'northe__section_instagram_header_start' ) ) {
		function northe__section_instagram_header_start( $o ) {
			?>
			<div class="col-12x m-bot-small">
				<header class="section-header sh1x">
			<?php
		}
	}

	// Section header end
	if( ! function_exists( 'northe__section_instagram_header_end' ) ) {
		function northe__section_instagram_header_end( $o ) {
			?>
				</header>
			</div>
			<?php
		}
	}

	// Section header title
	if( ! function_exists( 'northe__section_instagram_header_title' ) ) {
		function northe__section_instagram_header_title( $o ) {
			?><h2 class="section-title st1x"><?php echo esc_html( $o[ 'title' ] ); ?></h2><?php
		}
	}

	// Section header description
	if( ! function_exists( 'northe__section_instagram_header_description' ) ) {
		function northe__section_instagram_header_description( $o ) {
			$description = $o[ 'descr' ];
			if( empty( $description ) ) return;

			?>
			<p class="section-description">
				<?php echo esc_html( $description ); ?>
			</p>
			<?php
		}
	}

	// Section header link
	if( ! function_exists( 'northe__section_instagram_header_link' ) ) {
		function northe__section_instagram_header_link( $o ) {
			$text = $o[ 'hr_text' ];
			$url  = empty( $o[ 'hr_link' ] ) ? '#' : $o[ 'hr_link' ];

			if( empty( $text ) ) return;

			?>
			<ul class="small-nav section-subcats">
				<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $text ); ?></a></li>
			</ul>
			<?php
		}
	}

// Section init
if( ! function_exists( 'northe__section_instagram_init' ) ) {
	function northe__section_instagram_init( $o ) {
		/**
		 * Hooked:
		 * northe__section_instagram_init_start - 10
		 * northe__section_instagram_init_title - 20
		 * northe__section_instagram_init_items - 30
		 * northe__section_instagram_init_end   - 999
		 */
		do_action( 'northe__section_instagram_init', $o );
	}
}

	// Section init start
	if( ! function_exists( 'northe__section_instagram_init_start' ) ) {
		function northe__section_instagram_init_start( $o ) {
			?>
			<div class="inner-grid">
				<div class="row-display grid-1">
			<?php
		}
	}

	// Section init end
	if( ! function_exists( 'northe__section_instagram_init_end' ) ) {
		function northe__section_instagram_init_end( $o ) {
			?>
				</div><!-- .inner-grid .row-display -->
			</div><!-- .inner-grid -->
			<?php
		}
	}

	// Section init title
	if( ! function_exists( 'northe__section_instagram_init_title' ) ) {
		function northe__section_instagram_init_title( $o ) {
			$text = $o[ 'ot_text' ];
			$link = empty( $o[ 'ot_link' ] ) ? '#' : $o[ 'ot_link' ];

			if( empty( $text ) ) return;

			?>
			<div class="ex-if-title-wrap">
				<h2 class="section-title st1x"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a></h2>
			</div>
			<?php
		}
	}

	// Section init items
	if( ! function_exists( 'northe__section_instagram_init_items' ) ) {
		function northe__section_instagram_init_items( $o ) {
			$links  = $o[ 'links' ];
			$target = $o[ 'target' ];
			$rel    = $o[ 'relattr' ];
			$format =
			'<div class="col-2x ex-if-item">
				<figure class="img-has-overlay">
					<img src="%1$s" alt="%2$s" />
					<figcaption class="img-overlay-2">%3$s</figcaption>
				</figure>
			</div>';


			$options = apply_filters( 'northe___section_instagram_init_items', [
				'format'  => $format,
				'lclass'  => 'img-link-to',
				'lformat' => '<a href="%1$s" title="%2$s" class="%3$s" target="%4$s" rel="%5$s"></a>',
				'qty'     => absint( $o[ 'qty' ] ),
				'size'    => 300
			], $o );

			$link = $links ? $options[ 'lformat' ] : '';

			$items = $o['widget']->api->get_items( $options[ 'qty' ], $options[ 'size' ] );

			if ( ! is_array( $items ) ) {
				if( current_user_can( 'manage_options' ) ) {
					_e( 'Something is not right! Please configure the plugin in Settings > Instagram Settings', 'acosmin-north-extensions' );
				}

				return;
			}

			foreach ( $items[ 'items' ] as $item ) {
				printf(
					$format,
					esc_url( $item[ 'image-url' ] ),
					esc_attr( $item[ 'image-caption' ] ),
					sprintf(
						$link,
						esc_url( $item[ 'link' ] ),
						esc_attr( $item[ 'image-caption' ] ),
						esc_attr( $options[ 'lclass' ] ),
						esc_attr( $target ),
						esc_attr( $rel )
					)
				);
			}
		}
	}
