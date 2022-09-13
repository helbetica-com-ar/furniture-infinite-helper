<?php

class Chariho_Shortcodes
{

    private $plugin_name;
    private $version;

    private $baseURL;
    private $legacyBaseURL;
    private $auth_token;

    private $main_categories = array(
        "Bar",
        "Bathroom",
        "Bedroom",
        "Dining Room",
        "Kitchen",
        "Living Room",
        "Office",
        "Outdoor",
        "Specialty",
        "Youth"
    );

    private $image_prefix = 'https://infinite-digital-production.s3.us-east-2.amazonaws.com/';


    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function chariho_all_products()
    {

        $main_categories_ids = $this->get_main_categories_ids();

        if (isset($_GET['search']) && !empty($_GET['search'])) {

            $this->chariho_search();
        } elseif (isset($_GET['cat-id']) && !isset($_GET['sub-cat-id']) && in_array($_GET['cat-id'], $main_categories_ids)) {

            $this->chariho_sub_categories($_GET['cat-id']);
        } elseif (isset($_GET['sub-cat-id'])) {

            $this->chariho_products_by_category();
        } elseif (isset($_GET['manufacturer-id'])) {

            $this->chariho_products_by_collection();
        } else {

            $this->chariho_all_main_categories();
        }
    }

    public function chariho_all_main_categories()
    {

        $response = $this->chariho_get_api_response();

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

        include CHARIHO_HELPER_FILEPATH . 'public/partials/grid-categories.php';
    }

    public function chariho_sub_categories($id)
    {

        $response = $this->chariho_get_api_response();

        $categories = array();
        $main_category = $this->filter_array_by_id($response['categories'], $id);
        $main_category_name = $this->get_main_category_name_by_id($id);
        $sub_categories = $main_category['SubCategories'];


        // foreach ($sub_categories as $sub_category) {

        //     $categories[] = array(
        //         'cat-id'    => $sub_category['id'],
        //         'name'      => $sub_category['name'],
        //         'p_count'   => $this->chariho_count_products('SubCategoryId', $sub_category['id']),
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

        include CHARIHO_HELPER_FILEPATH . 'public/partials/sub-category-grid.php';
    }

    public function chariho_products_by_category()
    {

        $response = $this->chariho_get_api_response();

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

        include CHARIHO_HELPER_FILEPATH . 'public/partials/grid-products.php';
    }

    public function chariho_products_by_collection()
    {

        if (!isset($_GET['manufacturer-id']) || !is_numeric($_GET['manufacturer-id'])) {
            wp_redirect('/all-products');
        }
        $response = $this->chariho_get_api_response();

        $manufacturers = $response['furnitureData'][0]['Manufacturers'];

        include CHARIHO_HELPER_FILEPATH . 'public/partials/grid-products-by-collection.php';
    }

    public function get_main_categories()
    {
        return $this->main_categories;
    }

    public function get_main_categories_ids()
    {

        $main_categories = $this->get_main_categories();
        $response = $this->chariho_get_api_response();
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
        $response = $this->chariho_get_api_response();

        foreach ($response['categories'] as $parent_category) {
            if ($parent_category['id'] == $id) {
                return $parent_category['name'];
            }
        }

        return '';
    }

    public function chariho_home_categories()
    {

        $response = $this->chariho_get_api_response();
        $categories = $response['categories'];
        $display_cat = $this->get_main_categories();

        include CHARIHO_HELPER_FILEPATH . 'public/partials/chariho-home-categories.php';
    }

    public function chariho_collections()
    {

        $response = $this->chariho_get_api_response();

?>
        <style type="text/css"></style>
        <section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
            <div class="img-heading-su-874">
                <h1>COLLECTIONS</h1>
            </div>
        </section>
        <div class="grid-container collection-image collection-984564">
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

    public function chariho_all_collections()
    {

        $response = $this->chariho_get_api_response();

        $collections = $response['collections'];

        $no_of_records_per_page = 12;
        $total_rows = count($collections);
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {

            $collections = array_splice($collections, $_GET['offset'], $no_of_records_per_page);
        } else {
            $collections = array_splice($collections, 0, $no_of_records_per_page);
        }

        include CHARIHO_HELPER_FILEPATH . 'public/partials/grid-collections.php';
    }

    public function chariho_pdp()
    {

        if (!isset($_GET['pid']) || !is_numeric($_GET['pid']) && !is_admin()) {
            wp_redirect('/all-products');
        }

        $pid = $_GET['pid'];
        global $wp;
        $response = $this->chariho_get_api_response();
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

                    foreach ($product['FurnitureVariantOptions'] as $FurnitureVariantOption) {
                        $furniture_variant_options[] = $FurnitureVariantOption['name'];
                    }
                    foreach ($product['Options'] as $option) {
                        $p_options[] = $option['name'];
                    }
                    foreach ($product['FurnitureVariantOptionValues'] as $FurnitureVariantOptionValue) {
                        $furniture_variant_option_values[] = $FurnitureVariantOptionValues['value'];
                    }

                    include CHARIHO_HELPER_FILEPATH . 'public/partials/single-product.php';
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

    public function chariho_set_single_product_page_meta()
    {

        if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {

            $pid = $_GET['pid'];
            $response = $this->chariho_get_api_response();
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

                    if ($pro_Id == $pid) {

                        $img_url =  $this->image_prefix . $image['path'];

        ?>

                        <meta property="og:title" content="<?= $product['name'] ?>" />
                        <meta property="og:image" content="<?= $img_url ?>" />
                        <meta property="og:description" content="<?= $product['description'] ?>" />

<?php
                    }
                }
            }
        }
    }

    public function chariho_get_api_response()
    {

        if (false === (get_transient('furniture_api_data'))) {
            $this->chariho_set_api_response_transient();
            return get_transient('furniture_api_data');
        } else {
            return get_transient('furniture_api_data');
        }
    }

    private function chariho_set_api_response_transient()
    {

        $url = "https://furnitureinfinite.com/api/auth/wp-login";
        $user = 'tort.juanpablo+wpstoreadmin02@gmail.com';      // Chariho Furniture
        $pass = '3G28cRVCEPV9Jc';                               // Chariho Furniture 
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
        $bearer = $post_response["token"];
        # $bearer = get_option('furniture_api_bearer_token');
        $options = ["http" => ["header" => "Authorization: Bearer $bearer"]];

        $context = stream_context_create($options);

        $response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
        $response = json_decode($response);
        $response = json_encode($response, JSON_PRETTY_PRINT);
        $response = json_decode($response, true);


        // Expire time 6 hours
        return set_transient('furniture_api_data', $response, 60 * 60 * 6);
    }

    public function chariho_check_product_available_in_category($key, $id)
    {

        $response = $this->chariho_get_api_response();
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

    public function chariho_search()
    {

        $response = $this->chariho_get_api_response();

        $manufacturers = $response['furnitureData'][0]['Manufacturers'];

        include CHARIHO_HELPER_FILEPATH . 'public/partials/search-grid-products.php';
    }

    public function chariho_count_products($key, $cat_id)
    {

        $response = $this->chariho_get_api_response();
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
