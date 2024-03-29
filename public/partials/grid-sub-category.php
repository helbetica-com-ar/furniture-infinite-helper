<section class="all-products-section">
    <h2 style="text-align: center;"><strong><?= $main_category_name; ?> subcategories</strong></h2>
    <div class="grid-container alignfull php-sub-category-grid collection-image object-home">
        <?php
        $subCategories = [];
        foreach ($categories as $category) {
            if ($this->furniture_infinite_check_product_available_in_category("SubCategoryId", $category['id'])) {
                $count = $this->furniture_infinite_count_products('SubCategoryId', $category['id']);
                $subCategories[] = array(
                    'name'      => ucwords(strtolower($category["name"])),
                    'id'        => $category['id'],
                    'amount'    => $count
                );
                $columns = array_column($subCategories, 'name');
                array_multisort($columns, SORT_ASC, $subCategories);
            }
        }
        foreach ($subCategories as $subCategory) {  
            $sluggedSubCategory = preg_replace("/[^A-Za-z0-9 ]/", '', $subCategory["name"]);
            ?>
            <div class="furniture-infinite-grid-items <?= strtolower(str_replace(" ", "-", $sluggedSubCategory)); ?>">
                <a href="<?= get_permalink() ?>?showing-subcategory=<?= urlencode(strtolower(str_replace(" ", "-", $subCategory["name"]))); ?>&sub-cat-id=<?= $subCategory["id"]; ?>">
                    <?php
                    $manufacturers = $response['furnitureData'][0]['Manufacturers'];
                    foreach ($manufacturers as $manufacturer) {
                        foreach ($manufacturer['Furniture'] as $product) {
                            if ($product['SubCategoryId'] == $subCategory["id"]) {
                                // first uploaded image gets dumped in last position of array on json data
                                $last_image = sizeof($product['Images']) - 1; // minus 1 to match array position
                                $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/' . $product['Images'][$last_image]['path'];
                                $img_url = str_replace("-original", "-300x300", $img_url);
                                break;
                            }
                        }
                    }  ?>
                    <img src="<?= $img_url; ?>" alt="" />
                    <p>
                        <?= $subCategory["name"]; ?>
                        <span class="prodCount">(<?= $subCategory["amount"]; ?>)</span>
                    </p>
                </a>
            </div><?php
                }
                    ?>
    </div>
</section>