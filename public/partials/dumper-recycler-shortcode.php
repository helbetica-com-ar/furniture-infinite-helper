<div class="dump-wrapper">
    <?php 
    global $post;
    $furniture_page = get_page_by_path( 'furniture' );
    $furniture_page_id = $furniture_page->ID;

    ?>
    <div id="dumper" style="display: none;"><pre><?php print_r($furniture_page_id); ?></pre></div>
</div>