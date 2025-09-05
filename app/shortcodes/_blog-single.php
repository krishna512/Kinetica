<?php

/**
 * ====================================
 * Return title of people post by ID
 * ====================================
 */
if (! function_exists('blog_author')) {
    function blog_author()
    {
        $postID = get_field('custom_author');

        if (! $postID)
            return;

        return get_the_title($postID);
    }

    add_shortcode('blogAuthor', 'blog_author');
}
