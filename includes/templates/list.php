<?php
/**
 * SIQRP's built-in "template"
 * This "template" is used when you choose not to use a template.
 *
 * @file
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$options = array(
	'before_title',
	'after_title',
	'show_excerpt',
	'excerpt_length',
	'before_post',
	'after_post',
	'before_related',
	'after_related',
	'no_results',
	'credit_searchiq',
);
// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
extract( $this->parse_args( $args, $options ) );
$options = array( 'thumbnails_heading', 'heading', 'thumbnails_default', 'no_results' );

// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
extract( $this->parse_args( $args, $options ) );
// heading is the new field used on widgets and blocks and the thumbnails_heading is the old implementation of it.
// backward compatibility.
$thumbnails_heading = isset( $heading ) ? $heading : $thumbnails_heading;

$count  = 0;
$offset = self::$block_post_count_offset;
if ( is_array( self::$related_posts_data ) && count( self::$related_posts_data ) > 0 && array_key_exists( 'recommendations', self::$related_posts_data ) && count( self::$related_posts_data['recommendations'] ) > 0 && $offset < count( self::$related_posts_data['recommendations'] ) ) {
	$output .= '<!-- SIQRP List -->' . "\n";
	$output .= '<div class="ss-content-wrapper">
            <div class="ss-content-container">';

	$output .= '<div class="ss-content-header">
                    <div class="ss-header-title">' . $thumbnails_heading . '</div>';
	if ( $credit_searchiq ) {
		$output .= '<div class="ss-header-poweredby">Powered by <a href="https://www.searchiq.co" target="_blank">SearchIQ</a></div>';
	}
	$output .= '</div>';

	$output .= '<div class="ss-list-container">';
	$output .= $before_related . "\n";

	foreach ( self::$related_posts_data['recommendations']  as $data ) {
		if ( $offset > 0 && $count < $offset ) {
			++$count;
			continue;
		}
		if ( ( 0 == $offset && $count >= $this->related_posts_count ) || ( $offset > 0 && $count >= $offset + $this->related_posts_count ) ) {
			break;
		}
		$post_data  = $data['entity'];
		$post_link  = apply_filters( 'siqrp_filter_url', $post_data['url'] );
		$tooltip    = $post_data['title'];
		$post_title = $post_data['title'];

		$post_thumbnail_url   = isset( $post_data['imageUrl'] ) ? $post_data['imageUrl'] : SIQRP_BASE_URL . '/assets/images/default-thumbnail.png';
		$post_thumbnail_class = ! isset( $post_data['imageUrl'] ) ? 'ss-no-img' : '';

		$score = null;

		$output .= $before_title . '<div class="ss-list-colm">
                        <a href="' . $post_link . '" title="' . $tooltip . '">
                            <div class="ss-list-colm-container">
                                <div class="ss-list-colm-placeholder">
                                    <img src="' . esc_url( $post_thumbnail_url ) . '" alt="">
                                </div>
                                <div class="ss-list-colm-content">
                                    <div class="ss-list-colm-title">
                                        ' . $post_title . '
                                    </div>
                                    <div class="ss-list-goto-arrow">
                                        <svg width="9" height="16" fill="none" stroke="#bdbdbd"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 15 7-7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>';
		$output .= $after_title . "\n";

		if ( $show_excerpt ) {
			$excerpt = wp_strip_all_tags( (string) $post_data['excerpt']['rendered'] );
			preg_replace( '/([,;.-]+)\s*/', '\1 ', $excerpt );
			$excerpt = implode( ' ', array_slice( preg_split( '/\s+/', $excerpt ), 0, $excerpt_length ) ) . '...';
			$output .= $before_post . $excerpt . $after_post;
		}

		++$count;
	}
	$output .= '</div>
            </div>
        </div>';

	$output .= $after_related . "\n";

}
