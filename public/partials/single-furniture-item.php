<?php 
if ( (!defined('FURNITURE_CAT_LINK_PREFIX')) || (FURNITURE_CAT_LINK_PREFIX == '') ) {
    $cat_prefix = '/furniture/';
} else {
    $cat_prefix = FURNITURE_CAT_LINK_PREFIX; 
}


$site_title = get_bloginfo( 'name' );
$site_url = network_site_url( '/' );
$site_description = get_bloginfo( 'description' ); 
if ( has_custom_logo() ){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    $site_logo = $image[0];
}

$p_name = htmlspecialchars($product['name']);

if( isset( $product['sku'] ) ){
    $p_sku = htmlspecialchars($product['sku']);
} else {
    $p_sku = "";
}
if( isset( $product['description'] ) ){
    $p_description = htmlspecialchars($product['description']);
} else {
    $p_description = "";
}

?>
<div class="alignfull wood-background">
    <div class="breadcrumbs container <?= str_replace(" ", "-", strtolower(get_bloginfo( 'name' ))); ?>">
        <a href="<?= site_url() ?>">Home /</a>
        <a href="<?= site_url() . $cat_prefix ?>">Furniture /</a>
        <a href="<?= $cat_prefix ?><?= (isset($p_cat_name))? strtolower(str_replace(" ", "-", $p_cat_name)) . "/" : '' ?>?cat-id=<?= $p_cat_id ?>"><?= (isset($p_cat_name))? $p_cat_name . " /" : '' ?></a>
        <a href="<?= $cat_prefix ?><?= (isset($p_cat_name))? strtolower(str_replace(" ", "-", $p_cat_name)) . "/" : '' ?>?showing-subcategory=<?= (isset($p_sub_cat_name))? strtolower(str_replace(" ", "-", $p_sub_cat_name))  : '' ?>&sub-cat-id=<?= $p_sub_cat_id ?>"><?= (isset($p_sub_cat_name))? $p_sub_cat_name  : '' ?></a>
    </div>
