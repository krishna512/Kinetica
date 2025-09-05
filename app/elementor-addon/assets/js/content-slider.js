/**
 * ===========================================================================
 *  Custom widget handler class
 *  @widget Animating Content Slider
 * ===========================================================================
 */

class ContentSliderHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specifying the jQuery selectors of the HTML elements
   *
   * Runs when the widget is loaded
   */
  getDefaultSettings() {
    return {
      selectors: {
        progressBar: '.bar',
        playPause: '.play-btn',
        playBtn: '.play-icon',
        pauseBtn: '.pause-icon',
        titleCarousel: '.text-swiper',
        contentCarousel: '.content-swiper',
        codeCarousel: '.code-swiper',
        jumpTo: '.jumpTo',
        space: '.empty-space',
        select: '.custom-select',
        tutorialLink: '.tutorial-link',
      },
    };
  }

  /**
   * On Element Change
   *
   * Runs every time a control value is changed by the user in the editor.
   *
   * @param {string} propertyName - The ID of the control that was changed.
   */

  onElementChange(propertyName) {
    // custom code here
  }

  /**
   * On Init
   *
   * Runs when the widget is loaded and initialized in the frontend.
   */
  onInit() {
    this.selectors = this.getSettings('selectors');

    this.playing = true;

    // slider initialization
    this.initializations();
    this.setupEventListeners();
  }

  /**
   * Initializations
   */
  initializations() {
    const that = this;
    this.progressDuration = this.getElementSettings('progress_speed');
    this.reverseDuration = this.getElementSettings('animation_speed');

    // gsap timeline initialization
    this.timeline = gsap.timeline({
      onComplete: this.reverseAnimation.bind(this),
      onReverseComplete: this.restartAnimation.bind(this),
    });

    // Title swiper
    const options = {
        autoplay: false,
        speed: this.reverseDuration * 1000,
        spaceBetween: 30,
        slidesPerView: 1,
        loop: true,
        noSwiping: true,
        noSwipingClass: 'swiper-no-swiping',
        allowTouchMove: false,
      },
      currentWidget = `div[data-id="${this.getID()}"]`,
      swiper1 = `${currentWidget} ${this.selectors.titleCarousel}`;

    this.textSwiper = new Swiper(swiper1, {
      ...options,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      on: {
        slideChangeTransitionEnd: function () {
          // Manually trigger slideChangeTransitionEnd for contentSwiper and codeSwiper
          this.codeSwiper.emit('slideChangeTransitionEnd');
        }.bind(this),
      },
    });

    // Content carousel
    const swiper2 = `${currentWidget} ${this.selectors.contentCarousel}`;

    this.contentSwiper = new Swiper(swiper2, {
      ...options,
      effect: 'creative',
      creativeEffect: {
        prev: {
          shadow: true,
          translate: [0, '-100px', -50],
          opacity: 0,
        },
        next: {
          translate: [0, '100px', 50],
          opacity: 0,
        },
      },
    });

    // Code carousel
    const swiper3 = `${currentWidget} ${this.selectors.codeCarousel}`;

    this.codeSwiper = new Swiper(swiper3, {
      ...options,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      // autoHeight: true,
      on: {
        slideChangeTransitionEnd: function () {
          this.handleSlideChangeTransitionEnd(this.codeSwiper);
        }.bind(this),
      },
    });

    // sync three carousel
    this.textSwiper.controller.control = [this.contentSwiper, this.codeSwiper];

    // this.textSwiper.on('slideChange', () => {
    //   this.setWidthSelect();
    // });

    // starting gsap animation
    this.startAnimation();
    // this.setWidthSelect();
  }

  /**
   * Common slide change handler
   */

  handleSlideChangeTransitionEnd(swiperInstance) {
    let currentLink = '';

    const currentSlide = swiperInstance.slides[swiperInstance.activeIndex],
      currentLinkHTML = currentSlide.querySelector('.link');

    if (currentLinkHTML) {
      currentLink = currentLinkHTML.getAttribute('data-link');
    }
    // console.log('here', currentLink);

    const anchor = this.$element.find(this.selectors.tutorialLink).find('a');

    if (currentLink) {
      anchor.attr('href', currentLink);
    } else {
      anchor.removeAttr('href');
    }
  }

  /**
   * Event Listeners
   */
  setupEventListeners() {
    // toggle play pause slider
    this.$element.find(this.selectors.playPause).on('click', (event) => this.togglePlayPause(event));

    // jump to specific slides
    this.$element.find(this.selectors.jumpTo).on('click', (event) => {
      event.preventDefault();

      const ind = jQuery(event.currentTarget).data('number');

      this.textSwiper.slideToLoop(ind, 1000);

      this.reverseAnimation();

      // fix for play/pause icon
      this.$element.find(this.selectors.playBtn).hide();
      this.$element.find(this.selectors.pauseBtn).show();

      this.playing = true;

      this.togglePlayPause(event);
    });

    // toggle dropdown

    this.$element.find(this.selectors.select).on('click', (event) => {
      event.stopPropagation();
      jQuery(event.currentTarget).find('.dropdown').slideToggle();
      this.togglePlayPause(event);
    });

    // close the dropdown when clicked outside
    jQuery('body').on('click', (event) => {
      let toggleTarget = jQuery(event.currentTarget).find('.dropdown');
      if (toggleTarget.is(':visible')) {
        toggleTarget.slideUp();
        this.togglePlayPause(event);
      }
    });
  }

  /**
   * Start animation
   */
  startAnimation() {
    const $progressHtml = this.$element.find(this.selectors.progressBar);

    this.timeline.to($progressHtml, {
      duration: this.progressDuration,
      delay: 0.5,
      value: 100,
      ease: Power1.out,
    });
  }

  /**
   * Reverse animation
   * @trigger start backward animation with different speed
   */
  reverseAnimation() {
    this.timeline.reverse();

    this.timeline.duration(this.reverseDuration);

    this.textSwiper.slideNext();
  }

  /**
   * Re-start animation
   * @trigger restart's progress animation from start
   */
  restartAnimation() {
    this.timeline.play();

    this.timeline.duration(this.progressDuration);
  }

  /**
   * Toggle play/pause animation
   * @param {*} event
   */
  togglePlayPause(event) {
    event.preventDefault();

    // play/pause animation
    this.timeline.paused(!this.timeline.paused());

    // hide show playpause icon
    this.playing = !this.playing;

    if (!this.playing) {
      this.$element.find(this.selectors.playBtn).show();
      this.$element.find(this.selectors.pauseBtn).hide();
    } else {
      this.$element.find(this.selectors.playBtn).hide();
      this.$element.find(this.selectors.pauseBtn).show();
    }
  }

  /**
   * Set width of custom .custom_select same as H1 tag
   */
  setWidthSelect() {
    // Get the active slide element
    const activeSlide = this.textSwiper.slides[this.textSwiper.activeIndex],
      spaceElement = this.$element.find(this.selectors.space);

    // Get the width of the h1 of active slide
    const width = activeSlide.querySelector('h1').offsetWidth;

    // Get the height of the h1 of active slide
    const height = activeSlide.querySelector('h1').offsetHeight;

    spaceElement.css('transition', `width ${this.reverseDuration}s ease`);

    spaceElement.width(width);
    spaceElement.height(height);
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
    elementorFrontend.elementsHandler.addHandler(ContentSliderHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/content-slider.default', addHandler);
});
