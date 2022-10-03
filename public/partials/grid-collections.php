<style type="text/css"></style>

<section class="all-products-section">

    <h2 style="text-align: center;">Browse Products By Collections</h2> 

    <div class="row">
        
        <?php foreach ($collections as $collection) {  ?>
            
            <div class="col-md-2">
                    <a href="/all-products?manufacturer-id=<?= $collection['ManufacturerId'] ?>">
                        <?= trim( ucwords( strtolower( $collection['name'] ) ) ) ?>
                    </a>
            </div>

        <?php } ?>
    </div>
</section>
<div class="pagination-wrap">
    <div class="pagination">

      <?php 
            $offset = $no_of_records_per_page;

            if(!isset($_GET['offset']) || $_GET['offset'] == 0){
                
                echo "<a class='active-page' href='?offset=0'>1</a>";

            } else {

                echo "<a href='?offset=0'>1</a>";
            }


            for ($i=2; $i <= $total_pages; $i++) { 

                if( isset($_GET['offset']) && $_GET['offset'] == $offset ){
                
                    echo "<a class='active-page' href='?offset=". $offset ."'>". $i ."</a>";
                    $offset = $offset + $no_of_records_per_page;    
                
                } else {

                    echo "<a href='?offset=". $offset ."'>". $i ."</a>";
                    $offset = $offset + $no_of_records_per_page;
                }
            } 
      ?>

    </div>
</div>