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

    .chariho-grid-items p .prodCount {
        margin-left: 10px;
        opacity: 0.6;    
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

</style>

<section class="all-products-section">
    
    <h2 style="text-align: center;">Category: <strong><?php echo $main_category_name; ?></strong></h2>
    <div class="grid-container collection-image-96 object-1-home">
        <?php 
        $subCategories = [];
        foreach ($categories as $category){ 
            if( $this->chariho_check_product_available_in_category("SubCategoryId", $category['id']) ){ 
                $count = $this->chariho_count_products('SubCategoryId', $category['id']);
                $subCategories[] = array(
                    'name'      => ucwords( strtolower( $category["name"] ) ),
                    'id'        => $category['id'],
                    'amount'    => $count
                );
                $columns = array_column($subCategories, 'name');
                array_multisort($columns, SORT_ASC, $subCategories);
            } 
        } 
        foreach ($subCategories as $subCategory){  ?>
        <div class="chariho-grid-items">
            <a href="<?= site_url() ?>/all-products?sub-cat-id=<?php echo $subCategory["id"]; ?>">
                <?php 
                $manufacturers = $response['furnitureData'][0]['Manufacturers'];
                foreach ($manufacturers as $manufacturer) {
                    foreach ($manufacturer['Furniture'] as $product) {
                        if($product['SubCategoryId'] == $subCategory["id"]){
                            $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$product['Images'][0]['path'];
                            $img_url = str_replace("-original", "-300x300", $img_url);
                            break;
                        }
                    }
                }  ?>
                <img src="<?php echo $img_url; ?>">
                <p>
                    <?php echo $subCategory["name"]; ?>
                    <span class="prodCount">(<?php echo $subCategory["amount"]; ?>)</span>
                </p>
            </a>
        </div><?php 
        }
        ?>
    </div>
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