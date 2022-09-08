<?php

add_shortcode( 'home_collections', 'chariho_shortcode_home_collections' );
function chariho_shortcode_home_collections() {
	$url = "https://furnitureinfinite.com/api/auth/wp-login";
	$user = 'tort.juanpablo+wpstoreadmin02@gmail.com';		// Chariho Furniture
	$pass = '3G28cRVCEPV9Jc';								// Chariho Furniture 
	$auth = base64_encode($user . ':' . $pass);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Authorization: Basic " . $auth . "",
		"Content-Type: application/x-www-form-urlencoded",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$post_response = curl_exec($curl);
	curl_close($curl);
	$post_response = json_decode($post_response,true);
	$bearer = $post_response["token"];
	# $bearer = get_option('myplugin_option_name');

	$options = ["http" => ["header" => "Authorization: Bearer $bearer"]];
	$context = stream_context_create($options);
	$response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
	$response = json_decode($response);
	$response = json_encode($response, JSON_PRETTY_PRINT);
	$response = json_decode($response, true);
	//echo "<pre>"; print_r($response); echo "</pre>";exit;
	?>
	<style>
		.grid-container {     margin-bottom: 50px; display: grid; grid-template-columns:repeat(3, 1fr); gap: 50px}

		.collection-image-96 div {
			background-color: #f2f2f2;
			padding: 15px;
		}

		.collection-image-96 div img {
			width: 100%;
			height: auto;
		}

		.collection-image-96 div .grid-item {
			text-align: center;
			font-family: "Open Sans", Sans-serif;
			font-size: 23px;
			font-weight: 400;
			text-transform: uppercase;
			color: var( --e-global-color-primary );
		}

		.elementor-widget-container ul {
			padding: 0 !important;
		}
	</style>
	<div class="grid-container chariho_shortcode_home_collections collection-image-96 object-1-home">
		<?php 
		$manufacturers = $response['furnitureData'][0]['Manufacturers'];
		$cat_ids = array();
		foreach ($manufacturers as $key => $manufacturer) {	
			$products = $manufacturer['Furniture'];
			foreach ($products as $key => $product) {
				if (in_array($product['CategoryId'], $cat_ids)){			
				}else{
					$cat_ids[] = $product['CategoryId'];
				}
			}
		}
		//echo "<pre>"; print_r($cat_ids); echo "</pre>"; exit;
		$count_sub_cat = 0;
		$rowCount = 0;
		?>
			<?php
			foreach ($response['categories'] as $col_key => $col_value) {
				$count_sub_cat = count($col_value['SubCategories']);
				if($count_sub_cat > 0){
					$url = '/sub-categories/?cat-id='.$col_value['id'];
				}else{
					$url = '/all-products/?cat-id='.$col_value['id'];
				}
				if (in_array($col_value['id'], $cat_ids)){					
					echo '<div style=""><a href="'.$url.'">';
					echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
					echo '<div class="grid-item" style="">'; print_r($col_value['name']); echo "</div>";
					echo '</a></div>';					
					$rowCount++;
				}
			}
			$rowCount1 = 0;
			?>
	</div>
	<?php
}


