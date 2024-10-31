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
 * Class SIQRP_Shortcode
 * Adds the SIQRP shortcode.
 *
 * @package SIQRP
 */
class SIQRP_Shortcode {

	/**
	 * Summary of register
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode(
			'siqrp',
			array( $this, 'render' )
		);
	}

	/**
	 * Summary of render
	 *
	 * @param  mixed $atts attributes for the shortcode.
	 * @return string
	 */
	public function render( $atts ) {
		/**
		 * Global variable siqrp
		 *
		 * @global mixed $siqrp
		 */
		global $siqrp, $post;
		// don't use shortcode_atts() as it's DRYer to all the validation in SIQRP::display_related()
		// but do use the same filter as shortcode_atts, with all the same parameters as before the backward-compatibility.
		$atts = apply_filters(
			'siqrp_shortcode_atts',
			(array) $atts,
			$atts,
			array(
				'reference_id' => null,
				'template'     => null,
				'limit'        => null,
				'recent'       => null,
				'heading'      => null,
			),
			'siqrp'
		);
		$atts = array_map(
			function ( $item ) {
				// Sanitize user input.
				$trimmed_value = trim( esc_attr( $item ) );
				// check for the strings "true" and "false" to mean boolean true and false.
				if ( is_string( $trimmed_value ) ) {
					$lower_trimmed_value = strtolower( $trimmed_value );
					if ( 'true' === $lower_trimmed_value ) {
						$trimmed_value = true;
					} elseif ( 'false' === $lower_trimmed_value ) {
						$trimmed_value = false;
					}
				}
				return $trimmed_value;
			},
			$atts
		);

		// Validate "limit" user input.
		if ( isset( $atts['limit'] ) && $atts['limit'] ) {
			// Use user input only if numeric value is passed.
			if ( filter_var( $atts['limit'], FILTER_VALIDATE_INT ) !== false ) {
				// Variable is an integer.
				$atts['limit'] = (int) $atts['limit'];
			} else {
				unset( $atts['limit'] );
			}
		}

		// We have hardcoded the "domain" as it should not be editable by users.
		$atts['domain'] = 'shortcode';

		$ref_post = isset( $atts['reference_id'] ) ? get_post( (int) $atts['reference_id'] ) : $post;
		unset( $atts['reference_id'] );
		if ( $ref_post instanceof WP_Post ) {
			return $siqrp->display_related(
				$ref_post->ID,
				$atts,
				false
			);
		} else {
			return '<!-- SIQRP shortcode called but no reference post found. -->';
		}
	}
}
