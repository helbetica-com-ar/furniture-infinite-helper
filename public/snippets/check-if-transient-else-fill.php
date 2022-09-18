<?php
// Get any existing copy of our transient data
if ( false === ( $special_query_results = get_transient( 'special_query_results' ) ) ) {
	// It wasn't there, so regenerate the data and save the transient
	$special_query_results = new WP_Query( 'cat=5&order=random&tag=tech&post_meta_key=thumbnail' );
	set_transient( 'special_query_results', $special_query_results, 12 * HOUR_IN_SECONDS );
}
// Use the data like you would have normally...
