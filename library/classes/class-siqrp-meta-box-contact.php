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
 * Summary of SIQRP_Meta_Box_Contact
 */
class SIQRP_Meta_Box_Contact extends SIQRP_Meta_Box {

	/**
	 * Summary of display
	 *
	 * @return void
	 */
	public function display() {
		global $siqrp;

		$happy = 'spin';

		$out =
		'<ul class="siqrp_contacts">' .
		'<li>' .
		'<a href="https://wordpress.org/support/plugin/related-posts-by-searchiq/" target="_blank">' .
		'<span class="icon icon-wordpress"></span> ' . __( 'SearchIQ Related Posts Forum', 'related-posts-by-searchiq' ) .
		'</a>' .
		'</li>' .
		'<li>' .
		'<a href="https://twitter.com/siqrp" target="_blank">' .
		'<span class="icon icon-twitter"></span> ' . __( 'SearchIQ Related Posts on Twitter', 'related-posts-by-searchiq' ) .
		'</a>' .
		'</li>' .
		'<li>' .
		'<a href="https://www.facebook.com/groups/357562101611506/" target="_blank">' .
		'<span class="icon icon-facebook"></span> ' . __( 'SearchIQ Related Posts User Group on Facebook', 'related-posts-by-searchiq' ) .
		'</a>' .
		'</li>' .
		'<li>' .
		'<a href="https://wordpress.org/support/plugin/related-posts-by-searchiq/reviews/?rate=5#new-post" target="_blank">' .
		'<span class="icon icon-star ' . $happy . '"></span> ' . __( 'Review SearchIQ Related Posts on WordPress.org', 'related-posts-by-searchiq' ) .
		'</a>' .
		'</li>' .
		'</ul>';

		echo wp_kses( $out, $siqrp->kses_allowed_html_config );
	}
}
