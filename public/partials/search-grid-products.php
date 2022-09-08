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
    .pro-name{
        text-transform: capitalize !important;
    }
</style>

<section class="all-products-section">
    
    <h2 style="text-align: center;">Search Results For:  <strong><?= (isset($_GET['search']))? $_GET['search'] : ''; ?></strong>
    </h2>

    <div class="grid-container php-search-grid-products collection-image-96 object-1-home">
        <?php
        $records_available = false;

        foreach ($manufacturers as $manufacturer) {
            foreach ($manufacturer['Furniture'] as $product) {

                $search_term = strtolower($_GET['search']);
                $search_term = str_replace(" ", "|", $search_term);

                if( preg_match("/\b($search_term)\b/", strtolower($product['name'])) ) { ?>

                    <?php 
                        $records_available = true;
                        $image      = $product['Images'][0];
                        // $img_type   = $image['type'];
                        // $img_type   = (empty($img_type))? "jpeg" : $img_type;

                        $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];
                        $img_url = str_replace("-original", "-300x300", $img_url);
                    ?>
                                      
                    <div class="chariho-grid-items">
                        <a href="/product-details/?pid=<?= $product['id'] ?>">
                            
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