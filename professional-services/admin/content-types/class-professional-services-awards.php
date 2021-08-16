<?php

require plugin_dir_path( dirname( __FILE__ ) ) . '/helpers/vendor/autoload.php';

use PostTypes\PostType;

class Awards {
    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    public function ps_create_award_cpt() {
        $options = [
            'name' => __( 'Awards',  $this->plugin_name ),
            'singular_name'  => __( 'Award', $this->plugin_name ),
            'menu_icon' => 'dashicons-admin-site-alt2',
            'supports' => array('title', 'page-attributes'),
            'show_in_menu' => $this->plugin_name,
            'menu_position' => 13,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'register_meta_box_cb' => array($this, 'ps_create_cpt_meta_boxes')
        ];

        $articles = new PostType('awards', $options);

        $articles->register();
    }

    /**
     * Register meta boxes.
     */
    public function ps_create_cpt_meta_boxes() {
        add_meta_box(
            'edit-area',
            __( 'Edit Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_display_callback'),
            'awards',
            'normal',
			'default'
        );

    }

    /**
     * Meta box display callback.
     *
     * @param WP_Post $post Current post object.
     */
    public function ps_create_cpt_display_callback( $post ) {
        $meta = get_post_meta( $post->ID );

        wp_nonce_field( plugin_basename(__FILE__), 'wp_custom_attachment_nonce' );
        wp_nonce_field( plugin_basename(__FILE__), 'ps_custom_meta_box_nounce' );

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/meta-box/awards-edit-area.php';
    }

    public function ps_create_cpt_meta_boxes_save( $post_id ) {
        if (wp_verify_nonce( $_REQUEST['ps_custom_meta_box_nounce'], 'ps_custom_meta_box_nounce' ) )
            return $post_id;

        /*
        * If this is an autosave, our form has not been submitted,
        * so we don't want to do anything.
        */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        $fields = [
            'ps-awards-date',
            'ps-awards-description',
            'ps-awards-icon'
        ];

        foreach ($fields as $field) {
            if ( array_key_exists( $field, $_POST ) ) {
                if( isset( $_POST[$field] ) ) {
                    update_post_meta( $post_id, $field, sanitize_text_field($_POST[$field]));
                } else {
                    delete_post_meta( $post_id, $field, $_POST[$field] );
                }
            }
        }
    }
}
