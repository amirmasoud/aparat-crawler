<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://chakosh.ir
 * @since             1.0.0
 * @package           Aparat_Crawler
 *
 * @wordpress-plugin
 * Plugin Name:       Aparat Crawler
 * Plugin URI:        http://aparat-crawler.chakosh.ir/
 * Description:       WordPress plugin to crawl Aparat API.
 * Version:           1.0.0
 * Author:            AmirMasoud Sheidayi
 * Author URI:        http://chakosh.ir/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aparat-crawler
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aparat-crawler-activator.php
 */
function activate_aparat_crawler() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aparat-crawler-activator.php';
	Aparat_Crawler_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aparat-crawler-deactivator.php
 */
function deactivate_aparat_crawler() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aparat-crawler-deactivator.php';
	Aparat_Crawler_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aparat_crawler' );
register_deactivation_hook( __FILE__, 'deactivate_aparat_crawler' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aparat-crawler.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aparat_crawler() {

	$plugin = new Aparat_Crawler();
	$plugin->run();

}
run_aparat_crawler();
