<section class="all-products-section">
    <!-- <h2 style="text-align: center;">Browse Manufacturers By Collections</h2> -->
    <?php 
    foreach ($collections as $collection) {  
        array_push($manufacturersCollections[$collection['ManufacturerId']]['collectionsArray'], array( "collectionName" => $collection['name'], "collectionID" => $collection['id']));
    }
    ?>
    <div class="row">
        <?php 
        $columns = array_column($manufacturersCollections, 'manufacturerName');
        array_multisort($columns, SORT_ASC, $manufacturersCollections);

        echo "<pre id='var-dump' style='display:none;'>";
        print_r($manufacturersCollections);
        echo "</pre>";

        $counter = 0;
        $placeholder = 0;
        $html_prefix;
        $tablinks;
        $tabs;
        $html_prefix .= '<div class="manufacturersCollections-wrapper">';
        foreach ($manufacturersCollections as $manufacturerCollection) {
            $counter++;
            if ( count($manufacturerCollection['collectionsArray']) >= 1 ){
                if ( $counter == 1 ){ $html_prefix .= '<div class="tab">'; }
                if (isset($_GET['showing-collecion']) && $_GET['showing-collecion'] == sanitize_title($manufacturerCollection['manufacturerName']) ) {
                    $tablinks .=  '<a class="tablinks active" data-manufacturer="'. sanitize_title($manufacturerCollection['manufacturerName'])  .'" data-tab="Tab' . $counter . '" onclick="openTab(event, \'Tab' . $counter . '\')">' . $manufacturerCollection['manufacturerName']  . '</a>';
                } else {
                    $tablinks .=  '<a class="tablinks" data-manufacturer="'. sanitize_title($manufacturerCollection['manufacturerName']) .'" data-tab="Tab' . $counter . '" onclick="openTab(event, \'Tab' . $counter . '\')">' . $manufacturerCollection['manufacturerName']  . '</a>';
                }
                if ( $counter == count($manufacturersCollections)){ 
                $tablinks .= '</div><!--/.tab-->'; 
                } 
                $itsCollections = $manufacturerCollection['collectionsArray'];
                $columns = array_column($itsCollections, 'collectionName');
                array_multisort($columns, SORT_ASC, $itsCollections);
                $collectionCounter = 0;
                foreach ($itsCollections as $theCollection) {
                    if (!isset($_GET['showing-collecion']) && $placeholder == 0) {
                        $tabs .= '<div id="TabPlaceholder" class="tabcontent tabcontent-placeholder active"><div class="tabcontent-wrapper-placeholder"><h3>Choose a Manufacturer from the left...</h3></div><!--/.tabcontent-wrapper--></div><!--/.tabcontent-->';
                    }
                    $placeholder++;
                    if ( $collectionCounter == 0){ $tabs .= '<div id="Tab' . $counter . '" class="tabcontent"><div class="tabcontent-wrapper">'; }
                    $collectionCounter++;
                    $tabs .= '<a class="tabcontent-links" href="/collection/?collection-name=' . sanitize_title($theCollection['collectionName']) . '&collection-id=' . $theCollection['collectionID'] . '">' . $theCollection['collectionName'] . '</a>';
                    if ( $collectionCounter == count($itsCollections)){ $tabs .= '</div><!--/.tabcontent-wrapper--></div><!--/.tabcontent-->'; }
                }
            } elseif ( $counter == count($manufacturersCollections)){ 
                $tablinks .= '</div><!--/.tab-->'; 
            }
        }
        echo $html_prefix . $tablinks . $tabs;
        if ( $counter == 0){ echo '</div><!--/.manufacturersCollections-wrapper-->'; }
        if ( $counter == count($manufacturersCollections)){ echo '</div><!--/.manufacturersCollections-wrapper-->'; }
        ?>
    </div>
</section>