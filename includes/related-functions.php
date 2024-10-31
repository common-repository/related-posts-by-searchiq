<?php
/**
 * Description of the file
 *
 * @file
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Gets the HTML for displaying related posts.
 *
 * @param  array $args         see readme.txt installation tab's  "SIQRP functions()" section.
 * @param  int   $reference_id the post ID to search against. If used from within "the loop", defaults to the.
 *                             $current_post.
 * @param  bool  $echo         if false only returns the HTML string.
 * @return mixed HTML output.
 */
function siqrp_related( $args = array(), $reference_id = false, $echo = true ) {
	global $siqrp;

	if ( is_array( $reference_id ) ) {
		_doing_it_wrong( __FUNCTION__, 'This SIQRP function now takes $args first and $reference_id second.', '3.5' );
		return;
	}

	return $siqrp->display_related( $reference_id, $args, $echo );
}
