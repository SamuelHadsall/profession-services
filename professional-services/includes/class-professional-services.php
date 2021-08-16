<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.steadyrain.com
 * @since      1.0.0
 *
 * @package    Professional_Services
 * @subpackage Professional_Services/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Professional_Services
 * @subpackage Professional_Services/includes
 * @author     SteadyRain <wpdev@steadyrain.com>
 */
class Professional_Services {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Professional_Services_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PROFESSIONAL_SERVICES_VERSION' ) ) {
			$this->version = PROFESSIONAL_SERVICES_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'professional-services';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Professional_Services_Loader. Orchestrates the hooks of the plugin.
	 * - Professional_Services_i18n. Defines internationalization functionality.
	 * - Professional_Services_Admin. Defines all hooks for the admin area.
	 * - Professional_Services_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-professional-services-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-professional-services-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-professional-services-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-professional-services-public.php';

		/**
		 * The class responsible for defining area content type.
		 */
		$content_types = glob(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/content-types/*.php');

		foreach ($content_types as $file) {
			require_once $file;
		}

		$this->loader = new Professional_Services_Loader();

		if ( !class_exists( 'Custom_Fields' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'custom-fields/class-professional-services-custom-fields.php';
			new Custom_Fields( $this->get_plugin_name(), $this->get_version() );
		}

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Professional_Services_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Professional_Services_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Professional_Services_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_area_cpt = new Area( $this->get_plugin_name(), $this->get_version() );
		$plugin_services_cpt = new Service( $this->get_plugin_name(), $this->get_version() );
		$plugin_case_studies_cpt = new Case_Studies( $this->get_plugin_name(), $this->get_version() );
		$plugin_award_cpt = new Awards( $this->get_plugin_name(), $this->get_version() );
		$plugin_business_sectors_cpt = new Business_Sectors( $this->get_plugin_name(), $this->get_version() );
		$plugin_industries_cpt = new Industries( $this->get_plugin_name(), $this->get_version() );
		$plugin_clients_cpt = new Clients( $this->get_plugin_name(), $this->get_version() );
		$plugin_channels_cpt = new Channels( $this->get_plugin_name(), $this->get_version() );
		$plugin_challenges_cpt = new Challenges( $this->get_plugin_name(), $this->get_version() );
		$plugin_platform_groups_cpt = new Platform_Groups( $this->get_plugin_name(), $this->get_version() );
		$plugin_platform_cpt = new platform( $this->get_plugin_name(), $this->get_version() );
		$plugin_articles_cpt = new Articles( $this->get_plugin_name(), $this->get_version() );
		$plugin_people_cpt = new People( $this->get_plugin_name(), $this->get_version() );
		$plugin_location_cpt = new Location( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ps_create_menu');
		$this->loader->add_filter('post_type_link', $plugin_admin, 'ps_create_service_cpt_permalinks', 10, 3);	
		$this->loader->add_action( 'init', $plugin_admin, 'ps_create_service_cpt_rewrite_rules' );
		$this->loader->add_filter('post_type_link', $plugin_admin, 'ps_create_platform_cpt_permalinks', 10, 3);	
		$this->loader->add_action( 'init', $plugin_admin, 'ps_create_platform_cpt_rewrite_rules' );	
		$this->loader->add_filter( 'mce_buttons_2', $plugin_admin, 'ps_create_mce_buttons' );
		$this->loader->add_filter( 'tiny_mce_before_init', $plugin_admin, 'ps_create_init_insert_formats' );
		//Service Area
		$this->loader->add_action( 'init', $plugin_area_cpt, 'ps_create_area_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_area', $plugin_area_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_area', $plugin_area_cpt, 'ps_create_cpt_meta_boxes_save');
		$this->loader->add_action('acf/init', $plugin_area_cpt, 'ps_register_block_init');
		//Services
		$this->loader->add_action( 'init', $plugin_services_cpt, 'ps_create_service_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_service', $plugin_services_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_service', $plugin_services_cpt, 'ps_create_cpt_meta_boxes_save');
		$this->loader->add_filter('template_include', $plugin_services_cpt,  'ps_create_cpt_template');	
		$this->loader->add_action('acf/init', $plugin_services_cpt, 'ps_register_block_init');	
		//Business Sectors
		$this->loader->add_action( 'init', $plugin_business_sectors_cpt, 'ps_create_business_sector_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_business_sectors', $plugin_business_sectors_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_business_sectors', $plugin_business_sectors_cpt, 'ps_create_cpt_meta_boxes_save');
		//Industries
		$this->loader->add_action( 'init', $plugin_industries_cpt, 'ps_create_industry_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_industries', $plugin_industries_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_industries', $plugin_industries_cpt, 'ps_create_cpt_meta_boxes_save');
		//Clients
		$this->loader->add_action( 'init', $plugin_clients_cpt, 'ps_create_client_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_clients', $plugin_clients_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_clients', $plugin_clients_cpt, 'ps_create_cpt_meta_boxes_save');
		//Channels
		$this->loader->add_action( 'init', $plugin_channels_cpt, 'ps_create_channel_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_channels', $plugin_channels_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_channels', $plugin_channels_cpt, 'ps_create_cpt_meta_boxes_save');
		//Challenges
		$this->loader->add_action( 'init', $plugin_challenges_cpt, 'ps_create_challenge_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_challenges', $plugin_challenges_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_challenges', $plugin_challenges_cpt, 'ps_create_cpt_meta_boxes_save');
		//Platform Groups
		$this->loader->add_action( 'init', $plugin_platform_groups_cpt, 'ps_create_platform_group_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_platform_groups', $plugin_platform_groups_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_platform_groups', $plugin_platform_groups_cpt, 'ps_create_cpt_meta_boxes_save');
		$this->loader->add_filter('template_include', $plugin_platform_groups_cpt,  'ps_create_cpt_template');
		//platform
		$this->loader->add_action( 'init', $plugin_platform_cpt, 'ps_create_platform_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_platform', $plugin_platform_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_platform', $plugin_platform_cpt, 'ps_create_cpt_meta_boxes_save');
		$this->loader->add_filter('template_include', $plugin_platform_cpt,  'ps_create_cpt_template');
		$this->loader->add_action('acf/init', $plugin_platform_cpt, 'ps_register_block_init');
		//Case Study
		$this->loader->add_action( 'init', $plugin_case_studies_cpt, 'ps_create_case_study_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_case_studies', $plugin_case_studies_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_case_studies', $plugin_case_studies_cpt, 'ps_create_cpt_meta_boxes_save', 10, 2);
		//Articles
		$this->loader->add_action( 'init', $plugin_articles_cpt, 'ps_create_article_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_articles', $plugin_articles_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_articles', $plugin_articles_cpt, 'ps_create_cpt_meta_boxes_save', 10, 2);
		//People
		$this->loader->add_action( 'init', $plugin_people_cpt, 'ps_create_people_cpt', 0);
		$this->loader->add_action( 'add_meta_boxes_people', $plugin_people_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_people', $plugin_people_cpt, 'ps_create_cpt_meta_boxes_save');
		//Awards
		$this->loader->add_action( 'init', $plugin_award_cpt, 'ps_create_award_cpt', 0);
        $this->loader->add_action( 'add_meta_boxes_awards', $plugin_award_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_awards', $plugin_award_cpt, 'ps_create_cpt_meta_boxes_save', 10, 2);
		//Location
		$this->loader->add_action( 'init', $plugin_location_cpt, 'ps_create_location_cpt', 0);
		$this->loader->add_action( 'add_meta_boxes_locations', $plugin_location_cpt, 'ps_create_cpt_meta_boxes_save', 1);
		$this->loader->add_action( 'save_post_locations', $plugin_location_cpt, 'ps_create_cpt_meta_boxes_save');
		
		//Enqueue Styles and Scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Professional_Services_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Professional_Services_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
