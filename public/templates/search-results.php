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
                if (isset($_GET['collname']) && !empty($_GET['collname'])) {
                    echo 'Collection <span class="string-searched">' . sanitize_text_field($_GET['collname']) . '</span>';
                    echo '<style> .results-collection {display: none;}  .results-collection-no-link { display: block!important; } </style>';
                } elseif ( isset($_GET['q']) && !empty($_GET['q']) ){
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
        <?php
            $search_query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
            $collectionID = isset($_GET['coll']) ? $_GET['coll'] : '';
            $manufacturerID = isset($_GET['man']) ? $_GET['man'] : '';
            if (!empty($search_query) || (!empty($collectionID) && !empty($manufacturerID))) {

                if (!empty($collectionID) && !empty($manufacturerID)){
                    $url = 'https://furnitureinfinite.com/api/furniture?collectionId=' . urlencode($collectionID) . '&manufacturerId=' . urlencode($manufacturerID) . '&page=1&per_page=100&search=' . urlencode($search_query);
                } else {
                    $url = 'https://furnitureinfinite.com/api/furniture?page=1&per_page=100&search=' . urlencode($search_query);
                }
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
                    echo '<section class="search-notice-wrapper"><p>Error: ' . $auth_response->get_error_message() . '</p>';
                    return;
                }
                
                $auth_data = json_decode(wp_remote_retrieve_body($auth_response), true);
                if (!isset($auth_data['token'])) {
                    echo '<section class="search-notice-wrapper"><p>Authentication failed. No token received.</p>';
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
                    
                    echo '<section class="search-notice-wrapper"><p>There was an error while fetching the information that you are looking for.</p><p>Please try again shortly</p>';

                    return;

                } else {

                    $body = wp_remote_retrieve_body($api_response_wp);
                    
                    # echo '<pre>' . htmlspecialchars($body) . '</pre>';

                    $data = json_decode($body, true);
                    if ($data){
                        if ( empty($data['data']) && $data['totalItems'] == 0 ) {
                            echo '<section class="search-notice-wrapper"><p style="display: block; width: 100%;"><strong>SORRY</strong><br/>No results were found for your search</p>';
                        } else {
                            echo '<section class="search-results-wrapper">';
                            foreach ($data['data'] as $item) {
                                if (isset($item['Images'][0]['path'])){
                                    $name = $item['name'];
                                    $pid = $item['id'];
                                    $category = $item['Category']['name'];
                                    $categoryID = $item['Category']['id'];
                                    $subcategory = $item['SubCategory']['name'];
                                    $subcategoryID = $item['SubCategory']['id'];
                                    $collection = $item['Collection']['name'];
                                    $collectionID = $item['Collection']['id'];
                                    $manufacturer = $item['Manufacturer']['name'];
                                    $manufacturerID = $item['Manufacturer']['id'];
                                    $imagePath = str_replace('-original', '-300x300', $item['Images'][0]['path']);
                                    #$imagePath = $item['Images'][0]['path'];
            
                                    // Build the HTML content using a variable
                                    $html = '<article class="results-wrapper">';
                                    $html .= '<a href="/product-details/?from-furniture-item=' . sanitize_title($name) . '&pid=' . $pid . '">';
                                    $html .= '<img src="https://infinite-digital-production.s3.us-east-2.amazonaws.com/' . $imagePath . '" alt="' . $name . '">';
                                    $html .= '</a>';
                                    $html .= '<p class="results-title"> ' . $name . '</p>';
                                    $html .= '<p class="results-category">Category: <br/>';
                                    $html .= '<a href="/furniture/' . sanitize_title($category) . '/?cat-id=' . $categoryID . '">' . $category . '</a>';
                                    $html .= ' » ';
                                    $html .= '<a href="/furniture/' . sanitize_title($category) . '/?showing-subcategory=' . sanitize_title($subcategory) . '&sub-cat-id=' . $subcategoryID . '">' . $subcategory . '</a>';
                                    $html .= '</p>';
                                    $html .= '<p class="results-collection">Collection: <br/>';
                                    $html .= '<a href="./?collname=' . urlencode($collection) . '&coll=' . $collectionID . '&man=' . $manufacturerID . '&q=" >';
                                    $html .= $collection . '</a></p>';
                                    $html .= '<p class="results-collection-no-link">Collection: <br/>' . $collection . '</p>';
                                    $html .= '<p class="builder-name-reveal" style="display: none;">Builder: <br/>' . $manufacturer . ' (' . $manufacturerID  . ')</p>';
                                    $html .= '</article>';
                                    
                                    // Output the HTML content
                                    echo $html;
                                }
                            }
                        }
                    }
                }

            } else {
                echo '<p>Type in on the search bar what you are intrested in.</p>';
            }
        ?>
        </section><!-- /.search-results-wrapper/.search-notice-wrapper -->
    </div><!-- /.page-content -->
</main>
<?php
//get_footer();
