<?php

class Chariho_Settings
{
    private $plugin_name;
    private $version;


    private $page = array(
        'title' => '',
        'slug' => 'default_pagename',
    );

    private $settings;
    private $setting_section;


    private $options;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function chariho_register_settings() {
        
        add_option( 'furniture_api_bearer_token', 'This is my option value.');
        register_setting( 'furniture_api_options_group', 'furniture_api_bearer_token', 'furniture_api_plugin_callback' );
    }

    public function chariho_register_options_page() {
        add_options_page('Furniture API', 'Furniture API', 'manage_options', 'furniture_api_plugin', array($this, 'chariho_options_page') );
    }
    
    function chariho_options_page(){ ?>
        <div>
            <?php //screen_icon(); ?>
            <h2>Furniture API Bearer Token</h2>
            <form method="post" action="options.php">
                <?php settings_fields( 'furniture_api_options_group' ); ?>
                <table>
                    <tr valign="top">
                        <th scope="row"><label for="furniture_api_bearer_token">Bearer Token</label></th>
                        <td><textarea id="furniture_api_bearer_token" name="furniture_api_bearer_token"><?php echo get_option('furniture_api_bearer_token'); ?></textarea></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php
    }

}