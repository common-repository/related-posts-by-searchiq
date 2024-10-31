<?php
/**
 * Plugin Name: Related Posts By SearchIQ
 * Description: Add sementic search based related posts.
 * Version: 1.0.0
 * Author: SearchIQ
 * Author URI: https://www.searchiq.co
 * Plugin URI:
 * Text Domain: related-posts-by-searchiq
 * License: GPLv2 or later
 *
 * @package SIQRP
 */

/**
 * Make sure we don't expose any info if called directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly..
}

define( 'SIQRP_VERSION', '1.0.0' );

define( 'SIQRP_BASE_DIR', __DIR__ );

define( 'SIQRP_BASE_URL', plugins_url( '', __FILE__ ) );
define( 'SIQRP_BASE_FILE', __FILE__ );

define( 'SIQRP_NO_RELATED', ':(' );
define( 'SIQRP_RELATED', ':)' );
define( 'SIQRP_NOT_CACHED', ':/' );
define( 'SIQRP_DONT_RUN', 'X(' );
define( 'SIQRP_DEFAULT_LIMIT', 3 );
define( 'SIQRP_DEFAULT_TEMPLATE', 'list' );
define( 'SIQRP_API_CALL_TIMEOUT', 30 );
define( 'SIQRP_API_BASE_URL', 'https://content.searchiq.io' );

require_once SIQRP_BASE_DIR . '/includes/functions-init.php';
require_once SIQRP_BASE_DIR . '/includes/related-functions.php';

require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-main.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-block.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-widget.php';
require_once SIQRP_BASE_DIR . '/lib/plugin-deactivation-survey/deactivate-feedback-form.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-db-options.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-shortcode.php';


global $siqrp;
add_action( 'init', 'siqrp_init' );
add_action( 'activate_' . plugin_basename( __FILE__ ), 'siqrp_plugin_activate', 10, 1 );
