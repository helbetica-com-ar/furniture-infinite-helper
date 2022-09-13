<?php

class Furniture_Infinite_Helper_Public
{

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
        // wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/startengine-helper-public.css', array('wpdreams-asl-basic', 'wpdreams-ajaxsearchlite'), rand(), 'all');
        // wp_enqueue_style($this->plugin_name . '-another', plugin_dir_url(__FILE__) . 'css/startengine-helper-public-new.css', array('wpdreams-asl-basic', 'wpdreams-ajaxsearchlite'), rand(), 'all');
        // wp_enqueue_style($this->plugin_name . '-fonts', plugin_dir_url(__FILE__) . 'css/ibm-font.css', array('wpdreams-asl-basic', 'wpdreams-ajaxsearchlite'), rand(), 'all');
        wp_enqueue_style($this->plugin_name . '-furniture-styles', plugin_dir_url(__FILE__) . 'css/helper-furniture-styles.css' , array(), rand(), 'all');

    }

    public function enqueue_scripts()
    {
        // if (is_page(array(4273, 4291))) wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/startengine-helper-public.js', array('jquery'), $this->version, false);
        // wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/startengine-helper.js', array('jquery'), rand(), false);
        // wp_enqueue_script($this->plugin_name . '_custom_tracking', plugin_dir_url(__FILE__) . 'js/custom-tracking.js', array('jquery'), rand(), true);
    }

}