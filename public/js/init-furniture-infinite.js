(function ($) {
    
    // $(window).load(function () { });

    optionSelected = false;
    variantSelected = false;

    if ($('.row-options-header').length){ 
    } else {
        optionSelected = true; 
    }
    if ($('.row-variants-header').length) { 
    } else {
        variantSelected = true;
    }

    $('.row-options-header, .row-variants-header').on('click', function () {
        $(this).toggleClass('open');
    });

    $('tr.row-option').on('click', function () {
        $('tr.row-option').removeClass('active');
        $(this).addClass('active');
        $('.row-options-header label span.which').html($(this).attr('data-option')).show();
        optionSelected = true;
        $('.get-quote-form-btn small span.option').remove();
        if (variantSelected == true){
            $('.get-quote-form-btn').removeAttr('disabled');
            $('.get-quote-form-btn small').html('ALL SET!!');
        }
    });
    $('tr.row-variant').on('click', function () {
        $('tr.row-variant').removeClass('active');
        $(this).addClass('active');
        $('.row-variants-header label span.which').html($(this).attr('data-variant')).show();
        variantSelected = true;
        $('.get-quote-form-btn small span.variant').remove();
        if (optionSelected == true) {
            $('.get-quote-form-btn').removeAttr('disabled');
            $('.get-quote-form-btn small').html('ALL SET!!');
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