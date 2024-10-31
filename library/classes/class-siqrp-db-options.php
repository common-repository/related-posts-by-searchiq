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
 * Class SIQRP_DB_Options
 * Class for storing and retrieving options saved to the WordPress options table. Does not contain extra logic
 * about the default SIQRP options' values or when to clear the cache. This is just a central way to get/set
 * database options used by SIQRP and to describe them.
 *
 * @package SIQRP
 */
class SIQRP_DB_Options {

	/**
	 * Key in SIQRP option.
	 * Currently indicates that SIQRP couldn't install the fulltext indexes upon activation, so the user
	 * had to run a database query to change their posts table to use MyISAM database engine. This option is set
	 * when they assert they have done that and then SIQRP can re-attempt creating the database indexes.
	 */
	const SIQRP_MYISAM_OVERRIDE = 'myisam_override';

	/**
	 * Key in options table whose value indicates the last error relating to adding fulltext indexes.
	 */
	const FULLTEXT_DB_ERROR = 'siqrp_fulltext_db_error';

	/**
	 * Gets all the raw SIQRP settings as stored in the DB. You should probably use `SIQRP::get_option` instead
	 * as that is merged with the defaults.
	 *
	 * @return array
	 */
	public function get_siqrp_options() {
		$options = (array) get_option( 'siqrp', array() );

		return $options;
	}

	/**
	 * Updates all the SIQRP settings. You should probably use SIQRP::set_option() instead, as that merges the input
	 * with the defaults, and it intelligently checks whether we should clear the SIQRP cache or not.
	 *
	 * @param array $options an array where keys are option names and values are their values.
	 *
	 * @return bool success
	 */
	public function set_siqrp_options( $options ) {
		return update_option( 'siqrp', (array) $options );
	}

	/**
	 * Gets whether fulltext indexes were not found to be supported.
	 *
	 * @deprecated in 5.14.0 because we just always try to use fulltext indexes
	 * @return     bool
	 */
	public function is_fulltext_disabled() {
		return (bool) get_option( 'siqrp_fulltext_disabled', false );
	}

	/**
	 * Records that fulltext indexes weren't supported.
	 *
	 * @param      boolean $new_value True if we found fulltext indexes were supported, false otherwise.
	 * @deprecated in 5.14.0 because we just check the actual DB instead
	 * @return     bool indicating success
	 */
	public function set_fulltext_disabled( $new_value ) {
		return update_option( 'siqrp_fulltext_disabled', (bool) $new_value );
	}

	/**
	 * Gets the installed version of SIQRP
	 *
	 * @return string
	 */
	public function plugin_version_in_db() {
		return get_option( 'siqrp_version' );
	}

	/**
	 * Updates the version SIQRP knows is installed.
	 *
	 * @return bool indicating success
	 */
	public function update_plugin_version_in_db() {
		return update_option( 'siqrp_version', SIQRP_VERSION );
	}

	/**
	 * Gets the "siqrp_activated" option, which indicates SIQRP was just activated.
	 *
	 * @return bool
	 */
	public function after_activation() {
		return (bool) get_option( 'siqrp_activated', false );
	}

	/**
	 * Deletes the WP option that indicates SIQRP was just activated.
	 *
	 * @return bool
	 */
	public function delete_activation_flag() {
		return delete_option( 'siqrp_activated' );
	}

	/**
	 * Checks if SIQRP was upgraded during this request.
	 *
	 * @return bool
	 */
	public function after_upgrade() {
		return (bool) get_option( 'siqrp_upgraded' );
	}

	/**
	 * Sets a flag that indicates SIQRP was just upgraded.
	 *
	 * @return bool
	 */
	public function add_upgrade_flag() {
		return update_option( 'siqrp_upgraded', true );
	}

	/**
	 * Deletes the flag that indicates SIQRP was just activated.
	 *
	 * @return bool
	 */
	public function delete_upgrade_flag() {
		return delete_option( 'siqrp_upgraded' );
	}

	/**
	 * Stores the $wpdb->last_error in a WP option with key "siqrp_fulltext_db_error" for later retrieval.
	 * This should be called right after SIQRP_DB_Schema::add_title_index() or SIQRP_DB_Schema::add_content_index().
	 *
	 * @return bool success
	 */
	public function update_fulltext_db_record() {
		global $wpdb;
		return update_option( self::FULLTEXT_DB_ERROR, $wpdb->last_error . '(' . current_time( 'mysql' ) . ')' );
	}

	/**
	 * Deletes the option that indicates there was an error adding the fulltext index.
	 *
	 * @return bool success
	 */
	public function delete_fulltext_db_error_record() {
		return delete_option( self::FULLTEXT_DB_ERROR );
	}

	/**
	 * Gets the last error relating to adding SIQRP's fulltext indexes.
	 *
	 * @return string
	 */
	public function get_fulltext_db_error() {
		return (string) get_option( self::FULLTEXT_DB_ERROR, esc_html__( 'No error recorded.', 'related-posts-by-searchiq' ) );
	}

	/**
	 * Summary of has_fulltext_db_error
	 *
	 * @return bool
	 */
	public function has_fulltext_db_error() {
		return (bool) get_option( self::FULLTEXT_DB_ERROR, false );
	}

	/**
	 * Summary of set_siqrp_sid
	 *
	 * @param  mixed $sid sid of the user.
	 * @return mixed
	 */
	public function set_siqrp_sid( $sid ) {
		return update_option( 'siqrp_sid', $sid );
	}

	/**
	 * Summary of get_siqrp_sid
	 *
	 * @return mixed
	 */
	public function get_siqrp_sid() {
		return get_option( 'siqrp_sid', false );
	}
}
