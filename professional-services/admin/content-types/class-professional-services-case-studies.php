<?php

require plugin_dir_path( dirname( __FILE__ ) ) . '/helpers/vendor/autoload.php';

use PostTypes\PostType;

class Case_Studies {
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

    public function ps_create_case_study_cpt() {
        $options = [
            'name' => __( 'Case Studies',  $this->plugin_name ),
            'singular_name'  => __( 'Case Study', $this->plugin_name ),
            'menu_icon' => 'dashicons-admin-site-alt2',
            'supports' => array('title', 'page-attributes'),
            'show_in_menu' => $this->plugin_name,
            'menu_position' => 10,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'register_meta_box_cb' => array($this, 'ps_create_cpt_meta_boxes')
        ];

        $case_studies = new PostType('case_studies', $options);

        $case_studies->register();
    }

    public function youtube_id( $data )
    {
        /**
         * Pattern matches
        * http://youtu.be/ID
        * http://www.youtube.com/embed/ID
        * http://www.youtube.com/watch?v=ID
        * http://www.youtube.com/?v=ID
        * http://www.youtube.com/v/ID
        * http://www.youtube.com/e/ID
        * http://www.youtube.com/user/username#p/u/11/ID
        * http://www.youtube.com/leogopal#p/c/playlistID/0/ID
        * http://www.youtube.com/watch?feature=player_embedded&v=ID
        * http://www.youtube.com/?feature=player_embedded&v=ID
        */
        $pattern =
        '%
        (?:youtube                    # Match any youtube url www or no www , https or no https
        (?:-nocookie)?\.com/          # allows for the nocookie version too.
        (?:[^/]+/.+/                  # Once we have that, find the slashes
        |(?:v|e(?:mbed)?)/|.*[?&]v=)  # Check if its a video or if embed
        |youtu\.be/)                  # Allow short URLs
        ([^"&?/ ]{11})                # Once its found check that its 11 chars.
        %i';

        // Checks if it matches a pattern and returns the value
        if (preg_match($pattern, $data, $match)) {
        return $match[1];
        }

        // if no match return false.
        return false;
    }

    /**
     * Register meta boxes.
     */
    public function ps_create_cpt_meta_boxes() {
        add_meta_box(
            'edit-area',
            __( 'Edit Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_display_callback'),
            'case_studies',
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

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/meta-box/case-studies-edit-area.php';
    }

    public function ps_create_cpt_meta_boxes_save( $post_id ) {
        //die(var_dump($_POST));
        if (wp_verify_nonce( $_REQUEST['ps_custom_meta_box_nounce'], 'ps_custom_meta_box_nounce' ) )
        return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        //die(var_dump(is_array($_POST['ps-videos'])));

        if (isset($_POST['ps-videos']) && is_array($_POST['ps-videos'])) {
            update_post_meta( $post_id, 'ps-videos', implode(',', $_POST['ps-videos'] ) );
        }

        if (isset($_POST['ps-document']) && is_array($_POST['ps-document'])) {
            update_post_meta( $post_id, 'ps-document', implode(',', $_POST['ps-document'] ) );
        }

        if (isset($_POST['ps-locations']) && is_array($_POST['ps-locations'])) {
            update_post_meta( $post_id, 'ps-locations', implode(',', $_POST['ps-locations'] ) );
        }

        if (isset($_POST['ps-industries']) && is_array($_POST['ps-industries'])) {
            update_post_meta( $post_id, 'ps-industries', implode(',', $_POST['ps-industries'] ) );
        }

        if (isset($_POST['ps-people']) && is_array($_POST['ps-people'])) {
            update_post_meta( $post_id, 'ps-people', implode(',', $_POST['ps-people'] ) );
        }

        if (isset($_POST['ps-challenges']) && is_array($_POST['ps-challenges'])) {
            update_post_meta( $post_id, 'ps-challenges', implode(',', $_POST['ps-challenges'] ) );
        }

        if (isset($_POST['ps-articles']) && is_array($_POST['ps-articles'])) {
            update_post_meta( $post_id, 'ps-articles', implode(',', $_POST['ps-articles'] ) );
        }

        if (isset($_POST['ps-platform-groups']) && is_array($_POST['ps-platform-groups'])) {
            update_post_meta( $post_id, 'ps-platform-groups', implode(',', $_POST['ps-platform-groups'] ) );
        }

        if (isset($_POST['ps-platform']) && is_array($_POST['ps-platform'])) {
            update_post_meta( $post_id, 'ps-platform', implode(',', $_POST['ps-platform'] ) );
        }

        if (isset($_POST['ps-services']) && is_array($_POST['ps-services'])) {
            update_post_meta( $post_id, 'ps-services', implode(',', $_POST['ps-services'] ) );
        }

        if (isset($_POST['ps-channels']) && is_array($_POST['ps-channels'])) {
            update_post_meta( $post_id, 'ps-channels', implode(',', $_POST['ps-channels'] ) );
        }       

        $fields = [  
            'ps-clients',
            'ps-detail-header',
            'ps-images-detail-banner-image',
            'ps-images-list-img',
            'ps-images-challenge-image',
            'ps-images-solutions-image',
            'ps-images-results-image',
            'ps-challenge-description',
            'ps-solution-description',
            'ps-results-description',
            'ps-list-description',
            'ps-detail-description',
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
}
