<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing
/**
 * This file includes all meta box related functionality
 *
 * @file
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-meta-box.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-meta-box-contact.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-meta-box-display-web.php';
require_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-meta-box-sid-setup.php';

add_meta_box(
	'siqrp_display_web',
	__( 'Settings', 'related-posts-by-searchiq' ),
	array(
		new SIQRP_Meta_Box_Display_Web(),
		'display',
	),
	'toplevel_page_siqrp',
	'normal',
	'core'
);

add_meta_box(
	'siqrp_display_contact',
	__( 'Contact Us', 'related-posts-by-searchiq' ),
	array( new SIQRP_Meta_Box_Contact(), 'display' ),
	'toplevel_page_siqrp',
	'side',
	'core'
);


add_meta_box(
	'siqrp_display_sid_form',
	__( 'Related Posts By SearchIQ - Setup', 'related-posts-by-searchiq' ),
	array(
		new SIQRP_Meta_Box_Sid_Setup(),
		'display',
	),
	'siqrp_display_sid_form',
	'normal',
	'core'
);
/**
 * Summary of siqrp_make_optin_classy
 *
 * @param  mixed $classes Default classes.
 * @return mixed
 */
function siqrp_make_optin_classy( $classes ) {
	if ( ! siqrp_get_option( 'optin' ) ) {
		$classes[] = 'siqrp_attention';
	}
	return $classes;
}

add_filter(
	'postbox_classes_toplevel_page_siqrp_siqrp_display_optin',
	'siqrp_make_optin_classy'
);
