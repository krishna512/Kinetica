<?php
/**
 * =============================================================
 * Update the main query of archives.
 *
 * @param \WP_Query $query The WordPress query instance.
 * =============================================================
 */

function add_custom_query_vars_filter($vars)
{
    $vars[] = 'filter_year';

    return $vars;
}

add_filter('query_vars', 'add_custom_query_vars_filter');

/**
 * =============================================================
 * Update the main query of archives.
 *
 * @param \WP_Query $query The WordPress query instance.
 * =============================================================
 */

function update_main_query($query)
{
    /**
     * for default post
     */
    if (! is_admin() && $query->is_main_query() && (is_home() || $query->is_tax('blog_type'))) {

        // items per page
        $ppp = 18;
        $query->set('posts_per_page', $ppp);

        // text search
        $search = (isset($_GET['search'])) ? $_GET['search'] : '';

        if ($search) {
            $query->set('s', $search);
        }

        // taxonomy search
        $tax_query = single_taxonomy_search('blog_type');

        if ($tax_query) {
            $query->set('tax_query', $tax_query);
        }

    }

    /**
     * for news room
     */
    if (! is_admin() && $query->is_main_query() && is_post_type_archive('news-room')) {

        // items per page
        $ppp = 18;
        $query->set('posts_per_page', $ppp);

        // text search
        $search = (isset($_GET['search'])) ? $_GET['search'] : '';

        if ($search) {
            $query->set('s', $search);
        }

        // year parameter
        $year = intval($query->get('filter_year'));

        if ($year) {
            $query->set('year', $year);
        }

        // taxonomy search
        $tax_query = single_taxonomy_search('news-category');

        if ($tax_query) {
            $query->set('tax_query', $tax_query);
        }
    }

    /**
     * for events room
     */
    if (! is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
        // items per page
        $ppp = 18;
        $query->set('posts_per_page', $ppp);

        // text search
        $search = (isset($_GET['search'])) ? $_GET['search'] : '';

        if ($search) {
            $query->set('s', $search);
        }

        // taxonomy search
        $tax_query = single_taxonomy_search('event-method');

        if ($tax_query) {
            $query->set('tax_query', $tax_query);
        }

    }

    /**
     * For events type
     */
    if (! is_admin() && $query->is_main_query() && $query->is_tax('event-type')) {
        // items per page
        $ppp = 18;
        $query->set('posts_per_page', $ppp);

        // text search
        $search = (isset($_GET['search'])) ? $_GET['search'] : '';

        if ($search) {
            $query->set('s', $search);
        }

        // taxonomy search
        $tax_query = single_taxonomy_search('event-method');

        if ($tax_query) {
            $query->set('tax_query', $tax_query);
        }

    }

    return;

}

add_action('pre_get_posts', 'update_main_query', 11);


/**
 * =============================================================
 * Single taxonomy search
 * =============================================================
 */
if (! function_exists('single_taxonomy_search')) {
    function single_taxonomy_search($tax)
    {
        $_param = (isset($_GET['tax_' . $tax])) ? $_GET['tax_' . $tax] : '';

        $tax_query = array(
            'relation' => 'AND',
        );

        if ($_param) {

            $tax_query[] = array(
                'taxonomy' => $tax,
                'field' => 'id',
                'terms' => $_param,
            );

            return $tax_query;
        }

        return;
    }

}