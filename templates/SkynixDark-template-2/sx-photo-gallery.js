function SXgallery( $ ) {
    var slides,
        timerId,
        amount,
        indexOfcurrent,
        indexOfstart,
        indexOfpenult,
        i, l, k;

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
        }, 3000);
    }

    function initializeGallery() {

        slides = $('.sx-photo-gallery-photos__photo-container');

        slides.on('click', function () {
            switchSlide(this);
        });

        amount = slides.length;

        hideSlides();

        if (amount < 8) {
            slides.css({'transition': 'opacity .4s  ease-in-out'});
            for (i = 0; i < 7; i++) {
                slides.eq(i).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
            }
            if (amount < 5) {
                slides.removeClass();
                for (i = 0; i < amount; i++) {
                    slides.eq(i).show().addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + (3 + i) + '');
                }
            }
        } else {
            for (i = 0; i < 7; i++) {
                slides.eq(i).show().addClass('sx-photo-gallery-photos__photo-container--' + i + '');
            }
        }


        if (amount > 1) {
            $('.sx-photo-gallery__controlls-arrow').on('click', function () {
                switchSlide($(this).data('param'));
            }).css({'pointer-events': 'inherit'});

            $('.sx-photo-gallery').on('mousemove', function () {
                clearInterval(timerId);
            });

            $('.sx-photo-gallery').on('mouseleave', function () {
                autoScroll();
            });
        }
    }


    function switchSlide(param) {
        indexOfstart = $('.sx-photo-gallery-photos__photo-container--1').index();
        indexOfpenult = $('.sx-photo-gallery-photos__photo-container--5').index();
        indexOfmain = $('.sx-photo-gallery-photos__photo-container--3').index();
        indexOfcurrent = ($(param).index());
        classOfCurrent = $(param).attr('class');

        if ($(param).is('.sx-photo-gallery-photos__photo-container')) {
            $('.sx-photo-gallery-photos__photo-container--3').removeClass().addClass(classOfCurrent);
            slides.eq(indexOfcurrent).removeClass()
                .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--3');
        } else if (param === 'right' && amount > 4) {
            slides.removeClass();

            for (i = 0; i < 7; i++) {
                l = 0;
                k = 0;

                slides.eq(indexOfstart + i).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                if (indexOfstart === (amount - (7 - i))) {
                    for (k = (7 - i); k < 7; k++) {
                        slides.eq(l).show()
                            .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + k + '');
                        l += 1;
                    }
                }
            }

            hideSlides();

        } else if (param === 'left' && amount > 4) {
            k = 0;
            slides.removeClass();

            for (i = 6; i >= 0; i--) {
                slides.eq(indexOfpenult - k).show()
                    .addClass('sx-photo-gallery-photos__photo-container sx-photo-gallery-photos__photo-container--' + i + '');
                k += 1;
            }
            hideSlides();
        }
    }

    initializeGallery();
    autoScroll();
}

SXgallery( jQuery );