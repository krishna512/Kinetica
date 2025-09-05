class TestimonialCarouselHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specify the jQuery selectors of the HTML elements in the widget
   */
  getDefaultSettings() {
    return {
      selectors: {
        swiper: '.swiper',
        paginationPrev: '.prev-btn',
        paginationNext: '.next-btn',
        popUpTriggers: '.popup-trigger',
        videoModals: '.video-modal',
        videoOverlays: '.video-modal__overlay',
        testimonialArrows: '.carousel-arrows',
      },
    };
  }

  onInit() {
    this.selectors = this.getDefaultSettings().selectors;
    this.initializations();
    this.setupEventListeners();
  }

  initializations() {
    this.popUpTriggers = this.$element.find(this.selectors.popUpTriggers);
    this.videoModals = this.$element.find(this.selectors.videoModals);
    this.videoOverlays = this.$element.find(this.selectors.videoOverlays);
    this.carouselArrows = this.$element.find(this.selectors.testimonialArrows);

    const isDesktop = window.matchMedia('(min-width: 768px)').matches;

    this.swiper = new Swiper(this.selectors.swiper, {
      speed: 350,
      spaceBetween: 0,
      slidesPerView: 1,
      navigation: {
        prevEl: this.selectors.paginationPrev,
        nextEl: this.selectors.paginationNext,
      },
      on: {
        /**
         * For hiding the arrows during transition on desktop
         */
        slideChangeTransitionStart: () => {
          if (isDesktop) {
            this.carouselArrows.addClass('invisible');
          }
        },
        slideChangeTransitionEnd: () => {
          if (isDesktop) {
            this.carouselArrows.removeClass('invisible');
          }
        },
      },
    });
  }

  setupEventListeners() {
    /**
     * For opening the video modal when the text below the portrait photo is clicked.
     * Only triggers if there is a video linked with the slide.
     */
    this.popUpTriggers.on('click', (event) => {
      const clickedElement = jQuery(event.currentTarget);
      const youtubeId = clickedElement.attr('data-youtube-id');

      if (!youtubeId) {
        return;
      }

      /**
       * Find the video modal with the given id and open it.
       * For optimisations purposes, iframe is named as frame_video, so we have to replace the inner HTML
       */
      const videoModal = this.videoModals.filter(`[data-youtube-id="${youtubeId}"]`);
      const videoOverlay = videoModal.find('.video-modal__overlay');
      const iFrame = videoModal.find('.inner-iframe');

      if (iFrame.length) {
        iFrame.replaceWith(function () {
          return this.outerHTML.replace(/frame_video/g, 'iframe');
        });
      }
      videoModal.addClass('open');
      videoOverlay.addClass('open');
    });

    /**
     * For closing the video modal when the corresponding overlay is clicked.
     * Also stops the video.
     */
    this.videoOverlays.on('click', (event) => {
      this.videoModals.removeClass('open');
      this.videoOverlays.removeClass('open');

      // For stopping the video when closing the modal.
      const clickedElement = jQuery(event.currentTarget);
      const iFrame = clickedElement.find('.inner-iframe');

      /**
       * To ensure that the video playback is stopped when closing the modal, the source to the
       * iframe is removed and then added again.
       */
      const videoSource = iFrame.attr('src');

      setTimeout(() => {
        iFrame.attr('src', '');
        iFrame.attr('src', videoSource);
      }, 400);
    });
  }
}

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(TestimonialCarouselHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/testimonial-card.default', addHandler);
});
