class LogoListHandler extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        parentContainer: '.logo-list-container',
        logoContainer: '.logo-list',
        text: '.description',
        logos: '.logo',
        slick: '.logo-list-container .js-logo-carousel',
      },
    };
  }

  onInit() {
    this.selectors = this.getSettings().selectors;
    this.initialisations();
    this.createElements();
    this.setupEventListeners();
  }

  /**
   * Get all the required elements of the widget
   */
  initialisations() {
    /**
     * Selecting just the logo container will select the container which doesn't including padding.
     * Hence we need to use .closest() to get the element with the logo-list-container class,
     * as it takes up the full width of the screen and includes vertical padding too.
     */
    this.parentContainer = this.$element.find(this.selectors.parentContainer);
    this.logoList = this.$element.find(this.selectors.logoContainer);
    this.logoContainer = this.$element.find(this.selectors.logoContainer).closest('.logo-list-container');
    this.text = this.$element.find(this.selectors.text);
    this.logos = this.$element.find(this.selectors.logos);

    if (this.isCarouselRequired()) {
      this.initialiseCarousel();
    }
  }

  /**
   * Function to check whether to initialize the carousel or not.
   * Returns true if the total width of the logos + gaps is greater than the width of the container.
   */
  isCarouselRequired() {
    const logoArray = this.logos.toArray();
    // 60 to take into consideration the gaps
    const totalWidth = logoArray.reduce((acc, logo) => acc + logo.offsetWidth + 60, 0);

    if (totalWidth > this.logoContainer.width()) {
      return true;
    }

    this.logoList.addClass('centre-logos');
    return false;
  }

  initialiseCarousel() {
    const BASE_SPEED = 100;

    const logoSlider = jQuery(this.selectors.slick);
    logoSlider.slick({
      dots: false,
      infinite: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 1,
      speed: BASE_SPEED,
      pauseOnHover: false,
      variableWidth: true,
      cssEase: 'linear',
    });

    // Calculating the transition duration for individual slides
    logoSlider.on('beforeChange', (event, slick, currentSlide, nextSlide) => {
      const currentSlideWidth = jQuery(slick.$slides[nextSlide]).outerWidth();
      const duration = currentSlideWidth * BASE_SPEED;
      slick.slickSetOption('speed', duration, true);
    });
  }

  /**
   * Create elements for the text overlay and blur effects
   */
  createElements() {
    /**
     * Create an element which overlays on top of the logo list, which contains the text and has
     * a gradual blur.
     */
    const overlay = document.createElement('div');
    overlay.classList.add('logo-overlay');

    this.logoContainer.append(overlay);

    // Store the overlay elements.
    this.overlay = jQuery(overlay);

    // Add the text to the overlay element
    jQuery(overlay).text(this.text.text());
  }

  setupEventListeners() {
    /**
     * Show and hide the overlay and blur elements on hover. Skip on mobile
     */
    const isSmallScreen = window.matchMedia('(max-width: 1023px)').matches;

    this.logoContainer.on('mouseenter', () => {
      if (isSmallScreen) {
        return;
      }

      this.overlay.addClass('active');
      this.logoList.addClass('active');
      this.logos.addClass('active');
    });

    this.logoContainer.on('mouseleave', () => {
      if (isSmallScreen) {
        return;
      }
      this.overlay.removeClass('active');
      this.logoList.removeClass('active');
      this.logos.removeClass('active');
    });
  }
}

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(LogoListHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/logos.default', addHandler);
});
