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

if ( $siqrp->db->has_fulltext_db_error() ) {
	?>
	<div class="notice notice-error" >
		<span class="siqrp-red"><?php esc_html_e( 'Full-text Index creation did not work!', 'related-posts-by-searchiq' ); ?></span><br/>
	<?php
	printf(
				/* translators:  %s represents the error */
		esc_html__( 'There was an error adding the full-text index to your posts table: %s', 'related-posts-by-searchiq' ),
		esc_html( $siqrp->db->get_fulltext_db_error() )
	);
			$siqrp->db->delete_fulltext_db_error_record();
	?>
			<br/>
	<?php esc_html_e( 'Titles and bodies still cannot be used as relatedness criteria.', 'related-posts-by-searchiq' ); ?>
	</div>
	<?php
}
