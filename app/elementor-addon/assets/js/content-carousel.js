/**
 * ===========================================================================
 *  Custom widget handler class
 *  @widget Animating Content Slider
 * ===========================================================================
 */

class ContentCarouselHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specifying the jQuery selectors of the HTML elements
   *
   * Runs when the widget is loaded
   */
  getDefaultSettings() {
    return {
      selectors: {
        carouselContainer: '.content-carousel',
        swiper: '.swiper',
      },
    };
  }

  selectElements() {
    this.carouselContainer = this.$element.find(this.selectors.carouselContainer);
  }

  /**
   * On Init
   *
   * Runs when the widget is loaded and initialized in the frontend.
   */
  onInit() {
    this.selectors = this.getDefaultSettings().selectors;
    this.selectElements();
    this.initialiseSwiper();
  }

  initialiseSwiper() {
    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;

    this.swiper = new Swiper(this.selectors.swiper, {
      spaceBetween: 2,
      pagination: {
        el: isDesktop ? '.swiper-pagination--desktop' : '.swiper-pagination--mobile',
        type: 'bullets',
      },
      navigation: {
        prevEl: '.navigation-prev',
        nextEl: '.navigation-next',
      },
    });
  }
}

/**
 * =========================================================================
 * Register JS Handler for the Widget
 *
 * When Elementor frontend was initiated, and the widget is ready, register
 * the widget JS handler.
 * =========================================================================
 */

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(ContentCarouselHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/content-carousel.default', addHandler);
});
