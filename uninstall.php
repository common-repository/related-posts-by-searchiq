<?php
/**
 * Uninstall procedure.
 *
 * @package SIQRP
 */

/* Exit if plugin delete hasn't be called */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

global $wpdb;

/* SIQRP option names */
$opt_names = array(
	'siqrp',
	'siqrp_pro',
	'siqrp_fulltext_disabled',
	'siqrp_optin_timeout',
	'siqrp_version',
	'siqrp_version_info',
	'siqrp_version_info_timeout',
	'siqrp_activated',
	'widget_siqrp_widget',
	'siqrp_upgraded',
	'siqrp_activate_timestamp',
);

/* Select right procedure for single or multi site */
if ( is_multisite() ) {

	/* Get sites ids */
	$all_blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

	/* Get main site id */
	$original_blog_id = get_current_blog_id();

	/* loop through all sites */
	foreach ( $all_blog_ids as $single_blog_id ) {
		switch_to_blog( $single_blog_id );
		siqrp_clean( $opt_names, $wpdb );
	}/*end foreach*/

	switch_to_blog( $original_blog_id );

} else {

	siqrp_clean( $opt_names, $wpdb );

}/*end if*/


/**
 * Loop through option array and delete the option and clear and drop cache tables.
 *
 * @param array  $opts Array of siqrp's options.
 * @param object $wpdb WordPress db global.
 */
function siqrp_clean( array $opts, $wpdb ) {

	foreach ( $opts as $opt ) {
		delete_option( $opt );
	}
	/* Truncate, clear and drop siqrp cache */
	$wpdb->query( 'DELETE FROM `' . $wpdb->prefix . 'postmeta` WHERE meta_key LIKE "%siqrp%"' );
	/* Delete users siqrp related data */
	$wpdb->query( 'DELETE FROM `' . $wpdb->prefix . 'usermeta` WHERE meta_key LIKE "%siqrp%"' );
}//end siqrp_clean()
