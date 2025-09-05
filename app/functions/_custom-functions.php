<?php

/**
 * =================================================================
 *
 * Custom Published date in the Post Type News Room is Set as default wordpress Published date
 *
 * =================================================================
 */


function update_post_date_from_acf($post_id)
{
    // Avoid auto-saves and revisions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    // Get post type to limit to specific CPT (e.g., 'news-room')
    $post_type = get_post_type($post_id);

    if ($post_type !== 'news-room') return;

    // Check if the post is in the "In-The-News" category
    $categories = wp_get_post_terms($post_id, 'news-category', ['fields' => 'slugs']);
    if (!in_array('in-the-news', $categories)) return;

    // Get the ACF 'published_date' value (make sure ACF is active)
    $acf_published_date = get_field('published_date', $post_id);
    if (empty($acf_published_date)) return;

    // Convert ACF date to WordPress date format
    $new_post_date = date('Y-m-d H:i:s', strtotime($acf_published_date));

    // Prepare the data for updating
    $post_data = [
        'ID' => $post_id,
        'post_date' => $new_post_date,
        'post_date_gmt' => get_gmt_from_date($new_post_date) // Convert to GMT
    ];

    // Remove action to avoid infinite loop during update
    remove_action('save_post', 'update_post_date_from_acf');

    // Update the post
    wp_update_post($post_data);

    // Re-add the action after update
    add_action('save_post', 'update_post_date_from_acf');
}
add_action('save_post', 'update_post_date_from_acf');

//  In the News Single Page Redirect to Home Page

add_action('template_redirect', function () {
    if (is_singular('news-room')) {
        $categories = wp_get_post_terms(get_the_ID(), 'news-category', ['fields' => 'slugs']);

        // Check if 'in-the-news' is in the post's categories
        if (in_array('in-the-news', $categories)) {
            $external_url = get_field('url', get_the_ID()); // Get the ACF field value
            if ($external_url) {
                wp_redirect($external_url); // Redirect to the external URL
                exit;
            } else {
                wp_redirect(get_post_type_archive_link('news-room')); // Redirect to the news-room archive page
                exit;
            }
        }
    }

    if (is_singular('resource')) {
        
       
            $file_field = get_field('pdf_file', get_the_ID()); // Get the ACF field value
            $white_paper_url = get_field('white_paper_url', get_the_ID()); // ACF field 'white_paper_url'
    
            // Check if the file field has a URL (this is the URL to the uploaded file)
            if ($file_field && isset($file_field['url'])) {
                $external_url = $file_field['url']; // Extract the URL from the ACF file field
                wp_redirect($external_url); // Redirect to the external PDF file URL
                exit;
            }elseif ($white_paper_url) {
                wp_redirect($white_paper_url); // Redirect to the white paper URL if the PDF is not available
                exit;
            }
        // }
    }
    

});

// Disable Canonical URL Guessing
remove_filter('template_redirect', 'redirect_canonical');


function custom_news_room_rewrite_rules() {
    // Add a rewrite rule for the press-release category
    add_rewrite_rule(
        '^press-releases/([^/]+)/?$',
        'index.php?news-room=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_news_room_rewrite_rules');

// Modify post type permalink for posts in the press-release category
function custom_news_room_post_link($post_link, $post) {
    if ('news-room' === get_post_type($post)) {
        $categories = get_the_terms($post, 'news-category');
        if ($categories) {
            foreach ($categories as $category) {
                if ('press-releases' === $category->slug) {
                    return home_url('/press-releases/' . $post->post_name . '/');
                }
            }
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_news_room_post_link', 10, 2);

// Flush rewrite rules on activation
function flush_custom_rewrite_rules_on_activation() {
    custom_news_room_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_custom_rewrite_rules_on_activation');


// Order News Room Post Type in Admin Menu
function custom_newsroom_order_in_admin($query) {
    // Check if we are in the admin area and the post type is 'news-room'
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'news-room') {
        // Order by the latest posts
        $query->set('orderby', 'date');
        $query->set('order', 'DESC');
    }
}
add_action('pre_get_posts', 'custom_newsroom_order_in_admin');