</div>
<?php /* 
<div><a class="pre-pre" href="#post-pre"><small>scroll</small></a></div><pre><?php  
echo '$this_p_collection_id: ' . $this_p_collection_id . '<br>';
echo '$this_p_collection_name: ' . $this_p_collection_name . '<br>';
echo '$this_p_manufacturer_name: ' . $this_p_manufacturer_name . '<br>';
echo '$this_p_manufacturer_id: ' . $this_p_manufacturer_id . '<br>';
echo 'upto_five_random_keys_from_products_IDs_from_same_collection:<br>';
print_r($upto_five_random_keys_from_products_IDs_from_same_collection); 
echo 'products_IDs_from_same_collection:<br>';
print_r($products_IDs_from_same_collection); 
echo 'upto_five_random_products_IDs_from_same_collection:<br>';
print_r($upto_five_random_products_IDs_from_same_collection); 
echo 'upto_five_random_products_from_same_collection:<br>';
print_r($upto_five_random_products_from_same_collection);  
echo 'products_from_same_collection:<br>';
print_r($products_from_same_collection); 
?></pre><div id="post-pre"></div>
*/ ?>
<section class="container product-details single-furniture-item">
    <div class="left-column alignfull" id="img">
        <div id="container" class="boxShadow">
            <?php 
            if(sizeof($thumbnails) > 1){  ?>
            <div class="thumbnails-wrapper">
                <div id="post-pre" style="display: none;"><pre><?php print_r($thumbnails); ?></pre></div>
                <div class="thumbnail-container">
                    <?php 
                    $c = 0;
                foreach($thumbnails as $thumb){
                    $c++;
                    $img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$thumb['path'];
                    $img_url = str_replace("-original", "-84x84", $img_url);
                    $img_type = $thumb['type'];
                    if (empty($img_type)) {
                        $img_type = "jpeg";
                    }  ?>
                    <div class="thumbnail">
                        <img src="<?= $img_url  ?>" class="<?php if($c == 1){ echo 'active'; } ?>" alt="" />
                    </div>
                    <?php 
                }
                ?>
                </div>
            </div><?php 
            }
            ?>
            <div class="zoom">
                <img id="hover-effect" data-image="black" class="active" src="<?php echo $main_img_url; ?>" alt="" />
            </div>
        </div>
    </div>
    <div class="right-column">
        <div class="product-details-wrapper">
            <div id="desc">
                <h1><?= $p_name ?></h1>
                <?php 
                if(isset($this_p_manufacturer_name) ) {  ?>
                    <h2 style="display: none"><?= $this_p_manufacturer_name; ?><h2><?php 
                } ?>
                <p><?= $product['description'] ?></p>
                <table class="product-data" cellspacing="0">
                    <tbody>
                    <?php  
                    if( isset( $product['sku'] ) ){  ?>
                        <tr>
                            <th class="cell label"><label for="pd_sku">SKU</label></th>
                            <td class="cell value"><p><?= $product['sku'] ?></p></td>
                        </tr><?php 
                    }
                    if( isset( $product['dimensions'][0] ) ){  ?>
                        <tr>
                            <th class="cell label"><label for="pd_dimensions">Dimensions</label></th>
                            <td class="cell value"><p><?= strtoupper($product['dimensions'][0]) ?></p></td>
                        </tr><?php 
                    }
                    if( isset( $product['id'] ) ){  ?>
                        <tr>
                            <th class="cell label"><label for="pd_id">Furniture Item ID</label></th>
                            <td class="cell value"><p><?= $product['id'] ?></p></td>
                        </tr><?php 
                    }
                    if( isset( $this_p_manufacturer_id ) ){  ?>
                        <tr class="hide-screen">
                            <th class="cell label"><label for="pd_id">Builder ID</label></th>
                            <td class="cell value"><p><?= $this_p_manufacturer_id ?></p></td>
                        </tr><?php 
                    }
                    if(isset($p_options)){  
                        if (sizeof($p_options) == 1 ){  ?>
                        <tr>
                            <th class="cell label"><label for="pd_options">Option</label></th>
                            <td class="cell value"><?php foreach($p_options as $option){ ?><p><?= strtoupper($option) ?></p><?php } ?></td>
                        </tr><?php 
                        } elseif (sizeof($p_options) > 1) { ?>
                        <tr class="row-highlight-header row-options-header">
                            <th class="cell label title-highlight" colspan="2"><label for="pd_options">Options <span class="which"></span><span class="placeholder">Select an Option</span></label></th>
                        </tr><?php
                            $alpha = range('a', 'z');
                            $p_option_counter = 0;
                            foreach ($p_options as $option) {  ?>
                        <tr class="row-highlight row-option" data-option-value="" data-option="<?= $alpha[$p_option_counter]; ?>">
                            <td class="cell value single" colspan="2"><p><?= ucwords(strtolower($option)) ?></p></td>
                        </tr><?php
                            $p_option_counter++;
                            }
                        } 
                    }
                     
                    if(isset($p_variants)){ 
                        if (sizeof($p_variants_options) == 1 ){ 
                            if( strtolower($p_variants_options[0]['name']) == "wood types") {           $which_variant = 'variant-wood-types';      } 
                            elseif( strtolower($p_variants_options[0]['name']) == "stain types") {      $which_variant = 'variant-stain-types';     } 
                            elseif( strtolower($p_variants_options[0]['name']) == "upholstery type") {  $which_variant = 'variant-upholstery-types';} 
                            elseif( strtolower($p_variants_options[0]['name']) == "stain brands") {     $which_variant = 'variant-stain-brands';    } 
                            ?>
                        <tr class="row-highlight-header row-variants-header single-variant">
                            <th class="cell label title-highlight" colspan="2"><label for="pd_variant_<?= strtolower(str_replace(" ", "-", $p_variants_options[0]['name'])) ?>"><?= $p_variants_options[0]['name'] ?> <span class="which"></span><span class="placeholder"><?php                 
                            $the_variant = $p_variants_options[0]['name'];
                            if( substr( $the_variant, -1 == "s") ){
                                $the_variant = substr_replace( $the_variant, "", -1);
                            } ?><span class="placeholder-data" data-placeholder="<?= ucwords($the_variant); ?>" >Select a <?= ucwords($the_variant); ?></span></label></th>
                        </tr><?php
                            $p_variant_counter = 1;
                            $p_variants_option_value_vulues = array();
                            foreach($p_variant_values as $p_variant_value){
                                $option_value_id = $p_variant_value['FurnitureVariantOptionValueId'];
                                foreach($p_variants_option_values as $p_variants_option_value){
                                    if( $p_variants_option_value['id'] == $option_value_id ){ 
                                        array_push($p_variants_option_value_vulues, $p_variants_option_value['value']);
                                    }
                                }
                            }
                            if(isset($p_variants_option_value_vulues) && !empty($p_variants_option_value_vulues)){
                                asort($p_variants_option_value_vulues);
                            }

                            foreach ($p_variants_option_value_vulues as $p_variants_option_value_vulue) { ?>
                        <tr class="row-highlight row-variant row-single-variant" data-variant-value="" data-variant="<?= $p_variant_counter; ?>">
                        <?php 
                            if(isset($which_variant)){
                                $image_url_prefix = 'https://assets.infinitedigitalsolutions.com/media/img/covers/';
                                $image_url_sufix = '---infinite-digital-solutions.jpg';
                                if( $which_variant = 'variant-wood-types' ) {      $image_url_folder = 'wood-types/standard/'; }
                                elseif( $which_variant = 'variant-stain-types' ){      $image_url_folder = 'stain-types/'; }
                                elseif( $which_variant = 'variant-upholstery-types' ){ $image_url_folder = 'upholstery-types/'; }
                                elseif( $which_variant = 'variant-stain-brands' ) {    $image_url_folder = 'stain-brands/'; }
                            }
                            if(isset($which_variant) && $which_variant == 'variant-wood-types'){

                                    if(ucwords(strtolower($p_variants_option_value_vulue)) == 'Qswo'){ ?>
                            <td class="cell value single" colspan="2">
                                <div class="wood-type-wrapper"> <div class="wood-type-name"> <p>Quarter Sawn White Oak</p> </div> <div class="wood-type-img" style="background-image:url('<?= $image_url_prefix . $image_url_folder . 'rustic-quarter-sawn-white-oak' . $image_url_sufix; ?>')" > </div> </div>
                            </td><?php
                                    } elseif(ucwords(strtolower($p_variants_option_value_vulue)) == 'Rustic Qswo'){ ?>
                            <td class="cell value single" colspan="2">
                                <div class="wood-type-wrapper"> <div class="wood-type-name"> <p>Rustic Quarter Sawn White Oak</p> </div> <div class="wood-type-img" style="background-image:url('<?= $image_url_prefix . $image_url_folder . 'quarter-sawn-white-oak' . $image_url_sufix; ?>')" > </div> </div>
                            </td><?php
                                    } else { ?>
                            <td class="cell value single" colspan="2">
                                <div class="wood-type-wrapper"> <div class="wood-type-name"> <p><?= ucwords(strtolower($p_variants_option_value_vulue)); ?></p> </div> <div class="wood-type-img" style="background-image:url('<?= $image_url_prefix . $image_url_folder . strtolower(str_replace(" ", "-", $p_variants_option_value_vulue)) . $image_url_sufix; ?>')" > </div> </div>
                            </td><?php
                                    } 

                            } else {

                                    if(ucwords(strtolower($p_variants_option_value_vulue)) == 'Qswo'){ ?>
                            <td class="cell value single" colspan="2"><p>Quarter Sawn White Oak</p></td><?php
                                    } elseif(ucwords(strtolower($p_variants_option_value_vulue)) == 'Rustic Qswo'){ ?>
                            <td class="cell value single" colspan="2"><p>Rustic Quarter Sawn White Oak</p></td><?php
                                    } else { ?>
                            <td class="cell value single" colspan="2"><p><?= ucwords(strtolower($p_variants_option_value_vulue)); ?></p></td><?php
                                    } 

                            } ?>
                        </tr><?php
                            $p_variant_counter++;
                            }

                        } elseif (sizeof($p_variants_options) > 1) { ?>
                            <tr class="row-highlight-header row-variants-header complex-variant">
                                <th class="cell label title-highlight" colspan="2"><label for="pd_variants">Alternatives <span class="which"></span><span class="placeholder placeholder-data" data-placeholder="Alternative">Select an Alternative</span></label></th>
                            </tr><?php 
                            for($i = 0; $i < count($p_variants); ++$i) { 
                            $variantID = $p_variants[$i]['id']; ?>
                            <tr class="row-highlight row-variant" data-variant="<?= $i+1; ?>">
                                <th class="cell label label-highlight" data-count="<?= $i+1; ?>">
                                    <?php 
                                    if($p_variants[$i]['description']){ ?>  
                                        <label for="pd_variant_description">Description</label><?php
                                    } if($p_variants[$i]['sku']){ ?>  
                                        <label for="pd_variant_sku">SKU</label><?php
                                    } /* if($p_variants[$i]['id']){ ?>  
                                        <label for="pd_variant_id">ID</label><?php
                                    } if($p_variants[$i]['price']){ ?>  
                                        <label for="pd_variant_price">Price</label><?php
                                    } */
                                    foreach($p_variant_values as $p_variant_value){
                                        if($p_variant_value['FurnitureVariantId'] == $variantID ){
                                            $option_id = $p_variant_value['FurnitureVariantOptionId'];
                                            foreach($p_variants_options as $p_variants_option){
                                                if( $p_variants_option['id'] == $option_id ){ ?>  
                                        <label for="pd_variant_<?= strtolower(str_replace(" ", "-", $p_variants_option['name'])); ?>"><?= $p_variants_option['name']; ?></label><?php
                                                }
                                            }
                                        }
                                    } ?>
                                </th>
                                <td class="cell value">
                                    <?php 
                                    if($p_variants[$i]['description']){ ?>  
                                        <p><?= ucfirst($p_variants[$i]['description']); ?></p><?php
                                    } if($p_variants[$i]['sku']){ ?>  
                                        <p><?= $p_variants[$i]['sku']; ?></p><?php
                                    } /* if($p_variants[$i]['id']){ ?>  
                                        <p><?= $p_variants[$i]['id']; ?></p><?php
                                    } if($p_variants[$i]['price']){ ?>  
                                        <p><?= $p_variants[$i]['price']; ?></p><?php
                                    } */
                                    foreach($p_variant_values as $p_variant_value){
                                        if($p_variant_value['FurnitureVariantId'] == $variantID ){
                                            $option_value_id = $p_variant_value['FurnitureVariantOptionValueId'];
                                            foreach($p_variants_option_values as $p_variants_option_value){
                                                if( $p_variants_option_value['id'] == $option_value_id ){ 
                                                    if(ucwords(strtolower($p_variants_option_value['value'])) == 'Qswo'){ ?>
                                        <p>Quarter Sawn White Oak</p><?php
                                                    } elseif(ucwords(strtolower($p_variants_option_value['value'])) == 'Rustic Qswo'){ ?>
                                        <p>Rustic Quarter Sawn White Oak</p><?php
                                                    } else { ?>
                                        <p><?= ucwords(strtolower($p_variants_option_value['value'])); ?></p><?php
                                                    } 
                                                }
                                            }
                                        }
                                    } ?>
                                </td>
                            </tr><?php 
                            } 
                        } // elseif (sizeof($p_variants) > 1) 
                    } // if(isset($p_variants)){
                    ?>
                    </tbody>
                </table>
            </div>

            <?php
            if ((isset($p_options) && sizeof($p_options) > 1) &&  (isset($p_variants) && sizeof($p_variants_options) == 1)) { 
                $which_variant = $p_variants_options[0]['name'];
                if( substr( $which_variant, -1 == "s") ){
                    $which_variant = substr_replace( $which_variant, "", -1);
                } ?>
            <button class="get-quote-form-btn" disabled>Get A Quote
                <small>Select <span class="option">an OPTION</span><span class="variant">a <?= strtoupper($which_variant) ?></span></small>
            </button><?php 
            } elseif (isset($p_variants) && sizeof($p_variants_options) == 1) { 
                $which_variant = $p_variants_options[0]['name'];
                if( substr( $which_variant, -1 == "s") ){
                    $which_variant = substr_replace( $which_variant, "", -1);
                } ?>
            <button class="get-quote-form-btn" disabled>Get A Quote
                <small>Select </span><span class="variant">a <?= strtoupper($which_variant) ?></span></small>
            </button><?php 
            } elseif ((isset($p_options) && sizeof($p_options) > 1) &&  (isset($p_variants) && sizeof($p_variants) > 1)) { ?>
            <button class="get-quote-form-btn" disabled>Get A Quote
                <small>Select <span class="option">an OPTION</span><span class="variant">an ALTERNATIVE</span></small>
            </button><?php 
            } elseif (isset($p_options) && sizeof($p_options) > 1) { ?>
            <button class="get-quote-form-btn" disabled>Get A Quote
                <small>Select <span class="option">an OPTION</span></small>
            </button><?php 
            } elseif (isset($p_variants) && sizeof($p_variants_options) > 1) { ?>
            <button class="get-quote-form-btn" disabled>Get A Quote
                <small>Select <span class="variant">an ALTERNATIVE</span></small>
            </button><?php 
            } else {  ?>
            <button class="get-quote-form-btn">Get A Quote</button><?php 
            }  ?>
            <!-- Go to www.addthis.com/dashboard to customize your tools --> 
            <div data-url='<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>'
            data-title="<?php echo $p_name; ?>"
            data-description="<?php echo $p_description; ?>"
            data-media="<?php echo $main_img_url; ?>" 
            class="addthis_inline_share_toolbox">
            </div>
        </div>
    </div>
