<?php

require plugin_dir_path( dirname( __FILE__ ) ) . '/helpers/vendor/autoload.php';

use PostTypes\PostType;

class Service {
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

        $this->init();
    }
    
    private function init() {       

        add_action( 'graphql_register_types', function() {
            register_graphql_field( 'service', 'ps-detail-header', [
               'type' => 'String',
               'description' => __( 'Detail Header Text', $this->plugin_name ),
               'resolve' => function( $post ) {
                 $detail_header = get_post_meta( $post->ID, 'ps-detail-header', true );
                 return ! empty( $detail_header ) ? $detail_header : '';
               }
            ] );
        } );

        add_action( 'graphql_register_types', function() {
            register_graphql_field( 'service', 'ps-list-description', [
               'type' => 'String',
               'description' => __( 'Content shown in List view', $this->plugin_name ),
               'resolve' => function( $post ) {
                 $list_description = get_post_meta( $post->ID, 'ps-list-description', true );
                 return ! empty( $list_description ) ? $list_description : '';
               }
            ] );
        } );

        add_action( 'graphql_register_types', function() {
            register_graphql_field( 'service', 'ps-nav-img', [
               'type' => 'MediaItem',
               'description' => __( 'Image Used for Navigation Items', $this->plugin_name ),
               'resolve' => function( $post ) {
                 $nav_image = get_post_meta( $post->ID, 'ps-nav-img', true );
                 return ! empty( $nav_image ) ? $nav_image : '';
               }
            ] );
        } );

        add_action( 'graphql_register_types', function() {
            register_graphql_connection([
                'fromType' => 'ContentNode',
                'toType' => 'MediaItem',
                'fromFieldName' => 'ps-nav-img',
                'connectionTypeName' => 'psnavimgConnection',
                'connectionArgs' => \WPGraphQL\Connection\PostObjects::get_connection_args(),
                'resolve' => function( \WPGraphQL\Model\Post $source, $args, $context, $info ) {
                    $resolver = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver( $source, $args, $context, $info, 'attachment' );
                    $resolver->set_query_arg( 'post_parent', $source->ID );
                    return $resolver->get_connection();
                }
            ]);        
        } );

        add_action( 'graphql_register_types', function() {
            register_graphql_field( 'service', 'ps-list-img', [
               'type' => 'MediaItem',
               'description' => __( 'Image used for Service List', $this->plugin_name ),
               'resolve' => function( $post ) {
                 $list_image = get_post_meta( $post->ID, 'ps-list-img', true );
                 return ! empty( $list_image ) ? $list_imagee : '';
               }
            ] );
        } );

        add_action( 'graphql_register_types', function() {
            register_graphql_connection([
                'fromType' => 'ContentNode',
                'toType' => 'MediaItem',
                'fromFieldName' => 'ps-list-img',
                'connectionTypeName' => 'pslistimgConnection',
                'connectionArgs' => \WPGraphQL\Connection\PostObjects::get_connection_args(),
                'resolve' => function( \WPGraphQL\Model\Post $source, $args, $context, $info ) {
                    $resolver = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver( $source, $args, $context, $info, 'attachment' );                   
                    $resolver->set_query_arg( '_wp_attachment_metadata', $source->ID );
                    return $resolver->get_connection();
                }
            ]);        
        } );
    }

    public function ps_create_service_cpt() {
        $options = [
            'name' => __( 'Services',  $this->plugin_name ),
            'singular_name'  => __( 'Service', $this->plugin_name ),
            'menu_icon' => 'dashicons-admin-site-alt2',
            'supports' => array('title', 'page-attributes'),
            'show_in_menu' => $this->plugin_name,
            'menu_position' => 3,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'show_in_graphql' => true,
            'hierarchical' => false,            
            'graphql_single_name' => 'service',
            'graphql_plural_name' => 'services',
            'rewrite' => false,
            'register_meta_box_cb' => array($this, 'ps_create_cpt_meta_boxes')
        ];

        $service = new PostType('service', $options);

        $service->register();
    }

    /**
     * Register meta boxes.
     */
    public function ps_create_cpt_meta_boxes() {
        add_meta_box(
            'edit-area',
            __( 'Edit Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_display_callback'),
            'service',
            'normal',
			'default'
        );

        add_meta_box( 
            'service-parent', 
            __( 'Area', $this->plugin_name ),
            array($this, 'ps_create_cpt_attributes'),
            'service', 
            'side', 
            'high' 
        );

    }

    public function ps_create_cpt_attributes( $post ) {
        $post_type_object = get_post_type_object( $post->post_type );
        $pages = wp_dropdown_pages( array( 'post_type' => 'area', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __( '(no parent)' ), 'sort_column'=> 'menu_order, post_title', 'echo' => 0 ) );
        
        if ( ! empty( $pages ) ) {
            echo $pages;
        }
    }

    public function ps_create_cpt_template( $template ) {
        if (get_post_type() == 'service') {
            if (is_single()) {
                $theme_files = array('archive-service.php', 'page-templates/archive-service.php');
                $exists_in_theme = locate_template($theme_files, false);
                if ( $exists_in_theme != '' ) {
                    return $exists_in_theme;
                } else {
                    return WP_PLUGIN_DIR . '/' . $this->plugin_name . '/public/page-templates/archive-service.php';
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

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/meta-box/service-edit-area.php';
    }

    public function ps_create_cpt_meta_boxes_save( $post_id ) {
        //die(var_dump($post));
        if (isset($_POST['ps_custom_meta_box_nounce']) && wp_verify_nonce( $_REQUEST['ps_custom_meta_box_nounce'], 'ps_custom_meta_box_nounce' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if (isset($_POST['ps-list-bullet-points']) && is_array($_POST['ps-list-bullet-points'])) {
            update_post_meta( $post_id, 'ps-list-bullet-points', array_map( 'sanitize_text_field', $_POST['ps-list-bullet-points'] ) );
        }

        if (isset($_POST['ps-service-industry']) && is_array($_POST['ps-service-industry'])) {
            update_post_meta( $post_id, 'ps-service-industry', implode(',', $_POST['ps-service-industry'] ) );
        }

        if (isset($_POST['ps-service-platform']) && is_array($_POST['ps-service-platform'])) {
            update_post_meta( $post_id, 'ps-service-platform', implode(',', $_POST['ps-service-platform'] ) );
        }

        $fields = [            
            'ps-detail-header',
            'ps-nav-img',
            'ps-list-img',
            'ps-list-description',
            'ps-banner-img',
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
        require_once WP_PLUGIN_DIR . '/' . $this->plugin_name . '/includes/blocks/service.php';
    }
}
