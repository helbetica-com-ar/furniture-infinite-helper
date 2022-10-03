<div class="breadcrumbs">
    <?php /* 
    <a href="<?= site_url() ?>">Home /</a>
    <a href="<?= site_url() ?>/all-products/">Furniture /</a>
    <a href="/all-products?cat-id=<?= $p_cat_id ?>"><?= (isset($p_cat_name))? $p_cat_name . " /" : '' ?></a>
    <a href="/all-products?sub-cat-id=<?= $sub_cat_id ?>"><?= (isset($sub_cat_name))? $sub_cat_name  : '' ?></a>
    */ ?>
    <a href="<?= site_url() ?>">Home /</a>
    <a href="<?= site_url() ?>/furniture/">Furniture /</a>
    <a href="/furniture/<?= (isset($p_cat_name))? strtolower($p_cat_name) . "/" : '' ?>?cat-id=<?= $p_cat_id ?>"><?= (isset($p_cat_name))? $p_cat_name . " /" : '' ?></a>
    <a href="/furniture/<?= (isset($p_cat_name))? strtolower($p_cat_name) . "/" : '' ?>?sub-cat-id=<?= $sub_cat_id ?>"><?= (isset($sub_cat_name))? $sub_cat_name  : '' ?></a>
</div>
<main class="container detail-product"> 
    <div class="left-column" id="img">
        <div id="container" class="boxShadow">
            <img id="hover-effect" data-image="black" class="active" src="<?php echo $img_url; ?>" alt="">
        </div>
    </div>

    <div class="right-column">
        <div class="product-description">
            <?php #var_dump($product); ?>
            <div id="desc">
                <h1><?= $product['name'] ?></h1>
                <p><?= $product['description'] ?></p>
                <?php 
                if( isset( $product['dimensions'][0] ) ){  ?>
                <p><strong>Dimensions: </strong><?= $product['dimensions'][0] ?></p><?php 
                }
                if( isset( $product['sku'] ) ){  ?>
                <p><strong>SKU: </strong><?= $product['sku'] ?></p><?php 
                }
                ?>
                
                <?php if(isset($furniture_variant_options)){ ?>
                    <p><strong>Furniture Options: </strong><?= implode(",", $furniture_variant_options) ?></p>
                <?php } ?>

                <?php if(isset($p_options)){ ?>
                    <p><strong>Options: </strong><?= implode(",", $p_options) ?></p>
                <?php } ?>

                <?php if(isset($furniture_variant_option_values)){ ?>
                    <p><strong>Variants: </strong><?= implode(",", $furniture_variant_option_values) ?></p>
                <?php } ?>
            </div>
            
            <button class="get-quote-form-btn">Get A Quote</button>
            
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

        // console.log(x, y)

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