<?php 

/**
 * @snippet       AutoCreate Simple Product @ WP Admin
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'add_attachment', 'bbloomer_create_simple_product_automatically', 9999 );
 
function bbloomer_create_simple_product_automatically( $image_id ) { 
    $product = new WC_Product_Simple();
    $product->set_name( get_the_title( $image_id ) );
    $product->set_status( 'publish' ); 
    $product->set_catalog_visibility( 'visible' );
    // $product->set_category_ids( array( 20 ) );
    $product->set_price( 1.00 );
    $product->set_regular_price( 1.00 );
    $product->set_sold_individually( false );
    $product->set_image_id( $image_id );
    $product->set_downloadable( false );
    $product->set_virtual( false );      
    $src_img = wp_get_attachment_image_src( $image_id, 'full' );
    //$file_url = reset( $src_img );
    //$file_md5 = md5( $file_url );
    //$download = new WC_Product_Download();
    //$download->set_name( get_the_title( $image_id ) );
    //$download->set_id( $file_md5 );
    //$download->set_file( $file_url );
    //$downloads[$file_md5] = $download;
    //$product->set_downloads( $downloads );
    $product->save();
}