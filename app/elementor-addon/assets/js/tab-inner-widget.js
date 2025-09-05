class TabInnerWidgetHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specify the jQuery selectors of the HTML elements in the widget
   */
  getDefaultSettings() {
    return {
      selectors: {
        primaryTabs: '.primary-tab',
        primaryTabContents: '.primary-tab-contents',
        innerTabs: '.inner-tab',
        desktopImages: '.inner-tab__image--desktop',
        accordions: '.accordion',
      },
    };
  }

  /**
   * On initialization
   */
  onInit() {
    /**
     * @type {JQuery<HTMLElement>}
     */
    this.$element;
    this.selectors = this.getDefaultSettings().selectors;
    this.initializations();
    this.setupEventListeners();
    this.followUpEvents();
  }

  /**
   * Get all the required elements of the widget
   */
  initializations() {
    /**
     * @type {JQuery<HTMLElement>}
     * */
    this.primaryTabs = this.$element.find(this.selectors.primaryTabs);

    /**
     * @type {JQuery<HTMLElement>}
     * */
    this.primaryTabContents = this.$element.find(this.selectors.primaryTabContents);

    /**
     * @type {JQuery<HTMLElement>}
     * */
    this.tabContents = this.$element.find(this.selectors.tabContents);

    /**
     * @type {JQuery<HTMLElement>}
     * */
    this.accordions = this.$element.find(this.selectors.accordions);
  }

  /**
   * Setup the event listeners for the widget
   */
  setupEventListeners() {
    // Event delegation for the primary tabs. Fat arrow notation to preserve this context
    this.$element.on('click', this.selectors.primaryTabs, (event) => {
      const clickedTab = jQuery(event.currentTarget);
      const index = clickedTab.index();

      // Activate current primary tab.
      this.$element.find(this.selectors.primaryTabs).removeClass('active');
      clickedTab.addClass('active');

      // Show the corresponding tab content
      this.$element.find(this.selectors.primaryTabContents).removeClass('active').eq(index).addClass('active');

      // Auto-click the first nested tab. If the non-first tab is active, don't trigger the click.
      const $targetTabContent = this.$element.find(this.selectors.primaryTabContents).eq(index);
      const isNonFirstTabActive =
        $targetTabContent.find(`${this.selectors.innerTabs}.active:not(:first-child)`).length > 0;

      if (!isNonFirstTabActive) {
        $targetTabContent.find(this.selectors.innerTabs).first().trigger('click');
      }
    });

    // Event delegation for the nested tabs
    this.$element.on('click', this.selectors.innerTabs, (event) => {
      const $clickedTab = jQuery(event.currentTarget);
      const $container = $clickedTab.closest(this.selectors.primaryTabContents);
      const $accordions = $container.find(this.selectors.accordions);

      const index = $clickedTab.index();

      // Activate the current nested tab, image and accordion
      $container.find(this.selectors.innerTabs).removeClass('active').eq(index).addClass('active');
      $container.find(this.selectors.desktopImages).removeClass('active').eq(index).addClass('active');
      $accordions.removeClass('active').eq(index).addClass('active');
    });
  }

  /**
   * Follow up events after the initializations
   */
  followUpEvents() {
    /**
     * Set the first primary tab and its first nested tab active by default.
     * If any other inner tabs are active, then don't trigger the click.
     */
    this.primaryTabs.first().trigger('click');
    this.primaryTabContents.find('.inner-tab').first().trigger('click');
  }
}

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(TabInnerWidgetHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/tab-inner-card.default', addHandler);
});
