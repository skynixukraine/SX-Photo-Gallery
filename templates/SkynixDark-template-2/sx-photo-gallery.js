(function SXgallery() {
    var slides,
        timerId,
        amount,
        state = false,
        indexOfcurrent,
        classOfCurrent,
        indexOfmain,
        indexOflast,
        i, l, k, m;

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

    function hideSlides() {
        slides.not('.sx-photo-gallery-photos__photo-container--0,' +
            '.sx-photo-gallery-photos__photo-container--1,' +
            '.sx-photo-gallery-photos__photo-container--2,' +
            '.sx-photo-gallery-photos__photo-container--3,' +
            '.sx-photo-gallery-photos__photo-container--4,' +
            '.sx-photo-gallery-photos__photo-container--5,' +
            '.sx-photo-gallery-photos__photo-container--6').hide();
    }

    function autoScroll() {
        timerId = setInterval(function () {
            switchSlide('right');
        }, 2500);
    }

    function updateShareLinks() {
        var src = jQuery('.sx-photo-gallery-photos__photo-container--3 img').attr('src');

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
            if (amount < 7) {
                if (amount < 4) {
                    k = 3;
                } else {
                    k = 7 - amount;
                    slides.css({'transition': 'opacity .5s ease-in-out'});
                }

                for (i = 0; i < amount; i++) {
                    slides.eq(i).show().addClass('sx-photo-gallery-photos__photo-container--' + k + '');
                    k += 1;
                }

            } else {
                for (i = 0; i < 7; i++) {
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
        indexOfcurrent = (jQuery(param).index());
        classOfCurrent = jQuery(param).attr('class');

        if (amount < 5) {
            l = 3;
            indexOflast = jQuery('.sx-photo-gallery-photos__photo-container--' + (amount + 1) + '').index();
            indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--3').index();
            if (state) {
                indexOflast = indexOfmain;
            }
        } else if (amount < 7) {
            l = 7 - amount;
            if (state) {
                indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--3').index() - (amount - 4);
                indexOflast = jQuery('.sx-photo-gallery-photos__photo-container--3').index() + 2;
            } else {
                indexOflast = jQuery('.sx-photo-gallery-photos__photo-container--5').index();
                indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--' + l + '').index();
            }
        } else {
            l = 0;
            if (state) {
                indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--3').index() - 3;
                indexOflast = jQuery('.sx-photo-gallery-photos__photo-container--3').index() + 2;
            } else {
                indexOfmain = jQuery('.sx-photo-gallery-photos__photo-container--0').index();
                indexOflast = jQuery('.sx-photo-gallery-photos__photo-container--5').index();
            }
        }

        if (jQuery(param).is('.sx-photo-gallery-photos__photo-container')) {
            jQuery('.sx-photo-gallery-photos__photo-container--3').removeClass().addClass(classOfCurrent);
            slides.eq(indexOfcurrent).removeClass()
                .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--3');
            state = true;

            updateShareLinks();

        } else if (param === 'right') {
            slides.removeClass();
            m = l;

            for (i = 0; i < 7; i++) {
                slides.eq(indexOfmain + i + 1).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + (m + i) + '');


                if (indexOfmain === (amount - i - 1)) {
                    for (k = 0; k < (indexOfmain + 1); k++) {
                        slides.eq(k).show()
                            .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + (l + i) + '');
                        l += 1;
                    }
                }

            }
            state = false;
            updateShareLinks();
            hideSlides();

        } else if (param === 'left') {
            slides.removeClass();
            k = 0;

            if (amount < 5) {
                for (i = amount + 2; i >= 3; i--) {
                    slides.eq(indexOflast - k).show()
                        .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                    k += 1;
                }
            } else {
                for (i = 6; i >= 0; i--) {
                    slides.eq(indexOflast - k).show()
                        .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                    k += 1;
                }
            }
            state = false;
            updateShareLinks();
            hideSlides();
        }
    }

    initializeGallery();

}());
