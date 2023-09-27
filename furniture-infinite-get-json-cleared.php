<?php

# execute via /opt/plesk/php/8.1/bin/php [RELATIVE PATH]

define('SHORTINIT', true);

if (!defined('ABSPATH')) {
    /** Set up WordPress environment */
    require_once dirname(__FILE__) . '/../../../wp-load.php';
}

function furniture_infinite_get_json(){


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
        echo 'ServerResponse message: ' . $post_response["message"] . PHP_EOL;
    } 
    
    # Then check if response has Token
    if(isset($post_response["token"])){
        $bearer = $post_response["token"];
        $lenght = strlen($bearer);
        # Then check if Token is not empty and Token lenght is valid
        if (!empty($bearer) && $lenght > 80) {

            # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA

            $options = ["http" => ["header" => "Authorization: Bearer $bearer"]];
            $context = stream_context_create($options);

            # ENDPOINT /api/wp
            $api_response_wp = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
            $api_response_wp = json_decode($api_response_wp);
            $api_response_wp = json_encode($api_response_wp, JSON_PRETTY_PRINT);
            $api_response_wp = json_decode($api_response_wp, true);

            print_r($api_response_wp);
            var_dump($api_response_wp);
            

        } else {
            echo 'Furniture data not retrieved' . PHP_EOL;
        }
    }
}

