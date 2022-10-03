<style type="text/css"></style>
<div class="grid-container php-home-categories collection-image object-home">
<?php

$link_prefix = '';
if ( defined('FURNITURE_CAT_LINK_PREFIX') ) {
    $link_prefix = FURNITURE_CAT_LINK_PREFIX;
}
$button_leyend = 'Browse Now';
if ( defined('FURNITURE_CAT_BTN_LEYEND') ) {
    $link_prefix = FURNITURE_CAT_BTN_LEYEND;
}
$upload_dir = wp_upload_dir();
$upload_dir = $upload_dir['baseurl'];

#$ordered_categories = array_column($categories, 'name'); 
#array_multisort($ordered_categories, SORT_ASC, $categories);     

    foreach ($categories as $category) {
        
        if( in_array( $category['name'], $display_cat ) ){ ?>

                <a class="grid-item" 
                    href="<?= site_url() ?>/furniture/<?= strtolower(str_replace(" ", "-", $category['name'])) ?>/?cat-id=<?= $category['id'] ?>"
                    style="background-image: url('<?= $upload_dir . '/furniture-categories/cat-'. strtolower(str_replace(" ", "-", $category['name'])) .'.jpg' ?>');"
                    >
                    <h3><?= $category['name'] ?></h3>
                    <p><?= $button_leyend ?></p>
                </a>

        <?php } ?>
    <?php } ?>

</div>