/**
 * ===========================================================================
 *  Custom widget handler class
 *  @widget Animating Content Slider
 * ===========================================================================
 */

class CodeHighlightHandler extends elementorModules.frontend.handlers.Base {
  /**
   * Specifying the jQuery selectors of the HTML elements
   *
   * Runs when the widget is loaded
   */
  getDefaultSettings() {
    return {
      selectors: {
        copyTarget: '.js-clipboard-copy',
        labelText: '.js-clipboard-copy .label',
        codeBlock: 'pre',
      },
    };
  }

  selectElements() {
    this.codeBlock = this.$element.find(this.selectors.codeBlock);
    this.copyButton = this.$element.find(this.selectors.labelText);
  }

  /**
   * On Element Change
   *
   * Runs every time a control value is changed by the user in the editor.
   *
   * @param {string} propertyName - The ID of the control that was changed.
   */

  onElementChange(propertyName) {}

  /**
   * On Init
   *
   * Runs when the widget is loaded and initialized in the frontend.
   */
  onInit() {
    this.selectors = this.getSettings('selectors');
    this.timeoutId = null; // Tracking the id to prevent glitches while spam-clicking

    this.selectElements();
    this.highlightText();
    this.setupEventListeners();
  }

  /**
   * Event Listeners
   */
  setupEventListeners() {
    this.$element.find(this.selectors.copyTarget).on('click', (event) => {
      event.preventDefault();

      this.copyToClipboard();
    });
  }

  /**
   * For highlighting the syntax in the pre tag.
   */
  highlightText() {
    hljs.highlightElement(this.codeBlock[0]);
  }

  /**
   *
   */
  copyToClipboard() {
    // Find the first <pre> element using your selector
    const textToCopyElement = this.$element.find(this.selectors.codeBlock)[0];

    // Extract the text content from the <pre> element
    const textContent = textToCopyElement.textContent;

    // For use in both the clipboard API and fallback functions
    // Show 'Copied' for a few seconds.
    const handleFeedback = () => {
      // Set text only if it's not already 'Copied'
      if (this.copyButton.text() !== 'Copied') {
        this.copyButton.text('Copied');
      }

      if (this.timeoutId) {
        clearTimeout(this.timeoutId);
      }

      this.timeoutId = setTimeout(() => {
        this.copyButton.text('Copy');
        this.timeoutId = null;
      }, 3000);
    };

    // Check if the Clipboard API is available
    if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
      // Use the Clipboard API to copy the text
      navigator.clipboard
        .writeText(textContent)
        .then(() => {
          handleFeedback();
          console.log('Copied using clipboard api');
        })
        .catch((err) => {
          console.error('Failed to copy text: ', err);
        });
    } else {
      // Fallback method using document.execCommand
      const textarea = document.createElement('textarea');
      textarea.value = textContent;
      document.body.appendChild(textarea);
      textarea.select();
      try {
        document.execCommand('copy');
        handleFeedback();
        console.log('Copied using execCommand');
      } catch (err) {
        console.error('Failed to copy text: ', err);
      } finally {
        document.body.removeChild(textarea);
      }
    }
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
    elementorFrontend.elementsHandler.addHandler(CodeHighlightHandler, {
      $element,
    });
  };

  elementorFrontend.hooks.addAction('frontend/element_ready/kinetica-code-highlight.default', addHandler);
});
