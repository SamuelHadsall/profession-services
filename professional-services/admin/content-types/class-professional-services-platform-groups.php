<?php

require plugin_dir_path( dirname( __FILE__ ) ) . '/helpers/vendor/autoload.php';

use PostTypes\PostType;

class Platform_Groups {
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

    public function ps_create_platform_group_cpt() {
        $options = [
            'name' => __( 'Platform Groups',  $this->plugin_name ),
            'singular_name'  => __( 'Platform Group', $this->plugin_name ),
            'menu_icon' => 'dashicons-admin-site-alt2',
            'supports' => array('title', 'page-attributes'),
            'show_in_menu' => $this->plugin_name,
            'menu_position' => 8,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'rewrite' => array('slug' => 'platform', 'with_front' => false),
            'register_meta_box_cb' => array($this, 'ps_create_cpt_meta_boxes')
        ];

        $platform_groups = new PostType('platform_groups', $options);

        $platform_groups->register();
    }

    /**
     * Register meta boxes.
     */
    public function ps_create_cpt_meta_boxes() {
        add_meta_box(
            'edit-area',
            __( 'Edit Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_display_callback'),
            'platform_groups',
            'normal',
			'default'
        );
    }

    public function ps_create_cpt_template( $template ) {
        if (get_post_type() == 'platform_groups') {
            if (is_single()) {
                $theme_files = array('archive-platform_groups.php', 'page-templates/archive-platform_groups.php');
                $exists_in_theme = locate_template($theme_files, false);
                if ( $exists_in_theme != '' ) {
                    return $exists_in_theme;
                } else {
                    return WP_PLUGIN_DIR . '/' . $this->plugin_name . '/public/page-templates/archive-platform_groups.php';
                }
            }
        }
        return $template;
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

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/meta-box/platform-groups-edit-area.php';
    }

    public function ps_create_cpt_meta_boxes_save( $post_id ) {
        if (isset($_POST['ps_custom_meta_box_nounce']) && wp_verify_nonce( $_REQUEST['ps_custom_meta_box_nounce'], 'ps_custom_meta_box_nounce' ) )
        return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
       

        $fields = [            
            'ps-image',           
            'ps-detail-page-description'            
        ];

        foreach ($fields as $field) {
            if ( array_key_exists( $field, $_POST ) ) {
                if( isset( $_POST[$field] ) ) {
                    update_post_meta( $post_id, $field, wp_kses_post($_POST[$field]));
                } else {
                    delete_post_meta( $post_id, $field, $_POST[$field] );
                }
            }
        } 
    }

    public function ps_register_block_init() {
        require_once WP_PLUGIN_DIR . '/' . $this->plugin_name . '/includes/blocks/platform-group.php';
    }
}
