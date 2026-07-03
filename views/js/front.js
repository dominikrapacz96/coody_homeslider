/**
 * Coody Home Slider — karuzela + dolny pasek z tytułami.
 */
$(function () {
  var $section = $('.coody-homeslider');
  var $slider = $section.find('#sliderHome');

  if (!$slider.length) {
    return;
  }

  var speed = parseInt($slider.data('coody-speed'), 10) || 5000;
  var $titleItems = $section.find('.coody-homeslider__title-item');
  var slideCount = $titleItems.length || $slider.children().length;
  var mobileQuery = window.matchMedia('(max-width: 767px)');
  var widePeekQuery = window.matchMedia('(min-width: 1921px)');
  var hasMultipleSlides = slideCount > 1;
  var centerSlideMaxWidth = 1920;
  var resizeTimer = null;
  var isSyncingLayout = false;

  function isPeekMode() {
    return mobileQuery.matches || widePeekQuery.matches;
  }

  function getWideStagePadding() {
    return Math.max(0, Math.round((window.innerWidth - centerSlideMaxWidth) / 2));
  }

  function updateWidePeekClass() {
    $section.toggleClass('coody-homeslider--wide-peek', widePeekQuery.matches && hasMultipleSlides);
  }

  function getLayoutSettings() {
    if (mobileQuery.matches) {
      return {
        center: true,
        stagePadding: 40,
        margin: 10,
        loop: hasMultipleSlides,
      };
    }

    if (widePeekQuery.matches && hasMultipleSlides) {
      return {
        center: true,
        stagePadding: getWideStagePadding(),
        margin: 16,
        loop: true,
      };
    }

    return {
      center: false,
      stagePadding: 0,
      margin: 0,
      loop: hasMultipleSlides,
    };
  }

  function eagerLoadSlideImages() {
    $slider.find('img.owl-lazy').each(function () {
      var $img = $(this);

      if ($img.closest('picture').length) {
        var $source = $img.closest('picture').find('source[media*="767px"]');
        var mobileSrc = $source.attr('srcset');

        if (mobileSrc && mobileQuery.matches) {
          $img.attr('src', mobileSrc);
        } else {
          var desktopSrc = $img.attr('data-src');

          if (desktopSrc) {
            $img.attr('src', desktopSrc);
          }
        }

        $img.removeClass('owl-lazy');
        return;
      }

      var src = $img.attr('data-src');

      if (src) {
        $img.attr('src', src).removeClass('owl-lazy');
      }
    });
  }

  function whenSlideImagesReady() {
    var promises = $slider.find('figure img').map(function () {
      var img = this;

      if (img.complete) {
        return $.Deferred().resolve().promise();
      }

      return $.Deferred(function (deferred) {
        $(img).one('load error', deferred.resolve);
      }).promise();
    }).get();

    return promises.length ? $.when.apply($, promises) : $.Deferred().resolve().promise();
  }

  function settlePeekCarouselPosition() {
    if (!isPeekMode()) {
      return;
    }

    var owl = $slider.data('owl.carousel');

    if (!owl) {
      return;
    }

    var current = owl.relative(owl.current());

    owl.to(current, 0, true);
    $slider.trigger('next.owl.carousel', [0]);
    $slider.trigger('prev.owl.carousel', [0]);
    owl.to(current, 0, true);
  }

  function syncCarouselLayout(repositionPeek) {
    var owl = $slider.data('owl.carousel');

    if (!owl || isSyncingLayout) {
      return;
    }

    isSyncingLayout = true;

    var layout = getLayoutSettings();
    var widePadding = getWideStagePadding();

    updateWidePeekClass();

    if (owl.options.responsive) {
      if (owl.options.responsive[0]) {
        $.extend(owl.options.responsive[0], {
          center: true,
          stagePadding: 40,
          margin: 10,
          loop: hasMultipleSlides,
        });
      }

      if (owl.options.responsive[768]) {
        $.extend(owl.options.responsive[768], {
          center: false,
          stagePadding: 0,
          margin: 0,
          loop: hasMultipleSlides,
        });
      }

      if (owl.options.responsive[1921]) {
        $.extend(owl.options.responsive[1921], {
          center: true,
          stagePadding: widePadding,
          margin: 16,
          loop: hasMultipleSlides,
        });
      }
    }

    $.extend(owl.settings, layout);

    if (typeof owl.invalidate === 'function') {
      owl.invalidate('width');
    }

    $slider.trigger('refresh.owl.carousel');

    if (repositionPeek && isPeekMode()) {
      settlePeekCarouselPosition();
      $slider.trigger('refresh.owl.carousel');
    }

    isSyncingLayout = false;
  }

  function setActiveTitle(index) {
    $titleItems
      .removeClass('is-active')
      .attr('aria-selected', 'false')
      .filter('[data-slide="' + index + '"]')
      .addClass('is-active')
      .attr('aria-selected', 'true');
  }

  function initCarousel() {
    $slider.owlCarousel({
      loop: hasMultipleSlides,
      nav: false,
      lazyLoad: !isPeekMode(),
      autoplay: hasMultipleSlides,
      autoplayTimeout: speed,
      autoplayHoverPause: true,
      dots: false,
      items: 1,
      smartSpeed: 450,
      center: false,
      stagePadding: 0,
      startPosition: 0,
      responsive: {
        0: {
          center: true,
          stagePadding: 40,
          margin: 10,
          loop: hasMultipleSlides,
        },
        768: {
          center: false,
          stagePadding: 0,
          margin: 0,
          loop: hasMultipleSlides,
        },
        1921: {
          center: true,
          stagePadding: getWideStagePadding(),
          margin: 16,
          loop: hasMultipleSlides,
        },
      },
    });
  }

  function bootCarousel() {
    updateWidePeekClass();
    initCarousel();
  }

  function scheduleLayoutSync(repositionPeek) {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      syncCarouselLayout(repositionPeek);
    }, 100);
  }

  $slider.on('initialized.owl.carousel changed.owl.carousel', function (e) {
    if (!e.namespace) {
      return;
    }

    var carousel = e.relatedTarget;
    setActiveTitle(carousel.relative(carousel.current()));
  });

  $slider.on('initialized.owl.carousel', function () {
    syncCarouselLayout(true);
    setTimeout(function () {
      syncCarouselLayout(true);
    }, 100);
  });

  $slider.on('resized.owl.carousel', function () {
    if (widePeekQuery.matches && hasMultipleSlides) {
      scheduleLayoutSync(false);
    }
  });

  $(window).on('load', function () {
    if (isPeekMode()) {
      eagerLoadSlideImages();
    }

    syncCarouselLayout(true);
  });

  $(window).on('resize', function () {
    scheduleLayoutSync(true);
  });

  if (typeof mobileQuery.addEventListener === 'function') {
    mobileQuery.addEventListener('change', function () {
      scheduleLayoutSync(true);
    });
    widePeekQuery.addEventListener('change', function () {
      scheduleLayoutSync(true);
    });
  }

  $section.find('.coody-homeslider__nav-btn--prev').on('click', function () {
    $slider.trigger('prev.owl.carousel');
  });

  $section.find('.coody-homeslider__nav-btn--next').on('click', function () {
    $slider.trigger('next.owl.carousel');
  });

  $titleItems.on('click', function () {
    var index = parseInt($(this).data('slide'), 10);

    if (!isNaN(index)) {
      $slider.trigger('to.owl.carousel', [index, 300, true]);
    }
  });

  if (isPeekMode()) {
    eagerLoadSlideImages();
    whenSlideImagesReady().always(bootCarousel);
  } else {
    bootCarousel();
  }
});
