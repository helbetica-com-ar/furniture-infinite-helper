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
                $url = 'https://furnitureinfinite.com/api/furniture?page=1&per_page=25&search=' . urlencode($search_query);
                $user = FURNITURE_WP_USER;
                $pass = FURNITURE_WP_PASS;
                // Obtain Bearer Token
                $auth_response = wp_remote_post(FURNITURE_WP_PATH, array(
                    'headers' => array(
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ),
                    'body' => array(
                        'email' => $user,
                        'password' => $pass,
                    ),
                    'sslverify' => false, // for debug only!
                ));
                if (is_wp_error($auth_response)) {
                    echo 'Error: ' . $auth_response->get_error_message();
                    return;
                }
                $auth_data = json_decode(wp_remote_retrieve_body($auth_response), true);
                if (!isset($auth_data['token'])) {
                    echo 'Authentication failed. No token received.';
                    return;
                }
                $bearer_token = $auth_data['token'];
                echo $bearer_token . '<br/>';
                # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA
                $options = ["http" => ["header" => "Authorization: Bearer $bearer_token"]];
                $context = stream_context_create($options);
                # ENDPOINT /api/wp
                $api_response_wp = file_get_contents($url, false, $context);
                if ($api_response_wp === false) {
                    echo 'Error fetching API response.';
                    return;
                }
                echo $api_response_wp;
            } else {
                echo '<p>No search query provided.</p>';
            }
        ?>
        </div><!-- /.search-results-wrapper -->
    </div><!-- /.page-content -->
</main>
<?php
get_footer();