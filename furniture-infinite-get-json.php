<?php

define('SHORTINIT', true);

if (!defined('ABSPATH')) {
    /** Set up WordPress environment */
    require_once __DIR__ . '/../../../wp-load.php';
}


function furniture_infinite_get_json(){

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
    # $bearer = get_option('furniture_api_bearer_token');
    $options = ["http" => ["header" => "Authorization: Bearer $bearer"]];
    
    $context = stream_context_create($options);
    
    $response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
    $response = json_decode($response);
    $response = json_encode($response, JSON_PRETTY_PRINT);
    $response = json_decode($response, true);

    // echo "<pre><code>" . $response . "</code></pre>";
    // print_r($response);

    // Expire time 6 hours
    set_transient('furniture_api_json_data_cron', $response, 60 * 60 * 6);
    
}
furniture_infinite_get_json();