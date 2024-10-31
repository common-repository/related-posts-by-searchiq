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
 * Summary of SIQRP
 */
class SIQRP_Main {


	/**
	 * Here's a list of all the options SIQRP uses (except version), as well as their default values,
	 */
	/**
	 * Summary of default_options
	 *
	 * @var array
	 */
	public $default_options = array();
	/**
	 * Summary of pro_default_options
	 *
	 * @var array
	 */
	public $pro_default_options = array();
	/**
	 * Summary of default_hidden_metaboxes
	 *
	 * @var array
	 */
	public $default_hidden_metaboxes = array();
	/**
	 * Summary of debug
	 *
	 * @var boolean
	 */
	public $debug = false;
	/**
	 * Summary of siqrp_pro
	 *
	 * @var boolean
	 */
	public $siqrp_pro = null;
	/**
	 * Summary of generate_missing_thumbnails
	 *
	 * @var mixed
	 */
	public $generate_missing_thumbnails = null;

	/**
	 * Summary of is_custom_template
	 *
	 * @var boolean
	 */
	public $is_custom_template;

	/**
	 * Summary of db
	 *
	 * @var SIQRP_DB_Options
	 */
	public $db;

	/**
	 * Summary of cache_bypass
	 *
	 * @var SIQRP_Cache_Bypass
	 */
	public $cache_bypass;
	/**
	 * Summary of demo_cache_bypass
	 *
	 * @var SIQRP_Cache_Demo_Bypass
	 */
	public $demo_cache_bypass;
	/**
	 * Summary of cache
	 *
	 * @var SIQRP_Cache
	 */
	public $cache;

	/**
	 * Summary of admin
	 *
	 * @var SIQRP_Admin
	 */
	public $admin;

	/**
	 * Summary of db_schema
	 *
	 * @var SIQRP_DB_Schema
	 */
	public $db_schema;

	/**
	 * Summary of active_cache
	 *
	 * @var SIQRP_Cache
	 */
	private $active_cache;
	/**
	 * Summary of storage_class
	 *
	 * @var Storage
	 */
	private $storage_class;
	/**
	 * Summary of default_dimensions
	 *
	 * @var array
	 */
	private $default_dimensions = array(
		'width'    => 120,
		'height'   => 120,
		'crop'     => false,
		'size'     => '120x120',
		'_default' => true,
	);
	/**
	 * Summary of rendering_related_content
	 *
	 * @var boolean
	 */
	private $rendering_related_content;
	/**
	 * Summary of related_posts_data
	 *
	 * @var array
	 */
	public static $related_posts_data = null;
	/**
	 * Summary of related_posts_count
	 *
	 * @var mixed
	 */
	public $related_posts_count = null;

