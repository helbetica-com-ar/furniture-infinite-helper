<style type="text/css"></style>

<section class="all-products-section">
    
    <h2 style="text-align: center;">Search Results For:  <strong><?= (isset($_GET['search']))? $_GET['search'] : ''; ?></strong>
    </h2>

    <div class="grid-container php-search-grid-products collection-image object-home">
        <?php
        $records_available = false;

        foreach ($manufacturers as $manufacturer) {
            foreach ($manufacturer['Furniture'] as $product) {

                $search_term = strtolower($_GET['search']);
                $search_term = str_replace(" ", "|", $search_term);

                if( preg_match("/\b($search_term)\b/", strtolower($product['name'])) ) { ?>

                    <?php 
                        $records_available = true;
                        // first uploaded image gets dumped in last position of array on json data
                        $last_image = sizeof($product['Images'])-1; // minus 1 to match array position
                        $image      = $product['Images'][$last_image];
                        // $img_type   = $image['type'];
                        // $img_type   = (empty($img_type))? "jpeg" : $img_type;

                        $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];
                        $img_url = str_replace("-original", "-300x300", $img_url);
                    ?>
                                      
                    <div class="furniture-infinite-grid-items">
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