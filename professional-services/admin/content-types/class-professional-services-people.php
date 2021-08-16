<?php

require plugin_dir_path( dirname( __FILE__ ) ) . '/helpers/vendor/autoload.php';

use PostTypes\PostType;

class People {
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

    public function ps_create_people_cpt() {
        $options = [
            'name' => __( 'People',  $this->plugin_name ),
            'singular_name'  => __( 'People', $this->plugin_name ),
            'menu_icon' => 'dashicons-admin-site-alt2',
            'supports' => array('page-attributes'),
            'show_in_menu' => $this->plugin_name,
            'menu_position' => 12,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'query_var'          => true,
            'rewrite' => array('slug' => 'people', 'with_front' => false),
            'register_meta_box_cb' => array($this, 'ps_create_cpt_meta_boxes')
        ];

        $people = new PostType('people', $options);

        $people->register();
    }

    public function people_rewrite_rule() {
        add_rewrite_rule('^people/([^/]*)/?', 'index.php?post_type=people&$matches[1]', 'top');
    }


    /**
     * Register meta boxes.
     */
    public function ps_create_cpt_meta_boxes() {
        add_meta_box(
            'edit-area',
            __( 'Edit Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_display_callback'),
            'people',
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

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/meta-box/people-edit-area.php';
    }

    public function ps_create_cpt_meta_boxes_save( $post_id ) {
        if (wp_verify_nonce( isset($_REQUEST['ps_custom_meta_box_nounce']), 'ps_custom_meta_box_nounce' ) )
            return $post_id;

        /*
        * If this is an autosave, our form has not been submitted,
        * so we don't want to do anything.
        */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        $fields = [
            'ps-first-name',
            'ps-last-name',
            'ps-people-title',
            'ps-people-phone-number',
            'ps-people-email',
            'ps-people-description',
            'ps-people-image',
            'useing-gravitar'
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
