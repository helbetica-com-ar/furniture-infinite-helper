<section class="all-products-section all-products-from-collection-section">
    <?php
    $collection_name= array_search($_GET['collection-id'], array_column($collections, 'id'));
    #var_dump($collections[$collection_name]);
    $manufacturer_id = $collections[$collection_name]["ManufacturerId"];
    $manufacturer_name = array_search($manufacturer_id, array_column($manufacturers, 'id'));
    ?>
    <h1 style="text-align: center;">Collection: <?= $collections[$collection_name]["name"]; ?></h1>
    <h4 style="text-align: center;">Manufacturer: <b><?= $manufacturers [$manufacturer_name]["name"]; ?></b></h4>
    <p style="text-align:center;"><a class="visit-other-collections" href="<?= site_url() ?>/manufacturers-collections/?showing-collection=<?= sanitize_title($manufacturers [$manufacturer_name]["name"]); ?>">View other collections from <?= $manufacturers [$manufacturer_name]["name"]; ?></a></p>
    <div class="row">
        <?php
        $records_available = false;
        foreach ($manufacturers as $manufacturer) {
            #if($manufacturer['id'] == $_GET['manufacturer-id']){
                foreach ($manufacturer['Furniture'] as $product) {
                    if ($product['CollectionId'] == $_GET['collection-id']) {
                        $records_available = true;
                        $image      = $product['Images'][0];
                        $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];
                        $img_url = str_replace("-original", "-300x300", $img_url);
                        ?>
                        <div class="col-md-2 col-furniture-item">
                            <a href="/product-details/?from-furniture-item=<?= sanitize_title($product['name']) ?>&pid=<?= $product['id'] ?>">
                                <img class="boxShadow" src="<?= $img_url ?>">
                                <p><?= $product['name'] ?></p>
                            </a>
                        </div>
                        <?php
                    }
                }
            #}
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