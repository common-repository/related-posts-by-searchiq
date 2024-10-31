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
 * Summary of SIQRP_Widget
 */
class SIQRP_Widget extends WP_Widget {


	/**
	 * Summary of __construct
	 */
	public function __construct() {
		$widget_ops = array(
			'description'           => 'Related Posts and/or Sponsored Content',
			'show_instance_in_rest' => true,
		);
		add_filter( 'widget_types_to_hide_from_legacy_widget_block', array( $this, 'hide_siqrp_widget_legacy_editor' ) );
		parent::__construct( false, 'SearchIQ Related Posts', $widget_ops );
	}

	/**
	 * Summary of widget
	 *
	 * @param  mixed $args     Arguments for the widget.
	 * @param  mixed $instance Widget Instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		if ( ! is_singular() ) {
			return;
		}

		global $siqrp;
     // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $args );

		/* Compatibility with pre-3.5 settings: */
		if ( isset( $instance['use_template'] ) ) {
			$instance['template'] = ( $instance['use_template'] ) ? ( $instance['template_file'] ) : false;
		}

		// Per display_related the template must be false if "list" template was selected.
		if ( 'list' === $instance['template'] || 'list' === $instance['template'] ) {
			$instance['template'] = false;
		}

		$instance['heading'] = $this->get_heading( $instance );
		$heading             = apply_filters( 'widget_title', $instance['heading'] );
		$output              = $before_widget;
		if ( ! $instance['template'] ) {
			$output .= $before_title;
			$output .= $heading;
			$output .= $after_title;
		}
		$instance['domain'] = 'widget';
		$output            .= $siqrp->display_related( null, $instance, false );
		$output            .= $after_widget;
		echo wp_kses( $output, $siqrp->kses_allowed_html_config );
	}

	/**
	 * Summary of update
	 *
	 * @param  mixed $new_instance New instance of the widget.
	 * @param  mixed $old_instance Old instance of the widget.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'template'        => false,
			'heading'         => $new_instance['heading'],
			'use_pro'         => false,
			'pro_dpid'        => null,
			'credit_searchiq' => false,
		);

		if ( isset( $new_instance['use_template'] ) && 'grid' === $new_instance['use_template'] ) {
			$instance['template'] = 'grid';
		} elseif ( isset( $new_instance['use_template'] ) && 'custom' === $new_instance['use_template'] ) {
			$instance['template'] = $new_instance['template_file'];
		} else {
			$instance['template'] = isset( $new_instance['template_file'] ) ? $new_instance['template_file'] : false;
		}

		// Legacy Widget block triggers this function on save but with the new instance..
		if ( isset( $new_instance['template'] ) ) {
			$instance['template'] = $new_instance['template'];
		}

		return $instance;
	}

	/**
	 * Summary of form
	 *
	 * @param  mixed $instance Current Instance.
	 * @return void
	 */
	public function form( $instance ) {
		global $siqrp;
		$id       = rtrim( $this->get_field_id( null ), '-' );
		$instance = wp_parse_args(
			$instance,
			array(
				'heading'         => $this->get_heading( $instance ),
				'template'        => false,
				'use_pro'         => false,
				'pro_dpid'        => null,
				'credit_searchiq' => false,
			)
		);

		/*
		* TODO: Deprecate
		* Compatibility with pre-3.5 settings
		*/
		if ( isset( $instance['use_template'] ) ) {
			$instance['template'] = $instance['template_file'];
		}

		$choice = ( $instance['template'] && ! empty( $instance['template'] ) ) ? $instance['template'] : 'custom';

		/* Check if SIQRP templates are installed */
		$block_templates = $siqrp->get_all_templates();

		if ( 'custom' === $choice ) {
			$choice = 'list';
		}

		include SIQRP_BASE_DIR . '/includes/phtmls/siqrp_widget_form.phtml';
	}

	/**
	 * Hides the siqrp widget from the block list
	 *
	 * @param  mixed $widget_types Which Widgets to hide.
	 * @return mixed
	 */
	public function hide_siqrp_widget_legacy_editor( $widget_types ) {
		$widget_types[] = 'siqrp_widget';
		return $widget_types;
	}

	/**
	 * Get the heading of the widget backwards compatibility
	 *
	 * @param  object $instance Current Widget Instance.
	 * @return string
	 */
	protected function get_heading( $instance ) {
		$heading = '';

		if ( empty( $instance ) ) {
			return $heading;
		}

		if ( 'grid' === $instance['template'] && isset( $instance['thumbnails_heading'] ) ) {
			$heading = $instance['thumbnails_heading'];
		} elseif ( false === $instance['template'] && isset( $instance['title'] ) ) {
			$heading = $instance['title'];
		} elseif ( ! empty( $instance['heading'] ) ) {
			$heading = $instance['heading'];
		}

		return $heading;
	}
}

/**
 * Summary of siqrp_widget_init
 *
 * @return void
 */
function siqrp_widget_init() {  // phpcs:ignore Universal.Files.SeparateFunctionsFromOO.Mixed
	register_widget( 'SIQRP_Widget' );
}

add_action( 'widgets_init', 'siqrp_widget_init' );
