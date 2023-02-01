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

    // if (alternatives > 0) { $('div.product_option, div.product_variant').find('input').attr('disabled', 'disabled'); }
    if (alternatives > 0) { $('div.product_option, div.product_variant').find('input').attr('readonly', 'readonly'); }

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



    if ($('body').hasClass('furniture-single-view') ){

        fieldValues = $('input[name=gform_field_values]').attr('value');
        splitted = fieldValues.split('&');


        $('tr.row-option').on('click', function () {
            $('tr.row-option').removeClass('active');
            $(this).addClass('active');
            $(this).attr('data-option-value', $(this).find('.cell.value.single p').text());
            if ($('#gform_1').length) {
                // $('#gform_1 .product_option').removeClass('gfield_visibility_hidden');
                chosenOption = 'Option ' + $(this).attr('data-option').toUpperCase() + ': ' + $(this).attr('data-option-value');
                $('#gform_1 .product_option input').attr('value', chosenOption);
                chosenOptionEncoded = encodeURIComponent(chosenOption).replace(/%20/g, "+");
                splitted[0] = 'product_option=' + chosenOptionEncoded;
                fieldValues = splitted.join('&');
                $('input[name=gform_field_values]').attr('value', fieldValues);
            }
            $('.row-options-header').addClass('has-choice');
            $('.row-options-header label span.which').html($(this).attr('data-option')).show();
            optionSelected = true;
            $('.get-quote-form-btn small span.option').remove();
            if (variantSelected == true) {
                // $('.get-quote-form-btn').removeAttr('disabled');
                $('.get-quote-form-btn').removeAttr('readonly');
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
                    chosenVariant = $('.row-variants-header .placeholder-data').attr('data-placeholder') + ' #' + $(this).attr('data-variant') + ': ' + $(this).attr('data-variant-value');
                    $('#gform_1 .product_variant input').attr('value', chosenVariant);
                    chosenVariantEncoded = encodeURIComponent(chosenVariant).replace(/%20/g, "+");
                    splitted[1] = 'product_variant=' + chosenVariantEncoded;
                    fieldValues = splitted.join('&');
                    $('input[name=gform_field_values]').attr('value', fieldValues);
                } else {
                    chosenVariant = $('.row-variants-header .placeholder-data').attr('data-placeholder') + ' #' + $(this).attr('data-variant')
                    $('#gform_1 .product_variant input').attr('value', chosenVariant);
                    chosenVariantEncoded = encodeURIComponent(chosenVariant).replace(/%20/g, "+");
                    splitted[1] = 'product_variant=' + chosenVariantEncoded;
                    fieldValues = splitted.join('&');
                    $('input[name=gform_field_values]').attr('value', fieldValues);
                }
            }
            $('.row-variants-header').addClass('has-choice');
            $('.row-variants-header label span.which').html($(this).attr('data-variant')).show();
            variantSelected = true;
            $('.get-quote-form-btn small span.variant').remove();
            if (optionSelected == true) {
                // $('.get-quote-form-btn').removeAttr('disabled');
                $('.get-quote-form-btn').removeAttr('readonly');
                $('.get-quote-form-btn small').html('ALL SET!!');
                $('html, body').animate({
                    scrollTop: ($(".right-column").offset().top + $(".right-column").height() - $(window).height())
                }, 500);
            }
        });

        $.preloadImages = function () {
            for (var i = 0; i < arguments.length; i++) {
                $("<img />").attr("src", arguments[i]);
            }
        }

        $.preloadImages("../wp-content/plugins/furniture-infinite-helper/public/img/active_cursor.png", "../wp-content/plugins/furniture-infinite-helper/public/img/plus_cursor.png", "../wp-content/plugins/furniture-infinite-helper/public/img/disabled_cursor.png");

        swapThumb();


    } // if ($('body').hasClass('furniture-single-view') )

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

