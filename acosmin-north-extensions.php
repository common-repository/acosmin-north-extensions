<?php
/**
 * Plugin Name: Acosmin North Extensions
 * Plugin URI: http://www.acosmin.com/theme/north/
 * Description: Adds front page sections (Instagram, Ads), a post title design option and other extensions to North WordPress theme.
 * Version: 1.0.0
 * Author: Acosmin
 * Author URI: http://www.acosmin.com/
 * Text Domain: acosmin-north-extensions
 * Domain Path: /languages
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Constants
 */
define( 'NORTHE_VERSION',        '1.0.0'                                            );
define( 'NORTHE_PLUGIN_DIR',     plugin_dir_path( __FILE__ )                        );
define( 'NORTHE_PLUGIN_URL',     plugin_dir_url( __FILE__ )                         );
define( 'NORTHE_PLUGIN_FILE',    __FILE__                                           );
define( 'NORTHE_INC_DIR',        NORTHE_PLUGIN_DIR . trailingslashit( 'inc' )        );
define( 'NORTHE_SECTIONS_DIR',   NORTHE_PLUGIN_DIR . trailingslashit( 'sections' )   );
define( 'NORTHE_WIDGETS_DIR',    NORTHE_PLUGIN_DIR . trailingslashit( 'widgets' )    );
define( 'NORTHE_MODULES_DIR',    NORTHE_PLUGIN_DIR . trailingslashit( 'modules' )    );
define( 'NORTHE_CUSTOMIZER_DIR', NORTHE_PLUGIN_DIR . trailingslashit( 'customizer' ) );

/**
 * Require some files
 */
require_once( NORTHE_INC_DIR . 'helper-functions.php'    );
require_once( NORTHE_INC_DIR . 'sanitization.php'        );
require_once( NORTHE_INC_DIR . 'enqueue-backend.php'     );

require_once( NORTHE_MODULES_DIR . 'title-design/init.php' );

require_once( NORTHE_WIDGETS_DIR . 'base.php' );
require_once( NORTHE_WIDGETS_DIR . 'init.php' );

require_once( NORTHE_PLUGIN_DIR . '/settings-pages/instagram.php' );

require_once( NORTHE_SECTIONS_DIR . 'init.php' );

require_once( NORTHE_CUSTOMIZER_DIR . 'init.php' );

/**
 * Load files only if the theme or parent theme
 * name is `North`
 */
if( northe_theme_check() ) {}
