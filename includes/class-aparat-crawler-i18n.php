<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://chakosh.ir
 * @since      1.0.0
 *
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/includes
 * @author     AmirMasoud Sheidayi <amirmasood33@gmail.com>
 */
class Aparat_Crawler_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'aparat-crawler',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
