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
add_action( 'northe__section_ads', 'northe__section_ads_output', 10 );

/**
 * Called functions
 *
 * @see https://developer.wordpress.org/reference/functions/do_action/
 */

// Section output
if( ! function_exists( 'northe__section_ads_output' ) ) {
	function northe__section_ads_output( $o ) {
		$code   = $o[ 'code' ];
		$border = $o[ 'border' ] ? ' with-border' : '';
		$padd   = ! $o[ 'padd' ] ? ' nopadd' : '';
		$size   = '';

		switch( $o[ 'type' ] ) {
			case 's980' : $size = ' b-9-8-0'; break;
			case 's728' : $size = ' b-7-2-8'; break;
			case 's468' : $size = ' b-4-6-8'; break;
		}
		?>
		<div class="container">
			<div class="row-display grid-2">

				<div class="col-12x">
					<div class="bannad-wrap<?php echo $border . $padd; ?>">
						<div class="bannad<?php echo $size; ?>">
							<?php echo $o[ 'code' ]; ?>
						</div>
					</div>
				</div>

			</div><!-- .row-display -->
		</div><!-- .container -->
		<?php
	}
}
