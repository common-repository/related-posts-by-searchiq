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
 * Summary of SIQRP_Meta_Box_Display_Web
 */
class SIQRP_Meta_Box_Display_Web extends SIQRP_Meta_Box {

	/**
	 * Summary of display
	 *
	 * @return void
	 */
	public function display() {
		global $siqrp;
		$disabled_checkbox           = '';
		$generate_missing_thumbnails = siqrp_get_option( 'generate_missing_thumbnails' );
		if ( defined( 'SIQRP_GENERATE_THUMBNAILS' ) ) {
			$disabled_checkbox           = 'disabled';
			$generate_missing_thumbnails = SIQRP_GENERATE_THUMBNAILS;
		}
		$siqrp_args      = array(
			'template_type'     => 'right-aligned-checkbox',
			'disabled_checkbox' => $disabled_checkbox,
			'option_value'      => $generate_missing_thumbnails,
		);
		$sid             = siqrp_get_sid();
		$edit_sid_screen = get_admin_url( null, 'admin.php?page=siqrp&edit_sid=1' );
		echo '<div class="siqrp_form_row info_box">';
		echo '<h4 class="header">Partner Settings</h4>';
		echo '<div class="inner">';
		echo '<p class="description"><b>Your Partner ID: </b>' . esc_attr( $sid ) . ' &nbsp;&nbsp;&nbsp;<a href="' . esc_url( $edit_sid_screen ) . '" class="inline-link">[Update Partner ID]</a></p>';
		echo '</div>';
		echo '</div>';

		echo '<div class="siqrp_form_row info_box">';
		echo '<h4 class="header">Plugin Settings</h4>';
		echo '<div class="inner">';
		echo '<div>';
		echo "<div class='siqrp_form_row siqrp_form_post_types'><div>";
		esc_attr_e( 'Automatically display related posts on: ', 'related-posts-by-searchiq' );
		echo " <span class='siqrp_help dashicons dashicons-editor-help' data-help='" . esc_attr( __( 'This option automatically displays <b>Related Posts By SearchIQ</b> right after the content on single posts, pages or other selected post types. If this option is off, you will need to manually insert the <code>[siqrp]</code> shortcode, block or  <code>siqrp_related()</code> PHP function into your theme files.', 'related-posts-by-searchiq' ) ) . "'>&nbsp;</span>&nbsp;&nbsp;";
		echo '</div><div>';
		$post_types        = siqrp_get_option( 'auto_display_post_types' );
		$include_post_type = siqrp_get_option( 'include_post_type' );
		$include_post_type = wp_parse_list( $include_post_type );
		foreach ( $siqrp->get_post_types( 'objects' ) as $post_type ) {
			$post_type_title   = $post_type->labels->name;
			$disabled_checkbox = '';
			$hide_help_text    = 'display: none;';
			if ( ! siqrp_get_option( 'cross_relate' ) && ! in_array( $post_type->name, $include_post_type, true ) ) {
				$disabled_checkbox = 'disabled';
				$hide_help_text    = '';
			}
			// Clarify "topics" are from bbPress plugin.
			if ( 'topic' == $post_type->name && class_exists( 'bbPress' ) ) {
				$post_type_title = sprintf(
				/* translators: %s to post type title*/
					__( 'BuddyPress %s', 'related-posts-by-searchiq' ),
					$post_type_title
				);
			}
			echo "<label for='siqrp_post_type_" . esc_attr( $post_type->name ) . "'><input id='siqrp_post_type_" . esc_attr( $post_type->name ) . "' name='auto_display_post_types[" . esc_attr( $post_type->name ) . "]' type='checkbox' ";
			checked( in_array( $post_type->name, $post_types ) );
			echo esc_attr( $disabled_checkbox );
			echo '/> ' . esc_attr( $post_type_title ) . '&nbsp;';
			echo "<span style='color: #d63638; " . esc_attr( $hide_help_text ) . "' class='siqrp_help dashicons dashicons-warning' data-help='" . '<p>' . esc_attr( __( "This option is disabled because 'The Pool':", 'related-posts-by-searchiq' ) ) . '</p><p>' . esc_attr( __( '1. does not include this post type', 'related-posts-by-searchiq' ) ) . '</p><p>' . esc_attr( __( '2. limits results to the same post type as the current post', 'related-posts-by-searchiq' ) ) . '</p><p>' . esc_attr( __( 'This combination will always result in no posts displaying on this post type. To enable, in The Pool either include this post type or do not limit results to the same post type.', 'related-posts-by-searchiq' ) ) . '</p>' . "'>&nbsp;</span>&nbsp;&nbsp;";
			echo '</label> ';
		}
		echo '</div></div>';

		echo '<div class="siqrp_form_row suggest-boxes">';
		$categories = $siqrp->admin->get_post_taxonomy_list( 'category' );
		if ( count( $categories ) > 0 ) :
			$filtered_categories = siqrp_get_option( 'filtered_categories' ) != 'all' ? explode( ',', siqrp_get_option( 'filtered_categories' ) ) : 'all';
			echo '<div class="suggest-box-outer">';
			echo '<div class="siqrp_form_row">';
			echo '<p><b>Select Categories:</b></p>';
			echo '<p>In order to <b>Automatically display related posts</b>, select the post category names from the list below.<br/> <b>Default "related posts" will only show for the posts that belong to the selected categories.</b></p>';
			echo '</div>';
			echo '<div class="siqrp_form_row suggest-box category-suggest-box">';
			echo '<div class="select-all">';
			$checked = ( ! is_array( $filtered_categories ) && 'all' == $filtered_categories ) ? 'checked="checked"' : '';
			echo '<input ' . esc_attr( $checked ) . ' type="checkbox" name="category_checkbox[all]" id="category_checkbox_all" /> <label for="category_checkbox_all">Select All</label>';
			echo '</div>';
			echo '<div class="selected-options selected-categories"><ul>';
			foreach ( $categories as $category ) :
				echo '<li>';
				$checked = ( ( is_array( $filtered_categories ) && in_array( $category->term_id, $filtered_categories ) ) || ( ! is_array( $filtered_categories ) && 'all' == $filtered_categories ) ) ? 'checked="checked"' : '';
				echo '<input ' . esc_attr( $checked ) . ' type="checkbox" name="category_checkbox[' . esc_attr( $category->term_id ) . ']" id="category_checkbox_' . esc_attr( $category->term_id ) . '" /> <label for="category_checkbox_' . esc_attr( $category->term_id ) . '">' . esc_attr( $category->name ) . '</label>';
				echo '</li>';
			endforeach;
			echo '</ul></div>';
			echo '</div>';
			echo '</div>';
		endif;

		$tags = $siqrp->admin->get_post_taxonomy_list( 'post_tag' );
		if ( count( $tags ) > 0 ) :
			$filtered_tags = siqrp_get_option( 'filtered_tags' ) != 'all' ? explode( ',', siqrp_get_option( 'filtered_tags' ) ) : 'all';
			echo '<div class="suggest-box-outer">';
			echo '<div class="siqrp_form_row">';
			echo '<p><b>Select Tags:</b></p>';
			echo '<p>In order to <b>Automatically display related posts</b>, select the post tag names from the list below.<br/> <b> Default "related posts" will only show for the posts that belong to the selected tags.</b></p>';
			echo '</div>';
			echo '<div class="siqrp_form_row suggest-box tag-suggest-box">';
			echo '<div class="select-all">';
			$checked = ( ! is_array( $filtered_tags ) && 'all' == $filtered_tags ) ? 'checked="checked"' : '';
			echo '<input ' . esc_attr( $checked ) . ' type="checkbox" name="tag_checkbox[all]" id="tag_checkbox_all" /> <label for="tag_checkbox_all">Select All</label>';
			echo '</div>';
			echo '<div class="selected-options selected-tags"><ul>';
			foreach ( $tags as $tag ) :
				echo '<li>';
				$checked = ( ( is_array( $filtered_tags ) && in_array( $tag->term_id, $filtered_tags ) ) || ( ! is_array( $filtered_tags ) && 'all' == $filtered_tags ) ) ? 'checked="checked"' : '';
				echo '<input ' . esc_attr( $checked ) . ' type="checkbox" name="tag_checkbox[' . esc_attr( $tag->term_id ) . ']" id="tag_checkbox_' . esc_attr( $tag->term_id ) . '" /> <label for="tag_checkbox_' . esc_attr( $tag->term_id ) . '">' . esc_attr( $tag->name ) . '</label>';
				echo '</li>';
			endforeach;
			echo '</ul></div>';
			echo '</div>';
			echo '</div>';
		endif;
		echo '</div>';

		echo '</div>';
		$chosen_template = siqrp_get_option( 'template' );
		$choice          = false === $chosen_template ? 'list' :
		( 'grid' == $chosen_template ? 'grid' : ( ! empty( $chosen_template ) ? $chosen_template : false ) );

		// Wrap all the options in a div with a gray border.
		echo '<div class="postbox">';
		$this->textbox( 'limit', __( 'Maximum number of posts:', 'related-posts-by-searchiq' ) );

		$this->template_checkbox( false );
		$this->textbox( 'thumbnails_heading', __( 'Heading:', 'related-posts-by-searchiq' ), 40 );
		$this->textbox( 'thumbnails_default', __( 'Default image (URL):', 'related-posts-by-searchiq' ), 40 );

		$use_minimalistic = siqrp_get_option( 'use_minimalistic' ) == 'yes' ? true : false;
		$checked          = $use_minimalistic ? 'checked="checked"' : '';
		echo '<div class="suggest-box-outer">';
			echo '<div class="siqrp_form_row">';
				echo '<p><input ' . esc_attr( $checked ) . ' type="checkbox" name="use_minimalistic" id="use_minimalistic" /> <label for="use_minimalistic"><b>Use Minimalistic Theme?</b></label>';
				$minimalistic_design_image = esc_url( plugins_url( 'assets/images/minimalistic-design.png', SIQRP_BASE_FILE ) );
				echo " <span class='siqrp_help dashicons dashicons-editor-help minimalistic-design' data-help='" . esc_attr( '<b>Here is how the minimalistic theme layout looks like.</b><br/><br/><img src="' . esc_url( $minimalistic_design_image ) . '"  />' ) . "'>&nbsp;</span>&nbsp;&nbsp;";
				echo '</p>';
				echo '<p>Select this options to use the minimalistic theme for related posts showing after the content. This will override the theme selected above.</p>';
			echo '</div>';
		echo '</div>';

		// Close the div that wraps all the options.
		echo '</div>';

		$this->displayorder( 'order' );

		/*
		Translators: %s to url
		*/
		$this->checkbox( 'credit_searchiq', __( 'Show SearchIQ Branding', 'related-posts-by-searchiq' ) . " <span class='siqrp_help dashicons dashicons-editor-help' data-help='" . esc_attr( sprintf( __( 'This option will add a branding link to SearchIQ %s These links are greatly appreciated and it keeps us motivated.', 'related-posts-by-searchiq' ), '<code>' . htmlspecialchars( sprintf( __( "Powered by <a href='%s' title='SearchIQ Related Posts Plugin' target='_blank'>SearchIQ</a>.", 'related-posts-by-searchiq' ), 'https://www.searchiq.com' ) ) . '</code>' ) ) . "'>&nbsp;</span>", 'siqrp' );
		echo sprintf(
			'<p><b>%1$s<br>%2$s</b></p>',
			esc_html('Enable this option to add a SearchIQ branding link on top of the related posts widgets.', 'related-posts-by-searchiq'),
			esc_html('Your gesture to enable this option is greatly appreciated and it keeps us motivated.', 'related-posts-by-searchiq')
		);
		echo '</div>';
		echo '</div>';

		$custom_css = get_site_option( '_siqrp_custom_css', '' );
		echo '<div class="siqrp_form_row info_box">';
		echo '<h4 class="header">Custom CSS</h4>';
		echo '<div class="inner">';
					echo '<textarea rows="10" cols="100" name="custom_css" class="large-text">' . esc_textarea( $custom_css ) . '</textarea>';
		echo '<div class="siqrp_form_row">';
					echo '<code>Add your custom css for overriding the plugin\'s default css in the above textarea.</code>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}
}
