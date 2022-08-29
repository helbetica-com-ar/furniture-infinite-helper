<style>
    .all-products-section .row::after{
        content: "";
        clear: both;
        display: table;
    }
    .all-products-section .row .col-md-2{
        float: left;
        width: 22.4%;
        text-align: center;
        padding: 20px 10px;
        background-color: #f8f8f8;
        margin: 15px;
    }
    .all-products-section .row .col-md-2:nth-child(4n+1){
        clear:left;
    }
    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
    }

</style>

<section class="all-products-section">
    <div class="row">

        <?php

        $records_available = false;


        foreach ($manufacturers as $manufacturer) {

            if($manufacturer['id'] == $_GET['manufacturer-id']){

                foreach ($manufacturer['Furniture'] as $product) { ?>

                    <?php 
                        $records_available = true;
                        $image      = $product['Images'][0];
                        // $img_type   = $image['type'];
                        // $img_type   = (empty($img_type))? "jpeg" : $img_type;

                        $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];
                        $img_url = str_replace("-original", "-300x300", $img_url);
                    ?>
                                      
                    <div class="col-md-2">
                        <a href="/product-details/?pid=<?= $product['id'] ?>">
                            
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