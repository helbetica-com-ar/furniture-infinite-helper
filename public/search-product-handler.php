<?php

// Include the WordPress bootstrap file
require_once('../../../../wp-load.php');

if (isset($_POST['submit-pid'])) {
    
    $number = $_POST['pid']; // #search-by-product-id form

    $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . '/product-details/?pid=' . $number;

    wp_redirect($redirect_url);

    exit;

} else {
    echo 'form submission not recognized';
}