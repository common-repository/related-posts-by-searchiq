<?php
/**
 * SIQRP options
 *
 * @global $wpdb WPDB
 * @global $wp_version string
 * @global $siqrp SIQRP
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wpdb, $wp_version, $siqrp;

/* MyISAM Check */
require 'siqrp-myisam-notice.php';

/* This is not a siqrp plugin update, it is an siqrp option update */
if ( isset( $_POST['update_siqrp'] ) && check_admin_referer( 'update_siqrp', 'update_siqrp-nonce' ) ) {
	$new_options = array();
	foreach ( $siqrp->default_options as $option => $default ) {
		$option_value = isset( $_POST[ $option ] ) ? sanitize_text_field( wp_unslash( $_POST[ $option ] ) ) : null;
		if ( is_bool( $default ) ) {
			$new_options[ $option ] = isset( $option_value );
		}
		if ( ( is_string( $default ) || is_int( $default ) )
			&& isset( $option_value ) && is_string( $option_value )
		) {
			// Sanitize input.
			$new_options[ $option ] = wp_kses_post( $option_value );
		}
	}

	$auto_display_post_types = isset( $_POST['auto_display_post_types'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['auto_display_post_types'] ) ) : null;
	if ( isset( $auto_display_post_types ) && is_array( $auto_display_post_types ) && count( $auto_display_post_types ) > 0 ) {
		$new_options['auto_display_post_types'] = array_keys( $auto_display_post_types );
	} else {
		$new_options['auto_display_post_types'] = array();
	}
	$exclude = isset( $_POST['exclude'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['exclude'] ) ) : null;
	if ( isset( $exclude ) && is_array( $exclude ) && count( $exclude ) > 0 ) {
		$new_options['exclude'] = implode( ',', array_keys( $exclude ) );
	} else {
		$new_options['exclude'] = '';
	}
	$same_post_type = isset( $_POST['same_post_type'] ) ? sanitize_text_field( wp_unslash( $_POST['same_post_type'] ) ) : null;
	if ( isset( $same_post_type ) ) {
		$new_options['cross_relate'] = false;
	} else {
		$new_options['cross_relate'] = true;
	}
	$include_post_type = isset( $_POST['include_post_type'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['include_post_type'] ) ) : null;
	if ( isset( $include_post_type ) && is_array( $include_post_type ) && count( $include_post_type ) > 0 ) {
		$new_options['include_post_type'] = implode( ',', array_keys( $include_post_type ) );
	} else {
		$new_options['include_post_type'] = '';
	}
	$include_sticky_posts                = isset( $_POST['include_sticky_posts'] ) ? sanitize_text_field( wp_unslash( $_POST['include_sticky_posts'] ) ) : '';
	$use_template                        = isset( $_POST['use_template'] ) ? sanitize_text_field( wp_unslash( $_POST['use_template'] ) ) : 'list';
	$new_options['include_sticky_posts'] = isset( $include_sticky_posts ) ? 1 : 0;
	$use_template                        = sanitize_text_field( $use_template );
	$new_options['template']             = ! empty( $use_template ) ? $use_template : $siqrp->default_options['template'];

	$new_options = apply_filters( 'siqrp_settings_save', $new_options );

	$category_checkbox = isset( $_POST['category_checkbox'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['category_checkbox'] ) ) : null;
	if ( isset( $category_checkbox ) && is_array( $category_checkbox ) && count( $category_checkbox ) > 0 ) {
		if ( array_key_exists( 'all', $category_checkbox ) ) {
			$new_options['filtered_categories'] = 'all';
		} else {
			$new_options['filtered_categories'] = implode( ',', array_keys( $category_checkbox ) );
		}
	} else {
		$new_options['filtered_categories'] = '';
	}
	$tag_checkbox = isset( $_POST['tag_checkbox'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['tag_checkbox'] ) ) : null;
	if ( isset( $tag_checkbox ) && is_array( $tag_checkbox ) && count( $tag_checkbox ) > 0 ) {
		if ( array_key_exists( 'all', $tag_checkbox ) ) {
			$new_options['filtered_tags'] = 'all';
		} else {
			$new_options['filtered_tags'] = implode( ',', array_keys( $tag_checkbox ) );
		}
	} else {
		$new_options['filtered_tags'] = '';
	}
	$use_minimalistic = isset( $_POST['use_minimalistic'] ) ? sanitize_text_field( wp_unslash( $_POST['use_minimalistic'] ) ) : null;
	if ( null != $use_minimalistic ) {
		$new_options['use_minimalistic'] = 'yes';
	} else {
		$new_options['use_minimalistic'] = '';
	}
	$new_options['credit_searchiq'] = isset($_POST['credit_searchiq']) ? true : false; // Always set to true.
	siqrp_set_option( $new_options );

	$custom_css = isset( $_POST['custom_css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['custom_css'] ) ) : '';
	if ( isset( $custom_css ) ) {
		update_site_option( '_siqrp_custom_css', wp_strip_all_tags( $custom_css ) );
	} else {
		update_site_option( '_siqrp_custom_css', '' );
	}
	echo '<div class="updated fade"><p>' . esc_attr( __( 'Options saved!', 'related-posts-by-searchiq' ) ) . '</p></div>';
}


if ( isset( $_POST['update_sid'] ) && check_admin_referer( 'update_sid', 'update_siqrp-nonce' ) ) {
	$siqrp_sid = isset( $_POST['siqrp_sid'] ) ? sanitize_text_field( wp_unslash( $_POST['siqrp_sid'] ) ) : '';
	if ( isset( $siqrp_sid ) && ! empty( $siqrp_sid ) ) {
		$sid                 = $siqrp_sid;
		$redirect_screen_url = get_admin_url( null, 'admin.php?page=siqrp' );
		$validate_sid        = $siqrp->validate_sid( $sid );
		if ( true === $validate_sid ) {
			siqrp_set_sid( $sid );
			do_action( 'siqrp_sid_validated' );
			echo '<div class="updated fade" id="partner-validated"><p><b>Partner ID Validated</b>. Taking you to the plugin settings page in <span id="update-seconds">5</span> seconds! <br/>Click <a href="' . esc_url( $redirect_screen_url ) . '">here</a> if you are not automatically redirected.</p></div>';
		} else {
			siqrp_set_sid( '' );
			do_action( 'siqrp_sid_not_validated' );
			echo '<div class="updated fade error"><p><b>Partner ID not validated</b>. We could not validate the partner ID you have entered. Please recheck and confim you have the correct Partner ID.</p></div>';
		}
	} else {
		echo '<div class="updated fade error"><p><b>Invalid Partner ID</b>. Please enter a valid Partner ID.</p></div>';
	}
}

wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field( 'siqrp_display_exclude_terms', 'siqrp_display_exclude_terms-nonce', false );
wp_nonce_field( 'siqrp_optin_data', 'siqrp_optin_data-nonce', false );

require SIQRP_BASE_DIR . '/includes/phtmls/siqrp_options.phtml';
