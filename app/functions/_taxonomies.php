<?php

function kinetica_terms_clauses($clauses, $taxonomy, $args)
{
    global $wpdb;

    if (array_key_exists('post_types', $args)) {
        $post_types = $args['post_types'];

        //allow for arrays
        if (is_array($args['post_types'])) {
            $post_types = implode("','", $args['post_types']);
        }

        $clauses['join'] .= " INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id";
        $clauses['where'] .= " AND p.post_type IN ('" . $post_types . "') GROUP BY t.term_id";
    }

    return $clauses;
}
add_filter('terms_clauses', 'kinetica_terms_clauses', 99999, 3);

// MODIFY CATEGORIES
function modify_categories()
{
    $labels = array(
        'name' => _x('Related Content', 'taxonomy general name'),
        'singular_name' => _x('Related Content', 'taxonomy singular name'),
        'search_items' => __('Related Content'),
        'all_items' => __('All Related Content'),
        'parent_item' => __('Group'),
        'parent_item_colon' => __('Group:'),
        'edit_item' => __('Related Pages'),
        'update_item' => __('Update Related Content'),
        'add_new_item' => __('Add New Related Content'),
        'new_item_name' => __('New Related Content'),
        'menu_name' => __('Related Content')
    );

    register_taxonomy('category', array('post', 'page', 'article', 'event', 'press-release'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => true,
        'description' => 'Please select no more than two or three items. Choose the most specific.'
    )
    );
}

// Blog Types... Announcements, Dev Blogs, etc.
function define_blog_types()
{
    $labels = array(
        'name' => _x('Blog Type', 'taxonomy general name'),
        'singular_name' => _x('Blog Type', 'taxonomy singular name'),
        'search_items' => __('Search Types'),
        'all_items' => __('All Types'),
        'parent_item' => __('Parent Type'),
        'parent_item_colon' => __('Parent Type:'),
        'edit_item' => __('Edit Types'),
        'update_item' => __('Update Type'),
        'add_new_item' => __('Add New Blog Type'),
        'new_item_name' => __('New Blog Type'),
        'menu_name' => __('Blog Types')
    );

    register_taxonomy('blog_type', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => '/blog-series',
            'with_front' => false
        )
    )
    );
}
add_action('init', 'define_blog_types', 0);

// Event Series - Roadshows, Partner Breakfasts and the likes!
function define_event_series()
{
    $labels = array(
        'name' => _x('Event Series', 'taxonomy general name'),
        'singular_name' => _x('Event Series', 'taxonomy singular name'),
        'search_items' => __('Search Series'),
        'all_items' => __('All Series'),
        'parent_item' => __('Parent Series'),
        'parent_item_colon' => __('Parent Series:'),
        'edit_item' => __('Edit Series'),
        'update_item' => __('Update Series'),
        'add_new_item' => __('Add New Event Series'),
        'new_item_name' => __('New Event Series'),
        'menu_name' => __('Event Series')
    );

    register_taxonomy('event_series', array('event'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'series',
            'with_front' => true
        )
    )
    );
}
add_action('init', 'define_event_series', 0);

// SETUP PARTNER TYPES
function define_partner_categories()
{
    $labels = array(
        'name' => _x('Partner Type', 'taxonomy general name'),
        'singular_name' => _x('Partner Type', 'taxonomy singular name'),
        'search_items' => __('Search Types'),
        'all_items' => __('All Types'),
        'parent_item' => __('Parent Type'),
        'parent_item_colon' => __('Parent Type:'),
        'edit_item' => __('Edit Types'),
        'update_item' => __('Update Type'),
        'add_new_item' => __('Add New Partner Type'),
        'new_item_name' => __('New Partner Type'),
        'menu_name' => __('Partner Types'),
    );

    register_taxonomy('partner_categories', array('partner'), array(
        'public' => false,
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
    )
    );
}
add_action('init', 'define_partner_categories', 0);


// SETUP PARTNER TYPES
function define_resource_types()
{
    $labels = array(
        'name' => _x('Resource Type', 'taxonomy general name'),
        'singular_name' => _x('Resource Type', 'taxonomy singular name'),
        'search_items' => __('Search Resource Types'),
        'all_items' => __('All Resource Types'),
        'parent_item' => __('Parent Type'),
        'parent_item_colon' => __('Parent Type:'),
        'edit_item' => __('Edit Types'),
        'update_item' => __('Update Resource Type'),
        'add_new_item' => __('Add New Resource Type'),
        'new_item_name' => __('New Resource Type'),
        'menu_name' => __('Resource Types'),
    );

    register_taxonomy('resource_types', array('attachment'), array(
        'public' => false,
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
    )
    );
}
add_action('init', 'define_resource_types', 0);


function define_tuts_series()
{
    $labels = array(
        'name' => _x('Tutorial Series', 'taxonomy general name'),
        'singular_name' => _x('Series', 'taxonomy singular name'),
        'search_items' => __('Search Types'),
        'all_items' => __('All Series'),
        'parent_item' => __('Parent Series'),
        'parent_item_colon' => __('Parent Series:'),
        'edit_item' => __('Edit Series'),
        'update_item' => __('Update Series'),
        'add_new_item' => __('Add New Series'),
        'new_item_name' => __('New Series'),
        'menu_name' => __('Series')
    );

    register_taxonomy('tuts_series', array('tutorial'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'tutorials/group',
            'with_front' => false
        )
    )
    );
}
add_action('init', 'define_tuts_series', 0);

// Remove tags support from posts
function KIN_unregister_tags()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'KIN_unregister_tags');