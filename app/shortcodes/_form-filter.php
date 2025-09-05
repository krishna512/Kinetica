<?php

/**
 * ====================================
 * Load filter form script
 * ====================================
 */
if (! function_exists('form_script')) {
    function form_script()
    {
        $handle = 'yi-form-filter';
        $list = 'enqueued';

        if (wp_script_is($handle, $list)) {
            return;
        } else {
            wp_enqueue_style('form-filter');
            wp_enqueue_script('form-filter');
        }
    }
}


/**
 * ====================================
 * Shortcode for blog archive
 * 
 * Filter Forms
 * ====================================
 */
if (! function_exists('blog_filter')) {
    function blog_filter()
    {

        // Load required scripts only if this shortcode triggers
        form_script();

        $shortcode = '[filterForm]';

        $shortcode .= '<div class="flex flex-wrap lg:flex-nowrap gap-5">';

        $shortcode .= '<div class="w-full mr-auto md:w-auto">' . search_filter() . '</div>';

        $shortcode .= '<div>' . taxonomies_radio_filter('blog_type') . '</div>';

        $shortcode .= '</div>';

        $shortcode .= '[/filterForm]';

        return do_shortcode($shortcode);
    }

    add_shortcode('blogFilter', 'blog_filter');
}


/**
 *  Facet Filter Form Wrapper
 */

if (! function_exists('filter_form')) {
    function filter_form($atts, $content = null)
    {

        // Load required scripts only if this shortcode triggers
        form_script();
        ?>
        <form class="yi-filter-form" id="post-type-filter" action="" method="GET" role="search"
            data-url="<?php echo get_current_page_link(); ?>">
            <div class="form_wrapper">
                <?php echo $content; ?>
            </div>
        </form>
        <?php
    }
    add_shortcode('filterForm', 'filter_form');
}


/**
 * ====================================
 * Shortcode for events archive
 * 
 * Filter Forms
 * ====================================
 */

if (! function_exists('eventfilter_form')) {
    function eventfilter_form($atts, $content = null)
    {
        // Load required scripts only if this shortcode triggers
        form_script();

        $shortcode = '[filterForm]';

        $shortcode .= '<div class="flex flex-wrap lg:flex-nowrap gap-5">';

        $shortcode .= '<div class="w-full mr-auto md:w-auto">' . search_filter() . '</div>';

        $shortcode .= taxonomies_radio_filter('event-type');

        $shortcode .= '</div>';

        $shortcode .= '[/filterForm]';

        return do_shortcode($shortcode);
    }
    add_shortcode('eventFilterForm', 'eventfilter_form');
}

/**
 * ====================================
 * Shortcode for events type archive
 * 
 * Filter Forms
 * ====================================
 */

if (! function_exists('eventTypeFilter_form')) {
    function eventTypeFilter_form($atts, $content = null)
    {
        // Load required scripts only if this shortcode triggers
        form_script();

        $shortcode = '[filterForm]';

        $shortcode .= '<div class="flex flex-wrap lg:flex-nowrap gap-5">';

        $shortcode .= '<div class="w-full mr-auto md:w-auto">' . search_filter() . '</div>';

        $shortcode .= '<div>' . taxonomies_radio_filter('event-method') . '</div>';

        $shortcode .= '</div>';

        $shortcode .= '[/filterForm]';

        return do_shortcode($shortcode);
    }
    add_shortcode('eventTypeFilterForm', 'eventTypeFilter_form');
}

/**
 * ====================================
 * Shortcode for news room archive
 * 
 * Filter Forms
 * ====================================
 */

if (! function_exists('news_filter_form')) {
    function news_filter_form($atts, $content = null)
    {
        // Load required scripts only if this shortcode triggers
        form_script();

        $shortcode = '[filterForm]';

        $shortcode .= '<div class="flex flex-wrap lg:flex-nowrap gap-5">';

        $shortcode .= search_filter();

        $shortcode .= '<div class="w-full mr-auto sm:w-auto">' . get_years_with_posts('news-room') . '</div>';

        $shortcode .= taxonomies_radio_filter('news-category');

        $shortcode .= '</div>';

        $shortcode .= '[/filterForm]';

        return do_shortcode($shortcode);
    }
    add_shortcode('newsFilterForm', 'news_filter_form');
}