const { OverlayScrollbars } = OverlayScrollbarsGlobal;

document.addEventListener('DOMContentLoaded', function () {
  OverlayScrollbars(document.body, {
    overflow: {
      x: 'hidden',
    },
    scrollbars: {
      autoHide: 'move',
    },
  });

  jQuery('.custom-scroll-bar').each(function () {
    OverlayScrollbars(this, {
      overflow: {
        x: 'hidden',
      },
      scrollbars: {
        autoHide: 'leave',
        autoHideDelay: 400,
      },
    });
  });

  jQuery('.source-shell').each(function () {
    OverlayScrollbars(this, {
      overflow: {
        y: 'hidden',
      },
    });
  });
});

/*!
 * Custom js scripts
 */
jQuery(function ($) {
  /**
   * ===============================================
   * Glider JS Initialization
   * ===============================================
   */
  if ($('.custom-swiper').length > 0) {
    const glider = new Glider(document.querySelector('.custom-swiper'), {
      slidesToShow: 'auto',
      slidesToScroll: 1,
      itemWidth: 268,
      exactWidth: 268,
      draggable: true,
      scrollLock: true,
      dots: '.carousel-dash',
      responsive: [
        {
          breakpoint: 1921,
          settings: {
            itemWidth: 500,
            exactWidth: 500,
          },
        },
      ],
    });
  }

  /**
   * ===============================================
   * Table OF Content
   * ===============================================
   */
  const TOC = '.elementor-toc__body';

  if ($(TOC).length > 0) {
    $(TOC).on('click', 'a', function (e) {
      e.preventDefault();

      // get hash url
      const target = this.hash,
        $target = $(target),
        offset = 150;

      if ($target.length) {
        $('html, body').animate(
          {
            scrollTop: $target.offset().top - offset,
          },
          1000,
          function () {
            // Use history.pushState to update the hash without causing a jump
            history.pushState(null, null, target);
          }
        );
      }
    });
  }

  /**
   * ===============================================
   * New homepage swiper (Everything you'd expect..)
   * ===============================================
   */
  if ($('.homepage-slider').length > 0) {
    // Make a new element for the glider pagination
    $('<div>', { class: 'carousel-dash' }).insertAfter('.homepage-slider');

    const glider = new Glider(document.querySelector('.homepage-slider'), {
      slidesToShow: 'auto',
      slidesToScroll: 1,
      itemWidth: 282,
      exactWidth: true,
      draggable: true,
      scrollLock: true,
      duration: 2,
      dragVelocity: 2,
      dots: '.carousel-dash',
      responsive: [
        {
          breakpoint: 1600,
          settings: {
            itemWidth: 352,
          },
        },
      ],
    });
  }

  /**
   * ===============================================
   * Single blog page copy button in code snippets
   * ===============================================
   */
  $(function () {
    if ($('.blog-content .dm-code-snippet').length > 0) {
      // Insert an svg copy icon. Prepending an svg normally doesn't seem to work, so after prepending
      // the svg to the target container, we refresh the page.
      $('#dm-copy-raw-code').prepend(
        `<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" height="1em">
        <path d="M21.3385 17.2052v5.6c0 4.6667-1.8666 6.5333-6.5333 6.5333h-5.6c-4.6667 0-6.5333-1.8666-6.5333-6.5333v-5.6c0-4.6667 1.8666-6.5333 6.5333-6.5333h5.6c4.6667 0 6.5333 1.8666 6.5333 6.5333Z" stroke="#161d26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M29.3385 9.2052v5.6c0 4.6667-1.8666 6.5333-6.5333 6.5333h-1.4667v-4.1333c0-4.6667-1.8666-6.5333-6.5333-6.5333h-4.1333V9.2052c0-4.6667 1.8666-6.5333 6.5333-6.5333h5.6c4.6667 0 6.5333 1.8666 6.5333 6.5333Z" stroke="#161d26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>`
      );
      $('body').html($('body').html());

      // Changing the contents of the initial text
      $('#dm-copy-raw-code .dm-copy-text').text('Copy');
    }
  });

  /**
   * ===============================================
   * Place two buttons side by side in mobile menu
   * ===============================================
   */
  $(function () {
    if (window.matchMedia('(min-width: 1024px)').matches) {
      return;
    }

    // First wrap them in a single li element
    $('.e-n-menu-heading').children(':nth-last-child(-n+2)').wrapAll('<li class="last-row e-n-menu-item"></li>');

    // Since two elements are now in the same li, we need to remove the inner <li>
    $('.e-n-menu-heading li.last-row  li').each(function () {
      $(this).replaceWith($(this).contents()); // removes inner <li> but keeps its content
    });
  });

  console.log('App started without any conflict.');
});
