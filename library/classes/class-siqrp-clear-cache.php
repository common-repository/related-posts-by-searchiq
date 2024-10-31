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
 * Summary of SIQRP_Clear_Cache
 */
class SIQRP_Clear_Cache extends WP_REST_Controller {


	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'searchiq-rp/v' . $version;
		$base      = 'updaterelatedpost';
		register_rest_route(
			$namespace,
			'/' . $base,
			array(
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'update_post_data' ),
					'permission_callback' => '__return_true',
					'args'                => array(
						'url' => array(
							'validate_callback' => array( $this, 'check_if_valid_url' ),
						),
					),
				),
			)
		);
	}
	/**
	 * Summary of update_post_data
	 *
	 * @param  WP_REST_Request $request Request Variable.
	 * @return mixed
	 */
	public function update_post_data( WP_REST_Request $request ) {
		if ( function_exists( 'url_to_postid' ) ) {
			$url     = $request->get_param( 'url' );
			$post_id = url_to_postid( $url );
			if ( ! is_null( $post_id ) ) {
				if ( ! wp_is_post_revision( $post_id ) ) {

					// unhook this function so it doesn't loop infinitely.
					remove_action( 'save_post', array( $this, 'update_post_data' ) );

					$data = array(
						'ID'         => $post_id,
						'meta_input' => array(
							'_siqrp_post_updated' => time(),
						),
					);
					if ( wp_update_post( $data ) ) {
						return new WP_Error( 'siqrp_cache_cleared', esc_attr( 'Post Updated For ' . esc_url( $url ) . '.' ), array( 'status' => 200 ) );
					}
					// re-hook this function.
					add_action( 'save_post', array( $this, 'update_post_data' ) );
				} else {
					return new WP_Error( 'siqrp_post_not_published', esc_attr( __( 'Post is not published.', 'related-posts-by-searchiq' ) ), array( 'status' => 500 ) );

				}
			}
		}
	}
	/**
	 * Summary of clear_post_cache.
	 *
	 * @param  WP_REST_Request $request WP Rest Request.
	 * @return mixed
	 */
	public function clear_post_cache( WP_REST_Request $request ) {
		if ( function_exists( 'url_to_postid' ) ) {
			$url     = $request->get_param( 'url' );
			$post_id = url_to_postid( $request->get_param( 'url' ) );
			if ( ! is_null( $post_id ) ) {
				$post = get_post( $post_id );
				if ( function_exists( 'wpcom_vip_purge_edge_cache_for_post' ) ) {
					wpcom_vip_purge_edge_cache_for_post( $post );
					return new WP_Error( 'siqrp_cache_cleared', esc_attr( 'Edge cache cleared for ' . esc_url( $url ) . '.' ), array( 'status' => 200 ) );
				} else {
					return new WP_Error( 'siqrp_method_not_found', esc_attr( __( 'Method "wpcom_vip_purge_edge_cache_for_post" not found.', 'related-posts-by-searchiq' ) ), array( 'status' => 404 ) );
				}
			} else {
				return new WP_Error( 'siqrp_post_not_found', esc_attr( __( 'Post Not Found.', 'related-posts-by-searchiq' ) ), array( 'status' => 404 ) );
			}
		} else {
			return new WP_Error( 'siqrp_method_not_found', esc_attr( __( 'Method "url_to_postid" not found.', 'related-posts-by-searchiq' ) ), array( 'status' => 404 ) );
		}
	}
	/**
	 * Summary of check_if_valid_url
	 *
	 * @param  mixed $param   Parameter to Validate.
	 * @param  mixed $request Full Request to validate.
	 * @param  mixed $key     Key to Validate.
	 * @return bool
	 */
	public function check_if_valid_url( $param, $request, $key ) {
		return false !== filter_var( $param, FILTER_VALIDATE_URL );
	}
}