</section>
<aside class="related-products products-from-same-collection <?= str_replace(" ", "-", strtolower(get_bloginfo( 'name' ))); ?>">
    <?php 
    if( !empty($products_IDs_from_same_collection) ){ ?>
    <div class="alignfull wood-background">
        <header class="container">
            <h2><?= $this_p_collection_name ?></h2>
            <h4>Other items from the same collection</h4>
        </header>
    </div>
    <div class="grid-container alignfull php-single-furniture-item collection-image object-home"><?php 
        if (isset($upto_five_random_products_from_same_collection)) {
            foreach ($upto_five_random_products_from_same_collection as $product_from_same_collection) { ?>
        <div class="furniture-infinite-grid-items">
            <a href="/product-details/?from-furniture-item=<?= sanitize_title($product_from_same_collection['name']) ?>&pid=<?= $product_from_same_collection['id'] ?>">
                <?php 
                $img_url = 'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$product_from_same_collection['image_path'];
                $img_url = str_replace("-original", "-300x300", $img_url);  ?>
                <img src="<?= $img_url ?>">
                <p class="pro-name"><?= $product_from_same_collection['name'] ?></p>
            </a>
        </div><?php 
            }
        } elseif ($products_from_same_collection) {
            foreach ($products_from_same_collection as $product_from_same_collection) { ?>
        <div class="furniture-infinite-grid-items">
            <a href="/product-details/?from-furniture-item=<?= sanitize_title($product_from_same_collection['name']) ?>&pid=<?= $product_from_same_collection['id'] ?>">
                <?php 
                $img_url = 'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$product_from_same_collection['image_path'];
                $img_url = str_replace("-original", "-300x300", $img_url);  ?>
                <img src="<?= $img_url ?>">
                <p class="pro-name"><?= $product_from_same_collection['name']; ?></p>
            </a>
        </div><?php 
            }
        }
    ?>
    </div><?php 
    } ?>
