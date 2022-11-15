<style type="text/css"></style>

<section class="all-products-section">
    <?php if ( isset($_GET['cat-id']) ){ $header = "Category:"; } elseif (isset($_GET['sub-cat-id'])) { $header = 'Subcategory:'; } ?>
    <h2 style="text-align: center;">
        <?= $header; ?>
        <strong>
        <?php 
        foreach ($categories as $category) {
            
            if(isset($category['cat-id']) && isset($_GET['cat-id']) && $category['cat-id'] == $_GET['cat-id']){
                echo $category['name'] . ' ';
            
            } elseif (isset($category['sub-cat-id']) && isset($_GET['sub-cat-id']) && $category['sub-cat-id'] == $_GET['sub-cat-id']){
                echo $category['name'];
            }

        }

        ?>   
        </strong>
    </h2>

    <div class="grid-container alignfull php-grid-proucts collection-image object-home">
        <?php
        $records_available = false;

        foreach ($manufacturers as $manufacturer) {
            foreach ($manufacturer['Furniture'] as $product) {

                if( (isset($_GET['cat-id']) && $product['CategoryId'] == $_GET['cat-id']) || (isset($_GET['sub-cat-id']) && $product['SubCategoryId'] == $_GET['sub-cat-id']) ){ ?>

                    <?php 
                        $records_available = true;
                        // first uploaded image gets dumped in last position of array on json data
                        $last_images = sizeof($product['Images'])-1; // minus 1 to match array position
                        $image      = $product['Images'][$last_images];

                        $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];
                        $img_url = str_replace("-original", "-300x300", $img_url);
                    ?>
                                      
                    <div class="furniture-infinite-grid-items">
                        <div id="post-pre" style="display: none;"><pre><?php print_r($last_images); ?></pre></div>
                        <a href="/product-details/?from-furniture-item=<?= sanitize_title($product['name']) ?>&pid=<?= $product['id'] ?>">
                            
                            <img src="<?= $img_url ?>">
                            <p class="pro-name"><?= $product['name'] ?></p>

                        </a>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
    
    <?php if(!$records_available){ ?>

        <div class="no-records">
            <h3>Sorry, No products found!!!</h3>
        </div>

    <?php } ?>

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