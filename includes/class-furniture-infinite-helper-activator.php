<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Furniture_Infinite_Helper
 * @subpackage furniture-infinite-helper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Furniture_Infinite_Helper
 * @subpackage furniture-infinite-helper/includes
 * @author     StartEngine <#>
 */
class Furniture_Infinite_Helper_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path(__FILE__) . '../furniture-infinite-get-json.php';
	}

}
