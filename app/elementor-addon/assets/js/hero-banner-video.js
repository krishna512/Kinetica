/**
 * ===========================================================================
 *  Custom widget handler class
 *  @widget Animating Content Slider
 * ===========================================================================
 */

class HeroSliderVideoHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specifying the jQuery selectors of the HTML elements
   *
   * Runs when the widget is loaded
   */
  getDefaultSettings() {
    return {
      selectors: {
        titleCarousel: '.kinetica__content--titleswiper',
        contentCarousel: '.kinetica__content--swiper',
        codeCarousel: '.kinetica__code--swiper',
        pagination: '.kinetica__content--pagination',
        next: '.kinetica__content--next',
        prev: '.kinetica__content--previous',
        tutorialLink: '.kinetica__code--tutorial-link',
        watchVideo: '.kinetica__video--playbtn',
        videoThumb: '.kinetica__video--thumbnail',
        videoPlayerWrapper: '.kinetica__video--player',
        videoPlayer: '.kinetica__video--controls',
        videoSource: '.kinetica__video--controls source',
        closeButton: '.kinetica__video--close',
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
    this.animationSpeed = this.getElementSettings('animation_speed');

    // Title swiper
    const options = {
        speed: this.animationSpeed.size * 1000,
        autoplay: {
          delay: this.progressDuration.size * 1000,
          disableOnInteraction: false,
        },
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
    });

    // Content carousel
    const swiper2 = `${currentWidget} ${this.selectors.contentCarousel}`;

    this.contentSwiper = new Swiper(swiper2, {
      ...options,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: false,
      pagination: {
        el: `${currentWidget} ${this.selectors.pagination}`,
      },
    });

    // sync two carousel
    this.textSwiper.controller.control = [this.contentSwiper];
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
    const videoWrapper = this.$element.find(this.selectors.videoPlayerWrapper),
      videoControl = this.$element.find(this.selectors.videoPlayer),
      videoThumb = this.$element.find(this.selectors.videoThumb),
      videoDomElement = videoControl.get(0),
      videoSource = this.$element.find(this.selectors.videoSource);

    // Check if the videoSource has a non-null source
    const isVideoPresent = Boolean(videoSource.attr('src'));

    // next slider
    this.$element.find(this.selectors.next).on('click', (event) => this.textSwiper.slideNext());

    // prev slider
    this.$element.find(this.selectors.prev).on('click', (event) => this.textSwiper.slidePrev());

    // play video
    this.$element.find(this.selectors.videoThumb).on('click', (event) => {
      event.preventDefault();

      if (!isVideoPresent) {
        console.log('Video is not present');
        return;
      }

      // const clickedButton = jQuery(event.currentTarget);

      if (videoControl.length) {
        videoThumb.hide();

        if (videoDomElement && typeof videoDomElement.play === 'function') {
          videoWrapper.show();
          videoDomElement.play();

          // Show banner again after video finishes playing
          // if (!videoDomElement._endedEventAdded) {
          //   videoDomElement.addEventListener('ended', () => {
          //     videoThumb.show();
          //     videoWrapper.hide();
          //   });
          //   videoDomElement._endedEventAdded = true;
          // }
        } else {
          console.error('Selected element is not a video element or play() is not a function.');
        }
      } else {
        console.error('Video element not found.');
      }
    });

    // close video
    this.$element.find(this.selectors.closeButton).on('click', (event) => {
      event.preventDefault();

      videoThumb.show();
      videoWrapper.hide();

      videoDomElement.pause();
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
    elementorFrontend.elementsHandler.addHandler(HeroSliderVideoHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/hero-slider-video.default', addHandler);
});
