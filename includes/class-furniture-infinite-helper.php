<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 * @package    Furniture_Infinite_Helper
 * @subpackage furniture-infinite-helper/includes
 * @author     StartEngine <#>
 */

class Furniture_Infinite_Helper
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Furniture_Infinite_Helper_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
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
    public function __construct()
    {
        if (defined('FURNITURE_INFINITE_HELPER_VERSION')) {
            $this->version = FURNITURE_INFINITE_HELPER_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'furniture-infinite-helper';

        $this->load_dependencies();
        $this->define_public_hooks();
        $this->create_master_settings();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-furniture-infinite-helper-loader.php';


        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-furniture-infinite-settings.php';


        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-furniture-infinite-helper-public.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-furniture-infinite-shortcodes.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'furniture-api.php';

        $this->loader = new Furniture_Infinite_Helper_Loader();

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Furniture_Infinite_Helper_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 999, 1);
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 1000, 1);



        $Furniture_Infinite_Shortcodes = new Furniture_Infinite_Shortcodes($this->get_plugin_name(), $this->get_version());

        add_shortcode('all-products', array($Furniture_Infinite_Shortcodes,'furniture_infinite_all_products'));
        add_shortcode('home-categories', array($Furniture_Infinite_Shortcodes,'furniture_infinite_home_categories'));
        add_shortcode('collections', array($Furniture_Infinite_Shortcodes,'furniture_infinite_collections'));
        add_shortcode('pdp', array($Furniture_Infinite_Shortcodes,'furniture_infinite_pdp'));
        add_shortcode('furniture-item', array($Furniture_Infinite_Shortcodes,'furniture_infinite_furniture_item'));
        add_shortcode('all-collections', array($Furniture_Infinite_Shortcodes,'furniture_infinite_all_collections'));
        add_shortcode('manufacturers-collections', array($Furniture_Infinite_Shortcodes,'furniture_infinite_manufacturers_collections'));
        add_shortcode('search-by-id', array($Furniture_Infinite_Shortcodes,'furniture_infinite_search_by_ID'));
        
        // add meta tags
        $this->loader->add_action('wp_head', $Furniture_Infinite_Shortcodes, 'furniture_infinite_set_single_product_page_meta', 1);    

    }

    private function create_master_settings()
    {
        // Adding settings
        $plugin_settings = new Furniture_Infinite_Settings($this->get_plugin_name(), $this->get_version());
        # $this->loader->add_action('admin_init', $plugin_settings, 'furniture_infinite_register_settings');
        # $this->loader->add_action('admin_menu', $plugin_settings, 'furniture_infinite_register_options_page');
        $this->loader->add_action('admin_menu', $plugin_settings, 'furniture_infinite_helper_call_status_page');
    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Furniture_Infinite_Helper_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

}
