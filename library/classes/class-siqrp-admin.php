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
 * Summary of SIQRP_Admin
 */
class SIQRP_Admin {


	/**
	 * Summary of core
	 *
	 * @var core Core.
	 */
	public $core;

	/**
	 * Summary of hook
	 *
	 * @var hook
	 */
	public $hook;

	const ACTIVATE_TIMESTAMP_OPTION = 'siqrp_activate_timestamp';
	const REVIEW_DISMISS_OPTION     = 'siqrp_review_notice';
	const REVIEW_FIRST_PERIOD       = 518400; // 6 days in seconds.
	const REVIEW_LATER_PERIOD       = 5184000; // 60 days in seconds.
	const REVIEW_FOREVER_PERIOD     = 63113904; // 2 years in seconds.


	/**
	 * Summary of __construct
	 *
	 * @param mixed $core parameter core.
	 */
	public function __construct( &$core ) {
		$this->core = &$core;
		add_action( 'admin_init', array( $this, 'ajax_register' ) );
		add_action( 'admin_init', array( $this, 'review_register' ) );
		add_action( 'admin_menu', array( $this, 'ui_register' ) );
		add_action( 'save_post', array( $this, 'siqrp_save_meta_box' ) );

		add_filter( 'current_screen', array( $this, 'settings_screen' ) );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'default_hidden_meta_boxes' ), 10, 2 );
		add_filter( 'siqrp_deactivate_feedback_form_plugins', array( $this, 'deactivation_survey_data' ) );
	}


	/**
	 * Register Review notice
	 */
	public function review_register() {
		self::check_review_dismissal();
		self::check_plugin_review();
	}

	/**
	 * Check review notice status for current user
	 */
	public static function check_review_dismissal() {

		global $current_user;
		$user_id = $current_user->ID;

		if ( ! is_admin()
			|| ! isset( $_GET['_wpnonce'] )
			|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'review-nonce' )
			|| ! isset( $_GET['siqrp_defer_t'] )
			|| ! isset( $_GET[ self::REVIEW_DISMISS_OPTION ] )
		) {
			return;
		}

		$the_meta_array = array(
			'dismiss_defer_period' => sanitize_text_field( wp_unslash( $_GET['siqrp_defer_t'] ) ),
			'dismiss_timestamp'    => time(),
		);

		update_user_meta( $user_id, self::REVIEW_DISMISS_OPTION, $the_meta_array );
	}

	/**
	 * Check if we should display the review notice
	 */
	public static function check_plugin_review() {

		global $current_user;
		$user_id = $current_user->ID;

		if ( ! current_user_can( 'publish_posts' ) ) {
			return;
		}

		$show_review_notice     = false;
		$activation_timestamp   = get_site_option( self::ACTIVATE_TIMESTAMP_OPTION );
		$review_dismissal_array = get_user_meta( $user_id, self::REVIEW_DISMISS_OPTION, true );
		$dismiss_defer_period   = isset( $review_dismissal_array['dismiss_defer_period'] ) ? $review_dismissal_array['dismiss_defer_period'] : 0;
		$dismiss_timestamp      = isset( $review_dismissal_array['dismiss_timestamp'] ) ? $review_dismissal_array['dismiss_timestamp'] : time();

		if ( $dismiss_timestamp + $dismiss_defer_period <= time() ) {
			$show_review_notice = true;
		}

		if ( ! $activation_timestamp ) {
			$activation_timestamp = time();
			add_site_option( self::ACTIVATE_TIMESTAMP_OPTION, $activation_timestamp );
		}

		// display review message after a certain period of time after activation.
		if ( ( time() - $activation_timestamp > self::REVIEW_FIRST_PERIOD ) && true == $show_review_notice ) {
			add_action( 'admin_notices', array( 'SIQRP_Admin', 'display_review_notice' ) );
		}
	}

	/**
	 * Summary of display_review_notice
	 *
	 * @return void
	 */
	public static function display_review_notice() {
		// todo ms: Add Review Notices Code.
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function ui_register() {
		global $wp_version;

		if ( $this->core->db->after_activation() ) {

			$this->core->db->delete_activation_flag();
			$this->core->db->delete_upgrade_flag();

			/* Optin/Pro message */
			add_action( 'admin_notices', array( $this, 'install_notice' ) );

		} elseif ( $this->core->db->after_upgrade() && current_user_can( 'manage_options' ) && $this->core->get_option( 'optin' ) ) {
			add_action( 'admin_notices', array( $this, 'upgrade_notice' ) );
		}

		if ( $this->core->get_option( 'optin' ) ) {
			$this->core->db->delete_upgrade_flag();
		}

		/*
		* Setup Admin
		*/
		$title_name = 'Related Posts';
		$this->hook = add_menu_page( $title_name, $title_name, 'manage_options', 'siqrp', array( $this, 'options_page' ), plugins_url( '/assets/images/siq_icon.png', SIQRP_BASE_FILE ) );

		/**
		* Filter for plugin action hooks.
		*/
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );

		$metabox_post_types = $this->core->get_option( 'auto_display_post_types' );
		if ( ! in_array( 'post', $metabox_post_types ) ) {
			$metabox_post_types[] = 'post';
		}

		foreach ( $metabox_post_types as $post_type ) {
			$title = __( 'SearchIQ Related Posts', 'related-posts-by-searchiq' );
			add_meta_box( 'siqrp_relatedposts', $title, array( $this, 'metabox' ), $post_type, 'normal' );
		}

		/**
		* Enqueue the scripts in admin.
		*/
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @param  [type] $current_screen Get the current screen name.
	 * @return mixed $curren_screen
	 */
	public function settings_screen( $current_screen ) {
		if ( 'toplevel_page_siqrp' !== $current_screen->id && 'siqrp_display_sid_form' !== $current_screen->id ) {
			return $current_screen;
		}

		/**
		* Include the meta boxes.
		*/
		include_once SIQRP_BASE_DIR . '/includes/siqrp-meta-boxes-hooks.php';

		return $current_screen;
	}

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $readme = null;

	/**
	 * Undocumented function
	 *
	 * @param  [type]  $msg  What should be the message.
	 * @param  boolean $echo Do we need to print the message.
	 * @return mixed
	 */
	public function the_donothing_button( $msg, $echo = false ) {
		$out = '<a href="admin.php?page=siqrp" class="button">' . $msg . '</a>';
		if ( $echo ) {
			echo esc_attr( $out );
			return null;
		} else {
			return $out;
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function upgrade_notice() {
		$optin_action = ( $this->core->get_option( 'optin' ) ) ? 'disable' : 'enable';
		$this->optin_notice( 'upgrade', $optin_action );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function install_notice() {
		$optin_action = ( $this->core->get_option( 'optin' ) ) ? 'disable' : 'enable';
		$this->optin_notice( 'install', $optin_action );
	}

	/**
	 * Undocumented function
	 *
	 * @param  boolean $type         Boolean Type.
	 * @param  string  $optin_action Is optin disabled.
	 * @return void
	 */
	public function optin_notice( $type = false, $optin_action = 'disable' ) {
		global $siqrp;
		$screen = get_current_screen();
		if ( is_null( $screen ) || 'toplevel_page_siqrp' == $screen->id || 'siqrp_display_sid_form' == $screen->id ) {
			return;
		}

		switch ( $type ) {
			case 'upgrade':
				$this->core->db->delete_upgrade_flag();
				break;
			case 'install':
			default:
				$user = get_current_user_id();
				update_user_option( $user, 'siqrp_saw_optin', true );
		}

		$out = '<div class="updated fade"><p>';

		if ( 'upgrade' === $type ) {
			/* translators: %1$s is replaced with the name of the plugin */
			$out .= '<strong>' . sprintf( __( '%1$s updated successfully.', 'related-posts-by-searchiq' ), 'Related Posts By SearchIQ' ) . '</strong>';
		}

		if ( 'install' === $type ) {
			$tmp  = __( 'Thank you for installing <span>Related Posts By SearchIQ</span>!', 'related-posts-by-searchiq' );
			$out .= '<strong>' . str_replace( '<span>', '<span style="font-style:italic; font-weight: inherit;">', $tmp ) . '</strong>';
		}
		$out .= '</div>';
		echo wp_kses( $out, $siqrp->kses_allowed_html_config );
	}

	/**
	 * Undocumented function
	 *
	 * @param  [type] $text
	 * @return void
	 */
	// faux-markdown, required for the help text rendering.

	/**
	 * Summary of markdown
	 *
	 * @param  mixed $text Text to replace markdown from.
	 * @return array|string|null
	 */
	protected function markdown( $text ) {
		$replacements = array(
			// strip each line.
			'!\s*[\r\n] *!'                    => "\n",
			// headers.
			'!^=(.*?)=\s*$!m'                  => '<h3>\1</h3>',
			// bullets.
			'!^(\* .*([\r\n]\* .*)*)$!m'       => "<ul>\n\\1\n</ul>",
			'!^\* (.*?)$!m'                    => '<li>\1</li>',
			'!^(\d+\. .*([\r\n]\d+\. .*)*)$!m' => "<ol>\n\\1\n</ol>",
			'!^\d+\. (.*?)$!m'                 => '<li>\1</li>',
			// code block.
			'!^(\t.*([\r\n]\t.*)*)$!m'         => "<pre>\n\\1\n</pre>",
			// wrap p.
			'!^([^<\t].*[^>])$!m'              => '<p>\1</p>',
			// bold.
			'!\*([^*]*?)\*!'                   => '<strong>\1</strong>',
			// code.
			'!`([^`]*?)`!'                     => '<code>\1</code>',
			// links.
			'!\[([^]]+)\]\(([^)]+)\)!'         => '<a href="\2" target="_new">\1</a>',
		);
		$text         = preg_replace( array_keys( $replacements ), array_values( $replacements ), $text );

		return $text;
	}

	/**
	 * Summary of render_screen_settings
	 *
	 * @param  mixed $output         Output.
	 * @param  mixed $current_screen Current Screen.
	 * @return string
	 */
	public function render_screen_settings( $output, $current_screen ) {
		_deprecated_function( 'SIQRP_Admin::render_screen_settings', '5.26.0' );
		return '';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function enqueue() {
		$version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : SIQRP_VERSION;
		$screen  = get_current_screen();
		if ( ! is_null( $screen ) && ( 'toplevel_page_siqrp' === $screen->id || 'siqrp_display_sid_form' === $screen->id ) ) {
			wp_enqueue_style( 'siqrp_switch_options', plugins_url( 'assets/css/options_switch.css', SIQRP_BASE_FILE ), array(), $version );
			wp_enqueue_script( 'siqrp_switch_options', siqrp_get_file_url_for_environment( 'assets/js/options_switch.min.js', 'assets/src/js/options_switch.js' ), array( 'jquery' ), $version );

			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_style( 'siqrp_options', plugins_url( 'assets/css/options_basic.css', SIQRP_BASE_FILE ), array(), $version );
			wp_enqueue_style( 'siqrp_remodal', plugins_url( 'lib/plugin-deactivation-survey/remodal.css', SIQRP_BASE_FILE ), array(), $version );
			wp_enqueue_style( 'siqrp_deactivate', plugins_url( 'lib/plugin-deactivation-survey/deactivate-feedback-form.css', SIQRP_BASE_FILE ), array(), $version );
			wp_enqueue_style( 'siqrp_default_theme', plugins_url( 'lib/plugin-deactivation-survey/remodal-default-theme.css', SIQRP_BASE_FILE ), array(), $version );

			wp_enqueue_script( 'postbox' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'siqrp_remodal', plugins_url( 'lib/plugin-deactivation-survey/remodal.min.js', SIQRP_BASE_FILE ), array(), $version );
			wp_enqueue_script( 'siqrp_options', siqrp_get_file_url_for_environment( 'assets/js/options_basic.min.js', 'assets/src/js/options_basic.js' ), array( 'jquery' ), $version );
			// Localize the script with messagesasset.
			$translation_strings = array(
				'alert_message' => __( 'This will clear all of SIQRP’s cached related results.<br> Are you sure?', 'related-posts-by-searchiq' ),
				'model_title'   => __( 'SIQRP Cache', 'related-posts-by-searchiq' ),
				'success'       => __( 'Cache cleared successfully!', 'related-posts-by-searchiq' ),
				'logo'          => plugins_url( '/assets/images/siq_icon.png', SIQRP_BASE_FILE ),
				'bgcolor'       => '#fff',
				'forbidden'     => __( 'You are not allowed to do this!', 'related-posts-by-searchiq' ),
				'nonce_fail'    => __( 'You left this page open for too long. Please refresh the page and try again!', 'related-posts-by-searchiq' ),
				'error'         => __( 'There is some error. Please refresh the page and try again!', 'related-posts-by-searchiq' ),
				'show_code'     => __( 'Show Code', 'related-posts-by-searchiq' ),
				'hide_code'     => __( 'Hide Code', 'related-posts-by-searchiq' ),
			);
			wp_localize_script( 'siqrp_options', 'siqrp_messages', $translation_strings );

			if ( function_exists( 'wp_enqueue_code_editor' ) ) {
				wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
			}
			wp_enqueue_script( 'suggest' );
			wp_enqueue_script( 'siqrp_custom_js', plugins_url( 'assets/js/custom-script.js', SIQRP_BASE_FILE ), array( 'siqrp_options', 'suggest' ), $version );
		}

		if ( method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor() ) {
			wp_enqueue_script( 'siqrp_custom_post_edit_js', plugins_url( 'assets/js/custom-post-edit-script.js', SIQRP_BASE_FILE ), array( 'jquery' ), $version );
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param  [type] $links Links.
	 * @param  [type] $file  File.
	 * @return array
	 */
	public function settings_link( $links, $file ) {
		$this_plugin = dirname( plugin_basename( __DIR__ ) ) . '/siqrp.php';
		if ( $file == $this_plugin ) {
			$links[] = '<a href="admin.php?page=siqrp">' . __( 'Settings', 'related-posts-by-searchiq' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function options_page() {
		include_once SIQRP_BASE_DIR . '/includes/siqrp-options.php';
	}
	/**
	 * Function to save the meta box.
	 *
	 * @param mixed $post_id Post ID.
	 */
	public function siqrp_save_meta_box( $post_id ) {
		$siqrp_meta = array();
		// Return if we're doing an autosave..
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Verify our nonce here..
		if ( ! isset( $_POST['siqrp_display-nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['siqrp_display-nonce'] ), 'siqrp_display' ) ) {
			return;
		}
		if ( isset( $_POST['siqrp_display_for_this_post'] ) ) {
			$siqrp_meta['siqrp_display_for_this_post'] = 1;
		} else {
			$siqrp_meta['siqrp_display_for_this_post'] = 0;
		}
		update_post_meta( $post_id, 'siqrp_meta', $siqrp_meta );

		if ( isset( $_POST['custom_post_css'] ) ) {
			update_post_meta( $post_id, '_siqrp_custom_css', wp_strip_all_tags( sanitize_textarea_field( wp_unslash( $_POST['custom_post_css'] ) ) ) );
		} else {
			update_post_meta( $post_id, '_siqrp_custom_css', '' );
		}
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function metabox() {
		global $post;
		$metabox_post_types = $this->core->get_option( 'auto_display_post_types' );
		$siqrp_meta         = get_post_meta( $post->ID, 'siqrp_meta', true );
		if ( isset( $siqrp_meta['siqrp_display_for_this_post'] ) && 0 === $siqrp_meta['siqrp_display_for_this_post'] ) {
			$siqrp_disable_here = 0;
		} else {
			$siqrp_disable_here = 1;
		}
		if ( in_array( get_post_type(), $metabox_post_types ) ) { ?>
		<p>
		<input type="checkbox" id="siqrp_display_for_this_post" name="siqrp_display_for_this_post" <?php checked( 1, $siqrp_disable_here, true ); ?> />
		<label for="siqrp_display_for_this_post"><strong><?php esc_html_e( 'Automatically display related posts on this post', 'related-posts-by-searchiq' ); ?></strong></label>
		<br />
		<em><?php esc_html_e( 'If this is unchecked, then SearchIQ will not automatically insert the related posts at the end of this post.', 'related-posts-by-searchiq' ); ?></em>
		</p>
		<?php } ?>
		<?php
		if ( ! get_the_ID() ) {
			echo '<div><p>' . esc_attr( __( 'Related posts will be displayed once you save this post', 'related-posts-by-searchiq' ) ) . '.</p></div>';
		}
		wp_nonce_field( 'siqrp_display', 'siqrp_display-nonce', false );
		echo '<p class="siqrp-metabox-options"><a href="' . esc_url( admin_url( 'admin.php?page=siqrp' ) ) . '" class="button-secondary">' . esc_attr( __( 'Configure Options', 'related-posts-by-searchiq' ) ) . '</a> <span class="spinner"></span></p>';
		$custom_css = get_post_meta( $post->ID, '_siqrp_custom_css', true );
		echo '<div class="siqrp_form_row info_box">';
		echo '<h4 class="header">Custom CSS - Only applies to this post</h4>';
		echo '<div class="inner">';
		echo '<textarea rows="10" cols="100" name="custom_post_css" class="large-text">' . esc_textarea( $custom_css ) . '</textarea>';
		echo '<div class="siqrp_form_row">';
		echo '<code>Add your custom css for overriding the plugin\'s default css for this post only in the above textarea.</code>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}

	/**
	 * Undocumented function
	 *
	 * @param  [type] $hidden Hidden.
	 * @param  [type] $screen Screen.
	 * @return boolean
	 */
	public function default_hidden_meta_boxes( $hidden, $screen ) {
		if ( 'toplevel_page_siqrp' === $screen->id ) {
			$hidden = $this->core->default_hidden_metaboxes;
		}
		return $hidden;
	}


	/**
	 * Registers SIQRP plugin for the deactivation survey library code.
	 *
	 * @param array $plugins Pligins.
	 *
	 * @return array
	 */
	public function deactivation_survey_data( $plugins ) {

		global $siqrp;
		if ( $siqrp instanceof SIQRP && isset( $siqrp->cloud ) && $siqrp->cloud instanceof SIQRP_Cloud ) {
			$api_key          = $siqrp->cloud->get_api_key();
			$verification_key = $siqrp->cloud->get_option( 'verification_key' );
			if ( empty( $verification_key ) ) {
				$verification_key = '';
			}
		} else {
			$api_key          = '';
			$verification_key = '';
		}
		$plugin_data = get_plugin_data( SIQRP_BASE_FILE, false, false );
		$plugins[]   = (object) array(
			'title_slugged'           => sanitize_title( $plugin_data['Name'] ),
			'basename'                => plugin_basename( SIQRP_BASE_FILE ),
			'logo'                    => plugins_url( '/assets/images/siq_icon.png', SIQRP_BASE_FILE ),
			'api_server'              => SIQRP_API_BASE_URL,
			'script_cache_ver'        => SIQRP_VERSION,
			'bgcolor'                 => '#fff',
			'send'                    => array(
				'plugin_name'      => 'siqrp',
				'plugin_version'   => SIQRP_VERSION,
				'api_key'          => $api_key,
				'verification_key' => $verification_key,
				'platform'         => 'wordpress',
				'domain'           => site_url(),
				'language'         => strtolower( get_bloginfo( 'language' ) ),
			),
			'reasons'                 => array(
				'error'                  => esc_html__( 'I think I found a bug', 'related-posts-by-searchiq' ),
				'feature-missing'        => esc_html__( 'It\'s missing a feature I need', 'related-posts-by-searchiq' ),
				'too-hard'               => esc_html__( 'I couldn\'t figure out how to do something', 'related-posts-by-searchiq' ),
				'inefficient'            => esc_html__( 'It\'s too slow or inefficient', 'related-posts-by-searchiq' ),
				'no-signup'              => esc_html__( 'I don\'t want to signup', 'related-posts-by-searchiq' ),
				'temporary-deactivation' => esc_html__( 'Temporarily deactivating or troubleshooting', 'related-posts-by-searchiq' ),
				'other'                  => esc_html__( 'Other', 'related-posts-by-searchiq' ),
			),
			'reasons_needing_comment' => array(
				'error',
				'feature-missing',
				'too-hard',
				'other',
			),
			'translations'            => array(
				'quick_feedback'        => esc_html__( 'Quick Feedback', 'related-posts-by-searchiq' ),
				'foreword'              => esc_html__(
					'If you would be kind enough, please tell us why you are deactivating the plugin:',
					'related-posts-by-searchiq'
				),
				'please_tell_us'        => esc_html__(
					'Please share anything you think might be helpful. The more we know about your problem, the faster we\'ll be able to fix it.',
					'related-posts-by-searchiq'
				),
				'cancel'                => esc_html__( 'Cancel', 'related-posts-by-searchiq' ),
				'skip_and_deactivate'   => esc_html__( 'Skip &amp; Deactivate', 'related-posts-by-searchiq' ),
				'submit_and_deactivate' => esc_html__( 'Submit &amp; Deactivate', 'related-posts-by-searchiq' ),
				'please_wait'           => esc_html__( 'Please wait...', 'related-posts-by-searchiq' ),
				'thank_you'             => esc_html__( 'Thank you!', 'related-posts-by-searchiq' ),
				'ask_for_support'       => sprintf(
				/* translators: %1$s is replaced with the start anchor tag with link to support forum %2$s with end anchor tag %3$s replaced with anchor tag with link to faq */
					esc_html__(
						'Have you visited %1$sthe support forum%2$s and %3$sread the FAQs%2$s for help?',
						'related-posts-by-searchiq'
					),
					'<a href="https://wordpress.org/support/plugin/related-posts-by-searchiq/" target="_blank" >',
					'</a>',
					'<a href="https://wordpress.org/plugins/related-posts-by-searchiq/#faq" target="_blank" >'
				),
				'email_request'         => esc_html__(
					'If you would like to tell us more, please leave your email here. We will be in touch (only for product feedback, nothing else).',
					'related-posts-by-searchiq'
				),
			),

		);

		return $plugins;
	}

	/**
	 * Undocumented function
	 *
	 * @param  string $taxonomy Taxonomy.
	 * @return array
	 */
	public function get_post_taxonomy_list( $taxonomy = 'category' ) {
		$taxonomy_list = get_categories(
			array(
				'taxonomy'   => $taxonomy,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => false,
			)
		);
		return $taxonomy_list;
	}
	/**
	 * Summary of ajax_register
	 *
	 * @return void
	 */
	public function ajax_register() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'wp_ajax_siqrp_display', array( $this, 'ajax_display' ) );
		}
	}
	/**
	 * Summary of ajax_display
	 *
	 * @return mixed
	 */
	public function ajax_display() {
		global $siqrp;
		check_ajax_referer( 'siqrp_display' );

		if ( ! isset( $_REQUEST['ID'] ) ) {
			return;
		}

		$args   = array(
			'domain' => isset( $_REQUEST['domain'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['domain'] ) ) : 'website',
		);
		$return = $this->core->display_related( absint( $_REQUEST['ID'] ), $args, false );

		header( 'HTTP/1.1 200' );
		header( 'Content-Type: text/html; charset=UTF-8' );
		echo wp_kses( $return, $siqrp->kses_allowed_html_config );

		die();
	}
}