add_shortcode( 'collections', 'chariho_shortcode_collections' );
function chariho_shortcode_collections() {
	$url = "https://furnitureinfinite.com/api/auth/wp-login";
	$user = 'tort.juanpablo+wpstoreadmin02@gmail.com';		// Chariho Furniture
	$pass = '3G28cRVCEPV9Jc';								// Chariho Furniture
	$auth = base64_encode($user . ':' . $pass);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Authorization: Basic " . $auth . "",
		"Content-Type: application/x-www-form-urlencoded",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$post_response = curl_exec($curl);
	curl_close($curl);
	$post_response = json_decode($post_response,true);
	$bearer = $post_response["token"];
	# $bearer = get_option('myplugin_option_name');

	$options = ["http" => ["header" => "Authorization: Bearer $bearer"]];

	$context = stream_context_create($options);

	$response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
	$response = json_decode($response);
	$response = json_encode($response, JSON_PRETTY_PRINT);
	$response = json_decode($response, true);

	//echo "<pre>"; print_r($response); echo "</pre>";exit;
	?>
	<style>
		.grid-container {     margin-bottom: 50px; display: grid; grid-template-columns:repeat(3, 1fr); gap: 50px}

		.collection-image-96 div {
			background-color: #f2f2f2;
			padding: 15px;
		}

		.collection-image-96 div img {
			width: 100%;
			height: auto;
		}

		.collection-image-96 div .grid-item {
			text-align: center;
			font-family: "Open Sans", Sans-serif;
			font-size: 23px;
			font-weight: 400;
			text-transform: uppercase;
			color: var( --e-global-color-primary );
		}

		.elementor-widget-container ul {
			padding: 0 !important;
		}
	</style>
	<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
		<div class="img-heading-su-874">
			<h1>COLLECTIONS</h1>
		</div>
	</section>
	<div class="grid-container chariho_shortcode_collections collection-image-96 collection-984564">
		<?php 

		$manufacturers = $response['furnitureData'][0]['Manufacturers'];
		//echo "<pre>"; print_r($response); echo "</pre>";exit;
		$cat_ids = array();
		foreach ($manufacturers as $key => $manufacturer) {		
			$products = $manufacturer['Furniture'];
			foreach ($products as $key => $product) {
				if (in_array($product['CategoryId'], $cat_ids)){			
				}else{
					$cat_ids[] = $product['CategoryId'];
				}		
			}
		}

		$count_sub_cat = 0;
		foreach ($response['categories'] as $col_key => $col_value) {
			$count_sub_cat = count($col_value['SubCategories']);
			if($count_sub_cat > 0){
				$url = '/sub-categories/?cat-id='.$col_value['id'];
			}else{
				$url = '/all-products/?cat-id='.$col_value['id'];
			}
			if (in_array($col_value['id'], $cat_ids)){
				echo '<div><a href="'.$url.'">';
				echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
				echo '<div class="grid-item">'; print_r($col_value['name']); echo "</div>";
				echo '</a></div>';
			}
		}
		?>
	</div>
	<?php
}


