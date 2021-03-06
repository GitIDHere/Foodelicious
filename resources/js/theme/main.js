(function ($) {
    'use strict';

    var browserWindow = $(window);

    // :: 1.0 Preloader Active Code
    browserWindow.on('load', function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

    // :: 3.0 Nav Active Code
    if ($.fn.classyNav) {
        $('#deliciousNav').classyNav();
    }

    // :: 4.0 Search Active Code
    var searchwrapper = $('.search-wrapper');
    $('.search-btn').on('click', function () {
        searchwrapper.toggleClass('on');
    });
    $('.close-btn').on('click', function () {
        searchwrapper.removeClass('on');
    });

    // :: 5.0 Sliders Active Code
    if ($.fn.owlCarousel) {
        var welcomeSlide = $('.hero-slides');
        var recipeSlide = $('.recipe-slider');

        welcomeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            nav: true,
            navText: ['Prev', 'Next'],
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 1000
        });

        welcomeSlide.on('translate.owl.carousel', function () {
            var slideLayer = $("[data-animation]");
            slideLayer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        welcomeSlide.on('translated.owl.carousel', function () {
            var slideLayer = welcomeSlide.find('.owl-item.active').find("[data-animation]");
            slideLayer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });

        $("[data-delay]").each(function () {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function () {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        var dot = $('.hero-slides .owl-dot');
        dot.each(function () {
            var index = $(this).index() + 1 + '.';
            if (index < 10) {
                $(this).html('0').append(index);
            } else {
                $(this).html(index);
            }
        });

        recipeSlide.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            itemsDesktop : [250,1],
            autoHeight: true,
            center: true,
            smartSpeed: 1000
        });
    }

    // :: 6.0 Gallery Active Code
    if ($.fn.magnificPopup) {
        $('.videobtn').magnificPopup({
            type: 'iframe'
        });
    }

    // :: 7.0 ScrollUp Active Code
    if ($.fn.scrollUp) {
        browserWindow.scrollUp({
            scrollSpeed: 1500,
            scrollText: '<i class="fa fa-angle-up"></i>'
        });
    }

    // :: 8.0 CouterUp Active Code
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    }

    var controller = null;
    var apiCallTimer = null;

    /**
    * A generic function which helps to generate a Tagify list based on the callback
    * @param term
    * @param tagifyObj
    * @param apiCallback
    */
    $.fn.generateTagList = function(term, tagifyObj, apiCallback)
    {
        clearTimeout(apiCallTimer);

        apiCallTimer = setTimeout(function(){

            tagifyObj.settings.whitelist.length = 0;

            // End any existing API calls
            controller && controller.abort();
            controller = new AbortController();

            tagifyObj.loading(true).dropdown.hide.call(tagifyObj);

            apiCallback(term)
                .then(function(resp)
                {
                    if (resp.data !== undefined)
                    {
                        var itemList = resp.data;

                        tagifyObj.settings.whitelist.splice(0, itemList.length, ...itemList);

                        // render the suggestions dropdown
                        tagifyObj.loading(false).dropdown.show.call(tagifyObj, term);
                    }
                })
                .catch(function(error)
                {
                    // Hide the dropdown list
                    tagifyObj.loading(false).dropdown.hide.call(tagifyObj);
                })
            ;

        }, 400);
    };



    // Grey bar show/hide toggle
    $('.slidetxt h3 a').click(function() {
        $(this).closest('.slidetxt').find('.slidetxtinner').slideToggle();
        $(this).toggleClass('open');
        return false;
    });

    var toastEl = $('.render-toast');
    if (toastEl !== undefined && toastEl.length > 0)
    {
        $(toastEl).hide();

        var toastTxt = $(toastEl).text();

        switch(true)
        {
            case toastEl.hasClass('info'):
                toastr.info(toastTxt);
                break;
            case toastEl.hasClass('warning'):
                toastr.warning(toastTxt);
                break;
        }
    }

    // :: 9.0 nice Select Active Code
    if ($.fn.niceSelect) {
        $('select').niceSelect();
    }

    // :: 10.0 wow Active Code
    if (browserWindow.width() > 767) {
        new WOW().init();
    }

    // :: 11.0 prevent default a click
    $('a[href="#"]').click(function ($) {
        $.preventDefault()
    });

    $("body").removeClass("preload");


    $('textarea.ck-editor').ckeditor();

})(jQuery);
