<?php

class Furniture_Infinite_Settings
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

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function furniture_infinite_helper_call_status_page() {
        add_menu_page(
            'Furniture API',
            'Furniture API',
            'manage_options',
            'furniture-infinite-helper-status',
            array($this, 'furniture_infinite_helper_status_page'),
            'dashicons-database-import',
            70
        );
    }

    public function furniture_infinite_helper_status_page(){ ?>
        <div stye="max-width: 80%;" class="wrapper furniture-infinite-helper-status-page">
            <h1>Furniture API</h1>
            <h2>Furniture Infinite Helper Status Page</h2>
            <p style="margin-top: 40px;"><u>FURNITURE INFINITE FIELDS:</u></p>
            <form method="post" action="options.php">
                <?php # settings_fields('furniture_api_options_group'); 
                ?>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr class="status-page-row">
                            <th scope="row">
                                <label for="sc_builder_code_defaults">wpStoreAdmin email:</label>
                            </th>
                            <td>
                                <?php
                                if (defined('FURNITURE_WP_USER')) {
                                    echo '<b>' . FURNITURE_WP_USER . '</b>';
                                } else {
                                    echo '<p style="color:red;"><b>Custom CONSTANT for Furniture Infite wpStoreAdmin user missing on WP-CONFIG File</b><p>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if (false !== get_transient('furniture_api_sync_message')) { ?>
                            <tr class="status-page-row">
                                <th scope="row">
                                    <label for="sc_builder_code_defaults">API Response:</label>
                                </th>
                                <td>
                                    <?php echo '<p style="color:red;"><b>' . get_transient('furniture_api_sync_message') .  '</b><p>'; ?>
                                </td>
                            </tr><?php
                        }

                        if ("false" === get_transient('furniture_api_sync_status')) { ?>
                            <tr class="status-page-row">
                                <th scope="row">
                                    <label for="sc_builder_code_defaults">Sync Status:</label>
                                </th>
                                <td>
                                    <?php echo '<p style="color:red;"><span style="font-size: 250%;" class="dashicons dashicons-no"></span><p>'; ?>
                                </td>
                            </tr><?php
                        } 

                        if ('true' === get_transient('furniture_api_sync_status')) { ?>
                            <tr class="status-page-row">
                                <th scope="row">
                                    <label for="sc_builder_code_defaults">Sync Status:</label>
                                </th>
                                <td>
                                    <?php echo '<p style="color:green;"><span style="font-size: 250%;" class="dashicons dashicons-plugins-checked"></span><p>'; ?>
                                </td>
                            </tr><?php
                        } 

                        if (false !== get_option('furniture_api_options_Furniture_Infinite_given_store_name')) { ?>
                            <tr class="status-page-row">
                                <th scope="row">
                                    <label for="sc_builder_code_defaults">External DB Store Name:</label>
                                </th>
                                <td>
                                    <?php echo '<p style="color: blue; font-style:italic;"><b>' . get_option('furniture_api_options_Furniture_Infinite_given_store_name') .  '</b><p>'; ?>
                                </td>
                            </tr><?php
                        } 

                        if (false !== get_option('furniture_api_options_Furniture_Infinite_last_save')) { ?>
                            <tr class="status-page-row">
                                <th scope="row">
                                    <label for="sc_builder_code_defaults">Last Save:</label>
                                </th>
                                <td>
                                    <?php echo '<p style="color:blue;"><b>' . get_option('furniture_api_options_Furniture_Infinite_last_save') .  '</b><p>'; ?>
                                </td>
                            </tr><?php
                        } ?>
                    </tbody>
                </table>
                <?php # submit_button(); 
                ?>
            </form>
        </div><?php
    }

    /*
    public function furniture_infinite_register_options_page() {
        add_options_page('Furniture API', 'Furniture API', 'manage_options', 'furniture_api_plugin', array($this 'furniture_infinite_options_page') );
        add_menu_page('Furniture API', 'Furniture API', 'manage_options', 'furniture-infinite-helper-info-page', 'furniture_infinite_options_page', 'dashicons-database-import', 101);
    }

    public function furniture_infinite_register_settings(){
        add_option( 'furniture_api_bearer_token', 'This is my option value.');
        register_setting( 'furniture_api_options_group', 'furniture_api_bearer_token', 'furniture_api_plugin_callback' );
    }
    */
}
