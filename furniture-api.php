<?php

add_shortcode('home_collections', 'furniture_infinite_shortcode_home_collections');
function furniture_infinite_shortcode_home_collections()
{
	$response = get_transient('furniture_api_json_data_wp');
?>
	<style type="text/css"></style>
	<div class="grid-container furniture_infinite_shortcode_home_collections collection-image object-home">
		<?php
		$manufacturers = $response['furnitureData'][0]['Manufacturers'];
		$cat_ids = array();
		foreach ($manufacturers as $key => $manufacturer) {
			$products = $manufacturer['Furniture'];
			foreach ($products as $key => $product) {
				if (in_array($product['CategoryId'], $cat_ids)) {
				} else {
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
			if ($count_sub_cat > 0) {
				$url = '/sub-categories/?cat-id=' . $col_value['id'];
			} else {
				$url = '/all-products/?cat-id=' . $col_value['id'];
			}
			if (in_array($col_value['id'], $cat_ids)) {
				echo '<div style=""><a href="' . $url . '">';
				echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
				echo '<div class="grid-item" style="">';
				print_r($col_value['name']);
				echo "</div>";
				echo '</a></div>';
				$rowCount++;
			}
		}
		$rowCount1 = 0;
		?>
	</div>
<?php
}


add_shortcode('collections', 'furniture_infinite_shortcode_collections');
function furniture_infinite_shortcode_collections()
{
	$response = get_transient('furniture_api_json_data_wp');
?>
	<style type="text/css"></style>
	<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
		<div class="img-heading-su-874">
			<h1>COLLECTIONS</h1>
		</div>
	</section>
	<div class="grid-container furniture_api_php furniture_infinite_shortcode_collections collection-image collection-984564">
		<?php

		$manufacturers = $response['furnitureData'][0]['Manufacturers'];
		//echo "<pre>"; print_r($response); echo "</pre>";exit;
		$cat_ids = array();
		foreach ($manufacturers as $key => $manufacturer) {
			$products = $manufacturer['Furniture'];
			foreach ($products as $key => $product) {
				if (in_array($product['CategoryId'], $cat_ids)) {
				} else {
					$cat_ids[] = $product['CategoryId'];
				}
			}
		}

		$count_sub_cat = 0;
		foreach ($response['categories'] as $col_key => $col_value) {
			$count_sub_cat = count($col_value['SubCategories']);
			if ($count_sub_cat > 0) {
				$url = '/sub-categories/?cat-id=' . $col_value['id'];
			} else {
				$url = '/all-products/?cat-id=' . $col_value['id'];
			}
			if (in_array($col_value['id'], $cat_ids)) {
				echo '<div><a href="' . $url . '">';
				echo '<img src="/wp-content/uploads/2022/03/bedroom-bg-300x300.jpg">';
				echo '<div class="grid-item">';
				print_r($col_value['name']);
				echo "</div>";
				echo '</a></div>';
			}
		}
		?>
	</div>
<?php
}


# add_shortcode('all-products', 'furniture_infinite_shortcode_all_products');
function furniture_infinite_shortcode_all_products()
{
	$response = get_transient('furniture_api_json_data_wp');
?>
	<style type="text/css"></style>
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
						if ($col_value['id'] == $cat_id) { ?>
							<h1><?php print_r($sub_col_value['name']);	?></h1><?php
						}
					}
				}
			}
			?>
		</div>
	</section>
	<div class="grid-container furniture_infinite_shortcode_all_products collection-image all-product-collection">
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
				if (empty($img_type)) {
					$img_type = "jpeg";
				}
				$img_url =  'https://infinite-digital-production.s3.us-east-2.amazonaws.com/' . $image['path'];

				if (!empty($sub_cat_id)) {
					if ($sub_cat_id == $pro_SubCategoryId) {
						$rowCount = 'yes';
						$url = "/product-detail/?pid=" . $product['id'];
						echo '<div><a href="' . $url . '">';
						echo '<img src="' . $img_url . '">';
						echo '<div class="grid-item">';
						print_r($product['name']);
						echo "</div>";
						echo '</a></div>';
					}
				} else {
					if ($cat_id == $pro_CollectionId) {
						$rowCount = 'yes';
						//echo "<pre>"; print_r($product); echo "</pre>";exit;
						$url = "/product-detail/?pid=" . $product['id'];
						echo '<div><a href="' . $url . '">';
						echo '<img src="' . $img_url . '">';
						echo '<div class="grid-item">';
						print_r($product['name']);
						echo "</div>";
						echo '</a></div>';
					}
				}
			}
		}
		if ($rowCount == 'no') {
			//echo "<pre>"; print_r($rowCount); echo "</pre>";exit;	
		?>
			<style type="text/css"></style>
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


add_shortcode('sub-categories', 'furniture_infinite_shortcode_sub_categories');
function furniture_infinite_shortcode_sub_categories()
{
	$response = get_transient('furniture_api_json_data_wp');
?>
	<style type="text/css"></style>
	<section class="img-products-45" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
		<div class="img-heading-su-874">
		<?php
		$sub_cat_id = $_GET['cat-id'];
		foreach ($response['categories'] as $col_key => $col_value) {
			//echo "<pre>"; print_r($col_value); echo "</pre>";exit;
			if ($col_value['id'] == $sub_cat_id) { ?>
			<h1><?php echo $col_value['name']; ?></h1><?php
			}
		} ?>
		</div>
	</section>
	<div class="grid-container furniture_infinite_shortcode_sub_categories collection-image collection-page-854564">
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


add_shortcode('pdp', 'furniture_infinite_shortcode_pdp');
function furniture_infinite_shortcode_pdp()
{
	$response = get_transient('furniture_api_json_data_wp');

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
				<section class="img-products-45 furniture-api-php" style="background-image: url(/wp-content/uploads/2022/03/rustic-country-room.jpg);">
					<div class="img-heading-su-874">
						<h1>PRODUCT</h1>
					</div>
				</section>
				<main class="container furniture_infinite_shortcode_pdp detail-product">
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

												<!-- <button><?php //echo $fvov_value['value']; 
																?></button> -->
										<?php
											}
										}
										?>
									</div>
								</div>
							<?php
							}
							?>
							<div class="form-87123"><?php echo do_shortcode('[elementor-template id="1863"]'); ?></div>
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
