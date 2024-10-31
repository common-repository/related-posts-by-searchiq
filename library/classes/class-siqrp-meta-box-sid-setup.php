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
 * Summary of SIQRP_Meta_Box_Sid_Setup
 */
class SIQRP_Meta_Box_Sid_Setup extends SIQRP_Meta_Box {

	/**
	 * Summary of display
	 *
	 * @return void
	 */
	public function display() {
		$sid = siqrp_get_sid();
		echo '<p><strong>';
		esc_html_e( 'Before moving forward to using the plugin, you need to have a valid Partner ID. Enter your Partner ID here in order to proceed setting up the plugin.', 'related-posts-by-searchiq' );
		echo '</strong></p>';

		echo '<div>';

		$this->textbox( 'siqrp_sid', __( 'Enter Your Partner ID here:', 'related-posts-by-searchiq' ), 30, 'siqrp_sid_displayed', null, $sid );
		echo '</div>';
		$button_text = ! empty( $sid ) ? __( 'Update Partner ID', 'related-posts-by-searchiq' ) : __( 'Save Partner ID', 'related-posts-by-searchiq' );

		echo '<div class="submit-sid-button">
			<input type="submit" class="button-primary siqrp_spin_on_click" name="update_sid" value="' . esc_attr( $button_text ) . '" />
			<span class="spinner siqrp-no-float"></span>
		</div>';
		wp_nonce_field( 'update_sid', 'update_siqrp-nonce' );
	}
}