add_shortcode( 'all-products', 'chariho_shortcode_all_products' );
function chariho_shortcode_all_products() {
	$url = "https://furnitureinfinite.com/api/auth/wp-login";
	$user = 'tort.juanpablo+wpstoreadmin02@gmail.com';		// Chariho Furniture
	$pass = '3G28cRVCEPV9Jc';								// Chariho Furniture
	$auth = base64_encode($user . ':' . $pass);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Authorization: Basic " . $auth . "",
		"Content-Type: application/x-www-form-urlencoded",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$post_response = curl_exec($curl);
	curl_close($curl);
	$post_response = json_decode($post_response,true);
	$bearer = $post_response["token"];
	# $bearer = get_option('myplugin_option_name');
	
	$options = ["http" => ["header" => "Authorization: Bearer $bearer"]];

	$context = stream_context_create($options);

	$response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
	$response = json_decode($response);
	$response = json_encode($response, JSON_PRETTY_PRINT);
	$response = json_decode($response, true);

	//echo "<pre>"; print_r($response); echo "</pre>";exit;
	//echo "<h1>Products</h1><ul>";
	?>
	<style>
		.grid-container {     margin-bottom: 50px; display: grid; grid-template-columns:repeat(3, 1fr); gap: 50px}

		.collection-image-96 div {
			background-color: #f2f2f2;
			padding: 15px;
		}

		.collection-image-96 div img {
			width: 100%;
			height: auto;
		}

		.collection-image-96 div .grid-item {
			text-align: center;
			font-family: "Open Sans", Sans-serif;
			font-size: 23px;
			font-weight: 400;
			text-transform: uppercase;
			color: var( --e-global-color-primary );
		}

		.elementor-widget-container ul {
			padding: 0 !important;
		}

		.page-id-1280 .all-product-collection-9 div a {
			background: #fff;
			text-align: center;
			display: block;
			vertical-align: middle !important;
			padding-top: 15px;
		}
		.page-id-1280 .all-product-collection-9 div img {
			width: auto;
			height: 400px;
			max-width: fit-content;
			margin: auto;
			object-fit: cover;
			object-position: center;
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 767px) {
			.page-id-1280 .grid-container{
				display: block;
			}
			.page-id-1280 .grid-container div {
				width: 100%;
				max-width: 100%;
			}
			.page-id-1280 .all-product-collection-9 div img{
				height: 300px;
			}

		}
	</style>
	<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
		<div class="img-heading-su-874">
		<?php 
		$cat_id = $_GET['cat-id'];
		$sub_cat_id = $_GET['sub-cat-id'];
		//$sub_cat_id = $_GET['cat-id'];
		foreach ($response['categories'] as $col_key => $col_value) {
			//echo "<pre>"; print_r($col_value); echo "</pre>";exit;
			if ($col_value['id'] == $cat_id) {
				foreach ($col_value['SubCategories'] as $sub_col_key => $sub_col_value) {				
					if ($col_value['id'] == $cat_id) {			
						?><h1><?php print_r($sub_col_value['name']);	?></h1><?php 
					}
				}
			}
		}
		?>
		</div>
	</section>
	<div class="grid-container chariho_shortcode_all_products collection-image-96 all-product-collection-9">
		<?php 
		$cat_id = $_GET['cat-id'];
		//$man_id = $_GET['man-id'];
		$sub_cat_id = $_GET['sub-cat-id'];
		//$sub_cat_id = '';
		//$products = $response['furnitureData'][0]['Manufacturers'][0]['Furniture'];
		$manufacturers = $response['furnitureData'][0]['Manufacturers'];

		$cat_ids = array();
		$rowCount = 'no';
		foreach ($manufacturers as $key => $manufacturer) {		
			$products = $manufacturer['Furniture'];
			foreach ($products as $key => $product) {
				$pro_CollectionId = $product['CategoryId'];
				//$pro_ManufacturerId = $product['ManufacturerId'];
				$pro_SubCategoryId = $product['SubCategoryId'];
				//echo "<pre>"; print_r($pro_SubCategoryId); echo "</pre>";
				$image = $product['Images'][0];
				$img_type = $image['type'];
				if(empty($img_type)){ $img_type = "jpeg"; }
				$img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/'.$image['path'];

				if(!empty($sub_cat_id)){				
					if($sub_cat_id == $pro_SubCategoryId){						
						$rowCount = 'yes';
						$url = "/product-detail/?pid=".$product['id'];
						echo '<div><a href="'.$url.'">';
						echo '<img src="'.$img_url.'">';
						echo '<div class="grid-item">'; print_r($product['name']); echo "</div>";
						echo '</a></div>';			
					}
				}else{
					if($cat_id == $pro_CollectionId){	
						$rowCount = 'yes';
						//echo "<pre>"; print_r($product); echo "</pre>";exit;
						$url = "/product-detail/?pid=".$product['id'];
						echo '<div><a href="'.$url.'">';
						echo '<img src="'.$img_url.'">';
						echo '<div class="grid-item">'; print_r($product['name']); echo "</div>";
						echo '</a></div>';		

					}
				}
			}
		}
		if($rowCount == 'no'){
			//echo "<pre>"; print_r($rowCount); echo "</pre>";exit;	
			?>
			<style>
				/* The alert message box */
				.alert {
				  	color: #721c24;
					background-color: #f8d7da !important;
					border-color: #f5c6cb;
					position: relative;
					padding: 0.75rem 1.25rem !important;
					margin-bottom: 1rem;
					border: 1px solid transparent;
					border-radius: 0.25rem;
				}
			</style>
			<div class="alert" style="background-color: #f8d7da !important; padding: 0.75rem 1.25rem !important;">
			  No product found.
			</div>	
			<?php
		}
		?>
	</div>
	<?php
	//echo "<pre>"; print_r($response['categories']); echo "</pre>";
}


