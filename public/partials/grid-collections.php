<style>
     @media only screen and (min-width: 1000px){
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
    }
    @media only screen and (min-width: 501px) and (max-width: 1000px){
        .all-products-section .row::after{
            content: "";
            clear: both;
            display: table;
        }
        .all-products-section .row .col-md-2{
            float: left;
            width: 33.333%;
            text-align: center;
            padding: 20px 10px;
            background-color: #f8f8f8;
            margin: 15px;
        }
        .all-products-section .row .col-md-2:nth-child(3n+1){
            clear:left;
        }
    }
    @media only screen and (max-width: 500px){
        .all-products-section .row::after{
            content: "";
            clear: both;
            display: table;
        }
        .all-products-section .row .col-md-2{
            float: left;
            width: 45%;
            text-align: center;
            min-height: 236px;
            padding: 20px 10px;
            background-color: #f8f8f8;
            margin: 10px;
        }
        .all-products-section .row .col-md-2 p{
            margin:  0px;
            padding-top: 12px;
        }
        .all-products-section .row .col-md-2:nth-child(2n){
            clear: right !important;
        }
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

    <h2 style="text-align: center;">Broswe Products By Collections</h2>

    <div class="row">
        
        <?php foreach ($collections as $collection) {  ?>
            
            <div class="col-md-2">
                    <a href="/all-products?manufacturer-id=<?= $collection['ManufacturerId'] ?>">
                        <img src="<?= site_url() ?>/wp-content/uploads/2022/05/download.png">
                        <p><?= trim( ucwords( strtolower( $collection['name'] ) ) ) ?></p>
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