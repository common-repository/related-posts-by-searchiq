<?php
/**
 * SIQRP's built-in grid template
 * This template is used when you choose the grid option.
 *
 * @file
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$this->set_option( 'manually_using_thumbnails', true );

$options = array( 'thumbnails_heading', 'heading', 'thumbnails_default', 'no_results', 'credit_searchiq' );

// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
extract( $this->parse_args( $args, $options ) );
// heading is the new field used on widgets and blocks and the thumbnails_heading is the old implementation of it.
// backward compatibility.
$thumbnails_heading = isset( $heading ) ? $heading : $thumbnails_heading;

// a little easter egg: if the default image URL is left blank,.
// default to the theme's header image. (hopefully it has one).
if ( empty( $thumbnails_default ) ) {
	$thumbnails_default = get_header_image();
}

$count  = 0;
$offset = self::$block_post_count_offset;
if ( is_array( self::$related_posts_data ) && count( self::$related_posts_data ) > 0 && array_key_exists( 'recommendations', self::$related_posts_data ) && count( self::$related_posts_data['recommendations'] ) > 0 && $offset < count( self::$related_posts_data['recommendations'] ) ) {
	$output .= '<!-- SIQRP Grid -->' . "\n";
	$output .= '<div class="ss-content-wrapper">
            <div class="ss-content-container">';

	$output .= '<div class="ss-content-header">
                    <div class="ss-header-title">' . $thumbnails_heading . '</div>';
	if ( $credit_searchiq ) {
		$output .= '<div class="ss-header-poweredby">Powered by <a href="https://www.searchiq.co" target="_blank">SearchIQ</a></div>';
	}
	$output .= '</div>';

	$output .= '<div class="ss-grid-container">';

	foreach ( self::$related_posts_data['recommendations'] as $data ) {
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

		$output .= '<div class="ss-grid-colm">' . "\n";
		$output .= '<a href="' . $post_link . '" title="' . $tooltip . '">
						<div class="ss-grid-colm-container">
                                <div class="ss-grid-colm-placeholder ' . $post_thumbnail_class . '">
                                    <img src="' . esc_url( $post_thumbnail_url ) . '" alt="">
                                </div>
								<div class="ss-grid-content">
                                <div class="ss-grid-colm-title">
                                    ' . $post_title . '
                                </div>
								<div class="ss-grid-content-readmore">
                                        <div class="ss-grid-readmore-text">Read more</div>
                                        <div class="ss-grid-readmore-arrow">
                                            <svg width="14" height="14" fill="none"><path stroke="#777" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="m7.667 5 2 2m0 0-2 2m2-2H4.333M13 7A6 6 0 1 1 .999 7 6 6 0 0 1 13 7Z"></path></svg>
                                        </div>
                                    </div>
								</div>
                            </div>
                        </a>' . "\n";
		$output .= '</div>';
		++$count;
	}
	$output .= '</div>
            </div>
        </div>';

}
