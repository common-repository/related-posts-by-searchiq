<?php
/**
 * SIQRP init functions
 *
 * @global $siqrp SIQRP
 *
 * @package SIQRP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Summary of siqrp_init
 *
 * @return void
 */
function siqrp_init() {
	global $siqrp;
	$siqrp = new SIQRP_Main();
}

/**
 * Summary of siqrp_plugin_activate
 *
 * @param  mixed $network_wide Is this network wide activation.
 * @return void
 */
function siqrp_plugin_activate( $network_wide ) {
	global $siqrp;
	$siqrp_obj = ( null == $siqrp ? ( new SIQRP_Main() ) : $siqrp );
	$siqrp_obj->activate();
	update_option( 'siqrp_activated', true );
}

/**
 * Summary of siqrp_set_option
 *
 * @param  mixed $options Option name to set.
 * @param  mixed $value   Option value to set.
 * @return void
 */
function siqrp_set_option( $options, $value = null ) {
	global $siqrp;
	$siqrp->set_option( $options, $value );
}

/**
 * Summary of siqrp_set_sid
 *
 * @param  mixed $sid Value of SID to set.
 * @return void
 */
function siqrp_set_sid( $sid ) {
	global $siqrp;
	$siqrp->set_sid( $sid );
}

/**
 * Summary of siqrp_get_sid
 *
 * @return mixed
 */
function siqrp_get_sid() {
	global $siqrp;
	return $siqrp->get_sid();
}

/**
 * Summary of siqrp_get_option
 *
 * @param  mixed $option GET Sid option from DB.
 * @return array|bool|float|int|mixed|string|null
 */
function siqrp_get_option( $option = null ) {
	global $siqrp;
	return $siqrp->get_option( $option );
}
/**
 * Given a minified path, and a non-minified path, will return
 * a minified or non-minified file URL based on whether SIQRP_DEBUG_SCRIPT is set true or not.
 *
 * @param  string $minified_path     minified path.
 * @param  string $non_minified_path non-minified path.
 * @return string The URL to the file.
 */
function siqrp_get_file_url_for_environment( $minified_path, $non_minified_path ) {
	$script_debug = defined( 'SIQRP_DEBUG_SCRIPT' ) && SIQRP_DEBUG_SCRIPT;
	if ( true === $script_debug ) {
		$path = plugins_url( $non_minified_path, SIQRP_BASE_FILE );
	} elseif ( false === $script_debug ) {
		$path = plugins_url( $minified_path, SIQRP_BASE_FILE );
	} else {
		// This should work in any case.
		$path = plugins_url( $non_minified_path, SIQRP_BASE_FILE );
	}
	return $path;
}

/**
 * Summary of siqrp_get_option_thumbnail
 *
 * @param  mixed $option         Option name.
 * @param  mixed $default_option Default value.
 * @return string
 */
function siqrp_get_option_thumbnail( $option = null, $default_option = 'grid' ) {
	global $siqrp_add_image_size;
	$get_template            = siqrp_get_option( 'template' );
	$user_selected_thumbnail = siqrp_get_option( $option );
	// If siqrp-thumbnail is added by other than siqrp plugin then default selection will be siqrp-thumbnail otherwise thumbnail.
	$default_checked = ( true === $siqrp_add_image_size ? 'grid' : 'siqrp-thumbnail' );
	/**
	 * If existing user upgrades to v5.18.1 then continue using siqrp-thumbnail as default option.
	 * If this is a fresh install then siqrp will use "grid" (WordPress default) because this is always available and does not require images to regenerate.
	 * Lastly, fallback to the provided fallback default.
	 */
	if ( empty( $user_selected_thumbnail ) && 'grid' === $get_template ) {
		$thumbnail_size = 'siqrp-thumbnail';
	} else {
		$thumbnail_size = $default_checked;
	}
	return $thumbnail_size;
}
