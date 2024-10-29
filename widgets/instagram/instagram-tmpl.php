<?php
/**
 * -----------------------------------
 * Instagram widget template partials
 *
 * @package Acosmin_North_Extensions
 * -----------------------------------
 */

/**
 * Hook some template actions ;)
 *
 * @see https://developer.wordpress.org/reference/functions/add_action/
 */
add_action( 'northe__widget_instagram', 'northe__widget_instagram_title',  10 );
add_action( 'northe__widget_instagram', 'northe__widget_instagram_start',  20 );
add_action( 'northe__widget_instagram', 'northe__widget_instagram_wrap',   30 );
add_action( 'northe__widget_instagram', 'northe__widget_instagram_button', 40 );
add_action( 'northe__widget_instagram', 'northe__widget_instagram_end',    999 );

add_action( 'northe__widget_instagram_wrap', 'northe__widget_instagram_wrap_start', 10 );
add_action( 'northe__widget_instagram_wrap', 'northe__widget_instagram_display',    20 );
add_action( 'northe__widget_instagram_wrap', 'northe__widget_instagram_wrap_end',   999 );

/**
 * Called functions
 *
 * @see https://developer.wordpress.org/reference/functions/do_action/
 */

// Widget title
if( ! function_exists( 'northe__widget_instagram_title' ) ) {
	function northe__widget_instagram_title( $o ) {
		$title = $o[ 'title' ];

		if( empty( $title ) ) return;

		?>
		<header class="widget-title-wrap">
			<h2 class="widget-title"><span><?php echo esc_html( $title ); ?></span></h2>
		</header>
		<?php
	}
}

// Widget start
if( ! function_exists( 'northe__widget_instagram_start' ) ) {
	function northe__widget_instagram_start( $o ) {
		?>
		<div class="container">
			<div class="row-display grid-1">
		<?php
	}
}

// Widget end
if( ! function_exists( 'northe__widget_instagram_end' ) ) {
	function northe__widget_instagram_end( $o ) {
		?>
			</div>
		</div>
		<?php
	}
}

// Widget button
if( ! function_exists( 'northe__widget_instagram_button' ) ) {
	function northe__widget_instagram_button( $o ) {
		$title = $o[ 'btn_text' ];
		$link  = empty( $o[ 'btn_link' ] ) ? '#' : $o[ 'btn_link' ];

		if( empty( $title ) ) return;
		?>
		<footer class="col-12x instagram-footer">
			<a href="<?php echo esc_url( $link ); ?>" class="sidebtn sb-general"><i class="eicon eicon-instagram"></i> <?php echo esc_html( $title ); ?></a>
		</footer>
		<?php
	}
}

	// Widget wrap
	if( ! function_exists( 'northe__widget_instagram_wrap' ) ) {
		function northe__widget_instagram_wrap( $o ) {
			/**
			 * Hooked:
			 * northe__widget_instagram_wrap_start - 10
			 * northe__widget_instagram_display    - 20
			 * northe__widget_instagram_wrap_end   - 999
			 */
			do_action( 'northe__widget_instagram_wrap', $o );
		}
	}

	// Widget wrap start
	if( ! function_exists( 'northe__widget_instagram_wrap_start' ) ) {
		function northe__widget_instagram_wrap_start( $o ) {
			?>
			<div class="inner-grid">
				<div class="row-display grid-1">
			<?php
		}
	}

	// Widget wrap end
	if( ! function_exists( 'northe__widget_instagram_wrap_end' ) ) {
		function northe__widget_instagram_wrap_end( $o ) {
			?>
				</div>
			</div>
			<?php
		}
	}

	// Widget display
	if( ! function_exists( 'northe__widget_instagram_display' ) ) {
		function northe__widget_instagram_display( $o ) {
			$links  = $o[ 'links' ];
			$target = $o[ 'target' ];
			$rel    = $o[ 'relattr' ];
			$format =
			'<div class="col-4x ex-if-item">
				<figure class="img-has-overlay">
					<img src="%1$s" alt="%2$s" />
					<figcaption class="img-overlay-2">%3$s</figcaption>
				</figure>
			</div>';

			$options = apply_filters( 'northe___widget_instagram_display', [
				'format'  => $format,
				'lclass'  => 'img-link-to',
				'lformat' => '<a href="%1$s" title="%2$s" class="%3$s" target="%4$s" rel="%5$s"></a>',
				'qty'     => 9,
				'size'    => 150
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
