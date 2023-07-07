<h2 class="search-heading">Search Builder Name or Furniture Item by ID</h2>
<h3 style="color:red; display: block; text-align: center;" class="search-subheading">THIS SEARCH FORMS DO NOT WORK YET | WORK IN PROGRESS</h3>
<div class="searches-wrapper">
  <div class="search-bar-wrapper">
      <h3>Enter Builder ID</h3>
      <form role="form" class="search-by-builder-id" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
          <input type="number" class="field" autocomplete="off" placeholder="Enter Builder ID numeric value" name="builderId">
          <input type="submit" value="Search">
      </form>
  </div>
  <div class="search-bar-wrapper">
      <h3>Enter product ID</h3>
      <form class="search-by-product-id" method="post" action="https://<?=$_SERVER['HTTP_HOST'];?>/wp-content/plugins/furniture-infinite-helper/public/search-product-handler.php">
          <input type="number" class="field" autocomplete="off" placeholder="Enter Furniture Item ID numeric value" name="pid">
          <input type="submit" value="Search" name="submit-pid" >
      </form>
  </div>
</div>