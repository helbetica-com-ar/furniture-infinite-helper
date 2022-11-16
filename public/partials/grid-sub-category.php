<section class="all-products-section">
    
    <h2 style="text-align: center;"><strong><?php echo $main_category_name; ?> subcategories</strong></h2>
    <div class="grid-container alignfull php-sub-category-grid collection-image object-home">
        <?php 
        $subCategories = []; 
        foreach ($categories as $category){ 
            if( $this->furniture_infinite_check_product_available_in_category("SubCategoryId", $category['id']) ){ 
                $count = $this->furniture_infinite_count_products('SubCategoryId', $category['id']);
                $subCategories[] = array(
                    'name'      => ucwords( strtolower( $category["name"] ) ),
                    'id'        => $category['id'],
                    'amount'    => $count
                );
                $columns = array_column($subCategories, 'name');
                array_multisort($columns, SORT_ASC, $subCategories);
            } 
        } 
        foreach ($subCategories as $subCategory){  ?>
        <div class="furniture-infinite-grid-items">
            <a href="<?= get_permalink() ?>?showing-subcategory=<?= strtolower(str_replace(" ", "-", $subCategory["name"])); ?>&sub-cat-id=<?php echo $subCategory["id"]; ?>">
                <?php 
                $manufacturers = $response['furnitureData'][0]['Manufacturers'];
                foreach ($manufacturers as $manufacturer) {
                    foreach ($manufacturer['Furniture'] as $product) {
                        if($product['SubCategoryId'] == $subCategory["id"]){
                            // first uploaded image gets dumped in last position of array on json data
                            $last_image = sizeof($product['Images'])-1; // minus 1 to match array position
                            $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$product['Images'][$last_image]['path'];
                            $img_url = str_replace("-original", "-300x300", $img_url);
                            break;
                        }
                    }
                }  ?>
                <img src="<?php echo $img_url; ?>">
                <p>
                    <?php echo $subCategory["name"]; ?>
                    <span class="prodCount">(<?php echo $subCategory["amount"]; ?>)</span>
                </p>
            </a>
        </div><?php 
        }
        ?>
    </div>
</section>
<div class="pagination-wrap">
    <div class="pagination">

      <?php 
            // $offset = $no_of_records_per_page;
            // echo "<a href='?offset=0'>1</a>";

            // for ($i=2; $i <= $total_pages; $i++) { 

            //     echo "<a href='?offset=". $offset ."'>". $i ."</a>";
            //     $offset = $offset + $no_of_records_per_page;
            // } 
      ?>

    </div>
</div>