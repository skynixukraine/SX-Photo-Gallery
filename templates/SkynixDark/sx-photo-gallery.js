(function SXgallery() {
    var slides,
        timerId,
        amount,
        indexOfcurrent,
        i, l, k;

    function hideSlides() {
        slides.not('.sx-photo-gallery-photos__photo-container--0,' +
            '.sx-photo-gallery-photos__photo-container--1,' +
            '.sx-photo-gallery-photos__photo-container--2').hide();
    }

    function autoScroll() {
        timerId = setInterval(function () {
            switchSlide('right');
        }, 3000);
    }

    function updateShareLinks() {
        var src = jQuery('.sx-photo-gallery-photos__photo-container--1 img').attr('src');
        jQuery('.sx-photo-gallery__share-facebook').parent()
            .attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + src + '');
        jQuery('.sx-photo-gallery__share-twitter').parent()
            .attr('href', 'https://twitter.com/home?status=' + src + '');
        jQuery('.sx-photo-gallery__share-linkedin').parent()
            .attr('href', 'https://www.linkedin.com/shareArticle?mini=true&url=' + src + '');
    }

    function initializeGallery() {

        jQuery('.sx-photo-gallery-photos img')
            .wrap('<li class="sx-photo-gallery-photos__photo-container"><a href=""></a></li>');

        slides = jQuery('.sx-photo-gallery-photos__photo-container');

        amount = slides.length;

        hideSlides();

        if (amount > 0) {

            if (amount < 4) {
                slides.css({'transition': 'opacity .4s  ease-in-out'});
                for (i = 0; i < 3; i++) {
                    slides.eq(i).show()
                        .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                }
                if (amount < 3) {
                    slides.removeClass();
                    for (i = 0; i < 3; i++) {
                        slides.eq(i).show().addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + (1 + i) + '');
                    }
                }
            } else {
                for (i = 0; i < 3; i++) {
                    slides.eq(i).show().addClass('sx-photo-gallery-photos__photo-container--' + i + '');
                }
            }

            if (amount > 1) {
                jQuery('.sx-photo-gallery__controlls-arrow').on('click', function () {
                    switchSlide(jQuery(this).data('param'));
                }).css({'pointer-events': 'inherit'});

                slides.on('click', function () {
                    switchSlide(this);
                });

                if (jQuery(window).width() > 560) {
                    jQuery('.sx-photo-gallery').on('mousemove', function () {
                        clearInterval(timerId);
                    });
                    jQuery('.sx-photo-gallery').on('mouseleave', function () {
                        autoScroll();
                    });
                    autoScroll();
                } else {
                    swipe();
                }
            }

            updateShareLinks();
        }
    }


    function switchSlide(param) {
        indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--1').index();
        indexOfcurrent = (jQuery(param).index());
        classOfCurrent = jQuery(param).attr('class');

        if (jQuery(param).is('.sx-photo-gallery-photos__photo-container')) {

            jQuery('.sx-photo-gallery-photos__photo-container--1').removeClass().addClass(classOfCurrent);

            slides.eq(indexOfcurrent).removeClass()
                .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--1');

            updateShareLinks();
        } else if (param === 'right') {
            slides.removeClass();

            for (i = 0; i < 3; i++) {
                l = 0;
                k = 0;

                slides.eq(indexOfmain + i).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');

                if (indexOfmain === (amount - (3 - i))) {
                    for (k = (3 - i); k < 3; k++) {
                        slides.eq(l).show()
                            .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + k + '');
                        l += 1;
                    }
                }
            }
            updateShareLinks();
            hideSlides();

        } else if (param === 'left') {
            k = 0;
            slides.removeClass();

            for (i = 2; i >= 0; i--) {
                slides.eq(indexOfmain - k).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                k += 1;
            }
            updateShareLinks();
            hideSlides();
        }
    }

    function swipe() {
        var touchstartX = 0;
        var touchendX = 0;

        var sliderZone = document.querySelector('.sx-photo-gallery');

        sliderZone.addEventListener('touchstart', function (e) {
            touchstartX = e.changedTouches[0].screenX;
        }, false);

        sliderZone.addEventListener('touchend', function (e) {
            touchendX = e.changedTouches[0].screenX;
            handleGesure();
        }, false);

        function handleGesure() {
            if (touchendX < touchstartX) {
                switchSlide('right');
            }
            if (touchendX > touchstartX) {
                switchSlide('left');
            }
        }
    }

    initializeGallery();
}());
