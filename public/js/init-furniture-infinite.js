(function ($) {
    // $(window).load(function () { });
    if ($('.tablinks.active').length){
        which = $('.tablinks.active').attr('data-tab');
        $('#' + which).show();
    }
    $(".tablinks").on("click", function () {
        //alert($(this).text().slice(-1));
        if (  $(this).text().slice(-1) != 's'){
            $('#' + $(this).attr("data-tab")).attr("data-before", $(this).text() + "'s Collection");
        } else {
            $('#' + $(this).attr("data-tab")).attr("data-before", $(this).text() + "' Collection");
        }
        
    });


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