<style type="text/css"></style>

<section class="all-products-section">

    <h2 style="text-align: center;">Broswe Products By Categories</h2>

    <div class="row">
        
        <?php foreach ($response['categories'] as $category) {  ?>
            
            <div class="col-md-2">

                <?php if(isset($_GET['cat-id']) && $_GET['cat-id'] == $category['id'] ) ?>
                
                    <?php foreach ($category['SubCategories'] as $sub_category) {  ?>
                        
                        <a href="/all-products?sub-cat-id=<?= $sub_category['id'] ?>">
                            <img src="https://jolly-noyce.51-38-107-3.plesk.page/wp-content/uploads/2022/05/download.png">
                            <p><?= ucwords( strtolower( $sub_category['name'] ) ) ?></p>
                        </a>

                    <?php } ?>
                <?php } else { ?>

                    <a href="/all-products?cat-id=<?= $category['id'] ?>">
                            <img src="https://jolly-noyce.51-38-107-3.plesk.page/wp-content/uploads/2022/05/download.png">
                        <p><?= ucwords( strtolower( $category['name'] ) ) ?></p>
                    </a>                    

                <?php } ?>

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