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

 class Custom_Fields {   

 /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name = '';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version = '1.0.0';
	
	/**
	 * The modus of ACF: Either "installed" if found as a plugin, "bundeled" when used via include ore false if not found
	 *
	 * @since    1.0.0
	 * @access   public static
	 * @var      string    $acf_modus    The used modus.
	 */
	public static $acf_modus;
	
	/**
	 * The path to the bundeled ACF
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $acf_dir    The path to the folder.
	 */
	protected $acf_dir;
	
	/**
	 * The URL to the bundeled ACF
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $acf_url    The url to the folder.
	 */
	protected $acf_url;
	
	/**
	 * The path to the json files
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $acf_json    The path to the folder.
	 */
	protected $acf_json;
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string $name The name of this plugin.
	 * @var      string $version The version of this plugin.
	 */
	public function __construct( $name = false, $version = false ) {
		
		if($name){
			$this->plugin_name = $name;
		}
		
		if($version){
			$this->plugin_version = $version;
		}
		
		$this->acf_dir = plugin_dir_path( dirname( __FILE__ ) ) .'includes/assets/acf/';
		$this->acf_url = plugin_dir_url( dirname( __FILE__ ) ) .'includes/assets/acf/';
		

		
		if ( class_exists('acf') ){
			self::$acf_modus = 'installed';
		} else if(file_exists($this->acf_dir.'acf.php')) {
			self::$acf_modus = 'bundeled';
		} else {
			self::$acf_modus = false;
		}

		$this->init();
	}
	
	/**
	 * Initiate the integration
	 *
	 * @since    1.0.0
	 */
	private function init(){
		if(!self::$acf_modus){
			return;
		}
		
		if ( 'bundeled' === self::$acf_modus ) {
			// Customize ACF path
			add_filter('acf/settings/path', array($this, 'acf_settings_path'));
			
			// Customize ACF URL
			add_filter('acf/settings/dir', array($this, 'acf_settings_dir'));
			
			// Stop ACF upgrade notifications
  			add_filter( 'site_transient_update_plugins', array($this, 'stop_acf_update_notifications' ), 11);	
			
			// Include ACF
			require_once( $this->acf_dir . 'acf.php' );
			
		}
		
		// Show/Hide ACF admin based on config
		if(defined('ACF_SHOW_ADMIN') && false === ACF_SHOW_ADMIN){
			add_filter('acf/settings/show_admin', '__return_false');
		}		
		
	}
	
	/**
	 * Filters the path to the ACF folder
	 *
	 * @since    1.0.0
	 */
	public function acf_settings_path( $path ) {
		$path = $this->acf_dir ;
		return $path;
	}
	
	/**
	 * Filters the URL to the ACF folder
	 *
	 * @since    1.0.0
	 */
	public function acf_settings_dir( $path ) {
		$path = $this->acf_url ;
		return $path;
	}
	
	/**
	 * Stops the upgrade notifications of ACF
	 *
	 * @since    1.0.0
	 */
	public function stop_acf_update_notifications( $value ) {
		unset( $value->response[ $this->acf_dir . 'acf.php' ] );
		return $value;
	}
	
	/**
	 * Returns the current value of acf_modus for use in plugins or themes
	 *
	 * @since    1.0.0
	 */
	public static function acf_modus() {
		return self::$acf_modus;
	}
}