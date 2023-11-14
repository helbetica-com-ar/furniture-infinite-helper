<?php
/*
Template Name: Custom Search Results Template
*/
get_header();
?>
<main id="content" class="site-main page furniture-search-results type-page status-publish hentry">
    <header class="page-header">
        <h1 class="entry-title">
            <?php
                if ( isset($_GET['q']) && !empty($_GET['q']) ){
                    echo 'Search Results for <span class="string-searched">' . sanitize_text_field($_GET['q']) . '</span>';
                } else {
                    echo 'Search';
                }
            ?>
        </h1>
    </header>
    <div class="page-content">
        <div class="custom-search-wrapper">
            <?php echo do_shortcode( '[custom-search-form]' ); ?>
        </div>
        <section class="search-results-wrapper">
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
                
                // echo $bearer_token . '<br/>';

                # BEARER TOKEN AUTHENTICATION GET RESPONSE WITH JSON DATA
                $auth_header_value = "Bearer $bearer_token";
                
                # ENDPOINT /api/wp
                $api_response_wp = wp_remote_get($url, array(
                    'headers' => array(
                        'Authorization' => $auth_header_value
                    )
                ));

                if ($api_response_wp === false) {
                    
                    echo '<p>There was an error while fetching the information that you are looking for.</p><p>Please try again shortly</p>';

                    return;

                } else {

                    $body = wp_remote_retrieve_body($api_response_wp);
                    
                    echo $body;

                    $data = json_decode($body, true);

                    foreach ($data['data'] as $item) {
                        if (isset($item['Images'][0]['path'])){
                            $name = $item['name'];
                            $pid = $item['id'];
                            $category = $item['Category']['name'];
                            $subcategory = $item['SubCategory']['name'];
                            $collection = $item['Collection']['name'];
                            $imagePath = str_replace('-original', '-300x300', $item['Images'][0]['path']);
                            #$imagePath = $item['Images'][0]['path'];
    
                            echo '<article class="results-wrapper">';
                            echo '<a href="/product-details/?from-furniture-item=' . sanitize_title($name) . '&pid=' . $pid . '">';
                            //echo '<a href="/product-details/?pid=' . $pid . '">';
                            echo '<img src="https://infinite-digital-production.s3.us-east-2.amazonaws.com/' . $imagePath . '" alt="' . $name . '">';
                            echo '</a>';
                            echo '<p class="results-title"> ' . $name . '</p>';
                            echo '<p class="results-category">Category: ' . $category . ' » ' . $subcategory . '</p>';
                            echo '<p class="results-collection">Collection: ' . $collection . '</p>';
                            echo '</article>';
                        }
                    }

                }

            } else {
                echo '<p>Type in on the search bar what you are intrested in.</p>';
            }
        ?>
        </section><!-- /.search-results-wrapper -->
    </div><!-- /.page-content -->
</main>
<?php
//get_footer();
