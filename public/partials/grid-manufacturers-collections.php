<section class="all-products-section" style="margin-bottom:7em">
    <h2 style="text-align: center;">Broswe Manufacturers By Collections</h2>
    <?php 
    foreach ($collections as $collection) {  
        array_push($manufacturersCollections[$collection['ManufacturerId']]['collectionsArray'], array( "collectionName" => $collection['name'], "collectionID" => $collection['id']));
    }
    //echo "<pre><code>" . print_r($manufacturersCollections) . "</code></pre>";
    ?>
    <div class="row">
        
        <?php 
        $counter = 0;
        $placeholder = 0;
        $html_prefix;
        $tablinks;
        $tabs;
        $html_prefix .= '<div class="manufacturersCollections-wrapper"><div class="tab">';
        foreach ($manufacturersCollections as $manufacturerCollection) {  
            if ( count($manufacturerCollection['collectionsArray']) >= 1 ){
                $counter++;
                $tablinks .=  '<a class="tablinks active" onclick="openTab(event, \'Tab' . $counter . '\')">' . $manufacturerCollection['manufacturerName']  . '</a>';
                if ( $counter == count($manufacturersCollections)){ 
                $tablinks .= '</div><!--/.tab-->'; 
                } 
                $itsCollections = $manufacturerCollection['collectionsArray'];
                $collectionCounter = 0;
                foreach ($itsCollections as $theCollection) {
                    if ($placeholder == 0) {
                        $tabs .= '<div id="TabPlaceholder" class="tabcontent active"><div class="tabcontent-wrapper"><h3>Choose a Manufacturer from the left...</h3></div><!--/.tabcontent-wrapper--></div><!--/.tabcontent-->';
                    }
                    $placeholder++;
                    if ( $collectionCounter == 0){ $tabs .= '<div id="Tab' . $counter . '" class="tabcontent"><div class="tabcontent-wrapper">'; }
                    $collectionCounter++;
                    $tabs .= '<a class="tabcontent-links" href="/collection/?collection-id=' . $theCollection['collectionID'] . '">' . $theCollection['collectionName'] . '</a>';
                    if ( $collectionCounter == count($itsCollections)){ $tabs .= '</div><!--/.tabcontent-wrapper--></div><!--/.tabcontent-->'; }
                }
            }
        }
        echo $html_prefix . $tablinks . $tabs;
        if ( $counter == count($manufacturersCollections)){ echo '</div><!--/.manufacturersCollections-wrapper-->'; }
        ?>
    </div>
</section>