</aside>
<div class="furniture-infinite-quote-form">
    <span class="form-close-icon">X</span>
    <div class="form-inner-wrapper">
        <div class="form-header-wrapper">
            <h6><?php echo $product['name']; ?></h6>
            <p><?= $product['description']; ?></p>
        </div>
        <div class="form-shortcode-wrapper">
        <?= do_shortcode("[gravityforms ajax='true' id='1' title='false' field_values='product_option=&product_variant=&sku=". $p_sku ."&name=". $p_name ."&description=" . $p_description . "&builder=" . $this_p_manufacturer_name . "&url=". site_url() . "%2Fproduct-details%2F%3Ffrom-furniture-item%3D" . sanitize_title($product['name']) . "%26pid%3D" . $pid . "&image_url=". $main_img_url . "&site_logo_url=". $site_logo . "&site_title=". $site_title . "&site_description=". $site_description . "&site_url=". $site_url . "']") ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(e){
        jQuery(".get-quote-form-btn").click(function(e){
            jQuery(".furniture-infinite-quote-form").show();
        });
        jQuery(".form-close-icon").click(function(e){
            jQuery(".furniture-infinite-quote-form").hide();
        });
        jQuery('.zoom').zoom({ on:'grab' });
    });
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-637ef52d00864aac"></script>
<!-- end single_furniture_php -->