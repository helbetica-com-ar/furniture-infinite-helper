<?php
/*
Template Name: Custom Search Results Template
*/

get_header();
?>
<main id="content" class="site-main page page-search-results type-page status-publish hentry">
    <header class="page-header">
        <h1 class="entry-title">Search Results</h1>
    </header>
    <div class="page-content">
        <div class="custom-search-wrapper">
            <?php echo do_shortcode( '[search-external-db]' ); ?>
        </div>
        <div class="search-results-wrapper">
        <?php
            $search_query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

            if (!empty($search_query)) {

                # BASIC AUTHENTICATION POST REQUEST TO FURNITURE INFINITE DATABASE WITH 'WPSTOREADMIN' E-MAIL AND PASSWORD
                $url = FURNITURE_WP_PATH;
                $user = FURNITURE_WP_USER;
                $pass = FURNITURE_WP_PASS;
                $auth = base64_encode($user . ':' . $pass);
                $data = array(
                    'email' => $user,
                    'password' => $pass,
                );
                
                $response = wp_remote_post($url, array(
                    'headers' => array(
                        'Accept' => 'application/json',
                        'Authorization' => 'Basic ' . $auth,
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ),
                    'body' => $data,
                    'sslverify' => false, // for debug only!
                ));
                
                if (is_wp_error($response)) {
                    echo 'Error on response: ' . $response->get_error_message();
                    return;
                }
                
                $post_response = json_decode(wp_remote_retrieve_body($response), true);
                
                # First check for Invalid response (incorrect email or password)
                if (isset($post_response["message"])) {
                    echo 'ServerResponse message: ' . $post_response["message"] . PHP_EOL;
                    return;
                }
                
                # Then check if response has Token
                if (isset($post_response["token"])) {
                    $bearer = $post_response["token"];
                    $length = strlen($bearer);
                    
                    # Then check if Token is not empty and Token length is valid
                    if (!empty($bearer) && $length > 80) {
                        # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA
                        $options = array(
                            'headers' => array(
                                'Authorization' => 'Bearer ' . $bearer,
                            ),
                        );
                        $api_response_wp = 'https://furnitureinfinite.com/api/furniture?page=1&per_page=25&search=' . urlencode($search_query);
                        echo 'output: '.$api_response_wp . '<br/ >';
                        //$api_response_wp = wp_remote_get('https://furnitureinfinite.com/api/wp', $options);
                        
                        if (is_wp_error($api_response_wp)) {
                            echo 'Error on api_response_wp: ' . $api_response_wp->get_error_message();
                            return;
                        }
                        
                        $api_response_wp = json_decode(wp_remote_retrieve_body($api_response_wp), true);
                        
                        print_r($api_response_wp);
                        var_dump($api_response_wp);
                    } else {
                        echo 'Furniture data not retrieved' . PHP_EOL;
                    }
                }
            } else {
                echo '<p>No search query provided.</p>';
            }
        ?>
        </div><!-- /.search-results-wrapper -->
    </div><!-- /.page-content -->
</main>

<?php
get_footer();