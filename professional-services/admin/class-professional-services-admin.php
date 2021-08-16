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
 * @subpackage Professional_Services/admin
 * @author     SteadyRain <wpdev@steadyrain.com>
 */
class Professional_Services_Admin {

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

	public function ps_create_menu()
    {
		//Add the menu item to the Main menu
        add_menu_page(
            'Professional Services Options',
            'Professional Services',
            'manage_options',
			$this->plugin_name,
		array($this, 'ps_create_admin'),
            'dashicons-groups',
			21
		);

		add_submenu_page(
			$this->plugin_name,
			'Professional Services Dashboard',
			'Dashboard',
			'manage_options',
			$this->plugin_name . '-dashboard', // Menu slug: The slug name to refer to this menu by. Should be unique for this menu page.
            array($this, 'ps_create_dashboard'),  // Callback: The name of the function to call when rendering this menu's page
			0
		);
	}
		
	/**
     * Renders the Dashboard page to display for the Dashboard menu defined above.
     *
     * @since   1.0.0
     */
	public function ps_create_dashboard()
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/professional-services-admin-dashboard.php';
	}

	public function ps_create_admin()
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/professional-services-admin-display.php';
	}

	/**
	 * Rewrite Rules
	 */

	public function ps_create_service_cpt_rewrite_rules() {
		add_rewrite_tag('%service%', '([^/]+)', 'service=');
		add_permastruct('service', '/service/%area%/%service%', false);
		add_rewrite_rule('^service/([^/]+)/([^/]+)/?','index.php?service=$matches[2]','top');
	}    
	
	public function ps_create_service_cpt_permalinks($permalink, $post, $leavename) {
		$post_id = $post->ID;
		if($post->post_type != 'service' || empty($permalink) || in_array($post->post_status, array('draft', 'pending', 'auto-draft')))
			 return $permalink;
	
		$parent = $post->post_parent;
		$parent_post = get_post( $parent );
	
		$permalink = str_replace('%area%', $parent_post->post_name, $permalink);
	
		return $permalink;
	}

	public function ps_create_platform_cpt_rewrite_rules() {
		add_rewrite_tag('%platform%', '([^/]+)', 'platform=');
		add_permastruct('platform', '/platform/%platform_groups%/%platform%', false);
		add_rewrite_rule('^platform/([^/]+)/([^/]+)/?','index.php?platform=$matches[2]','top');
	}    
	
	public function ps_create_platform_cpt_permalinks($permalink, $post, $leavename) {
		$post_id = $post->ID;
		if($post->post_type != 'platform' || empty($permalink) || in_array($post->post_status, array('draft', 'pending', 'auto-draft')))
			 return $permalink;
	
		$parent = $post->post_parent;
		$parent_post = get_post( $parent );
	
		$permalink = str_replace('%platform_groups%', $parent_post->post_name, $permalink);
	
		return $permalink;
	}

	public function ps_create_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	// Callback function to filter the MCE settings
	public function ps_create_init_insert_formats( $init_array ) {
	
		// Define the style_formats array
		$style_formats=array(
	
			// Each array child is a format with it's own settings
			array(
				'title' => 'Primary Button',
				'inline' => 'a',
				'selector' => 'a',
				'classes' => 'btn btn-primary',
				'wrapper' => false,     
			),
	
			array(
				'title' => 'Secondary Button',
				'inline' => 'a',
				'selector' => 'a',
				'classes' => 'btn btn-secondary',
				'wrapper' => false,
			),
		);
	
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );
		return $init_array;
	}

	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Professional_Services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Professional_Services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name.'-datepicker', '//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name .'-semantic-css',  plugin_dir_url( __FILE__ ) . 'helpers/vendor/semantic-ui/semantic.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/professional-services-admin.css', array($this->plugin_name.'select2-css', $this->plugin_name .'-semantic-css'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Professional_Services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Professional_Services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$js_file_nounce = wp_create_nonce( "js_file" );
		$city_api = 'Sm5WN1F6eGl5MkVZT1BuTjFtODNncGdUelFGdlZ4OUNPVmY2QTVPag==';

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( $this->plugin_name.'select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name .'-semantic-js', plugin_dir_url( __FILE__ ) . 'helpers/vendor/semantic-ui/semantic.js', array( ), $this->version, false);
		wp_enqueue_script( $this->plugin_name . '-fontawesome', '//pro.fontawesome.com/releases/v5.15.1/js/all.js', array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-admin-js', plugin_dir_url( __FILE__ ) . 'js/professional-services-admin.js', array( 'jquery',  $this->plugin_name.'select2-js', $this->plugin_name .'-semantic-js' ), $this->version, false );
		wp_localize_script( $this->plugin_name . '-admin-js', 'wp_js', array(
			'js_file_nounce' => $js_file_nounce,
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'pluginsUrl' => plugin_dir_url( __DIR__ ),
			'pluginname' => $this->plugin_name,
			'city_api' => $city_api
		)  );
	}

}
