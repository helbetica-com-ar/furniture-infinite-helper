<style type="text/css"></style>

<section class="all-products-section">
    <h2 style="text-align: center;">Broswe Products By Categories</h2>
    <div class="grid-container php-grid-cateogries collection-image object-home">
        <?php
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['baseurl'];
        $columns = array_column($categories, 'name');
        array_multisort($columns, SORT_ASC, $categories);
        foreach ($categories as $category) {  ?>
            <div class="furniture-infinite-grid-items debugger">
                <?php if( isset($category['sub-cat-id']) ){ ?>
                    <a href="?sub-cat-id=<?= $category['sub-cat-id'] ?>">
                        <img width="244" height="166" src="<?= $upload_dir . '/product-images/cat-'. $category['sub-cat-id'] .'.jpg' ?>">
                        <p><?= ucwords( strtolower($category['name']) ) ?></p>
                    </a>
                <?php } else { ?>
                    <a href="?cat-id=<?= $category['cat-id'] ?>">
                        <img width="244" height="166" src="<?= $upload_dir . '/product-images/cat-'. $category['cat-id'] .'.jpg' ?>">
                        <p><?= ucwords( strtolower($category['name']) ) ?></p>
                    </a>
                <?php } ?>
            </div><?php 
        } ?>
    </div>
</section>

<?php if($total_pages > 1){ ?>

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

<?php } ?>