<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://chakosh.ir
 * @since      1.0.0
 *
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/admin
 * @author     AmirMasoud Sheidayi <amirmasood33@gmail.com>
 */
class Aparat_Crawler_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $aparat_crawler    The ID of this plugin.
	 */
	private $aparat_crawler;

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
	 * @param      string    $aparat_crawler       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $aparat_crawler, $version ) {

		$this->aparat_crawler = $aparat_crawler;
		$this->version = $version;

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
		 * defined in Aparat_Crawler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aparat_Crawler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->aparat_crawler, plugin_dir_url( __FILE__ ) . 'css/aparat-crawler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Aparat_Crawler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aparat_Crawler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->aparat_crawler, plugin_dir_url( __FILE__ ) . 'js/aparat_crawler-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register aparat page.
	 * 
	 * @since 	1.0.0
	 */
	public function oscimp_admin_actions() {
    	add_options_page("آپارات", "آپارات", 1, "aparat", array($this, 'crawler'));
	}

	/**
	 * Main aparat crawler functionality.
	 *
	 * @since 	1.0.0
	 */
	public function crawler() {
		
	}

}
