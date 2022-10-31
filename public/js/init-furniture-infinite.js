(function ($) {
    
    // $(window).load(function () { });

    optionSelected = false;
    variantSelected = false;
    alternatives = 0;
    enableOption = false;
    enableVariant = false;
    
    if ($('.gform_footer.top_label').length) { $('.gform_footer.top_label').append("<small class='hover-notifier'>Please, fill in all the fields first</small>"); } 
    if ($('.row-options-header').length) { alternatives++; enableOption = true; } else { optionSelected = true; }
    if ($('.row-variants-header').length) { alternatives++; enableVariant = true; } else { variantSelected = true; }

    if (alternatives > 0) { $('div.product_option, div.product_variant').find('input').attr('disabled', 'disabled'); }

    if (alternatives == 2) { 
        $('div.product_option, div.product_variant').addClass('unhide'); 
        $('.furniture-infinite-quote-form .form-header-wrapper, .furniture-infinite-quote-form .form-shortcode-wrapper').addClass('dual-choice'); 
    } else if (alternatives == 1) { 
        $('.furniture-infinite-quote-form .form-header-wrapper, .furniture-infinite-quote-form .form-shortcode-wrapper').addClass('single-choice'); 
        if (enableOption == true) {  $('.furniture-infinite-quote-form .form-shortcode-wrapper').addClass('unhide-option');  }
        if (enableVariant == true) { $('.furniture-infinite-quote-form .form-shortcode-wrapper').addClass('unhide-variant'); }
    } else if (alternatives == 0) { 
        $('.furniture-infinite-quote-form .form-header-wrapper, .furniture-infinite-quote-form .form-shortcode-wrapper').addClass('no-choices'); 
    }

    $('.row-options-header, .row-variants-header').on('click', function () {
        $(this).toggleClass('open');
    });
    
    $('.row-variants-header').on('click', function () {
        setTimeout(() => {
            $('.wood-type-img').addClass('show');
        }, "5000")
    });

    $('tr.row-option').on('click', function () {
        $('tr.row-option').removeClass('active');
        $(this).addClass('active');
        $(this).attr('data-option-value', $(this).find('.cell.value.single p').text() );
        if ($('#gform_1').length) {
            // $('#gform_1 .product_option').removeClass('gfield_visibility_hidden');
            $('#gform_1 .product_option input').attr('value', 'Option ' + $(this).attr('data-option').toUpperCase() + ': ' + $(this).attr('data-option-value') );
        }
        $('.row-options-header').addClass('has-choice');
        $('.row-options-header label span.which').html($(this).attr('data-option')).show();
        optionSelected = true;
        $('.get-quote-form-btn small span.option').remove();
        if (variantSelected == true){
            $('.get-quote-form-btn').removeAttr('disabled');
            $('.get-quote-form-btn small').html('ALL SET!!');
            $('html, body').animate({
                scrollTop: ($(".right-column").offset().top + $(".right-column").height() - $(window).height())
            }, 500);
        }
    });
    $('tr.row-variant').on('click', function () {
        $('tr.row-variant').removeClass('active');
        $(this).addClass('active');
        if ($('.single-variant').length) { $(this).attr('data-variant-value', $(this).find('.cell.value.single p').text()); }
        if ($('#gform_1').length) {
            // $('#gform_1 .product_variant').removeClass('gfield_visibility_hidden');
            if ($('.single-variant').length) { 
                $('#gform_1 .product_variant input').attr('value', $('.row-variants-header .placeholder-data').attr('data-placeholder') + ' #' + $(this).attr('data-variant') + ': ' + $(this).attr('data-variant-value'));
            } else {
                $('#gform_1 .product_variant input').attr('value', $('.row-variants-header .placeholder-data').attr('data-placeholder') + ' #' + $(this).attr('data-variant') );
            }
        }
        $('.row-variants-header').addClass('has-choice');
        $('.row-variants-header label span.which').html($(this).attr('data-variant')).show();
        variantSelected = true;
        $('.get-quote-form-btn small span.variant').remove();
        if (optionSelected == true) {
            $('.get-quote-form-btn').removeAttr('disabled');
            $('.get-quote-form-btn small').html('ALL SET!!');
            $('html, body').animate({
                scrollTop: ($(".right-column").offset().top + $(".right-column").height() - $(window).height())
            }, 500);
        }
    });

    if ($('.tablinks.active').length){
        which = $('.tablinks.active');
        $('#' + which.attr('data-tab')).show();
        addPseudoContentBeforeSufix(which);
    }
    
    $(".tablinks").on("click", function () {
        addPseudoContentBeforeSufix($(this));
    });

    function addPseudoContentBeforeSufix(selector){
        if ($(selector).text().slice(-1) != 's') {
            $('#' + $(selector).attr("data-tab")).attr("data-before", $(selector).text() + "'s Collection");
        } else {
            $('#' + $(selector).attr("data-tab")).attr("data-before", $(selector).text() + "' Collection");
        }
    }


    $.preloadImages = function () {
        for (var i = 0; i < arguments.length; i++) {
            $("<img />").attr("src", arguments[i]);
        }
    }

    $.preloadImages("../wp-content/plugins/furniture-infinite-helper/public/img/active_cursor.png", "../wp-content/plugins/furniture-infinite-helper/public/img/plus_cursor.png", "../wp-content/plugins/furniture-infinite-helper/public/img/disabled_cursor.png" );

    


}(jQuery));


function openTab(evt, TabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(TabName).style.display = "block";
    evt.currentTarget.className += " active";
} 