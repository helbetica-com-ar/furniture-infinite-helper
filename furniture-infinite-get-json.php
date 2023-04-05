<?php

# execute via /opt/plesk/php/8.1/bin/php [RELATIVE PATH]

define('SHORTINIT', true);

if (!defined('ABSPATH')) {
    /** Set up WordPress environment */
    require_once dirname(__FILE__) . '/../../../wp-load.php';
}

echo 'STATUS CHECK #01: DIR: ' . dirname(__FILE__) . "\n"; 


function furniture_infinite_get_json(){

    echo 'STATUS CHECK #03: Function furniture_infinite_get_json() executed' . PHP_EOL;

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

    # First check for Invalid response (incorrect email or password)
    if (isset($post_response["message"])) {
        echo 'STATUS CHECK #04: SYNC Status FALSE' . PHP_EOL;
        echo 'STATUS CHECK #04: Response message: ' . $post_response["message"] . PHP_EOL;
        echo 'STATUS CHECK #04: Saving response message to WP DB.' . PHP_EOL;
        set_transient('furniture_api_sync_message', $post_response["message"], 5 * HOUR_IN_SECONDS); // Expire time 5 hours
        set_transient('furniture_api_sync_status', 'false', 63115200); // Expire time 2 years ## REVIEW
    } else {
        echo 'STATUS CHECK #04: No response message from JSON retrievedelete message if present' . PHP_EOL;
        echo 'STATUS CHECK #04: Deleting any previous retrieves message from WP DB' . PHP_EOL;
        delete_transient('furniture_api_sync_message');
    }
    
    # Then check if response has Token
    if(isset($post_response["token"])){
        echo 'STATUS CHECK #05: Token retrieved' . PHP_EOL;
        $bearer = $post_response["token"];
        $lenght = strlen($bearer);
        # Then check if Token is not empty and Token lenght is valid
        if (!empty($bearer) && $lenght > 80) {
            echo 'STATUS CHECK #06: Token not empty and lenght is valid' . PHP_EOL;
            echo 'STATUS CHECK #06: Token: ' . $post_response["token"] . PHP_EOL;
            echo 'STATUS CHECK #06: SYNC Status True' . PHP_EOL;
            set_transient('furniture_api_sync_status', 'true', 63115200); // Expire time 2 years ## REVIEW

            # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA

            $options = ["http" => ["header" => "Authorization: Bearer $bearer"]];
            $context = stream_context_create($options);

            # ENDPOINT /api/wp
            $api_response_wp = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
            $api_response_wp = json_decode($api_response_wp);
            $api_response_wp = json_encode($api_response_wp, JSON_PRETTY_PRINT);
            $api_response_wp = json_decode($api_response_wp, true);
            $furnitureInfinite_furnitureData_name = $api_response_wp['furnitureData'][0]['name'];
            $furnitureInfinite_furnitureData_Manufacturers = $api_response_wp['furnitureData'][0]['Manufacturers'];
            $furnitureInfinite_categories = $api_response_wp['categories'];
            $furnitureInfinite_collections = $api_response_wp['collections'];
            update_option('furniture_api_options_Furniture_Infinite_given_store_name',  $furnitureInfinite_furnitureData_name, '', false); // autoload false 
            update_option('furniture_api_options_Furniture_Infinite_last_save',  date("l d\, M Y \- h:i"), '', false); // autoload 
            // echo "<pre><code>" . $api_response_wp . "</code></pre>"; 
            // print_r($api_response_wp);
            set_transient('furniture_api_json_data_wp', $api_response_wp, 63115200); // Expire time 2 years ## REVIEW
            set_transient('furniture_api_json_data_Manufacturers', $furnitureInfinite_furnitureData_Manufacturers, 63115200); // Expire time 2 years ## REVIEW
            set_transient('furniture_api_json_data_categories', $furnitureInfinite_categories, 63115200); // Expire time 2 years ## REVIEW
            set_transient('furniture_api_json_data_collections', $furnitureInfinite_collections, 63115200); // Expire time 2 years ## REVIEW

            # ENDPOINT /api/wp/general-info
            $api_response_wp_gral_info = file_get_contents("https://furnitureinfinite.com/api/wp/general-info", false, $context);
            $api_response_wp_gral_info = json_decode($api_response_wp_gral_info);
            $api_response_wp_gral_info = json_encode($api_response_wp_gral_info, JSON_PRETTY_PRINT);
            $api_response_wp_gral_info = json_decode($api_response_wp_gral_info, true);
            $furnitureInfinite_woodTypes = $api_response_wp_gral_info['woodTypes'];
            // echo "<pre><code>" . $api_response_wp_gral_info . "</code></pre>"; 
            // print_r($api_response_wp_gral_info); 
            set_transient('furniture_api_json_data_wp_gral_info', $api_response_wp_gral_info, 63115200); // Expire time 2 years ## REVIEW
            set_transient('furniture_api_json_data_woodTypes', $furnitureInfinite_woodTypes, 63115200); // Expire time 2 years ## REVIEW

        } else {
            echo 'STATUS CHECK #06: Token not retrieved' . PHP_EOL;
            echo 'STATUS CHECK #06: SYNC Status FALSE' . PHP_EOL;
            set_transient('furniture_api_sync_status', 'Token Lenght Invalid', 63115200); // Expire time 2 years ## REVIEW
        }
    }
}

if (
    defined('FURNITURE_WP_PATH') && 
    defined('FURNITURE_WP_USER') && 
    defined('FURNITURE_WP_PASS')
    ) {
    update_option('furniture_api_options_wpStoreAdmin_credentials_present', 'true', '', false); // autoload false
    echo 'STATUS CHECK #02: WP Custom CONSTANTS for wpStoreAdmin are set on wp-config.php' . PHP_EOL; 
    furniture_infinite_get_json();
} else {
    update_option('furniture_api_options_wpStoreAdmin_credentials_present', 'false', '', false); // autoload false
    echo 'STATUS CHECK #02: Furniture Infinite User Credentials (wpStoreAdmin) missing on wp-config.php' . PHP_EOL; 
}


