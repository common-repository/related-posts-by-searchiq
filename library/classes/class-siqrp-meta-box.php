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
 * Summary of SIQRP_Meta_Box
 */
class SIQRP_Meta_Box {

	/**
	 * Summary of siqrp
	 *
	 * @var SIQRP
	 */
	protected $siqrp = null;
	/**
	 * Summary of __construct
	 */
	public function __construct() {
		global $siqrp;
		$this->siqrp = $siqrp;
	}
	/**
	 * Summary of checkbox
	 *
	 * @param  mixed $option   Name of option.
	 * @param  mixed $desc     Description of option.
	 * @param  mixed $class    Additional css Classes.
	 * @param  mixed $siqrp_args Arguments.
	 * @return void
	 */
	public function checkbox( $option, $desc, $class = null, $siqrp_args = array() ) {
		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_checkbox.phtml';
	}
	/**
	 * Summary of radio
	 *
	 * @param  mixed $option Name of option.
	 * @param  mixed $desc   Description of option.
	 * @param  mixed $class  Additional css Classes.
	 * @param  mixed $value  Selected value of option.
	 * @return void
	 */
	public function radio( $option, $desc, $class = null, $value = null ) {
		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_radio.phtml';
	}
	/**
	 * Summary of template_checkbox
	 *
	 * @param  mixed $rss   Is this RSS.
	 * @param  mixed $class Additional Class.
	 * @return void
	 */
	public function template_checkbox( $rss = false, $class = null ) {
		$pre             = ( $rss ) ? 'rss_' : '';
		$chosen_template = siqrp_get_option( $pre . 'template' );
		$choice          = ( false === $chosen_template )
			? 'list' : ( ( 'grid' === $chosen_template ) ? 'grid' : ( ! empty( $chosen_template ) ? $chosen_template : false ) );

		$builtin = ( 'list' === $choice ) ? 'active' : null;

		$thumbnails = ( 'grid' === $choice ) ? 'active' : null;
		$custom     = ( 'custom' === $choice ) ? 'active' : null;
		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_template_checkbox.phtml';
	}
	/**
	 * Summary of template_file
	 *
	 * @param  mixed $rss   Is this RSS.
	 * @param  mixed $class Additional Class.
	 * @return void
	 */
	public function template_file( $rss = false, $class = null ) {
		$pre             = ( $rss ) ? 'rss_' : '';
		$chosen_template = siqrp_get_option( $pre . 'template' );

		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_template_file.phtml';
	}
	/**
	 * Summary of textbox
	 *
	 * @param  mixed $option  Option Name.
	 * @param  mixed $desc    Option Description.
	 * @param  mixed $size    TextBox Size.
	 * @param  mixed $class   Additional Class.
	 * @param  mixed $note    Help note.
	 * @param  mixed $default Default value.
	 * @return void
	 */
	public function textbox( $option, $desc, $size = 2, $class = null, $note = null, $default = '' ) {
		$value = ! empty( esc_attr( siqrp_get_option( $option ) ) ) ? esc_attr( siqrp_get_option( $option ) ) : ( ! empty( $default ) ? esc_attr( $default ) : '' );

		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_textbox.phtml';
	}
	/**
	 * Summary of beforeafter
	 *
	 * @param  mixed $options Option Name.
	 * @param  mixed $desc    Option Description.
	 * @param  mixed $size    Size.
	 * @param  mixed $class   Additional Class.
	 * @param  mixed $note    Help Note.
	 * @return void
	 */
	public function beforeafter( $options, $desc, $size = 10, $class = null, $note = null ) {
		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_beforeafter.phtml';
	}
	/**
	 * Render the select options.
	 *
	 * @param string $name    Select option name.
	 * @param array  $options Array of option value.
	 * @param string $desc    label description.
	 * @param array  $args    Array of additional argument.
	 */
	public function siqrp_select_option( $name, $options, $desc = '', $args = '' ) {
		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_select.phtml';
	}
	/* MARK: Last cleaning spot */
	/**
	 * Summary of weight
	 *
	 * @param  mixed $option Option name.
	 * @param  mixed $desc   Option description.
	 * @return void
	 */
	public function weight( $option, $desc ) {
		$weight = (int) siqrp_get_option( "weight[$option]" );

		$fulltext = $this->siqrp->db_schema->database_supports_fulltext_indexes() ? '' : ' readonly="readonly" disabled="disabled"';

		echo "<div class='siqrp_form_row siqrp_form_select'><div class='siqrp_form_label'>" . esc_attr( $desc ) . '</div><div>';
		echo "<select name='weight[" . esc_attr( $option ) . "]'>";
		echo '<option ' . esc_attr( $fulltext ) . " value='no'" . ( ( ! $weight ) ? ' selected="selected"' : '' ) . '  >' . esc_attr( __( 'do not consider', 'related-posts-by-searchiq' ) ) . '</option>';
		echo '<option ' . esc_attr( $fulltext ) . " value='consider'" . ( ( 1 == $weight ) ? ' selected="selected"' : '' ) . '  > ' . esc_attr( __( 'consider', 'related-posts-by-searchiq' ) ) . '</option>';
		echo '<option ' . esc_attr( $fulltext ) . " value='consider_extra'" . ( ( $weight > 1 ) ? ' selected="selected"' : '' ) . '  > ' . esc_attr( __( 'consider with extra weight', 'related-posts-by-searchiq' ) ) . '</option>';
		echo '</select>';
		echo '</div></div>';
	}
	/**
	 * Summary of displayorder
	 *
	 * @param  mixed $option Option Name.
	 * @param  mixed $class  Additional Class.
	 * @return void
	 */
	public function displayorder( $option, $class = null ) {
		echo "<div class='siqrp_form_row siqrp_form_select " . esc_attr( $class ) . "'><div class='siqrp_form_label'>";
		esc_attr_e( 'Order results:', 'related-posts-by-searchiq' );
		echo "</div><div><select name='" . esc_attr( $option ) . "' id='" . esc_attr( $option ) . "'>";
		$order = siqrp_get_option( $option );
		?>
				<option value="score DESC" <?php echo ( 'score DESC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'score (high relevance to low)', 'related-posts-by-searchiq' ); ?></option>
				<option value="score ASC" <?php echo ( 'score ASC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'score (low relevance to high)', 'related-posts-by-searchiq' ); ?></option>
				<option value="post_date DESC" <?php echo ( 'post_date DESC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'date (new to old)', 'related-posts-by-searchiq' ); ?></option>
				<option value="post_date ASC" <?php echo ( 'post_date ASC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'date (old to new)', 'related-posts-by-searchiq' ); ?></option>
				<option value="post_title ASC" <?php echo ( 'post_title ASC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'title (alphabetical)', 'related-posts-by-searchiq' ); ?></option>
				<option value="post_title DESC" <?php echo ( 'post_title DESC' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'title (reverse alphabetical)', 'related-posts-by-searchiq' ); ?></option>
				<option value="rand" <?php echo ( 'rand' == $order ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( 'random', 'related-posts-by-searchiq' ); ?></option>
		<?php
		echo '</select></div></div>';
	}
}
