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

                if ( defined('FURNITURE_WP_USER') && defined('FURNITURE_WP_PASS') ) {
                    $user = FURNITURE_WP_USER;
                    $pass = FURNITURE_WP_PASS;
                }

                // Make API request with basic authentication
                $api_url = 'https://furnitureinfinite.com/api/furniture?page=1&per_page=25&search=' . urlencode($search_query);
                $username = $user;
                $password = $pass;

                $response = wp_safe_remote_get($api_url, array(
                    'headers' => array(
                        'Authorization' => 'Basic ' . base64_encode($username . ':' . $password)
                    )
                ));

                echo 'api_url: ' . $api_url; 
                echo '<br />'; 
                echo 'username: ' . $username; 
                echo '<br />'; 
                echo 'password: ' . $password; 
                echo '<br />'; 
                var_dump($response);


                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                    $data = wp_remote_retrieve_body($response);
                    $results = json_decode($data); // Assuming API returns JSON data

                    if (!empty($results)) {
                        echo '<h2>Search Results</h2>';

                        // Display search results
                        foreach ($results as $result) {
                            // Display each result item as needed
                            echo '<div class="search-result">';
                            echo '<h3>' . esc_html($result->title) . '</h3>';
                            echo '<p>' . esc_html($result->description) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No results found.</p>';
                    }
                } else {
                    echo '<p>Error fetching results MOFO.</p>';
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