function swapThumb(){
    jQuery('.thumbnail img').on('click', function () {
        if (!jQuery(this).hasClass('active')){
            jQuery('.thumbnail img').removeClass('active');
            jQuery(this).addClass('active');
            $src = jQuery(this).attr('src');
            $replacement = $src.replace('-84x84', '-original');
            jQuery('.zoomImg').remove();
            jQuery('.zoom').zoom({ on: 'grab', url: $replacement });
            jQuery('#hover-effect').attr('src', $replacement);
        }
    });
}








/*!
    Zoom 1.7.21
    license: MIT
    http://www.jacklmoore.com/zoom
*/
(function (o) { var t = { url: !1, callback: !1, target: !1, duration: 120, on: "mouseover", touch: !0, onZoomIn: !1, onZoomOut: !1, magnify: 1 }; o.zoom = function (t, n, e, i) { var u, c, a, r, m, l, s, f = o(t), h = f.css("position"), d = o(n); return t.style.position = /(absolute|fixed)/.test(h) ? h : "relative", t.style.overflow = "hidden", e.style.width = e.style.height = "", o(e).addClass("zoomImg").css({ position: "absolute", top: 0, left: 0, opacity: 0, width: e.width * i, height: e.height * i, border: "none", maxWidth: "none", maxHeight: "none" }).appendTo(t), { init: function () { c = f.outerWidth(), u = f.outerHeight(), n === t ? (r = c, a = u) : (r = d.outerWidth(), a = d.outerHeight()), m = (e.width - c) / r, l = (e.height - u) / a, s = d.offset() }, move: function (o) { var t = o.pageX - s.left, n = o.pageY - s.top; n = Math.max(Math.min(n, a), 0), t = Math.max(Math.min(t, r), 0), e.style.left = t * -m + "px", e.style.top = n * -l + "px" } } }, o.fn.zoom = function (n) { return this.each(function () { var e = o.extend({}, t, n || {}), i = e.target && o(e.target)[0] || this, u = this, c = o(u), a = document.createElement("img"), r = o(a), m = "mousemove.zoom", l = !1, s = !1; if (!e.url) { var f = u.querySelector("img"); if (f && (e.url = f.getAttribute("data-src") || f.currentSrc || f.src), !e.url) return } c.one("zoom.destroy", function (o, t) { c.off(".zoom"), i.style.position = o, i.style.overflow = t, a.onload = null, r.remove() }.bind(this, i.style.position, i.style.overflow)), a.onload = function () { function t(t) { f.init(), f.move(t), r.stop().fadeTo(o.support.opacity ? e.duration : 0, 1, o.isFunction(e.onZoomIn) ? e.onZoomIn.call(a) : !1) } function n() { r.stop().fadeTo(e.duration, 0, o.isFunction(e.onZoomOut) ? e.onZoomOut.call(a) : !1) } var f = o.zoom(i, u, a, e.magnify); "grab" === e.on ? c.on("mousedown.zoom", function (e) { 1 === e.which && (o(document).one("mouseup.zoom", function () { n(), o(document).off(m, f.move) }), t(e), o(document).on(m, f.move), e.preventDefault()) }) : "click" === e.on ? c.on("click.zoom", function (e) { return l ? void 0 : (l = !0, t(e), o(document).on(m, f.move), o(document).one("click.zoom", function () { n(), l = !1, o(document).off(m, f.move) }), !1) }) : "toggle" === e.on ? c.on("click.zoom", function (o) { l ? n() : t(o), l = !l }) : "mouseover" === e.on && (f.init(), c.on("mouseenter.zoom", t).on("mouseleave.zoom", n).on(m, f.move)), e.touch && c.on("touchstart.zoom", function (o) { o.preventDefault(), s ? (s = !1, n()) : (s = !0, t(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0])) }).on("touchmove.zoom", function (o) { o.preventDefault(), f.move(o.originalEvent.touches[0] || o.originalEvent.changedTouches[0]) }).on("touchend.zoom", function (o) { o.preventDefault(), s && (s = !1, n()) }), o.isFunction(e.callback) && e.callback.call(a) }, a.setAttribute("role", "presentation"), a.alt = "", a.src = e.url }) }, o.fn.zoom.defaults = t })(window.jQuery);