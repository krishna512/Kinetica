class TabWidgetHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specify the jQuery selectors of the HTML elements in the widget
   */
  getDefaultSettings() {
    return {
      selectors: {
        tabs: '.tab',
        tabContents: '.tab__animation.desktop',
        accordions: '.accordion',
      },
    };
  }

  /**
   * On initialization
   */
  onInit() {
    this.selectors = this.getDefaultSettings().selectors;
    this.initializations();
    this.setupEventListeners();
    this.followUpEvents();
  }

  /**
   * Get all the required elements of the widget
   */
  initializations() {
    this.tabs = this.$element.find(this.selectors.tabs);
    this.accordions = this.$element.find(this.selectors.accordions);
    this.tabContents = this.$element.find(this.selectors.tabContents);
  }

  /**
   * Setup the event listeners for the widget
   */
  setupEventListeners() {
    this.tabs.on('click', (event) => {
      /**
       * Get the clicked tab and its corresponding accordion
       */
      const clickedTab = jQuery(event.currentTarget);
      const accordion = clickedTab.find('.accordion');

      /**
       * On smaller screens, if the user clicks an active tab, remove the active class from both the
       * tab and its corresponding accordion.
       * On larger screens, there is no effect on clicking the active tab
       */
      const isMobileAndActive = window.matchMedia('(max-width: 767px)').matches && clickedTab.hasClass('active');

      // Regardless, remove the active class from the other tabs and accordions.
      this.tabs.removeClass('active');
      this.accordions.removeClass('active');

      if (isMobileAndActive) {
        clickedTab.removeClass('active');
        accordion.removeClass('active');
      } else {
        clickedTab.addClass('active');
        accordion.addClass('active');
      }

      /**
       * Add active class to the image contents of the corresponding tab, remove from the rest
       */
      const index = clickedTab.index();
      this.tabContents.removeClass('active');
      this.tabContents.eq(index).addClass('active');
    });
  }

  /**
   * Follow up events after the initializations
   */
  followUpEvents() {
    /**
     * Set the first tab active by default.
     */
    this.tabs.first().click();
  }
}

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(TabWidgetHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/tab-card.default', addHandler);
});
