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
        background-color: #f2f2f2;
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
</style>
<div class="grid-container collection-image-96 object-1-home">

    <?php
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['baseurl'];
    ?>

    <?php foreach ($categories as $category) {?>
        
        <?php if( in_array( $category['name'], $display_cat ) ){ ?>

            <div class="chariho-grid-items">
                <a href="<?= site_url() ?>/all-products?cat-id=<?= $category['id'] ?>">
                    <img src="<?= $upload_dir . '/product-images/cat-'. $category['id'] .'.jpg' ?>">
                    <p><?= $category['name'] ?></p>
                </a>
            </div>

        <?php } ?>
    <?php } ?>

</div>