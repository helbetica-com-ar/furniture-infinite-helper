<h1 class="search-heading">Search</h2>
<div class="searches-wrapper">
  <div class="search-bar-wrapper first">
    <h2 class="search-heading"><span>Search a product by</span> Furniture Item ID</h2>
  </div>
  <div class="search-bar-wrapper second">
      <form class="search-by-product-id" method="post" action="https://<?=$_SERVER['HTTP_HOST'];?>/wp-content/plugins/furniture-infinite-helper/public/search-product-handler.php">
          <input type="number" class="field" autocomplete="off" placeholder="Enter Furniture Item ID numeric value" name="pid">
          <input type="submit" value="Search" name="submit-pid" >
      </form>
  </div>
</div>
<div class="img-sample-wrapper">
    <img src="https://assets.infinitedigitalsolutions.com/media/img/furniture-item-ID-sample.png" alt="Furniture Item ID SAMPLE">    
</div>