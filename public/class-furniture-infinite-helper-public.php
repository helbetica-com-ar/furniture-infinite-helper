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
        wp_enqueue_style($this->plugin_name . '-furniture-styles', plugin_dir_url(__FILE__) . 'css/helper-furniture-styles.css' , array(), rand(), 'all');
        wp_enqueue_style($this->plugin_name . '-sites', plugin_dir_url(__FILE__) . 'css/sites.css' , array(), rand(), 'all'); 
    }

    public function enqueue_scripts()
    {
        wp_register_script('init-furniture-infinite-js', plugin_dir_url(__FILE__) . 'js/init-furniture-infinite.js', array('jquery'), date('U'), true);
        wp_enqueue_script('init-furniture-infinite-js');
    }

}