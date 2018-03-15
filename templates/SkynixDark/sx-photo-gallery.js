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

    function swipedetect(callback) {
        var touchsurface,
            swipedir,
            startX,
            distX,
            threshold = 100,
            handleswipe = callback || function (swipedir) {
            };

        touchsurface = document.querySelectorAll('.sx-photo-gallery-photos__photo-container img');
        Array.prototype.forEach.call(touchsurface, function (element) {
            element.addEventListener('touchstart', function (e) {
                var touchobj = e.changedTouches[0];
                swipedir = 'none';
                dist = 0;
                startX = touchobj.pageX;
                e.preventDefault();
            }, false);

            element.addEventListener('touchmove', function (e) {
                e.preventDefault();
            }, false);

            element.addEventListener('touchend', function (e) {
                var touchobj = e.changedTouches[0];
                distX = touchobj.pageX - startX;

                if (Math.abs(distX) >= threshold) {
                    swipedir = (distX < 0) ? 'right' : 'left';
                }
                handleswipe(swipedir);
                e.preventDefault();
            }, false);
        });
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
                    jQuery('.sx-photo-gallery').on('mouseenter', function () {
                        clearInterval(timerId);
                    });
                    jQuery('.sx-photo-gallery').on('mouseleave', function () {
                        autoScroll();
                    });
                    autoScroll();
                } else {
                    swipedetect(function (swipedir) {
                        switchSlide(swipedir);
                    });
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

    initializeGallery();
}());
