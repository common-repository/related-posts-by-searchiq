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

$count = 1;
if ( is_array( self::$related_posts_data ) && count( self::$related_posts_data ) > 0 && array_key_exists( 'recommendations', self::$related_posts_data ) && count( self::$related_posts_data['recommendations'] ) > 0 ) {
	$output .= '<ol>';
	foreach ( self::$related_posts_data['recommendations'] as $data ) {
		if ( $count > $this->related_posts_count ) {
			break;
		}
		$post_data  = $data['entity'];
		$post_link  = apply_filters( 'siqrp_filter_url', $post_data['url'] );
		$tooltip    = $post_data['title'];
		$post_title = $post_data['title'];

		$output .= '<li><a href="' . $post_link . '" rel="bookmark">' . $post_title . '</a>';
		$output .= '</li>';
	}
	$output .= '</ol>';
} else {
	$output .= '<p><em>' . __( 'No related posts.', 'related-posts-by-searchiq' ) . '</em></p>';
}
