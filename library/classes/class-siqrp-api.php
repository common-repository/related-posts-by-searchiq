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
 * Summary of SIQRP_API
 */
class SIQRP_API {

	/**
	 * End point for making API call.
	 *
	 * @var string
	 */
	private $api_endpoint = '';
	/**
	 * Summary of data_param
	 *
	 * @var array
	 */
	private $data_param = array(
		'params' => array(),
		'method' => 'POST',
	);
	/**
	 * Summary of __construct
	 */
	public function __construct() {
		$this->set_api_endpoint();
	}
	/**
	 * Summary of set_api_endpoint
	 *
	 * @param  mixed $endpoint Endpoint suffix.
	 * @return void
	 */
	public function set_api_endpoint( $endpoint = '' ) {
		$this->api_endpoint = SIQRP_API_BASE_URL . $endpoint; // End point for making API call.
	}
	/**
	 * Summary of serialize_params
	 *
	 * @param  mixed $params Parameters for serialization.
	 * @return string
	 */
	private function serialize_params( &$params ) {
		$query_string = '';
		if ( is_array( $params ) && count( $params ) > 0 ) {
			foreach ( $params as $k => $v ) {
				$query_string .= $k . '=' . $v . '&';
			}
			$query_string = substr( $query_string, 0, -1 );
		}
		return $query_string;
	}
	/**
	 * Summary of call
	 *
	 * @param  mixed $data     What data to send.
	 * @param  mixed $endpoint What is API endpoint.
	 * @throws \Exception Function throws an exception on certain conditions.
	 * @return array
	 */
	public function call( &$data = array(), $endpoint = '' ) {
		global $wp_version;
		$this->set_api_endpoint( $endpoint );
		$site_domain = get_option( 'siteurl' );
		$user_agent  = 'WordPress/' . $wp_version . '; ' . $site_domain;

		if ( count( $data ) == 0 ) {
			$data = $this->data_param;
		}
		$params            = &$data['params'];
		$method            = &$data['method'];
		$headers           = array(
			'Content-Type' => 'application/json; charset=UTF-8',
			'user-agent'   => &$user_agent,
		);
		$headers['Accept'] = 'application/json, text/plain';
		$args              = array(
			'method'      => '',
			'timeout'     => SIQRP_API_CALL_TIMEOUT,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => &$headers,
			'cookies'     => array(),
			'body'        => array(),
		);
		if ( ! empty( $method ) ) {
			$args['method'] = &$method;
		}

		$call_url = $this->api_endpoint;

		if ( ( 'GET' == $method ) && ! empty( $params ) && ( ! isset( $data['body'] ) || ( isset( $data['body'] ) && false == $data['body'] ) ) ) {
			$call_url .= '?' . $this->serialize_params( $params );
		} elseif ( 'POST' == $method || 'PUT' == $method || 'DELETE' == $method || ( isset( $data['body'] ) && true == $data['body'] ) ) {
			$args['body'] = wp_json_encode( $params );
		}

		$res = wp_remote_request( $call_url, $args );
		if ( is_wp_error( $res ) ) {
			$msg = '';
			$msg = $res->get_error_message();
			if ( strpos( $msg, 'Connection refused' ) > -1 ) {
				$msg = 'We are experiencing temporary site issues';
			}
			throw new Exception( esc_attr( $msg ), 500 );
		} else {
			$retrieve_response_code    = wp_remote_retrieve_response_code( $res );
			$retrieve_response_message = wp_remote_retrieve_response_message( $res );

			if ( ( $retrieve_response_code >= 200 && $retrieve_response_code < 300 ) || 403 == $retrieve_response_code || 401 == $retrieve_response_code ) {
				$response_body   = wp_remote_retrieve_body( $res );
				$response_array  = json_decode( $response_body, true );
				$response_string = json_decode( $response_body, false );
				if ( is_array( $response_array ) ) {
					$response_array['success'] = true;
					return array(
						'response_code'    => $retrieve_response_code,
						'response_body'    => $response_array,
						'response_message' => $retrieve_response_message,
						'response_string'  => $response_string,
					);
				} elseif ( ! empty( $response_body ) && ( 403 == $retrieve_response_code || 401 == $retrieve_response_code ) ) {
					return array(
						'response_code' => $retrieve_response_code,
						'response_body' => array(
							'success' => false,
							'message' => $response_body,
						),
					);
				} elseif ( ! empty( $response_body ) ) {
					return array(
						'response_code' => $retrieve_response_code,
						'response_body' => array(
							'success' => true,
							'message' => $response_body,
						),
					);
				} elseif ( ! empty( $retrieve_response_message ) ) {
					return array(
						'response_code' => $retrieve_response_code,
						'response_body' => array(
							'success' => true,
							'message' => $retrieve_response_message,
						),
					);
				} else {
					throw new Exception( esc_attr( __( 'Unknown Error', 'related-posts-by-searchiq' ) ), intval( esc_attr( $retrieve_response_code ) ) );
				}
			} elseif ( ! empty( $retrieve_response_message ) ) {
				$response_body = wp_remote_retrieve_body( $res );
				if ( ! empty( $response_body ) ) {
					$body = json_decode( $response_body, true );
					if ( is_array( $body ) ) {
						$message = $body['message'];
					} else {
						$message = $response_body;
					}
				} else {
					$message = $retrieve_response_message;
				}
				throw new Exception( esc_attr( $message ), intval( esc_attr( $retrieve_response_code ) ) );
			} elseif ( 0 == $retrieve_response_code && empty( $retrieve_response_message ) ) {
				throw new Exception( esc_attr( __( 'Unable to connect to server, please check your network', 'related-posts-by-searchiq' ) ), intval( esc_attr( $retrieve_response_code ) ) );
			} else {
				throw new Exception( esc_attr( __( 'Unknown Error', 'related-posts-by-searchiq' ) ), intval( esc_attr( $retrieve_response_code ) ) );
			}
		}
	}
	/**
	 * Summary of siq_get_api_endpoint
	 *
	 * @return string
	 */
	public function siq_get_api_endpoint() {
		return $this->api_endpoint;
	}
}
