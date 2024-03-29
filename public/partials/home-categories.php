<?php
$pattern = '/[^a-zA-Z0-9]+/';
$replacement = '-';
$siteSettingsName = strtolower(html_entity_decode(get_bloginfo('name')));
$sluggedSettingsName = preg_replace($pattern, $replacement, $siteSettingsName);
?>

<div class="grid-container php-home-categories collection-image object-home <?= $sluggedSettingsName; ?>">
<?php

if ( (!defined('FURNITURE_CAT_LINK_PREFIX')) || (FURNITURE_CAT_LINK_PREFIX == '') ) {
    $cat_prefix = '/furniture/';
} else {
    $cat_prefix = FURNITURE_CAT_LINK_PREFIX;
}

if ( defined('FURNITURE_CAT_BTN_LEYEND') ) {
    $button_leyend = FURNITURE_CAT_BTN_LEYEND;
} else {
    $button_leyend = 'Browse Now';
}
# $upload_dir = wp_upload_dir();
# $upload_dir = $upload_dir['baseurl'];
$assets_media_cat = 'https://assets.infinitedigitalsolutions.com/media/img/covers/categories/cat-';

#$ordered_categories = array_column($categories, 'name'); 
#array_multisort($ordered_categories, SORT_ASC, $categories);     

foreach ($categories as $category) {
    if( in_array( $category['name'], $display_cat ) ){ ?>
        <a class="grid-item" 
            href="<?= site_url() . $cat_prefix . strtolower(str_replace(" ", "-", $category['name'])) ?>/?cat-id=<?= $category['id'] ?>"
            style="background-image: url('<?= $assets_media_cat . strtolower(str_replace(" ", "-", $category['name'])) .'.jpg' ?>');"
            >
            <h3><?= $category['name'] ?></h3> 
            <p><?= $button_leyend ?></p>
        </a><?php 
    } 
} ?>

</div>