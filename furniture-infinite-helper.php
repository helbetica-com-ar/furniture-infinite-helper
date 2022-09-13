<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Furniture_Infinite_helper
 *
 * @wordpress-plugin
 * Plugin Name:       Furniture Infinite Helper
 * Plugin URI:        #
 * Description:       #
 * Version:           5.6.5
 * Author:            WPSPIN LLC
 * Author URI:        https://wpspins.com/?utm_source=StartEngineHelperPlugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       furniture-infinite-helper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FURNITURE_INFINITE_HELPER_VERSION', '1.0.0' );

define( 'FURNITURE_INFINITE_HELPER_FILEPATH', plugin_dir_path(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-startengine-helper-activator.php
 */
function activate_furniture_infinite_helper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-furniture-infinite-helper-activator.php';
	Furniture_Infinite_Helper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-startengine-helper-deactivator.php
 */
function deactivate_furniture_infinite_helper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-furniture-infinite-helper-deactivator.php';
	Furniture_Infinite_Helper_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_furniture_infinite_helper' );
register_deactivation_hook( __FILE__, 'deactivate_furniture_infinite_helper' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-furniture-infinite-helper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_furniture_infinite_helper() {

	$plugin = new Furniture_Infinite_Helper();
	$plugin->run();
	

}
run_furniture_infinite_helper();
