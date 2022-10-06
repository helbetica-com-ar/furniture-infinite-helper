(function ($) {
    
    // $(window).load(function () { });
    
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