add_shortcode('sub-categories', 'chariho_shortcode_sub_categories');
function chariho_shortcode_sub_categories(){
	$url = "https://furnitureinfinite.com/api/auth/wp-login";
	$user = 'tort.juanpablo+wpstoreadmin02@gmail.com';		// Chariho Furniture
	$pass = '3G28cRVCEPV9Jc';								// Chariho Furniture
	$auth = base64_encode($user . ':' . $pass);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Authorization: Basic " . $auth . "",
		"Content-Type: application/x-www-form-urlencoded",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$post_response = curl_exec($curl);
	curl_close($curl);
	$post_response = json_decode($post_response,true);
	$bearer = $post_response["token"];
	# $bearer = get_option('myplugin_option_name');
	$options = ["http" => ["header" => "Authorization: Bearer $bearer"]];

	$context = stream_context_create($options);
	$response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
	$response = json_decode($response);
	$response = json_encode($response, JSON_PRETTY_PRINT);
	$response = json_decode($response, true);
	//echo "<h1>Sub Categories</h1><ul>";
	?>
	<style>
		.grid-container {
			margin-bottom: 50px;
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 50px
		}

		.collection-image-96 div {
			background-color: #dcad6f !important;
			padding: 15px;
		}

		.collection-image-96 div img {
			width: 100%;
			height: auto;
		}

		.collection-image-96 div .grid-item {
			text-align: center;
			font-family: "Open Sans", Sans-serif;
			font-size: 23px;
			font-weight: 400;
			text-transform: uppercase;
			color: var(--e-global-color-primary);
		}

		.elementor-widget-container ul {
			padding: 0 !important;
		}
		.grid-container.collection-image-96.collection-page-854564 {
			gap: 18px !important;
		}


		.grid-container.collection-image-96.collection-page-854564 div a {
			margin-bottom: 10px;
			display: block;
		}

		.grid-container.collection-image-96.collection-page-854564 div a .grid-item {
			background-color: unset !important;
			text-align: left !important;
			font-size:20px;
		}
		.grid-container.collection-image-96.collection-page-854564 div {
			background-color: unset !important;
			padding-top: 10px !important;
		}
	</style>
	<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
		<div class="img-heading-su-874">
			<?php
			$sub_cat_id = $_GET['cat-id'];
			foreach ($response['categories'] as $col_key => $col_value) {
				//echo "<pre>"; print_r($col_value); echo "</pre>";exit;
				if ($col_value['id'] == $sub_cat_id) {
					?><h1><?php echo $col_value['name'];?></h1><?php
				}
			}
			?>		
		</div>
	</section>
	<div class="grid-container chariho_shortcode_sub_categories collection-image-96 collection-page-854564">
		<?php
		$sub_cat_id = $_GET['cat-id'];
		foreach ($response['categories'] as $col_key => $col_value) {
			//echo "<pre>"; print_r($col_value); echo "</pre>";exit;
			if ($col_value['id'] == $sub_cat_id) {
				foreach ($col_value['SubCategories'] as $sub_col_key => $sub_col_value) {
					$url = "/all-products/?cat-id=" . $col_value['id'] . "&sub-cat-id=" . $sub_col_value['id'];
					echo '<div><a href="' . $url . '">';
					echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
					echo '<div class="grid-item">';
					print_r($sub_col_value['name']);
					echo "</div>";
					echo '</a></div>';
				}
			}
		}
		?>
	</div>
	<?php
	//echo "<pre>"; print_r($response['categories']); echo "</pre>";
}


