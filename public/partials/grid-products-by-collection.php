<style type="text/css"></style>

<section class="all-products-section">
    <div class="row">

        <?php

        $records_available = false;


        foreach ($manufacturers as $manufacturer) {

            if($manufacturer['id'] == $_GET['manufacturer-id']){

                foreach ($manufacturer['Furniture'] as $product) { ?>

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
                                      
                    <div class="col-md-2">
                        <a href="/product-details/?from-furniture-item=<?= sanitize_title($product['name']) ?>&pid=<?= $product['id'] ?>">
                            
                            <img src="<?= $img_url ?>">
                            <p><?= $product['name'] ?></p>

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