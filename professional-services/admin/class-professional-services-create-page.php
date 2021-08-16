<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.steadyrain.com
 * @since      1.0.0
 *
 * @package    Professional_Services
 * @subpackage Professional_Services/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Professional_Services
 * @subpackage Professional_Services/create_page
 * @author     SteadyRain <wpdev@steadyrain.com>
 */
class Professional_Services_Create_Page {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    }

    public function ps_create_page($post_id, $post, $update)
    {        

      if (get_post_status($post_id) == 'publish') {           
            $post_name = $post->post_name;
            $post_title = $post->post_title;
            $post_content = $post->post_content;  
            
            die(var_dump($post));

            $new_page = array(
                'post_title'    => wp_strip_all_tags( $post_title ),
                'post_content'  => $post_content,
                'post_type'     => 'page',
                'post_status'   => 'publish',
                'post_date'     => date( 'Y-m-d H:i:s', time() ),
                'post_template' => 'detail-page-template.php'
              );              

              wp_insert_post( $new_page );            
        }

        $args = array(
            'public'   => true,
            '_builtin' => false            
         );
        
         $output = 'objects'; // 'names' or 'objects' (default: 'names')
         $operator = 'and'; // 'and' or 'or' (default: 'and') 
        
        $content_types = get_post_types( $args, $output, $operator );
        $post_types = array();
        
        foreach($content_types as $type) {
            array_push($post_types, $type->name);
        }

        $updated = get_posts(array(
            'numberposts' => -1,
            'post_type' => array($post_types),
            'order' => 'ASC',
            'post_status' => 'publish'
        ));

        foreach( $updated as $page) {
            if (get_post_status($page->ID) == 'publish') {
                $page_name = $post->post_name;
                $page_title = $post->post_title;
                $page_content = $post->post_content;  

                $new_page = array(
                    'post_title'    => wp_strip_all_tags( $page_title ),
                    'post_content'  => $post_content,
                    'post_type'     => 'page',
                    'post_status'   => 'publish',
                    'post_date'     => date( 'Y-m-d H:i:s', time() ),
                    'post_template' => 'detail-page-template.php'
                  );              
    
                  wp_insert_post( $new_page );            
            }
        }
    }
}