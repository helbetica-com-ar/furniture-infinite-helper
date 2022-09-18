<?php

define('SHORTINIT', true);

if (!defined('ABSPATH')) {
    /** Set up WordPress environment */
    require_once dirname(__FILE__) . '/../../../wp-load.php';
}

# echo 'DIR: ' . dirname(__FILE__) . "\n";


function furniture_infinite_get_json(){

    echo 'furniture_infinite_get_json executed' . PHP_EOL;

    # BASIC AUTHENTICATION POST REQUEST TO FURNITURE INFINITE DATABASE WITH 'WPSTOREADMIN' E-MAIL AND PASSWORD

    $url = FURNITURE_WP_PATH;
    $user = FURNITURE_WP_USER;
    $pass = FURNITURE_WP_PASS;
    $auth = base64_encode($user . ':' . $pass);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Accept: application/json",
        "Authorization: Basic " . $auth . "",
        "Content-Type: application/x-www-form-urlencoded",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $post_response = curl_exec($curl);
    curl_close($curl);
    $post_response = json_decode($post_response, true);
    $bearer = $post_response["token"];

    if ($post_response["message"]) {

        if (false === get_transient('furniture_api_sync_message')) {
            set_transient('furniture_api_sync_message', $post_response["message"], 5 * HOUR_IN_SECONDS); // Expire time 5 hours
        }
        
    } else {

        delete_transient('furniture_api_sync_message');
        
        $lenght = strlen($bearer);
        if (!empty($bearer) && $lenght > 80) {
            # echo 'TOKEN LENGHT IS VALID' . PHP_EOL;
            set_transient('furniture_api_sync_status', true, 63115200); // Expire time 2 years ## REVIEW
        } else {
            # echo 'INVALID LOGIN' . PHP_EOL; 
            set_transient('furniture_api_sync_status', false, 63115200); // Expire time 2 years ## REVIEW
        }

        # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA

        $options = ["http" => ["header" => "Authorization: Bearer $bearer"]];
        $context = stream_context_create($options);

        # ENDPOINT /api/wp
        $api_response_wp = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
        $api_response_wp = json_decode($api_response_wp);
        $api_response_wp = json_encode($api_response_wp, JSON_PRETTY_PRINT);
        $api_response_wp = json_decode($api_response_wp, true); 
        $furnitureInfinite_furnitureData__name = $api_response_wp['furnitureData'][0]['name'];
        $furnitureInfinite_furnitureData__Manufacturers = $api_response_wp['furnitureData'][0]['Manufacturers'];
        $furnitureInfinite__categories = $api_response_wp['categories'];
        $furnitureInfinite__collections = $api_response_wp['collections'];
        update_option('furniture_api_options_Furniture_Infinite_given_store_name',  $furnitureInfinite_furnitureData__name, '', false); // autoload false 
        // echo "<pre><code>" . $api_response_wp . "</code></pre>"; 
        // print_r($api_response_wp);
        set_transient('furniture_api_json_data_wp', $api_response_wp, 63115200); // Expire time 2 years ## REVIEW
        set_transient('furniture_api_json_data_Manufacturers', $furnitureInfinite_furnitureData__Manufacturers, 63115200); // Expire time 2 years ## REVIEW
        set_transient('furniture_api_json_data_categories', $furnitureInfinite__categories, 63115200); // Expire time 2 years ## REVIEW
        set_transient('furniture_api_json_data_collections', $furnitureInfinite__collections, 63115200); // Expire time 2 years ## REVIEW

        # ENDPOINT /api/wp/general-info
        $api_response_wp_gral_info = file_get_contents("https://furnitureinfinite.com/api/wp/general-info", false, $context);
        $api_response_wp_gral_info = json_decode($api_response_wp_gral_info);
        $api_response_wp_gral_info = json_encode($api_response_wp_gral_info, JSON_PRETTY_PRINT);
        $api_response_wp_gral_info = json_decode($api_response_wp_gral_info, true);
        $furnitureInfinite__woodTypes = $api_response_wp_gral_info['woodTypes'];
        // echo "<pre><code>" . $api_response_wp_gral_info . "</code></pre>"; 
        // print_r($api_response_wp_gral_info); 
        set_transient('furniture_api_json_data_wp_gral_info', $api_response_wp_gral_info, 63115200); // Expire time 2 years ## REVIEW
        set_transient('furniture_api_json_data_woodTypes', $furnitureInfinite__woodTypes, 63115200); // Expire time 2 years ## REVIEW
    }

}

if (
    defined('FURNITURE_WP_PATH') && 
    defined('FURNITURE_WP_USER') && 
    defined('FURNITURE_WP_PASS')
    ) {
    # echo 'Custom CONSTANTS for wpStoreAdmin user were declared on WP-CONFIG File' . PHP_EOL; 
    update_option('furniture_api_options_wpStoreAdmin_credentials__present', true, false); // autoload false
    furniture_infinite_get_json();
} else {
    # REPORT
    # return 'Furniture Infinite User Credentials missing in Configuration File';
    update_option('furniture_api_options_wpStoreAdmin_credentials__present', false, false); // autoload false

}


