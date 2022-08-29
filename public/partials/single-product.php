<div class="breadcrumbs">
    <a href="<?= site_url() ?>">Home /</a>
    <a href="<?= site_url() ?>/all-products/">Furniture /</a>
    <a href="/all-products?cat-id=<?= $p_cat_id ?>"><?= (isset($p_cat_name))? $p_cat_name . " /" : '' ?></a>
    <a href="/all-products?sub-cat-id=<?= $sub_cat_id ?>"><?= (isset($sub_cat_name))? $sub_cat_name  : '' ?></a>
</div>
<main class="container detail-product-85">
    <div class="left-column" id="img">
        <div id="container">
            <img id="hover-effect" data-image="black" class="active" src="<?php echo $img_url; ?>" alt="">
        </div>
    </div>

    <div class="right-column">
        <div class="product-description">
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

<div class="chariho-quote-form">
    <span class="form-close-icon">X</span>
    <div class="inner-wrap-323">
        <div class="text-wrap-8767">
            <h6><?php echo $product['name']  ?></h6>
            <p>I would like more information.</p>
        </div>
        <?= do_shortcode("[gravityforms ajax='true' id='1' title='false' field_values='sku=". $product['sku'] ."&name=". $product['name'] ."&url=". home_url(add_query_arg(array(), $wp->request)) ."']") ?>
    </div>
</div>

<style type="text/css">
    .addthis_inline_share_toolbox_z3mt{
        float: left;
    }
    .print-btn{
        margin-left: 3px;
        float: left;
        border-radius: 0px;
    }
    .print-btn i{
        margin-right: 10px;
    }
    .at4-visible{
        opacity: 1 !important;
    }
    .chariho-quote-form{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0px;
        margin: auto;
        background-color: #fff;
        z-index: 99;
    }
    @media only screen and (max-width: 750px){
        .chariho-quote-form{
            overflow-y: scroll;
        }
    }
    @media only screen and (min-width: 800px){
        .inner-wrap-323{
            padding: 0 50px;  
            width: 800px;
            margin: auto;
        }
    }
    @media only screen and (max-width: 800px){
        .inner-wrap-323{
            padding: 20px;
            width: 100%;
            margin: auto;
        }   
    }
    .gform_footer{
        text-align: right;
        display: block !important;
    }
    .gform_confirmation_message_1{
        text-align: center;
    }
    .chariho-quote-form input[type=submit]{
        background-color: #87b840 !important;
        color: #fff;
        border: 0px;
        padding: 10px 80px;
    }
    .text-wrap-8767{
        text-align: center;
        font-family: inherit;
    }
    .text-wrap-8767 h6{
        font-family: inherit !important;
    }
    .form-close-icon{
        cursor: pointer;
        position: absolute;
        font-size: 30px;
        right: 30px;
        top: 15px;
        font-weight: bold;
        color:  #000;
    }
    .more-color-btn{
        display: block;
        background-color: #707070;
        text-align: center;
        padding: 10px 10px;
        margin-bottom: 20px;
        margin-top: 20px;
        color: #fff !important;
        font-size: 20px;
        font-weight: bold;
        border-radius: 3px !important;
        font-family: inherit !important;
    }
    .get-quote-form-btn{
        display: block;
        background-color: #87b840 !important;
        text-align: center;
        padding: 10px 10px;
        margin-bottom: 20px;
        color: #fff !important;
        font-size: 20px;
        font-weight: bold;
        width: 100%;
        border: 0px;
        border-radius: 3px !important;
        font-family: inherit;
    }
    @media only screen and (min-width:  1000px){
        #container{
            width: 500px;
        }   
    }
    #container{
        overflow: hidden;
        margin: auto;
    }
    #container img {
        transform-origin: center center;
        object-fit: cover;
        height: auto;
        width: 90%;
    }
    .breadcrumbs{
        margin: 0px 30px;
    }
    @media only screen and (max-width:  1000px){
        .breadcrumbs{
            margin-bottom: 20px !important;
        }
        main.container.detail-product-85{
            display: block;
        }
        main.container .left-column,
        main.container .right-column{
            padding: 0px 15px;
            width: 100% !important;
        }
    }

</style>
<script type="text/javascript">
    jQuery(document).ready(function(e){
        jQuery(".get-quote-form-btn").click(function(e){
            jQuery(".chariho-quote-form").show();
        });
        jQuery(".form-close-icon").click(function(e){
            jQuery(".chariho-quote-form").hide();
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