	/**
	 * Summary of sid
	 *
	 * @var string
	 */
	public $sid = '';
	/**
	 * Summary of screen
	 *
	 * @var mixed
	 */
	public $screen = null;
	/**
	 * Summary of block_post_count
	 *
	 * @var int
	 */
	public $block_post_count;
	/**
	 * Summary of block_post_count_offset
	 *
	 * @var int
	 */
	public static $block_post_count_offset = 0;
	/**
	 * Summary of count_blocks
	 *
	 * @var int
	 */
	public static $count_blocks = 0;
	/**
	 * Summary of kses_allowed_html_searchbox
	 *
	 * @var array
	 */
	public $kses_allowed_html_searchbox = array(
		'select'   => array(
			'name'     => array(),
			'id'       => array(),
			'class'    => array(),
			'disabled' => array(),
			'style'    => array(),
		),
		'option'   => array(
			'value'    => array(),
			'selected' => array(),
			'style'    => array(),
		),
		'optgroup' => array(
			'value'     => array(),
			'label'     => array(),
			'style'     => array(),
			'data-help' => array(),
		),
	);
	/**
	 * Summary of kses_allowed_html_config
	 *
	 * @var array
	 */
	public $kses_allowed_html_config = array(
		'select'   => array(
			'name'     => array(),
			'id'       => array(),
			'class'    => array(),
			'disabled' => array(),
			'style'    => array(),
		),
		'option'   => array(
			'value'    => array(),
			'selected' => array(),
			'style'    => array(),
		),
		'optgroup' => array(
			'value'     => array(),
			'label'     => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'table'    => array(
			'class'       => array(),
			'id'          => array(),
			'width'       => array(),
			'cellpadding' => array(),
			'cellspacing' => array(),
			'border'      => array(),
			'style'       => array(),
		),
		'tbody'    => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'tr'       => array(
			'class'         => array(),
			'id'            => array(),
			'rowspan'       => array(),
			'style'         => array(),
			'data-posttype' => array(),
		),
		'th'       => array(
			'class'   => array(),
			'id'      => array(),
			'colspan' => array(),
			'style'   => array(),
		),
		'td'       => array(
			'class'   => array(),
			'id'      => array(),
			'colspan' => array(),
			'style'   => array(),
		),
		'div'      => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'h2'       => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'h3'       => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'ul'       => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'li'       => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'ol'       => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'input'    => array(
			'class'       => array(),
			'id'          => array(),
			'name'        => array(),
			'value'       => array(),
			'type'        => array(),
			'style'       => array(),
			'placeholder' => array(),
			'checked'     => array(),
			'disabled'    => array(),
		),
		'textarea' => array(
			'class'       => array(),
			'id'          => array(),
			'name'        => array(),
			'rows'        => array(),
			'cols'        => array(),
			'style'       => array(),
			'placeholder' => array(),
		),
		'b'        => array(),
		'br'       => array(),
		'a'        => array(
			'href'   => array(),
			'target' => array(),
			'class'  => array(),
			'id'     => array(),
			'style'  => array(),
		),
		'span'     => array(
			'class' => array(),
			'id'    => array(),
			'style' => array(),
		),
		'label'    => array(
			'class'     => array(),
			'id'        => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'form'     => array(
			'class'     => array(),
			'id'        => array(),
			'action'    => array(),
			'method'    => array(),
			'style'     => array(),
			'data-help' => array(),
		),
		'script'   => array( 'type' => array() ),
		'style'    => array( 'type' => array() ),
	);
	/**
	 * Summary of api_exception
	 *
	 * @var false $api_exception
	 */
	private $api_exception = false;
	/**
	 * Summary of after_content
	 *
	 * @var boolean after_content
	 */
	public $after_content = false;
	/**
	 * Summary of __construct
	 */
	public function __construct() {
		$this->is_custom_template = false;
		$this->load_default_options();
		if ( is_null( $this->block_post_count ) ) {
			$this->block_post_count = 0;
		}

		/* Loads the plugin's translated strings. */
		load_plugin_textdomain( 'related-posts-by-searchiq', false, plugin_basename( SIQRP_BASE_DIR ) . '/lang' );

		/* Load cache object. */
		$this->db = new SIQRP_DB_Options();

		$this->sid = $this->get_sid();

		/* Automatic display hooks: */
		/**
		 * Allow filtering the priority of SIQRP's placement.
		 */
		$content_priority    = apply_filters( 'siqrp_content_priority', 1200 );
		$custom_css_priority = apply_filters( '_siqrp_custom_css_priority', 2000 );

		add_filter( 'the_content', array( $this, 'the_content' ), $content_priority );
		add_action( 'bbp_template_after_single_topic', array( $this, 'add_to_bbpress' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_thumbnails_stylesheet' ) );
		add_filter( 'is_protected_meta', array( $this, 'is_protected_meta' ), 10, 3 );

		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts_in_admin' ) );
		add_action( 'admin_init', array( $this, 'siqrp_admin_init' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css_to_header' ), $custom_css_priority );

		add_filter( 'siqrp_filter_url', array( $this, 'add_siqrp_filter_url' ) );
		/**
		 * If we're using thumbnails, register siqrp-thumbnail size, if theme has not already.
		 * Note: see FAQ in the readme if you would like to change the SIQRP thumbnail size.
		 * If theme has already siqrp-thumbnail size registered and we also try to register siqrp-thumbnail then it will throw a fatal error. So it is necessary to check if siqrp-thumbnail size is not registered.
		 */
		global $siqrp_add_image_size;

		/**
		 * Filters whether or not to register SIQRP's image size "siqrp-thumbnail". Defaults to registering it
		 * if it wasn't already by the theme or some other plugin. But if you don't want siqrp-thumbnail sizes being
		 * generated at all, have it always return false.
		 */
		$siqrp_add_image_size = false;

		if ( ! $this->db->plugin_version_in_db() ) {
			$this->db->add_upgrade_flag();
		}

		/**
		 * Check if is admin.
		 */
		if ( is_admin() ) {
			include_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-admin.php';
			$this->admin = new SIQRP_Admin( $this );
		}

		include_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-clear-cache.php';
		add_action( 'rest_api_init', array( ( new SIQRP_Clear_Cache() ), 'register_routes' ) );
		$shortcode = new SIQRP_Shortcode();
		$shortcode->register();
	}

	/**
	 * Summary of siqrp_admin_init
	 *
	 * @return void
	 */
	public function siqrp_admin_init() {
		$this->screen = get_current_screen();
		add_action( 'admin_print_footer_scripts', array( $this, 'siq_admin_validated_scripts' ) );
	}

	/**
	 * Add siqrp_meta key to protected list.
	 *
	 * @param bool   $protected Whether the key is considered protected.
	 * @param string $meta_key  Metadata key.
	 * @param string $meta_type Type of object metadata is for. Accepts 'post', 'comment', 'term', 'user',
	 *                          or any other object type with an associated meta table.
	 */
	public function is_protected_meta( $protected, $meta_key, $meta_type ) {
		if ( 'siqrp_meta' === $meta_key ) {
			return true;
		}
		return $protected;
	}
	/**
	 * Summary of load_default_options
	 *
	 * @return void
	 */
	private function load_default_options() {
		$this->default_options = array(
			'threshold'                           => 1,
			'limit'                               => SIQRP_DEFAULT_LIMIT,
			'result_count'                        => 10,
			'min_score'                           => 0.8,
			'excerpt_length'                      => 10,
			'recent'                              => false,
			'before_title'                        => '<li>',
			'after_title'                         => '</li>',
			'before_post'                         => ' <small>',
			'after_post'                          => '</small>',
			'before_related'                      => '<ol>',
			'after_related'                       => '</ol>',
			'no_results'                          => '<p>' . __( 'No related posts.', 'related-posts-by-searchiq' ) . '</p>',
			'order'                               => 'score DESC',
			'rss_limit'                           => SIQRP_DEFAULT_LIMIT,
			'rss_excerpt_length'                  => 10,
			'rss_before_title'                    => '<li>',
			'rss_after_title'                     => '</li>',
			'rss_before_post'                     => ' <small>',
			'rss_after_post'                      => '</small>',
			'rss_before_related'                  => '<h3>' . __( 'Related posts:', 'related-posts-by-searchiq' ) . '</h3><ol>',
			'rss_after_related'                   => '</ol>',
			'rss_no_results'                      => '<p>' . __( 'No related posts.', 'related-posts-by-searchiq' ) . '</p>',
			'rss_order'                           => 'score DESC',
			'past_only'                           => false,
			'show_excerpt'                        => false,
			'rss_show_excerpt'                    => false,
			'template'                            => SIQRP_DEFAULT_TEMPLATE,
			'rss_template'                        => false,
			'show_pass_post'                      => false,
			'cross_relate'                        => false,
			'include_sticky_posts'                => true,
			'generate_missing_thumbnails'         => false,
			'rss_display'                         => false,
			'rss_excerpt_display'                 => true,
			'credit_searchiq'                     => false,
			'rss_credit_searchiq'                 => false,
			'myisam_override'                     => false,
			'exclude'                             => '',
			'include_post_type'                   => get_post_types( array() ),
			'weight'                              => array(
				'title' => 0,
				'body'  => 0,
				'tax'   => array(
					'category' => 1,
					'post_tag' => 1,
				),
			),
			'require_tax'                         => array(),
			'optin'                               => false,
			'thumbnails_heading'                  => __( 'Related posts:', 'related-posts-by-searchiq' ),
			'thumbnails_default'                  => plugins_url( 'assets/images/default-thumbnail.png', SIQRP_BASE_FILE ),
			'rss_thumbnails_heading'              => __( 'Related posts:', 'related-posts-by-searchiq' ),
			'rss_thumbnails_default'              => plugins_url( 'assets/images/default-thumbnail.png', SIQRP_BASE_FILE ),
			'auto_display_archive'                => false,
			'auto_display_post_types'             => array( 'post' ),
			'pools'                               => array(),
			'manually_using_thumbnails'           => false,
			'rest_api_display'                    => true,
			'thumbnail_size_display'              => 0,
			'custom_theme_thumbnail_size_display' => 0,
			'thumbnail_size_feed_display'         => 0,
			'rest_api_client_side_caching'        => false,
			'siqrp_rest_api_cache_time'           => 15,
			'filtered_categories'                 => '',
			'filtered_tags'                       => '',
			'use_minimalistic'                    => '',
		);
	}
	/**
	 * Summary of set_option
	 *
	 * @param  mixed $options Which options to set.
	 * @param  mixed $value   Value for the option in case it is single.
	 * @return bool
	 */
	public function set_option( $options, $value = null ) {
		$current_options = $this->get_option();

		/* We can call siqrp_set_option(key,value) if we like. */
		if ( ! is_array( $options ) ) {
			if ( isset( $value ) ) {
				$options = array( $options => $value );
			} else {
				return false;
			}
		}

		$new_options = array_merge( $current_options, $options );
		$this->db->set_siqrp_options( $new_options );
	}

	/**
	 * Summary of get_option
	 *
	 * @param  mixed $option Which option_name to get.
	 * @return array|bool|float|int|mixed|string|null
	 */
	public function get_option( $option = null ) {
		$options = $this->db->get_siqrp_options();

		// ensure defaults if not set:.
		$options = array_merge( $this->default_options, $options );

		if ( is_null( $option ) ) {
			return $options;
		}

		$optionpath    = array();
		$parsed_option = array();
		wp_parse_str( $option, $parsed_option );
		$optionpath = $this->array_flatten( $parsed_option );

		$current = $options;
		foreach ( $optionpath as $optionpart ) {
			if ( ! is_array( $current ) || ! isset( $current[ $optionpart ] ) ) {
				return null;
			}
			$current = $current[ $optionpart ];
		}

		return $current;
	}
	/**
	 * Summary of get_sid
	 *
	 * @return mixed
	 */
	public function get_sid() {
		$sid = $this->db->get_siqrp_sid();
		if ( ! empty( $sid ) ) {
			return $sid;
		}
		return false;
	}
	/**
	 * Summary of set_sid
	 *
	 * @param  mixed $sid Value of sid to set.
	 * @return mixed
	 */
	public function set_sid( $sid ) {
		$this->db->set_siqrp_sid( $sid );
		$new_sid = $this->get_sid();
		if ( ! empty( $new_sid ) ) {
			return $new_sid;
		}
		return false;
	}
	/**
	 * Summary of array_flatten
	 *
	 * @param  mixed $array Array to flatten.
	 * @param  mixed $given Given value of the array.
	 * @return mixed
	 */
	private function array_flatten( $array, $given = array() ) {
		foreach ( $array as $key => $val ) {
			$given[] = $key;
			if ( is_array( $val ) ) {
				$given = $this->array_flatten( $val, $given );
			}
		}
		return $given;
	}

	/**
	 * Summary of activate
	 *
	 * @return bool
	 */
	public function activate() {
		if ( ! $this->db->plugin_version_in_db() ) {
			$this->db->update_plugin_version_in_db();
		} else {
			$this->upgrade();
		}

		return true;
	}
	/**
	 * Summary of thumbnail_dimensions
	 *
	 * @return mixed
	 */
	public function thumbnail_dimensions() {
		global $_wp_additional_image_sizes;
		if ( ! isset( $_wp_additional_image_sizes['siqrp-thumbnail'] ) ) {
			return $this->default_dimensions;
		}

		// get user selected thumbnail size..
		$dimensions = '';
		if ( empty( $dimensions ) ) {
			$dimensions         = $_wp_additional_image_sizes['siqrp-thumbnail'];
			$dimensions['size'] = 'siqrp-thumbnail';
		}

		/* Ensure SIQRP dimensions format: */
		$dimensions['width']  = (int) $dimensions['width'];
		$dimensions['height'] = (int) $dimensions['height'];
		return $dimensions;
	}
	/**
	 * Summary of maybe_enqueue_thumbnails_stylesheet
	 *
	 * @return void
	 */
	public function maybe_enqueue_thumbnails_stylesheet() {
		if ( is_feed() ) {
			return;
		}

		$auto_display_post_types = $this->get_option( 'auto_display_post_types' );

		/* If it's not an auto-display post type, return. */
		if ( ! in_array( get_post_type(), $auto_display_post_types ) ) {
			return;
		}

		if ( ! is_singular() && ! ( $this->get_option( 'auto_display_archive' ) && ( is_archive() || is_home() ) ) ) {
			return;
		}

		if ( $this->get_option( 'template' ) !== 'grid' ) {
			return;
		}

		$this->enqueue_thumbnails_stylesheet();
	}
	/**
	 * Summary of enqueue_thumbnails_stylesheet
	 *
	 * @return void
	 */
	public function enqueue_thumbnails_stylesheet() {

		wp_register_style( 'siqrp-thumbnails', plugins_url( '/assets/css/template-thumbnails.css', SIQRP_BASE_FILE ), array(), SIQRP_VERSION );
		wp_register_style( 'siqrpRelatedCss', plugins_url( '/assets/css/template-list.css', SIQRP_BASE_FILE ), array(), SIQRP_VERSION );

		wp_enqueue_style( 'siqrpRelatedCss' );
		wp_enqueue_style( 'siqrp-thumbnails' );
	}

	/**
	 * Summary of add_scripts_in_admin
	 *
	 * @return void
	 */
	public function add_scripts_in_admin() {
		wp_register_style( 'siqrpCoreCss', plugins_url( '/assets/css/core-style.css', SIQRP_BASE_FILE ), array(), SIQRP_VERSION );
		wp_enqueue_style( 'siqrpCoreCss' );
	}

	/**
	 * Get all the available templates
	 *
	 * @return array
	 */
	public function get_all_templates() {
		$block_templates = array(
			esc_attr( 'list' )    => esc_html__( 'List', 'related-posts-by-searchiq' ),
			esc_attr( 'grid' )    => esc_html__( 'Grid', 'related-posts-by-searchiq' ),
			esc_attr( 'minimal' ) => esc_html__( 'Minimal', 'related-posts-by-searchiq' ),
		);
		return $block_templates;
	}
	/**
	 * Summary of get_template_data
	 *
	 * @param  mixed $file Filename for template.
	 * @return mixed
	 */
	public function get_template_data( $file ) {
		$headers          = array(
			'name'        => 'SIQRP Template',
			'description' => 'Description',
			'author'      => 'Author',
			'uri'         => 'Author URI',
		);
		$data             = get_file_data( $file, $headers );
		$data['file']     = $file;
		$data['basename'] = basename( $file );

		if ( empty( $data['name'] ) ) {
			$data['name'] = $data['basename'];
		}

		return $data;
	}

	/**
	 * Summary of upgrade
	 *
	 * @return void
	 */
	public function upgrade() {
		$last_version = $this->db->plugin_version_in_db();

		if ( version_compare( SIQRP_VERSION, $last_version ) === 0 ) {
			return;
		}

		$this->db->update_plugin_version_in_db();
		$this->db->add_upgrade_flag();
		$this->delete_transient( 'siqrp_optin' );
	}

	/**
	 * Summary of post_types
	 *
	 * @var $post_type null
	 */
	private $post_types = null;

	/**
	 * Gets all the post types SIQRP can add related posts to, and the post types SIQRP can include in
	 * "the pool"
	 *
	 * @param string $field 'objects', or any property on WP_Post_Type, like 'name'. Defaults to 'name'.
	 *
	 * @return array|null
	 */
	public function get_post_types( $field = 'name' ) {
		if ( is_null( $this->post_types ) ) {
			$this->post_types = get_post_types( array(), 'objects' );
			$this->post_types = array_filter( $this->post_types, array( $this, 'post_type_filter' ) );
		}

		if ( 'objects' === $field ) {
			return $this->post_types;
		}

		return wp_list_pluck( $this->post_types, $field );
	}

	/**
	 * Gets the post types to use for the current SIQRP query
	 *
	 * @param  string|WP_Post $reference_id Reference ID or Post ID.
	 * @param  array          $args         Arguments.
	 * @return string[]
	 */
	public function get_query_post_types( $reference_id = null, $args = array() ) {
		$include_post_type = siqrp_get_option( 'include_post_type' );
		$include_post_type = wp_parse_list( $include_post_type );
		if ( isset( $args['post_type'] ) ) {
			$post_types = wp_parse_list( $args['post_type'] );
		} elseif ( ! $this->get_option( 'cross_relate' ) ) {
			$current_post_type = get_post_type( $reference_id );
			$post_types        = array( $current_post_type );
			if ( ! in_array( $current_post_type, $include_post_type ) ) {
				$post_types = array( '' );
			}
		} elseif ( ! empty( $include_post_type ) ) {
			$post_types = $include_post_type;
		} elseif ( $this->get_option( 'cross_relate' ) ) {
			$post_types = $this->get_post_types();
		} else {
			$post_types = array( get_post_type( $reference_id ) );
		}
		return apply_filters(
			'siqrp_map_post_types',
			$post_types,
			is_array( $args ) && isset( $args['domain'] ) ? $args['domain'] : null
		);
	}
	/**
	 * Summary of post_type_filter
	 *
	 * @param  mixed $post_type Name of the post_type.
	 * @return mixed
	 */
	private function post_type_filter( $post_type ) {
		// Remove blacklisted post types..
		if ( class_exists( 'bbPress' ) && in_array(
			$post_type->name,
			array(
				'forum', // bbPress forums (ie, group of topics)..
				'reply', // bbPress replies to topics.
			)
		)
		) {
			return false;
		}
		if ( $post_type->public ) {
			return true;
		}
		if ( isset( $post_type->siqrp_support ) ) {
			return $post_type->siqrp_support;
		}
		return false;
	}
	/**
	 * Summary of taxonomies
	 *
	 * @var $taxonomies Array of the taxonomies.
	 */
	private $taxonomies = null;
	/**
	 * Summary of get_taxonomies
	 *
	 * @param  mixed $field Boolean Field.
	 * @return mixed
	 */
	public function get_taxonomies( $field = false ) {
		if ( is_null( $this->taxonomies ) ) {
			$this->taxonomies = get_taxonomies( array(), 'objects' );
			$this->taxonomies = array_filter( $this->taxonomies, array( $this, 'taxonomy_filter' ) );
		}

		if ( $field ) {
			return wp_list_pluck( $this->taxonomies, $field );
		}

		return $this->taxonomies;
	}

	/**
	 * Summary of taxonomy_filter
	 *
	 * @param  mixed $taxonomy Filter taxonomy.
	 * @return mixed
	 */
	private function taxonomy_filter( $taxonomy ) {
		if ( ! count( array_intersect( $taxonomy->object_type, $this->get_post_types() ) ) ) {
			return false;
		}

		// if siqrp_support is set, follow that; otherwise include if show_ui is true..
		if ( isset( $taxonomy->siqrp_support ) ) {
			return $taxonomy->siqrp_support;
		}

		return $taxonomy->show_ui;
	}

	/**
	 * Gather optin data.
	 *
	 * @return array
	 */
	public function optin_data() {
		global $wpdb;

		$comments = wp_count_comments();
		$users    = $wpdb->get_var( 'SELECT COUNT(ID) FROM ' . $wpdb->users ); // count_users();.
		$posts    = $wpdb->get_var( 'SELECT COUNT(ID) FROM ' . $wpdb->posts . " WHERE post_type = 'post' AND comment_count > 0" );
		$settings = $this->get_option();

		$collect = array_flip(
			array(
				'threshold',
				'limit',
				'excerpt_length',
				'recent',
				'rss_limit',
				'rss_excerpt_length',
				'past_only',
				'show_excerpt',
				'rss_show_excerpt',
				'template',
				'rss_template',
				'show_pass_post',
				'cross_relate',
				'generate_missing_thumbnails',
				'include_sticky_posts',
				'rss_display',
				'rss_excerpt_display',
				'credit_searchiq',
				'rss_credit_searchiq',
				'myisam_override',
				'weight',
				'require_tax',
				'auto_display_archive',
				'exclude',
				'include_post_type',
			)
		);

		$check_changed = array(
			'before_title',
			'after_title',
			'before_post',
			'after_post',
			'after_related',
			'no_results',
			'order',
			'rss_before_title',
			'rss_after_title',
			'rss_before_post',
			'rss_after_post',
			'rss_after_related',
			'rss_no_results',
			'rss_order',
			'exclude',
			'thumbnails_heading',
			'thumbnails_default',
			'rss_thumbnails_heading',
			'rss_thumbnails_default',
		);

		$data = array(
			'versions'    => array(
				'siqrp' => SIQRP_VERSION,
				'wp'    => get_bloginfo( 'version' ),
				'php'   => phpversion(),
			),
			'siqrp'       => array(
				'settings'     => array_intersect_key( $settings, $collect ),
				'cache_engine' => 'none',
			),
			'diagnostics' => array(
				'myisam_posts'        => '',
				'fulltext_indices'    => '',
				'hidden_metaboxes'    => '',
				'post_thumbnails'     => '',
				'happy'               => '',
				'using_thumbnails'    => '',
				'generate_thumbnails' => '',
			),
			'stats'       => array(
				'counts'   => array(),
				'terms'    => array(),
				'comments' => array(
					'moderated' => $comments->moderated,
					'approved'  => $comments->approved,
					'total'     => $comments->total_comments,
					'posts'     => $posts,
				),
				'users'    => $users,
			),
			'locale'      => get_bloginfo( 'language' ),
			'url'         => get_bloginfo( 'url' ),
			'plugins'     => array(
				'active'   => implode( '|', get_option( 'active_plugins', array() ) ),
				'sitewide' => implode( '|', array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) ),
			),
			'pools'       => $settings['pools'],
		);

		$data['siqrp']['settings']['auto_display_post_types'] = implode( '|', $settings['auto_display_post_types'] );

		$changed = array();
		foreach ( $check_changed as $key ) {
			if ( $this->default_options[ $key ] !== $settings[ $key ] ) {
				$changed[] = $key;
			}
		}

		foreach ( array( 'before_related', 'rss_before_related' ) as $key ) {
			if ( '<p>' . __( 'Related posts:', 'related-posts-by-searchiq' ) . '</p><ol>' !== $settings[ $key ]
				&& $settings[ $key ] !== $this->default_options[ $key ]
			) {
				$changed[] = $key;
			}
		}

		$data['siqrp']['changed_settings'] = implode( '|', $changed );

		if ( method_exists( $wpdb, 'db_version' ) ) {
			$data['versions']['mysql'] = preg_replace( '/[^0-9.].*/', '', $wpdb->db_version() );
		}

		$counts = array();
		foreach ( get_post_types( array( 'public' => true ) ) as $post_type ) {
			$counts[ $post_type ] = wp_count_posts( $post_type );
		}

		$data['stats']['counts'] = wp_list_pluck( $counts, 'publish' );

		foreach ( get_taxonomies( array( 'public' => true ) ) as $taxonomy ) {
			$data['stats']['terms'][ $taxonomy ] = wp_count_terms( $taxonomy );
		}

		if ( is_multisite() ) {
			$data['multisite'] = array(
				'url'   => network_site_url(),
				'users' => get_user_count(),
				'sites' => get_blog_count(),
			);
		}

		return $data;
	}

	/**
	 * CORE LOOKUP + DISPLAY FUNCTIONS
	 */
	protected function display_basic() {
		/* if it's not an auto-display post type, return */
		if ( ! in_array( get_post_type(), $this->get_option( 'auto_display_post_types' ) ) ) {
			return null;
		}

		if ( ! is_singular() && ! ( $this->get_option( 'auto_display_archive' ) && ( is_archive() || is_home() ) ) ) {
			return null;
		}
		// If we're only viewing a single post with page breaks, only show SIQRP on the last page..
		global $page, $pages;
		if ( is_singular() && is_int( $page ) && is_array( $pages ) && $page < count( $pages ) ) {
			return null;
		}
		return $this->display_related(
			null,
			array(
				'domain' => 'website',
			),
			false
		);
	}

	/**
	 * Display related posts
	 *
	 * @param  integer $reference_id Reference ID or Post ID.
	 * @param  array   $args         see readme.txt's installation tab's  "SIQRP functions()" section.
	 * @param  bool    $echo         Whether to print the output.
	 * @return string
	 */
	public function display_related( $reference_id = null, $args = array(), $echo = true ) {
		if ( empty( $this->sid ) ) {
			if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_admin() ) {
				return "<div class='update-nag notice notice-error inline'>Please complete your Partner ID setup in order to start using the plugin. <a class='goto-partner-setup' href='" . esc_url( admin_url( 'admin.php?page=siqrp' ) ) . "'><b>Setup Partner ID</b></a></div>";
			} else {
				return '';
			}
		}

		// Avoid infinite recursion here..
		if ( $this->do_not_query_for_related() ) {
			return false;
		}
		// Custom templates require .php extension..
		if ( isset( $args['template'] ) && $args['template'] ) {
			// Normalize parameter..
			if ( ( strpos( $args['template'], 'siqrp-template-' ) === 0 ) && ( strpos( $args['template'], '.php' ) === false ) ) {
				$args['template'] .= '.php';
			}
		}
		wp_register_style( 'siqrpRelatedCss', plugins_url( '/assets/css/template-list.css', SIQRP_BASE_FILE ), array(), SIQRP_VERSION );
		/**
		 * Filter to allow dequeing of related.css.
		 *
		 * @param boolean default true
		 */
		$enqueue_related_style = apply_filters( 'siqrp_enqueue_related_style', true );

		if ( true === $enqueue_related_style ) {
			wp_enqueue_style( 'siqrpRelatedCss' );
		}

		if ( is_numeric( $reference_id ) ) {
			$reference_id = (int) $reference_id;
		} else {
			$reference_id = get_the_ID();
		}

		if ( ! $this->check_if_post_is_filtered( $reference_id ) ) {
			if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_admin() ) {
				return "<div class='update-nag notice notice-error inline'>Related posts only show on posts that belong to categories or tags selected in SearchIQ Related Posts Settings. <a class='goto-plugin-settings' href='" . esc_url( admin_url( 'admin.php?page=siqrp' ) ) . "'><b>Go to settings</b></a></div>";
			} else {
				return '';
			}
		}
		$this_post = get_post( $reference_id );
		$this->check_if_block_in_content( $this_post, self::$count_blocks );
		++self::$count_blocks;

		$output          = '';
		$remote_has_data = $this->fetch_related_posts( $this_post, $args );
		if ( $remote_has_data ) {
			$output .= $this->get_template_content( $reference_id, $args );
		}
		if ( 'shortcode' == $args['domain'] ) {
			if ( array_key_exists( 'limit', $args ) ) {
				self::$block_post_count_offset += $args['limit'];
			} else {
				$optin_data                     = $this->optin_data();
				self::$block_post_count_offset += ( is_array( $optin_data ) && array_key_exists( 'siqrp', $optin_data ) ? $optin_data['siqrp']['settings']['limit'] : $this->default_options['limit'] );
			}
		}
		$this->rendering_related_content = false;

		if ( $echo ) {
			echo wp_kses( $output, $this->kses_allowed_html_config );
		}
		return $output;
	}

	/**
	 * Summary of check_if_block_in_content
	 *
	 * @param  mixed $post         Post object.
	 * @param  mixed $count_blocks Block count.
	 * @return void
	 */
	private function check_if_block_in_content( $post, $count_blocks ) {
		$blocks       = parse_blocks( $post->post_content );
		$siqrp_blocks = array();
		foreach ( $blocks as $block ) {
			// SIQRP's block name.
			if ( 'siqrp/siqrp-block' === $block['blockName'] ) {
				array_push( $siqrp_blocks, $block );
			}
		}
		$current_block = $count_blocks - 1;
		if ( array_key_exists( $current_block, $siqrp_blocks ) ) {
			if ( array_key_exists( 'attrs', $siqrp_blocks[ $current_block ] ) && array_key_exists( 'limit', $siqrp_blocks[ $current_block ]['attrs'] ) ) {
				self::$block_post_count_offset += (int) $siqrp_blocks[ $current_block ]['attrs']['limit'];
			} else {
				self::$block_post_count_offset += (int) SIQRP_DEFAULT_LIMIT;
			}
		}
	}
	/**
	 * Summary of fetch_related_posts
	 *
	 * @param  mixed $this_post Post Object.
	 * @param  mixed $args      POST Args.
	 * @return bool
	 */
	private function fetch_related_posts( $this_post, $args ) {
		$optin_data                = $this->optin_data();
		$this->related_posts_count = isset( $args['limit'] ) ? $args['limit'] : ( is_array( $optin_data ) && array_key_exists( 'siqrp', $optin_data ) ? $optin_data['siqrp']['settings']['limit'] : $this->default_options['limit'] );
		if ( 0 == (int) $this->related_posts_count ) {
			$this->related_posts_count = $this->default_options['limit'];
		}
		if ( null !== self::$related_posts_data ) {
			return true;
		}

		$options = $this->get_option();

		$endpoint  = '/recommend';
		$method    = 'POST';
		$data_args = array(
			'method' => $method,
		);

		$params['pageTitle'] = $this_post->post_title;
		// $params['pageDescription'] = !empty($this_post->post_excerpt) ? $this_post->post_excerpt : wp_trim_words(wp_strip_all_tags($this_post->post_content, true), 75,"");.
		// $params['minRelevanceScore'] = $options['min_score'];.
		$params['count'] = $options['result_count'];
		if ( 'GET' == $method ) {
			$params['text'] = $params['pageTitle'];
			unset( $params['pageTitle'] );
			unset( $params['pageDescription'] );
		}
		$data_args['params'] = $params;
		include_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-api.php';
		$api = new SIQRP_API();
		try {
			$response = $api->call( $data_args, $endpoint );
			if ( array_key_exists( 'response_code', $response ) && 200 == $response['response_code'] ) {
				self::$related_posts_data = $response['response_body'];
				return true;
			}
		} catch ( Exception $e ) {
			$this->api_exception = true;
		}
		return false;
	}
	/**
	 * Summary of validate_sid
	 *
	 * @param  mixed $sid Sid.
	 * @return mixed
	 */
	public function validate_sid( $sid ) {
		$endpoint            = '/validate';
		$method              = 'POST';
		$data_args           = array(
			'method' => $method,
		);
		$params['sid']       = $sid;
		$data_args['params'] = $params;
		include_once SIQRP_BASE_DIR . '/library/classes/class-siqrp-api.php';
		$api = new SIQRP_API();
		try {
			$response = $api->call( $data_args, $endpoint );
			if ( array_key_exists( 'response_code', $response ) ) {
				if ( 200 == $response['response_code'] ) {
					return true;
				} else {
					return false;
				}
			}
		} catch ( Exception $e ) {
			$this->api_exception = true;
		}
		return false;
	}
	/**
	 * Returns the SIQRP template html data.
	 *
	 * @param  int   $reference_id reference id.
	 * @param  array $args         see readme.txt installation tab's  "SIQRP functions()" section.
	 * @param  bool  $is_demo      whether to add siqrp-demo-related class to div or not.
	 * @return string return html data.
	 */
	protected function get_template_content( $reference_id = null, $args = array(), $is_demo = false ) {
		// make $related_query available to custom templates. It may be in use by old custom templates.
		global $wp_query;

		$options = array(
			'domain',
			'template',
			'credit_searchiq',
			'extra_css_class',
		);

     // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $this->parse_args( $args, $options ) );

		// CSS class "siqrp-related" exists for backwards compatibility in-case older custom themes are dependent on it..
		$output = "<div class='siqrp siqrp-related";
		if ( $is_demo ) {
			$output .= ' siqrp-demo-related';
		}

		if ( true === $this->after_content ) {
			$output .= ' siqrp-after-content';
			if ( 'yes' == siqrp_get_option( 'use_minimalistic' ) ) {
				$template = 'minimal';
			}
		} else {
			$output .= ' siqrp-within-content';
		}

		// Add CSS class to identify domain..
		if ( isset( $domain ) && $domain ) {
			$domain  = esc_attr( $domain );
			$output .= " siqrp-related-{$domain}";
		}

		// Add CSS class to identify template..
		if ( isset( $template ) && $template ) {

			// Normalize "grid" and "grid" to reference the same inbuilt template.
			if ( 'grid' === $template ) {
				$template = 'grid';
			}
			// Sanitize template name; remove file extension if exists.

			// avoid any monkeying around where someone could try a custom template like a template name like.
			// "siqrp-template-;../../wp-config.php". SIQRP custom templates are only supported in the theme's root folder..
			$template = sanitize_file_name( $template );

			if ( strpos( $template, '.php' ) ) {
				$template_css_class_suffix = preg_replace( '/' . preg_quote( '.php', '/' ) . '$/', '', $template );
			} else {
				$template_css_class_suffix = $template;
			}
			$output .= " siqrp-template-$template_css_class_suffix";
		} else {
			// fallback to default template ("list").
			$output .= ' siqrp-template-list';
		}

		// Add any extra CSS classes specified (blocks).
		if ( isset( $extra_css_class ) && $extra_css_class ) {
			$extra_css_class = esc_attr( $extra_css_class );
			$output         .= " $extra_css_class";
		}

		$output .= "'";
		$output .= " id='siqrp-block-id-" . self::$count_blocks;
		$output .= "' >\n";

		$this->enqueue_thumbnails_stylesheet();
		if ( (bool) $template && 'grid' === $template ) {
			include SIQRP_BASE_DIR . '/includes/templates/grid.php';
		} elseif ( (bool) $template && 'list' === $template ) {
			include SIQRP_BASE_DIR . '/includes/templates/list.php';
		} elseif ( (bool) $template && 'minimal' === $template ) {
			include SIQRP_BASE_DIR . '/includes/templates/minimal.php';
		} elseif ( (bool) $template ) {
			$named_properly  = strpos( $template, 'siqrp-template-' ) === 0;
			$template_exists = file_exists( get_stylesheet_directory() . '/' . $template );
			if ( $named_properly && $template_exists ) {
				global $post;
				ob_start();
				include get_stylesheet_directory() . '/' . $template;
				$output .= ob_get_contents();
				ob_end_clean();
			} else {
				include SIQRP_BASE_DIR . '/includes/templates/list.php';
			}
		} elseif ( 'widget' === $domain ) {
			include SIQRP_BASE_DIR . '/includes/templates/widget.php';
		} else {
			include SIQRP_BASE_DIR . '/includes/templates/list.php';
		}

		$output = trim( $output ) . "\n";

		$output .= "</div>\n";

		return $output;
	}


	/**
	 * Create an array whose keys come from $options, and whose values are either their values in $args or the option's
	 * default value.
	 * Any keys from $args that aren't in $options are ignored and not included in the returned result.
	 *
	 * @param array $args    inputted arguments.
	 * @param array $options names of arguments to consider.
	 *
	 * @return array with all the keys from the list of $options, with their values
	 * from $args or the options' default values.
	 */
	public function parse_args( $args, $options ) {
		$options_with_rss_variants = array(
			'limit',
			'template',
			'excerpt_length',
			'before_title',
			'after_title',
			'before_post',
			'after_post',
			'before_related',
			'after_related',
			'no_results',
			'order',
			'credit_searchiq',
			'thumbnails_heading',
			'thumbnails_default',
		);

		if ( ! isset( $args['domain'] ) ) {
			$args['domain'] = 'website';
		}

		// Validate "limit" arg; Use only if numeric value, otherwise use default value..
		if ( isset( $args['limit'] ) && $args['limit'] ) {
			if ( filter_var( $args['limit'], FILTER_VALIDATE_INT ) !== false ) {
				$args['limit'] = (int) $args['limit'];
			} else {
				unset( $args['limit'] );
			}
		}

		$r = array();
		foreach ( $options as $option ) {
			if ( 'rss' === $args['domain']
				&& in_array( $option, $options_with_rss_variants )
			) {
				$default = $this->get_option( 'rss_' . $option );
			} else {
				$default = $this->get_option( $option );
			}

			if ( isset( $args[ $option ] ) && $args[ $option ] !== $default ) {
				$r[ $option ] = $args[ $option ];
			} else {
				$r[ $option ] = $default;
			}

			if ( 'weight' === $option && ! isset( $r[ $option ]['tax'] ) ) {
				$r[ $option ]['tax'] = array();
			}
		}
		return $r;
	}


	/**
	 * Return true if user disabled the SIQRP related post for the current post, false otherwise.
	 *
	 * @return bool
	 */
	public function siqrp_disabled_for_this_post() {
		global $post;

		if ( $post instanceof WP_Post ) {
			$siqrp_meta = get_post_meta( $post->ID, 'siqrp_meta', true );
			if ( isset( $siqrp_meta['siqrp_display_for_this_post'] ) && 0 === (int) $siqrp_meta['siqrp_display_for_this_post'] ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Summary of is_nosiqrp
	 *
	 * @param  mixed $content Post Content.
	 * @return mixed
	 */
	public function is_nosiqrp( $content ) {
		/*
		* Before automatically adding SIQRP's related posts onto a post's content, checks the value of the
		* "siqrp_meta" postmeta's key "siqrp_display_for_this_post", and whether the post's content contains
		* the magic comment "<!--nosiqrp-->"`. If either one of those is true `$nosiqrp` will be true, otherwise false.
		*/
		$nosiqrp = $this->siqrp_disabled_for_this_post();   // post meta flag..
		if ( strpos( $content, '<!--nosiqrp-->' ) !== false ) {
			$nosiqrp = true;    // does content includes <!--nosiqrp--> ?.
		}
		/**
		 * Filters whether or not to disable adding SIQRP's related posts on the current post.
		 *
		 * Note: the global `$post` will be populated with the current post, if needed.
		 *
		 * @param bool $nosiqrp true indicates that SIQRP should be disabled on the post; false indicates it should be shown.
		 * @param string $content post's content
		 */
		$nosiqrp = apply_filters( 'siqrp_nosiqrp', $nosiqrp, $content );

		return $nosiqrp;
	}

	/**
	 * DEFAULT CONTENT FILTERS
	 *
	 * @param mixed $content Post Content.
	 */
	public function the_content( $content ) {
		// Avoid infinite recursion..
		global $post;
		if ( is_feed() || $this->do_not_query_for_related() ) {
			return $content;
		}

		// Disable Automatic Display?.
		if ( true === $this->is_nosiqrp( $content ) ) {
			return $content;
		}
		if ( empty( $this->sid ) ) {
			if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_admin() ) {
				return $content .= "<div class='update-nag notice notice-error inline'>Please complete your Partner ID setup in order to start using the plugin. <a class='goto-partner-setup' href='" . esc_url( admin_url( 'admin.php?page=siqrp' ) ) . "'><b>Setup Partner ID</b></a></div>";
			} else {
				return $content;
			}
		}
		if ( is_object( $post ) && ! $this->check_if_post_is_filtered( $post->ID ) ) {
			if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || is_admin() ) {
				return $content .= "<div class='update-nag notice notice-error inline'>Related posts only show on posts that belong to categories or tags selected in SearchIQ Related Posts Settings. <a class='goto-plugin-settings' href='" . esc_url( admin_url( 'admin.php?page=siqrp' ) ) . "'><b>Go to settings</b></a></div>";
			} else {
				return $content;
			}
		}
		$this->after_content = true;
		$content            .= $this->display_basic();
		return $content;
	}



	/**
	 * A version of the transient functions which is unaffected by caching plugin behavior.
	 * We want to control the lifetime of data.
	 *
	 * @param  int $transient Transient Name.
	 * @return bool
	 */
	private function get_transient( $transient ) {
		$transient_timeout = $transient . '_timeout';

		if ( intval( get_option( $transient_timeout ) ) < time() ) {
			delete_option( $transient_timeout );
			return false; // timed out..
		}

		return get_option( $transient, true ); // still ok..
	}
	/**
	 * Summary of set_transient
	 *
	 * @param  mixed $transient  Name of transient.
	 * @param  mixed $data       Data for transient.
	 * @param  mixed $expiration Expiration seconds.
	 * @return void
	 */
	private function set_transient( $transient, $data = null, $expiration = 0 ) {
		$transient_timeout = $transient . '_timeout';

		if ( get_option( $transient_timeout ) === false ) {

			add_option( $transient_timeout, time() + $expiration, '', 'no' );
			if ( ! is_null( $data ) ) {
				add_option( $transient, $data, '', 'no' );
			}
		} else {

			update_option( $transient_timeout, time() + $expiration );
			if ( ! is_null( $data ) ) {
				update_option( $transient, $data );
			}
		}
	}
	/**
	 * Summary of delete_transient
	 *
	 * @param  mixed $transient Transient key to delete.
	 * @return void
	 */
	private function delete_transient( $transient ) {
		delete_option( $transient );
		delete_option( $transient . '_timeout' );
	}

	/**
	 * Summary of clean_pre
	 *
	 * @param  mixed $text Text to clean.
	 * @return array|string
	 */
	public function clean_pre( $text ) {
		$text = str_replace( array( '<br />', '<br/>', '<br>' ), array( '', '', '' ), $text );
		$text = str_replace( '<p>', "\n", $text );
		$text = str_replace( '</p>', '', $text );
		return $text;
	}

	/**
	 * Gets the list of valid interval units used by SIQRP and MySQL interval statements.
	 *
	 * @return array keys are valid values for recent units, and for MySQL interval
	 * (see https://www.mysqltutorial.org/mysql-interval/), values are translated strings
	 */
	public function recent_units() {
		return array(
			'day'   => __( 'day(s)', 'related-posts-by-searchiq' ),
			'week'  => __( 'week(s)', 'related-posts-by-searchiq' ),
			'month' => __( 'month(s)', 'related-posts-by-searchiq' ),
		);
	}

	/**
	 * Adds SIQRP's content to bbPress topics.
	 */
	public function add_to_bbpress() {
		echo wp_kses( $this->display_basic(), $this->kses_allowed_html_config );
	}

	/**
	 * Checks if it's an appropriate time to look for related posts, or if we should skip that.
	 *
	 * @return bool
	 */
	protected function do_not_query_for_related() {
		return $this->rendering_related_content;
	}

	/**
	 * Summary of check_if_post_is_filtered
	 *
	 * @param  mixed $post_id Post ID to check.
	 * @return bool
	 */
	private function check_if_post_is_filtered( $post_id ) {
		if ( get_post_type( $post_id ) != 'post' ) {
			return true; // Post type not equal to post will not have any categories and tags.
		}

		$filtered_categories = siqrp_get_option( 'filtered_categories' );
		$filtered_tags       = siqrp_get_option( 'filtered_tags' );

		$all_categories = ( 'all' === $filtered_categories );
		$all_tags       = ( 'all' === $filtered_tags );

		if ( $all_categories || $all_tags ) {
			return true; // All categories and tags are allowed.
		}

		$post_categories = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
		$post_tags       = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );

		if ( ! $all_categories && ! empty( $filtered_categories ) ) {
			$filtered_categories = explode( ',', $filtered_categories );
			if ( array_intersect( $filtered_categories, $post_categories ) ) {
				return true; // Found similar categories.
			}
		}

		if ( ! $all_tags && ! empty( $filtered_tags ) ) {
			$filtered_tags = explode( ',', $filtered_tags );
			if ( array_intersect( $filtered_tags, $post_tags ) ) {
				return true; // Found similar tags.
			}
		}

		return false;
	}

	/**
	 * Summary of add_custom_css_to_header
	 *
	 * @return void
	 */
	public function add_custom_css_to_header() {
		global $post;
		$custom_css = get_site_option( '_siqrp_custom_css', '' );
		if ( is_single() && isset( $post ) && ! empty( $post->ID ) ) {
			$custom_post_css = get_post_meta( $post->ID, '_siqrp_custom_css', true );
			if ( ! empty( $custom_post_css ) ) {
				$custom_css .= "\n" . $custom_post_css;
			}
		}
		if ( ! empty( $custom_css ) ) {
			wp_enqueue_style( 'siqrp-custom-css', plugins_url( '/assets/css/custom-style.css', SIQRP_BASE_FILE ), array(), SIQRP_VERSION );
			wp_add_inline_style( 'siqrp-custom-css', wp_strip_all_tags( $custom_css ) );
		}
	}
	/**
	 * Summary of add_siqrp_filter_url
	 *
	 * @param  mixed $url URL to check.
	 * @return mixed
	 */
	public function add_siqrp_filter_url( $url ) {
		if ( strpos( $url, 'utm_source' ) === false ) {
			$bind = '?';
			if ( strpos( $url, $bind ) !== false ) {
				$bind = '&';
			}
			$domain_name = $this->clean_site_url( get_site_url() );
			$url        .= $bind . 'utm_source=' . $domain_name;
		}
		return $url;
	}
	/**
	 * Summary of clean_site_url
	 *
	 * @param  mixed $url URL to clean.
	 * @return array|bool|int|string|null
	 */
	private function clean_site_url( $url ) {
		return parse_url( $url, PHP_URL_HOST );
	}

	/**
	 * Summary of siq_admin_validated_scripts
	 *
	 * @return void
	 */
	public function siq_admin_validated_scripts() {
		global $current_screen;
		if ( ! empty( $current_screen ) && 'toplevel_page_siqrp' == $current_screen->base ) {
			$redirect_screen_url = get_admin_url( null, 'admin.php?page=siqrp' );
			echo '<script type="text/javascript">
				if(document.getElementById("partner-validated") != undefined ){
					console.log("Partner ID found");
					document.addEventListener(\'DOMContentLoaded\', (event) => {
						let counter = 5;
						const element = document.getElementById(\'update-seconds\');
						element.textContent = counter;

						const intervalId = setInterval(() => {
							if (counter > 1) {
								counter--;
								element.textContent = counter;
							} else {
								window.location.href = "' . esc_url( $redirect_screen_url ) . '";
								clearInterval(intervalId);
							}
						}, 1000);
					});
				}
			</script>';
		}
	}
}
