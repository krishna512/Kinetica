class TableOfContentsHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specify the jQuery selectors of the HTML elements in the widget
   */
  getDefaultSettings() {
    return {
      selectors: {
        tableOfContents: '#toc-list',
        headings: '.blog-content h2',
        tocItems: '.toc-item',
      },
    };
  }

  /**
   * On initialization
   */
  onInit() {
    this.selectors = this.getDefaultSettings().selectors;
    this.initializations();
    this.populateTocList();
    this.setupIntersectionObserver();
    this.setupEventListeners();
  }

  /**
   * Get all the required elements of the widget
   */
  initializations() {
    this.headings = jQuery(this.selectors.headings);
    this.tocList = jQuery(this.selectors.tableOfContents);
  }

  /**
   * Populate the table of contents on the basis of the blog content headings
   */
  populateTocList() {
    // Clear existing ToC items to avoid duplication
    this.tocList.empty();

    // Populate the table of contents with the headings
    this.headings.each((_, heading) => {
      if (heading.id) {
        // Ensure the heading has an id before adding it to the ToC
        this.tocList.append(`<li class="toc-item"><a href="#${heading.id}">${heading.innerText}</a></li>`);
      }
    });

    this.tocItems = jQuery(this.selectors.tocItems);

    // Add 'active' class to the first TOC item
    if (this.tocItems.length > 0) {
      this.tocItems.first().addClass('active');
    }
  }

  /**
   * Setup the intersection observer for the headings in the blog content.
   * .toArray() is used to convert a jQuery array to a javascript array
   */
  setupIntersectionObserver() {
    const isExtraLargeScreen = window.matchMedia('(min-width: 1600px)').matches;
    const rootMargin = isExtraLargeScreen ? '-100px 0% -70% 0%' : '-50px 0% -60% 0%';

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;

          const index = Array.from(this.headings.toArray()).indexOf(entry.target);

          // Remove the active class from all items except for the intersecting one
          this.tocItems.toArray().forEach((heading, i) => {
            heading.classList.toggle('active', i === index);
          });
        });
      },
      {
        root: null,
        threshold: 0,
        rootMargin,
      }
    );

    this.headings.toArray().forEach((heading) => observer.observe(heading));
  }

  /**
   * Setup the event listeners for the widget
   */
  setupEventListeners() {
    /**
     * For controlling the scroll position manually
     */
    this.tocItems.on('click', (event) => {
      event.preventDefault();

      // Getting the element to scroll to.
      const targetId = event.currentTarget.querySelector('a').getAttribute('href');
      const targetElement = document.querySelector(targetId);

      if (!targetElement) return;

      const OFFSET = 112;
      const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - OFFSET;

      // Animate scrolling
      jQuery('html, body').animate({ scrollTop: targetPosition }, 50);
    });
  }
}

window.addEventListener('elementor/frontend/init', () => {
  const addHandler = ($element) => {
    elementorFrontend.elementsHandler.addHandler(TableOfContentsHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/table-carousel.default', addHandler);
});