add_shortcode('pdp', 'chariho_shortcode_pdp');
function chariho_shortcode_pdp(){
	$url = "https://furnitureinfinite.com/api/auth/wp-login";
	$user = 'tort.juanpablo+wpstoreadmin02@gmail.com';		// Chariho Furniture
	$pass = '3G28cRVCEPV9Jc';								// Chariho Furniture
	$auth = base64_encode($user . ':' . $pass);

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Authorization: Basic " . $auth . "",
		"Content-Type: application/x-www-form-urlencoded",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

	$data = "email=" . urlencode($user) . "&password=" . urlencode($pass) . "";


	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$post_response = curl_exec($curl);
	curl_close($curl);
	$post_response = json_decode($post_response,true);
	$bearer = $post_response["token"];
	# $bearer = get_option('myplugin_option_name');
	
	$options = ["http" => ["header" => "Authorization: Bearer $bearer"]];

	$context = stream_context_create($options);
	$response = file_get_contents("https://furnitureinfinite.com/api/wp", false, $context);
	$response = json_decode($response);
	$response = json_encode($response, JSON_PRETTY_PRINT);
	$response = json_decode($response, true);

	$pid = $_GET['pid'];

	$manufacturers = $response['furnitureData'][0]['Manufacturers'];
	//echo "<pre>"; print_r($response); echo "</pre>";exit;
	$cat_ids = array();
	foreach ($manufacturers as $key => $manufacturer) {		
		$products = $manufacturer['Furniture'];

		foreach ($products as $key => $product) {
			$pro_Id = $product['id'];
			$image = $product['Images'][0];
			$img_type = $image['type'];
			if (empty($img_type)) {
				$img_type = "jpeg";
			}
			$img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/' . $image['path'];


			$CategoryId = $product['CategoryId'];

			$cat_name = "";
			foreach ($response['categories'] as $col_key => $col_value) {
				if ($col_value['id'] == $CategoryId) {
					$cat_name = $col_value['name'];
				}
			}

			if ($pid == $pro_Id) {
				//echo "<pre>"; print_r($product); echo "</pre>";exit;
				?>
				<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
					<div class="img-heading-su-874">
						<h1>PRODUCT</h1>
					</div>
				</section>
				<main class="container chariho_shortcode_pdp detail-product-85">
					<div class="left-column">
						<img data-image="black" class="active" src="<?php echo $img_url; ?>" alt="">
					</div>

					<div class="right-column">
						<div class="product-description">
							<span><?php echo $cat_name; ?></span>
							<h1><?php print_r($product['name']); ?></h1>
							<p><?php print_r($product['description']); ?></p>
						</div>

						<div class="product-configuration">
							<?php
								foreach ($product['FurnitureVariantOptions'] as $fvo_key => $fvo_value) { ?>
									<div class="cable-config config-heading-964">
										<span><?php echo $fvo_value['name']; ?></span>
										<div class="cable-choose">
											<?php
											foreach ($product['FurnitureVariantOptionValues'] as $fvov_key => $fvov_value) {
												if ($fvov_value['FurnitureVariantOptionId'] === $fvo_value['id']) {
													//echo "<pre>"; print_r($fvov_value['id']); echo "</pre>";exit;
													foreach ($product['FurnitureVariantValues'] as $fvv_key => $fvv_value) {
														if ($fvv_value['FurnitureVariantOptionValueId'] == $fvov_value['id']) {
															$fv_id = $fvv_value['FurnitureVariantId'];
														}
													} ?>
													<div class="radio-btn-967">
														<ul>
															<li><?php echo $fvov_value['value']; ?></li>
														</ul>
													</div>
													
													<!-- <button><?php //echo $fvov_value['value']; ?></button> -->
													<?php
												}
											}
											?>					
										</div>
									</div>					
									<?php
								}
							?>
							<div class="form-87123"><?php echo do_shortcode('[elementor-template id="1863"]');?></div>
						</div>

						<!-- Product Pricing -->
						<div class="product-price">
							<?php
								foreach ($product['FurnitureVariants'] as $fp_key => $fp_value) {
							?>
							<span class="pri_hide" id="<?php echo $fp_value['id']; ?>" style="display: none;">$<?php echo $fp_value['price']; ?></span>
							<?php
								}
							?>
						</div>
					</div>
				</main>
				<?php
			}
		}
	} ?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.cable-choose input').on('change', function() {
				var price_id = jQuery(this).val();
				jQuery(".pri_hide").css("display", "none");
				jQuery("#" + price_id).css("display", "block");
			});

		});
	</script>
	<?php
	//echo "<pre>"; print_r($response['categories']); echo "</pre>";
}


add_action( 'admin_init', 'myplugin_register_settings' );
function myplugin_register_settings() {
   	add_option( 'myplugin_option_name', 'This is my option value.');
   	register_setting( 'myplugin_options_group', 'myplugin_option_name', 'myplugin_callback' );
}

add_action('admin_menu', 'myplugin_register_options_page');
function myplugin_register_options_page() {
	/* myplugin_options_page */
  	add_options_page('Furniture API', 'Furniture API', 'manage_options', 'myplugin', 'myplugin_options_page');
}

function myplugin_options_page(){ ?>
	<div>
		<?php //screen_icon(); ?>
		<h2>Furniture API Bearer Token</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'myplugin_options_group' ); ?>
			<table>
				<tr valign="top">
					<th scope="row"><label for="myplugin_option_name">Bearer Token</label></th>
					<td><textarea id="myplugin_option_name" name="myplugin_option_name"><?php echo get_option('myplugin_option_name'); ?></textarea></td>
				</tr>
			</table>
			<?php  submit_button(); ?>
		</form>
	</div><?php
} 
?>