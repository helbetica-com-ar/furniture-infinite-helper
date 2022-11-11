<?php

class Furniture_Infinite_Shortcodes
{

    private $plugin_name;
    private $version;

    private $baseURL;
    private $legacyBaseURL;
    private $auth_token;

    private $main_categories = FURNITURE_CAT_LIST;

    private $image_prefix = 'https://infinite-digital-production.s3.us-east-2.amazonaws.com/';


    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function furniture_infinite_all_products()
    {

        $main_categories_ids = $this->get_main_categories_ids();

        if (isset($_GET['search']) && !empty($_GET['search'])) {

            $this->furniture_infinite_search();

        } elseif (isset($_GET['cat-id']) && !isset($_GET['sub-cat-id']) && in_array($_GET['cat-id'], $main_categories_ids)) {

            $this->furniture_infinite_sub_categories($_GET['cat-id']);

        } elseif (isset($_GET['sub-cat-id'])) {

            $this->furniture_infinite_products_by_category();

        } elseif (isset($_GET['collection-id'])) {

            $this->furniture_infinite_products_by_collection();

        } else {

            $this->furniture_infinite_all_main_categories();

        }
    }

    public function furniture_infinite_all_main_categories()
    {

        $response = get_transient('furniture_api_json_data_wp');
        $categories = array();
        $display_cat = $this->get_main_categories();

        foreach ($response['categories'] as $parent_category) {

            if (in_array($parent_category['name'], $display_cat)) {

                $categories[] = array(
                    'cat-id'    => $parent_category['id'],
                    'name'  => $parent_category['name']
                );
            }
        }

        $no_of_records_per_page = 12;
        $total_rows = count($categories);
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
            
            $categories = array_splice($categories, $_GET['offset'], $no_of_records_per_page);

        } else {
            
            $categories = array_splice($categories, 0, $no_of_records_per_page);
            
        }

        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-categories.php';
    }

    public function furniture_infinite_sub_categories($id)
    {

        $response = get_transient('furniture_api_json_data_wp');

        $categories = array();
        $main_category = $this->filter_array_by_id($response['categories'], $id);
        $main_category_name = $this->get_main_category_name_by_id($id);
        $sub_categories = $main_category['SubCategories'];

        // foreach ($sub_categories as $sub_category) {
        //     $categories[] = array(
        //         'cat-id'    => $sub_category['id'],
        //         'name'      => $sub_category['name'],
        //         'p_count'   => $this->furniture_infinite_count_products('SubCategoryId', $sub_category['id']),
        //     );
        // }

        $no_of_records_per_page = 10000;
        $total_rows = count($sub_categories);
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {

            $categories = array_splice($sub_categories, $_GET['offset'], $no_of_records_per_page);
        } else {
            $categories = array_splice($sub_categories, 0, $no_of_records_per_page);
        }

        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-sub-category.php';
    }

    public function furniture_infinite_products_by_category()
    {

        $response = get_transient('furniture_api_json_data_wp');

        $categories = array();

        foreach ($response['categories'] as $parent_category) {

            $categories[] = array(
                'cat-id'    => $parent_category['id'],
                'name'  => $parent_category['name']
            );

            if (isset($parent_category['SubCategories']) && !empty($parent_category['SubCategories'])) {

                foreach ($parent_category['SubCategories'] as $sub_category) {

                    $categories[] = array(
                        'sub-cat-id'    => $sub_category['id'],
                        'name'  => $sub_category['name']
                    );
                }
            }
        }

        $manufacturers = $response['furnitureData'][0]['Manufacturers'];

        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-products.php';
    }

    public function furniture_infinite_products_by_collection()
    {

        #if (!isset($_GET['manufacturer-id']) || !is_numeric($_GET['manufacturer-id'])) { wp_redirect('/all-products'); }
        #$response = get_transient('furniture_api_json_data_wp');
        #$manufacturers = $response['furnitureData'][0]['Manufacturers'];
        #include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-products-by-collection.php';
        if (!isset($_GET['collection-id']) || !is_numeric($_GET['collection-id'])) { wp_redirect('/furniture'); }
        $response = get_transient('furniture_api_json_data_wp');
        $collections = get_transient('furniture_api_json_data_collections');
        $manufacturers = $response['furnitureData'][0]['Manufacturers'];
        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-collection-s-products.php';

    }

    public function get_main_categories()
    {
        return $this->main_categories;
    }

    public function get_main_categories_ids()
    {

        $main_categories = $this->get_main_categories();
        $response = get_transient('furniture_api_json_data_wp');
        $main_categories_ids = [];

        foreach ($response['categories'] as $parent_category) {
            if (in_array($parent_category['name'], $main_categories)) {
                array_push($main_categories_ids, $parent_category['id']);
            }
        }

        return $main_categories_ids;
    }

    public function get_main_category_name_by_id($id)
    {
        $main_categories = $this->get_main_categories();
        $response = get_transient('furniture_api_json_data_wp');

        foreach ($response['categories'] as $parent_category) {
            if ($parent_category['id'] == $id) {
                return $parent_category['name'];
            }
        }

        return '';
    }

    public function furniture_infinite_home_categories()
    {

        $response = get_transient('furniture_api_json_data_wp');
        # $response_categories = get_transient('furniture_api_json_data_categories');
        # print("<div id='var-dump' style='display:none;'><pre>".print_r($response_categories,true)."</pre></div>");
        # print("<pre>" . print_r($response_categories, true) . "</pre>"); 
        #$count = count($response_categories);
        #for ($i = 0; $i < $count; $i++) {
        #    echo $response_categories[$i]['name'] . '<br>';
        #}

        $categories = $response['categories'];
        $display_cat = $this->get_main_categories();
        $ordered_categories = array_column($categories, 'name');
        array_multisort($ordered_categories, SORT_ASC, $categories);

        include FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/home-categories.php';
    }

    public function furniture_infinite_collections()
    {

        $response = get_transient('furniture_api_json_data_wp');

?>
        <style type="text/css"></style>
        <section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);"> 
            <div class="img-heading-su-874">
                <h1>COLLECTIONS</h1>
            </div>
        </section>
        <div class="grid-container class-furniture-infinite-shortcode-php collection-image collection-984564">
            <?php

            $manufacturers = $response['furnitureData'][0]['Manufacturers'];
            //echo "<pre>"; print_r($response); echo "</pre>";exit;
            $cat_ids = array();
            foreach ($manufacturers as $key => $manufacturer) {
                $products = $manufacturer['Furniture'];
                foreach ($products as $key => $product) {
                    if (in_array($product['CategoryId'], $cat_ids)) {
                    } else {
                        $cat_ids[] = $product['CategoryId'];
                    }
                }
            }

            $count_sub_cat = 0;

            foreach ($response['categories'] as $col_value) {

                $count_sub_cat = count($col_value['SubCategories']);

                if ($count_sub_cat > 0) {

                    $url = site_url() . '/all-products/?sub-cat-id=' . $col_value['id'];
                } else {

                    $url = site_url() . '/all-products/?cat-id=' . $col_value['id'];
                }

                if (in_array($col_value['id'], $cat_ids)) {

                    echo '<div><a href="' . $url . '">';
                    echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
                    echo '<div class="grid-item">';
                    print_r($col_value['name']);
                    echo "</div>";
                    echo '</a></div>';
                }
            }
            ?>
        </div>
    <?php
    }

    public function furniture_infinite_all_collections()
    {

        $response = get_transient('furniture_api_json_data_wp');

        $collections = $response['collections'];

        $no_of_records_per_page = 30;
        $total_rows = count($collections);
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
            $collections = array_splice($collections, $_GET['offset'], $no_of_records_per_page);
        } else {
            $collections = array_splice($collections, 0, $no_of_records_per_page);
        }

        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-collections.php';
    }

    public function furniture_infinite_manufacturers_collections()
    {

        $response = get_transient('furniture_api_json_data_wp');

        $collections = $response['collections'];
        #$responseManufacturers = get_transient('furniture_api_json_data_Manufacturers');
        #$response = get_transient('furniture_api_json_data_wp');
        #$collections = $response['collections'];
        #$manufacturers = $response['furnitureData'][0]['Manufacturers'];
        #$collections = get_transient('furniture_api_json_data_collections');
        $manufacturers = get_transient('furniture_api_json_data_Manufacturers');
        $manufacturersCollections = [];
        foreach ($manufacturers as $manufacturer) {
            $manufacturersCollections[$manufacturer['id']] = array( "manufacturerName" => $manufacturer['name'], "collectionsArray" => []);
        }
        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/grid-manufacturers-collections.php';
    }

    public function furniture_infinite_pdp()
    {

        if ((!isset($_GET['pid']) || !is_numeric($_GET['pid'])) && !is_admin()) {
            wp_redirect('/furniture');
        }

        $pid = $_GET['pid'];
        global $wp;
        $response = get_transient('furniture_api_json_data_wp');
        $all_categories = $response['categories'];
        $manufacturers = $response['furnitureData'][0]['Manufacturers'];
        $cat_ids = array();

        foreach ($manufacturers as $key => $manufacturer) {

            $products = $manufacturer['Furniture'];

            foreach ($products as $key => $product) {
                $pro_Id = $product['id'];
                $image = $product['Images'][0];
                $img_type = $image['type'];

                if (empty($img_type)) {
                    $img_type = "jpeg";
                }

                $img_url =  $this->image_prefix . $image['path'];
                $CategoryId = $product['CategoryId'];
                $cat_name = "";

                foreach ($response['categories'] as $col_key => $col_value) {
                    if ($col_value['id'] == $CategoryId) {
                        $cat_name = $col_value['name'];
                    }
                }

                if ($pid == $pro_Id) {

                    $p_cat_id = "";
                    $sub_cat_id = "";

                    foreach ($all_categories as $category) {

                        if ($category['id'] == $product['CategoryId']) {
                            $p_cat_id = $category['id'];
                            $p_cat_name = $category['name'];
                        }

                        foreach ($category['SubCategories'] as $sub_category) {

                            if ($sub_category['id'] == $product['SubCategoryId']) {
                                $sub_cat_id = $sub_category['id'];
                                $sub_cat_name = $sub_category['name'];
                            }
                        }
                    }

                    $furniture_variant_options = array();
                    foreach ($product['FurnitureVariantOptions'] as $FurnitureVariantOption) {
                        $furniture_variant_options[] = $FurnitureVariantOption['name'];
                    }
                    $p_options = array();
                    foreach ($product['Options'] as $option) {
                        $p_options[] = $option['name'];
                    }
                    $furniture_variant_option_values = array();
                    foreach ($product['FurnitureVariantOptionValues'] as $FurnitureVariantOptionValue) {
                        $furniture_variant_option_values[] = $FurnitureVariantOptionValues['value'];
                    }

                    include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/single-product.php';
                }
            }
        } ?>
        <script>
            // unkown script

            // jQuery(document).ready(function() {
            //     jQuery('.cable-choose input').on('change', function() {
            //         var price_id = jQuery(this).val();
            //         jQuery(".pri_hide").css("display", "none");
            //         jQuery("#" + price_id).css("display", "block");
            //     });

            // });
        </script>
        <?php
    }
    public function furniture_infinite_furniture_item()
    {

        if ((!isset($_GET['pid']) || !is_numeric($_GET['pid'])) && !is_admin()) {
            wp_redirect('/furniture');
        }

        $pid = $_GET['pid'];
        #global $wp;
        $response = get_transient('furniture_api_json_data_wp');
        $all_categories = $response['categories'];
        $manufacturers = $response['furnitureData'][0]['Manufacturers'];
        $products_from_same_manufacturer = array();
        foreach ($manufacturers as $key => $manufacturer) 
        {
            $products = $manufacturer['Furniture'];
            foreach ($products as $key => $product)
            {
                
                $loop_pid = $product['id'];

                if ($pid == $loop_pid) {
                    
                    // GOTCHA! Got the product required by _GET!
                    
                    $this_p_id = $product['id'];
                    $this_p_collection_id = $product['CollectionId'];
                    foreach( $response['collections'] as $collection ){
                        if($collection['id'] == $this_p_collection_id){
                            $this_p_collection_name = $collection['name'];
                            break 1;
                        }
                    }


                    $this_p_manufacturer_id = $product['ManufacturerId'];
                    $products_IDs_from_same_collection = array();
                    if(isset($this_p_manufacturer_id) && ( $manufacturer['id'] == $this_p_manufacturer_id ) ){
                        $products_from_same_manufacturer = $manufacturer['Furniture'];
                        foreach($products_from_same_manufacturer as $product_from_same_manufacturer){
                            if($product_from_same_manufacturer['id'] != $this_p_id){
                                if($product_from_same_manufacturer['CollectionId'] == $this_p_collection_id){
                                    $products_IDs_from_same_collection[] = $product_from_same_manufacturer['id'];
                                }
                            }
                        }
                        if(sizeof($products_IDs_from_same_collection) > 5 ){
                            $upto_five_random_keys_from_products_IDs_from_same_collection = array_rand($products_IDs_from_same_collection, 5);
                        }
                        

                        if(isset($upto_five_random_keys_from_products_IDs_from_same_collection)){
                            $upto_five_random_products_IDs_from_same_collection = array();
                            foreach( $upto_five_random_keys_from_products_IDs_from_same_collection as $random_key){
                                $upto_five_random_products_IDs_from_same_collection[] .= $products_IDs_from_same_collection[$random_key];
                            }
                            $upto_five_random_products_from_same_collection = array();
                            for ($i=0; $i < count($upto_five_random_products_IDs_from_same_collection); $i++) { 
                                foreach ($products_from_same_manufacturer as $product_from_same_manufacturer) {
                                    if($product_from_same_manufacturer['id'] == $upto_five_random_products_IDs_from_same_collection[$i]){
                                        $upto_five_random_products_from_same_collection[$i]['id'] = $product_from_same_manufacturer['id'];
                                        $upto_five_random_products_from_same_collection[$i]['name'] = $product_from_same_manufacturer['name'];
                                        $upto_five_random_products_from_same_collection[$i]['image_path'] = $product_from_same_manufacturer['Images'][0]['path'];
                                        break 1;
                                    }
                                }
                            }
                        } else {
                            $products_from_same_collection = array();
                            for ($i=0; $i < count($products_IDs_from_same_collection); $i++) { 
                                foreach ($products_from_same_manufacturer as $product_from_same_manufacturer) {
                                    if($product_from_same_manufacturer['id'] == $products_IDs_from_same_collection[$i]){
                                        $products_from_same_collection[$i]['id'] = $product_from_same_manufacturer['id'];
                                        $products_from_same_collection[$i]['name'] = $product_from_same_manufacturer['name'];
                                        $products_from_same_collection[$i]['image_path'] = $product_from_same_manufacturer['Images'][0]['path'];
                                        break 1;
                                    }
                                }
                            }
                            
                        }
                    }



                    $image = $product['Images'][0];
                    if (empty($image['type'])) { $img_type = "jpeg"; } else { $img_type = $image['type']; }
                    $main_img_url =  $this->image_prefix . $image['path']; 

                    $p_options = array();
                    foreach ($product['Options'] as $option) {
                        $p_options[] = $option['name'];
                    }

                    if(isset($p_options) && !empty($p_options)){
                        asort($p_options);
                    }
                    
                    $p_variants_options = array();
                    foreach ($product['FurnitureVariantOptions'] as $FurnitureVariantOption) {
                        $p_variants_options[] = $FurnitureVariantOption;
                    }

                    $p_variant_values = array();
                    foreach ($product['FurnitureVariantValues'] as $FurnitureVariantValue) {
                        $p_variant_values[] = $FurnitureVariantValue;
                    }

                    foreach ($product['FurnitureVariantOptionValues'] as $FurnitureVariantOptionValue) {
                        $p_variants_option_values[] = $FurnitureVariantOptionValue; 
                    }

                    foreach ($product['FurnitureVariants'] as $FurnitureVariant) {
                        $p_variants[] = $FurnitureVariant;
                    }

                    // Loop through Category and SubCategory to use data on breadcrumb
                    if(!empty($product['CategoryId'])){ 
                        
                        $p_cat_id = $product['CategoryId']; 

                        foreach ($all_categories as $category) 
                        {
                            if ($category['id'] != $p_cat_id) {

                                continue 1;

                            } elseif($category['id'] == $p_cat_id) {

                                $p_cat_name = $category['name'];

                                if(!empty($product['SubCategoryId'])){ 

                                    $p_sub_cat_id = $product['SubCategoryId']; 

                                    foreach ($category['SubCategories'] as $sub_category) 
                                    {
                                        if ($sub_category['id'] != $p_sub_cat_id) {

                                            continue 1;

                                        } elseif ($sub_category['id'] == $p_sub_cat_id) {

                                            $p_sub_cat_name = $sub_category['name'];
                                            break 1;
                                            
                                        }
                                    }
                                }
                                break 1;
                            }

                        }
                    }
                    include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/single-furniture-item.php';
                    break 2;
                }

            }
        } 
    }

    public function furniture_infinite_set_single_product_page_meta()
    {

        if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {

            $pid = $_GET['pid'];
            $response = get_transient('furniture_api_json_data_wp');
            $manufacturers = $response['furnitureData'][0]['Manufacturers'];

            foreach ($manufacturers as $key => $manufacturer) {

                $products = $manufacturer['Furniture'];

                foreach ($products as $product) {

                    $pro_Id = $product['id'];
                    $image = $product['Images'][0];
                    $img_type = $image['type'];

                    if (empty($img_type)) {
                        $img_type = "jpeg";
                    }

                    if ($pro_Id == $pid) 
                    {
                        $img_url =  $this->image_prefix . $image['path']; ?>
                        <meta property="og:title" content="<?= esc_html($product['name']) ?>" />
                        <meta property="og:image" content="<?= $img_url ?>" />
                        <meta property="og:description" content="<?= esc_html($product['description']) ?>" /><?php
                    }
                }
            }
        }
    }

    public function furniture_infinite_get_api_response()
    {
        return get_transient('furniture_api_json_data_wp');
    }

    public function furniture_infinite_check_product_available_in_category($key, $id)
    {

        $response = get_transient('furniture_api_json_data_wp');
        $manufacturers = $response['furnitureData'][0]['Manufacturers'];
        $availability = false;

        foreach ($manufacturers as $manufacturer) {
            foreach ($manufacturer['Furniture'] as $product) {

                if ($product[$key] == $id) {
                    $availability = true;
                }
            }
        }

        return $availability;
    }

    public function filter_array_by_id($items, $id)
    {

        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
    }

    public function furniture_infinite_search()
    {

        $response = get_transient('furniture_api_json_data_wp');

        $manufacturers = $response['furnitureData'][0]['Manufacturers'];

        include_once FURNITURE_INFINITE_HELPER_FILEPATH . 'public/partials/search-grid-products.php';
    }

    public function furniture_infinite_count_products($key, $cat_id)
    {

        $response = get_transient('furniture_api_json_data_wp');
        $manufacturers = $response['furnitureData'][0]['Manufacturers'];
        $pids = array();

        foreach ($manufacturers as $manufacturer) {
            foreach ($manufacturer['Furniture'] as $product) {

                if ($cat_id == $product[$key]) {

                    $pids[] = $product['id'];
                }
            }
        }

        return count($pids);
    }

    public function pre($arg)
    {
        echo "<pre>";
        print_r($arg);
        echo "</pre>";
    }
}