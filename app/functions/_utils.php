<?php

/**
 * ====================================================
 * Read time of post
 * 
 * @return string "3 Min. To Read"
 * ====================================================
 */
if (! function_exists('readingTime')) {

    add_shortcode('readingTime', 'readingTime');
    function readingTime()
    {
        global $post;

        $content = get_post_field('post_content', $post->ID);

        $wordcount = str_word_count(strip_tags($content));

        $time = ($number = $wordcount / 200) > 1 ? ceil($number) . '  Min. To Read' : $number . ' Sec. To Read';

        return ($time);
    }
}


/**
 * ====================================================
 * Return Categories attached to post
 * 
 * @return $html
 * ====================================================
 */

if (! function_exists('categoriesList')) {

    add_shortcode('postCategories', 'categoriesList');
    function categoriesList()
    {
        $categories = get_the_category();

        if (! empty($categories)) {
            $cats = array();
            foreach ($categories as $category) {
                $cat[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            }

            echo '<ul class="post-categories">';
            echo join('', $cat);
            echo '</ul>';
        }
    }
}

/**
 * =======================================================
 * Dynamic SVG icon
 * 
 * @return $html
 * =======================================================
 */

if (! function_exists('useSVG')) {
    function useSVG($filename = 'sample-icon')
    {
        $icon = get_stylesheet_directory() . '/resources/icons/' . $filename . '.svg';

        $svg_icon_content = @file_get_contents($icon);

        return $svg_icon_content;
    }
}


/**
 * =========================================================
 * Excerpt
 * =========================================================
 */
if (!function_exists('excerpt')) {

    function excerpt($atts)
    {
        // Set default attributes
        $a = shortcode_atts(array(
            'limit' => 168, // Limit in characters
            'id' => '',     // Post ID
        ), $atts);

        // Get the post object
        $post = $a['id'] ? get_post($a['id']) : get_post();

        if (!$post) {
            return ''; // Return empty if the post doesn't exist
        }

        // Fetch the excerpt or generate one from content
        $excerpt = has_excerpt($post) ? get_the_excerpt($post) : wp_strip_all_tags(get_the_content(null, false, $post));

        // Trim the excerpt to the specified character limit
        $trimmed_excerpt = wp_trim_words($excerpt, $a['limit'] / 5, '...');

        // Return the sanitized excerpt
        return esc_html($trimmed_excerpt);
    }

    add_shortcode('excerpt', 'excerpt');
}


if (! function_exists('default_excerpt_length')) {
    function default_excerpt_length($length)
    {
        return 168;
    }
    add_filter("excerpt_length", "default_excerpt_length");
}

/**
 * =========================================================
 * Get current URL
 * =========================================================
 */

if (! function_exists('get_current_page_link')) {
    function get_current_page_link()
    {
        global $wp;

        // Ensure $wp is available
        if (! isset($wp)) {
            return '';
        }

        // Generate the current page URL
        $url = home_url($wp->request);

        // Remove pagination part if it exists
        $url = preg_replace('/\/page\/[0-9]+\/?$/', '/', $url);

        return $url;
    }

}