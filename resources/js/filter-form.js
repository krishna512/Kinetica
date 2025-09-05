jQuery(function ($) {
  class RealtimeFilter {
    /**
     * ========================================================
     * Constructor to initialize
     * ========================================================
     */
    constructor() {
      // access selectors
      this.selectors = this.getSettings('selectors');

      // add event listener
      this.setupEventListeners();
    }

    /**
     * ========================================================
     * Specifying the jQuery selectors of the HTML elements
     * ========================================================
     */
    getDefaultSettings() {
      return {
        selectors: {
          submissionForm: 'form.yi-filter-form',
          textFilter: '.yi-text-input',
          radioFilter: '.yi-input-radio',
          selectFilter: '.yi-input-select',
          pagination: '.ajax-filter .elementor-pagination a',
          filter: '.ajax-filter',
        },
      };
    }

    /**
     * ========================================================
     * Specifying the jQuery selectors of the HTML elements
     * ========================================================
     */
    getSettings(key) {
      const object = this.getDefaultSettings();
      return object[key];
    }

    /**
     * ================================================================
     * Debounce Function
     * @param {*} func
     * @param {*} delay
     * @returns
     * ================================================================
     */
    debounce(func, delay) {
      let timerId;
      return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timerId);
        timerId = setTimeout(() => {
          func.apply(context, args);
        }, delay);
      };
    }

    /**
     * ========================================================
     * create an HTTP request object
     * ========================================================
     */
    makeHttpObject() {
      if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest(); // Modern browsers
      } else if (typeof ActiveXObject !== 'undefined') {
        // For older versions of Internet Explorer
        try {
          return new ActiveXObject('Msxml2.XMLHTTP');
        } catch (error) {
          try {
            return new ActiveXObject('Microsoft.XMLHTTP');
          } catch (error) {
            throw new Error('Could not create HTTP request object.');
          }
        }
      } else {
        throw new Error('XMLHttpRequest is not supported by this browser.');
      }
    }

    /**
     * ========================================================
     * Adding Event Listeners
     * ========================================================
     */
    setupEventListeners() {
      const debouncedInputHandler = this.debounce(this.submitForm.bind(this), 1000);

      // Use event delegation for input events
      $(document).on('input', this.selectors.textFilter, debouncedInputHandler);

      // Use event delegation for ajax form submission
      $(document).on('submit', this.selectors.submissionForm, this.formSubmission.bind(this));

      // Use event delegation for ajax pagination
      $(document).on('click', this.selectors.pagination, this.pagination.bind(this));

      // Use event delegation for radio button
      $(document).on('change', this.selectors.radioFilter, this.submitForm.bind(this));

      // use event delegation for select field
      $(document).on('change', this.selectors.selectFilter, this.submitForm.bind(this));
    }

    /**
     * ================================================================
     * Trigger form submit on any field value change
     * @param {*} event
     * ================================================================
     */

    submitForm(event) {
      $(event.target).closest('form.yi-filter-form').trigger('submit');
    }

    /**
     * ================================================================
     * Ajax pagination
     * @param {*} event
     * ================================================================
     */
    pagination(event) {
      // Prevent redirection behavior
      event.preventDefault();

      // getting required data
      const link = $(event.target).attr('href'),
        contentWrapper = $(event.target).closest('.ajax-filter'),
        dataID = '[data-id="' + contentWrapper.data('id') + '"]';

      // request for data
      this.getHTMLData(link, dataID);
    }

    /**
     * ================================================================
     * Ajax Form Submission
     *
     * Generates the URL with parameters and sends requests
     * @param {*} event
     * ================================================================
     */

    formSubmission(event) {
      // Prevent default form submission behavior
      event.preventDefault();

      // getting required data
      const target = $(event.target),
        data = target.serialize(),
        submissionLink = target.data('url') + '/?' + data,
        dataID = '[data-id="' + target.closest('.ajax-filter').data('id') + '"]';

      // request for data
      this.getHTMLData(submissionLink, dataID);
    }

    /**
     * ================================================================
     * Get Results from request
     * @param {*} link
     * @param {*} id
     * ================================================================
     */
    getHTMLData(link, HTML_ID) {
      // Dim the target element on request initialization
      $(HTML_ID).css('opacity', '0.6').css('pointer-events', 'none');

      // Create an HTTP request object
      var request = this.makeHttpObject();

      // Open a POST request to the specified link
      request.open('POST', link, true);

      // Send the request
      request.send(null);

      // Define the callback function to handle the response
      request.onreadystatechange = function () {
        // The operation is complete
        if (request.readyState == 4) {
          // Check if the request was successful
          if (request.status == 200) {
            // Create jQuery object from the received HTML content
            const htmlDoc = $(request.responseText);

            // Find the required HTML content within the received HTML
            const html = htmlDoc.find(HTML_ID).html();

            // Update the target element with the received HTML content
            $(HTML_ID).html(html);

            // Scroll to the top of the filtered content
            const $htmlElement = $(HTML_ID);
            if ($htmlElement.length > 0) {
              $('html, body').animate(
                {
                  scrollTop: $(HTML_ID).offset().top - 100,
                },
                1000
              );
            }

            // Change route in the browser
            window.history.pushState({}, '', link);

            // Restore opacity of the target element
            $(HTML_ID).css('opacity', '1').css('pointer-events', 'auto');
          } else {
            // Handle errors if any
            alert('Error fetching data:', request.status);
            $(HTML_ID).css('opacity', '1').css('pointer-events', 'auto');
          }
        }
      };
    }
  }

  const formFilter = new RealtimeFilter();
});
