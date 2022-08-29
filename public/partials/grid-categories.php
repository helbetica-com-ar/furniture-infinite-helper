<style>

   @media only screen and (min-width: 1024px){
        .grid-container.collection-image-96.object-1-home {
            margin-bottom: 50px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }
    }
    @media only screen and (min-width: 800px) and (max-width: 1024px){
        .grid-container.collection-image-96.object-1-home {
            margin-bottom: 50px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
    }
    @media only screen and (min-width: 500px) and (max-width: 800px){
        .grid-container.collection-image-96.object-1-home {
            margin-bottom: 50px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
    }
    @media only screen and (max-width: 500px){
        .grid-container.collection-image-96.object-1-home {
            margin-bottom: 50px;
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 25px;
        }
    }

    .collection-image-96 div {
        padding: 15px;
    }

    .collection-image-96 div img {
        width: 100%;
        height: auto;
    }

    .collection-image-96 .chariho-grid-items p {
        text-align: center;
        font-family: inherit;
        font-size: 18px;
        font-weight: 400;
        text-transform: capitalize;
    }
    .object-1-home img{ 
        height: 234px !important;
        width: 346px !important;
    }
    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 5px;
      text-decoration: none;
      margin: 5px;
      font-family: inherit !important;
    }
    .pagination a:hover{
        background-color: #00375B;
        color: #fff;
    }
    .pagination-wrap{
        width: 100%;
        text-align: center;
    }
    .active-page{
        background-color: #00375B;
        color: #fff !important;
    }
    p{
        font-family: inherit !important;
    }
    .all-products-section img{
        height: 166px;
    }

</style>

<section class="all-products-section">
    <h2 style="text-align: center;">Broswe Products By Categories</h2>
    <div class="grid-container collection-image-96 object-1-home">
        <?php
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['baseurl'];
        $columns = array_column($categories, 'name');
        array_multisort($columns, SORT_ASC, $categories);
        foreach ($categories as $category) {  ?>
            <div class="chariho-grid-items debugger">
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