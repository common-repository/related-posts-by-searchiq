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
 * SIQRP block setup
 *
 * @package SIQRP
 */


if ( ! class_exists( 'SIQRP_Block', false ) && function_exists( 'register_block_type' ) ) {
	/**
	 * SIQRP_Block Class.
	 *
	 * @class SIQRP_Block
	 */
	class SIQRP_Block {

		/**
		 * SIQRP Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'siqrp_gutenberg_block_func' ), 100 );

			// block_categories_all is a replacement for block_categories filter from WP v5.8.
			// see: https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#block_categories_all.
			if ( class_exists( 'WP_Block_Editor_Context' ) ) {
				add_filter( 'block_categories_all', array( $this, 'siqrp_block_categories' ), 10, 2 );
			} else {
				add_filter( 'block_categories', array( $this, 'siqrp_block_categories' ), 10, 2 );
			}
			add_action( 'enqueue_block_editor_assets', array( $this, 'siqrp_enqueue_block_editor_assets' ) );
		}

		/**
		 * SIQRP enqueue thumbnail stylesheet.
		 */
		public function siqrp_enqueue_block_editor_assets() {
			global $siqrp;
			$siqrp->enqueue_thumbnails_stylesheet();
		}
		/**
		 * SIQRP siqrp_block_render_callback.
		 *
		 * @param  array[] $block_attributes SIQRP block attributes.
		 * @param  string  $content          block content.
		 * @param  bool    $is_preview       block preview.
		 * @return string Rendered SIQRP block HTML.
		 */
		public function siqrp_block_render_callback( $block_attributes, $content, $is_preview = false ) {
			global $siqrp, $post;
			$post_id        = null;
			$siqrp_is_admin = false;

			// If preview then return preview image..
			if ( $is_preview && ! empty( $block_attributes['siqrp_preview'] ) ) {
				$preview_image = SIQRP_BASE_URL . '/images/siqrp-grid.svg';
				return '<img style="width:100%;" src="' . esc_url( $preview_image ) . '">';
			}

			// Since WP 5.8, the widgets are now Gutenberg blocks too, this will help us to differentiate between block and widget.
			$siqrp_args = array(
				'domain' => isset( $block_attributes['domain'] ) ? $block_attributes['domain'] : 'block',
			);
			if ( isset( $block_attributes['reference_id'] ) && ! empty( $block_attributes['reference_id'] ) ) {
				$reference_post = get_post( (int) $block_attributes['reference_id'] );
				$post_id        = $reference_post->ID;
			}
			// Checks if the block is being used in the admin interface.
			if ( isset( $block_attributes['siqrp_is_admin'] ) ) {
				$siqrp_is_admin = $block_attributes['siqrp_is_admin'];
			}
			if ( isset( $block_attributes['heading'] ) ) {
				$siqrp_args['heading'] = $block_attributes['heading'];
			}
			if ( isset( $block_attributes['limit'] ) ) {
				$siqrp_args['limit'] = $block_attributes['limit'];
			}
			if ( isset( $block_attributes['template'] ) ) {
				$siqrp_args['template'] = ( 'list' !== $block_attributes['template'] && 'list' !== $block_attributes['template'] ) ? $block_attributes['template'] : false;
			}
			if ( isset( $block_attributes['domain'] ) ) {
				$siqrp_args['domain'] = $block_attributes['domain'];
			}
			if ( isset( $block_attributes['className'] ) ) {
				$siqrp_args['extra_css_class'] = $block_attributes['className'];
			}

			$output = '';

			// if there is no Reference ID specified on Block.
			if ( empty( $post_id ) ) {
				// Check if the block is on the admin interface or if is preview (Gutenberg editor preview).
				if ( $siqrp_is_admin ) {
					$post_id = $post instanceof WP_Post ? $post->ID : null;
				} else {
					$queried_object = get_queried_object();
					// queried_object corresponds to the post that is being called.
					// https://developer.wordpress.org/reference/functions/get_queried_object/.
					if ( $queried_object instanceof WP_Post ) {
						$post_id = $queried_object->ID;
					}
				}
			}

			if ( 'widget' === $siqrp_args['domain'] && ! $siqrp_args['template'] && ( ! empty( $post_id ) || $siqrp_is_admin ) ) {
				$output .= '<h3>' . $siqrp_args['heading'] . '</h3>';
			}

			if ( ! empty( $post_id ) ) {
				$output .= $siqrp->display_related(
					$post_id,
					$siqrp_args,
					false
				);
			}

			return $output;
		}
		/**
		 * Get all  siqrp theme style.
		 *
		 * @return array all template data.
		 */
		public function siqrp_get_block_templates() {
			global $siqrp;
			$block_templates = $siqrp->get_all_templates();
			/**
			 * Filter the array containing templates.
			 *
			 * @param string $block_templates siqrp templates.
			 */
			return apply_filters( 'siqrp_get_block_templates', $block_templates );
		}
		/**
		 * SIQRP siqrp_gutenberg_block_func.
		 */
		public function siqrp_gutenberg_block_func() {
			global $post, $siqrp;
			$options         = $siqrp->get_option();
			$limit           = ( is_array( $options ) && array_key_exists( 'limit', $options ) ? $options['limit'] : $siqrp->default_options['limit'] );
			$template        = ( is_array( $options ) && array_key_exists( 'template', $options ) ? $options['template'] : $siqrp->default_options['template'] );
			$heading         = ( is_array( $options ) && array_key_exists( 'thumbnails_heading', $options ) ? $options['thumbnails_heading'] : $siqrp->default_options['thumbnails_heading'] );
			$credit_searchiq = ( is_array( $options ) && array_key_exists( 'credit_searchiq', $options ) ? $options['credit_searchiq'] : $siqrp->default_options['credit_searchiq'] );

			$version      = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : SIQRP_VERSION;
			$default_deps = array(
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-components',
				'wp-block-editor',
			);

			$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) : '';
			// batch/v1 is for the request on server_rendering.
			$is_widget_page = substr_count( $uri, 'widgets.php' ) > 0 || substr_count( $uri, 'v2/widgets' ) > 0 || substr_count( $uri, '/batch/v1' ) > 0;
			$siqrp_is_admin = ( substr_count( $uri, 'block-renderer/siqrp/siqrp-block' ) > 0 && substr_count( $uri, '_locale=user' ) > 0 ) || is_admin() || ( substr_count( $uri, 'wp-json/wp/v2/posts/' ) > 0 && substr_count( $uri, '_locale=user' ) > 0 );

			// checks if the current page is the widgets.php admin page, since WP 5.8 there is an error when enqueuing the wp-editor and wp-edit-widgets at the same time.
			if ( $is_widget_page ) {
				$default_deps[] = 'wp-edit-widgets';
			} else {
				$default_deps[] = 'wp-editor';
			}

			// automatically load dependencies and version..
			wp_register_script( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter.
				'siqrp-block',
				siqrp_get_file_url_for_environment( 'assets/js/block.min.js', 'assets/src/js/block.js' ),
				$default_deps,
				$version
			);
			wp_register_style(
				'siqrp-block-style',
				plugins_url( 'assets/css/siqrp-block-editor.css', SIQRP_BASE_FILE ),
				array( 'wp-edit-blocks' ),
				$version
			);
			// Fetch chosen template from SIQRP setting page..
			$chosen_template = $template;
			// Localize the script with data..
			$localized_variables = array(
				'template'             => $this->siqrp_get_block_templates(),
				'selected_theme_style' => $chosen_template,
				'default_domain'       => $is_widget_page ? 'widget' : 'block',
				'siqrp_is_admin'       => $siqrp_is_admin,
				'block_heading'        => $heading,
				'post_count'           => $limit,
			);
			wp_localize_script( 'siqrp-block', 'siqrp_localized', $localized_variables );
			$args = array(
				'editor_style'    => 'siqrp-block-style',
				'editor_script'   => 'siqrp-block',
				'render_callback' => array( $this, 'siqrp_block_render_callback' ),
				'attributes'      => array(
					'className'      => array(
						'type'    => 'string',
						'default' => '',
					),
					'reference_id'   => array(
						'type'    => 'string',
						'default' => null,
					),
					'heading'        => array(
						'type'    => 'string',
						'default' => $siqrp->default_options['thumbnails_heading'],
					),
					'limit'          => array(
						'type'    => 'number',
						'default' => SIQRP_DEFAULT_LIMIT,
					),
					'template'       => array(
						'type'    => 'string',
						'default' => $chosen_template,
					),
					'domain'         => array(
						'type' => 'string',
					),
					'siqrp_is_admin' => array(
						'type'    => 'boolean',
						'default' => $siqrp_is_admin,
					),
					'siqrp_preview'  => array(
						'type' => 'string',
					),
				),
			);
			register_block_type( 'siqrp/siqrp-block', $args );
		}
		/**
		 * Filters the default array of block categories.
		 *
		 * @param array[] $categories Array of block categories.
		 * @param WP_Post $post       Post being loaded.
		 */
		public function siqrp_block_categories( $categories, $post ) {
			return array_merge(
				$categories,
				array(
					array(
						'slug'  => 'siqrp',
						'title' => __( 'SearchIQ Related Posts', 'related-posts-by-searchiq' ),
					),
				)
			);
		}
	}
	new SIQRP_Block();
}
