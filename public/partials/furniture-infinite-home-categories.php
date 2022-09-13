<style type="text/css"></style>
<div class="grid-container php-furniture-infinite-home-categories collection-image object-home">

    <?php
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['baseurl'];
    ?>

    <?php foreach ($categories as $category) {?>
        
        <?php if( in_array( $category['name'], $display_cat ) ){ ?>

            <div class="furniture-infinite-grid-items">
                <a href="<?= site_url() ?>/all-products?cat-id=<?= $category['id'] ?>">
                    <img src="<?= $upload_dir . '/product-images/cat-'. $category['id'] .'.jpg' ?>">
                    <p><?= $category['name'] ?></p>
                </a>
            </div>

        <?php } ?>
    <?php } ?>

</div>