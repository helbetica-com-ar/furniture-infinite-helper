<div class="breadcrumbs">
    <a href="<?= site_url() ?>">Home /</a>
    <a href="<?= site_url() ?>/furniture/">Furniture /</a>
    <a href="/furniture/<?= (isset($p_cat_name))? strtolower(str_replace(" ", "-", $p_cat_name)) . "/" : '' ?>?cat-id=<?= $p_cat_id ?>"><?= (isset($p_cat_name))? $p_cat_name . " /" : '' ?></a>
    <a href="/furniture/<?= (isset($p_cat_name))? strtolower(str_replace(" ", "-", $p_cat_name)) . "/" : '' ?>?showing-subcategory=<?= (isset($p_sub_cat_name))? strtolower(str_replace(" ", "-", $p_sub_cat_name))  : '' ?>&sub-cat-id=<?= $p_sub_cat_id ?>"><?= (isset($p_sub_cat_name))? $p_sub_cat_name  : '' ?></a>
</div>
<main class="container product-details single-furniture-item">
    <div class="left-column" id="img">
        <div id="container" class="boxShadow">
            <img id="hover-effect" data-image="black" class="active" src="<?php echo $img_url; ?>" alt="" />
        </div>
    </div>
    <div class="right-column">
        <div class="product-details-wrapper">
            <div id="desc">
                <h1><?= $product['name'] ?></h1>
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
                    if(isset($p_options)){  
                        if (sizeof($p_options) == 1 ){  ?>
                        <tr>
                            <th class="cell label"><label for="pd_options">Option</label></th>
                            <td class="cell value"><?php foreach($p_options as $option){ ?><p><?= strtoupper($option) ?></p><?php } ?></td>
                        </tr><?php 
                        } elseif (sizeof($p_options) > 1) { ?>
                        <tr class="row-highlight-header row-options-header">
                            <th class="cell label title-highlight" colspan="2"><label for="pd_options">Options <span class="which"></span></label></th>
                        </tr><?php
                            $alpha = range('a', 'z');
                            $p_option_counter = 0;
                            foreach ($p_options as $option) {  ?>
                        <tr class="row-highlight row-option" data-option="<?= $alpha[$p_option_counter]; ?>">
                            <td class="cell value single" colspan="2"><p><?= ucwords(strtolower($option)) ?></p></td>
                        </tr><?php
                            $p_option_counter++;
                            }
                        } 
                    }
                    if(isset($p_variants)){ 
                        if (sizeof($p_variants_options) == 1 ){ ?>
                        <tr class="row-highlight-header row-variants-header">
                            <th class="cell label title-highlight" colspan="2"><label for="pd_variant_<?= strtolower(str_replace(" ", "-", $p_variants_options[0]['name'])) ?>"><?= $p_variants_options[0]['name'] ?> <span class="which"></span></label></th>
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
                            asort($p_variants_option_value_vulues);
                            foreach ($p_variants_option_value_vulues as $p_variants_option_value_vulue) { ?>
                        <tr class="row-highlight row-variant row-single-variant" data-variant="<?= $p_variant_counter; ?>">
                        <?php 
                                    if(ucwords(strtolower($p_variants_option_value_vulue)) == 'Qswo'){ ?>
                            <td class="cell value single" colspan="2"><p>Quarter Sawn White Oak</p></td><?php
                                    } elseif(ucwords(strtolower($p_variants_option_value_vulue)) == 'Rustic Qswo'){ ?>
                            <td class="cell value single" colspan="2"><p>Rustic Quarter Sawn White Oak</p></td><?php
                                    } else { ?>
                            <td class="cell value single this" colspan="2"><p><?= ucwords(strtolower($p_variants_option_value_vulue)); ?></p></td><?php
                                    } ?>
                        </tr><?php
                            $p_variant_counter++;
                            }

                        } elseif (sizeof($p_variants_options) > 1) { ?>
                            <tr class="row-highlight-header row-variants-header">
                                <th class="cell label title-highlight" colspan="2"><label for="pd_variants">Alternatives <span class="which"></span></label></th>
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
            <div 
            class="addthis_inline_share_toolbox_z3mt"
            data-url='<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>'
            data-title="<?php echo $product['name']; ?>"
            data-description="<?php echo $product['description']; ?>"
            data-media="<?php echo $img_url; ?>"
            >
            </div>
            <button class="print-btn" onclick="printProduct()"><i class="fa fa-print" aria-hidden="true"></i>Print</button>
            
        </div>
    </div>
</main>

<div class="furniture-infinite-quote-form">
    <span class="form-close-icon">X</span>
    <div class="form-inner-wrapper">
        <div class="form-header-wrapper">
            <h6><?php echo $product['name']  ?></h6>
            <p>I would like more information.</p>
        </div>
        <div class="form-shortcode-wrapper">
        <?= do_shortcode("[gravityforms ajax='true' id='1' title='false' field_values='sku=". $product['sku'] ."&name=". $product['name'] ."&url=". home_url(add_query_arg(array(), $wp->request)) ."']") ?>
        </div>
    </div>
</div>

<style type="text/css"></style>
<script type="text/javascript">
    jQuery(document).ready(function(e){
        jQuery(".get-quote-form-btn").click(function(e){
            jQuery(".furniture-infinite-quote-form").show();
        });
        jQuery(".form-close-icon").click(function(e){
            jQuery(".furniture-infinite-quote-form").hide();
        });

    });

    // Image Mouse hover effect
    const container = document.getElementById("container");
    const img = document.getElementById("hover-effect");

    container.addEventListener("mousemove", onZoom);
    container.addEventListener("mouseover", onZoom);
    container.addEventListener("mouseleave", offZoom);

    function onZoom(e) {
        const x = e.clientX - e.target.offsetLeft;
        const y = e.clientY - e.target.offsetTop;

        //console.log(x, y);

        img.style.transformOrigin = `${x}px ${y}px`;
        img.style.transform = "scale(1.5)";
    }

    function offZoom(e) {
        img.style.transformOrigin = `center center`;
        img.style.transform = "scale(1)";
    }

    function printProduct() {
        var img = document.getElementById("img").innerHTML;
        var desc = document.getElementById("desc").innerHTML;
        var a = window.open('', '', 'height=1200, width=1200');


        a.document.write('<html>');
        a.document.write('<body >');
        a.document.write(img);
        a.document.write(desc);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
    // <!-- Go to www.addthis.com/dashboard to customize your tools -->


</script>