<?php

/**
 * =============================================
 * Add categories and tag taxonomy to page
 * =============================================
 */
function add_categories_to_pages()
{
    register_taxonomy_for_object_type('category', 'page');
    register_taxonomy_for_object_type('category', 'attachment');
}
// add_action('init', 'add_categories_to_pages');


/**
 * =============================================
 * Add excerpt support to page
 * =============================================
 */
function add_excerpts_to_pages()
{
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'add_excerpts_to_pages');


function create_press_release_post_type()
{
    $labels = array(
        'name' => _x('Press Releases', 'post type general name'),
        'singular_name' => _x('Press Release', 'post type singular name'),
        'add_new' => _x('Add New', 'Press Release'),
        'add_new_item' => __('Add New Press Release'),
        'edit_item' => __('Edit Press Release'),
        'new_item' => __('New Press Press Release'),
        'view_item' => __('View Press Releases'),
        'search_items' => __('Search Press Releases'),
        'not_found' => __('No items found'),
        'not_found_in_trash' => __('No items found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'editor', 'excerpt', 'revisions');

    register_post_type(
        'press-releases',
        array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => false,
            'taxonomies' => array('category'),
            'has_archive' => true,
            'exclude_from_search' => true,
            'supports' => $supports,
            'rewrite' => array(
                'slug' => 'press-releases',
                'with_front' => false
            ),
            'menu_icon' => get_bloginfo('stylesheet_directory') . '/dist/cpticons/news.png'
        )
    );
}
// add_action('init', 'create_press_release_post_type');


/* Don't need this anymore either!
function create_classes_post_type() {
    $labels = array(
        'name'                  => _x( 'Classes', 'post type general name' ),
        'singular_name'         => _x( 'Class', 'post type singular name' ),
        'add_new'               => _x( 'Add New', 'Class' ),
        'add_new_item'          => __( 'Add New Class' ),
        'edit_item'             => __( 'Edit Class' ),
        'new_item'              => __( 'New Class' ),
        'view_item'             => __( 'View Class' ),
        'search_items'          => __( 'Search Classes' ),
        'not_found'             => __( 'No Classes found' ),
        'not_found_in_trash'    => __( 'No Classes found in Trash' ),
        'parent_item_colon'     => ''
    );
    $supports = array( 'title', 'editor' );

    register_post_type( 'class',
        array(
            'labels'            => $labels,
            'public'            => true,
            'rewrite'           => array( 'slug' => 'training', 'with_front' => false ),
            'hierarchical'      => false,
            'capability_type'   => 'post',
            'supports'          => $supports,
            'taxonomies'        => array( 'class_categories' ),
            'menu_icon'         => 'dashicons-welcome-learn-more'
        )
    );
}
add_action( 'init', 'create_classes_post_type' );
*/

/* CAREERS
function create_job_openings()
{
    $labels = array(
        'name' => _x('Job Openings', 'post type general name'),
        'singular_name' => _x('Job Opening', 'post type singular name'),
        'add_new' => _x('Add New', 'Job Opening'),
        'add_new_item' => __('Add New Job Opening'),
        'edit_item' => __('Edit Job Opening'),
        'new_item' => __('New Press Job Opening'),
        'view_item' => __('View Job Openings'),
        'search_items' => __('Search Job Openings'),
        'not_found' => __('No items found'),
        'not_found_in_trash' => __('No items found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'revisions', 'editor', 'excerpt');

    register_post_type('job-opening',
        array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => false,
            'taxonomies'    => array('department'),
            'has_archive' => false,
            'supports' => $supports,
            'rewrite' => array(
                'slug' => 'careers',
                'with_front' => false
            ),
            'menu_icon' => get_bloginfo('stylesheet_directory') . '/images/cpticons/news.png'
        )
    );
}
add_action( 'init', 'create_job_openings' );
*/

// ARTICLES... USED FOR POSTING NEWS ARTICLES ABOUT US IN THE MEDIA
function create_article_post_type()
{
    $labels = array(
        'name' => _x('News Articles', 'post type general name'),
        'singular_name' => _x('News Article', 'post type singular name'),
        'add_new' => _x('Add New', 'News Article'),
        'add_new_item' => __('Add New News Article'),
        'edit_item' => __('Edit Article'),
        'new_item' => __('New News Article'),
        'view_item' => __('View Article'),
        'search_items' => __('Search Articles'),
        'not_found' => __('No Articles found'),
        'not_found_in_trash' => __('No Articles found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'revisions', 'thumbnail');

    register_post_type(
        'article',
        array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'taxonomies' => array('category'),
            'hierarchical' => true,
            'has_archive' => true,
            'exclude_from_search' => true,
            'supports' => $supports,
            'rewrite' => array(
                'slug' => 'articles',
                'with_front' => true
            ),
            'menu_icon' => get_bloginfo('stylesheet_directory') . '/dist/cpticons/articles.png'
        )
    );
}
// add_action('init', 'create_article_post_type');

/* CUSTOMERS... FOR OUR CUSTOMERS
function create_customer_post_type() {
    $labels = array(
        'name'                  => _x( 'Customers', 'post type general name' ),
        'singular_name'         => _x( 'Customer Story', 'post type singular name' ),
        'add_new'               => _x( 'Add New', 'Customer Story' ),
        'add_new_item'          => __( 'Add New Customer Story' ),
        'edit_item'             => __( 'Edit Customer Story' ),
        'new_item'              => __( 'New Customer' ),
        'view_item'             => __( 'View Customer' ),
        'search_items'          => __( 'Search Customer Stories' ),
        'not_found'             => __( 'No Customer Stories found' ),
        'not_found_in_trash'    => __( 'No Customer Stories found in Trash' ),
        'parent_item_colon'     => ''
    );
    $supports = array( 'title', 'revisions', 'editor', 'excerpt', 'thumbnail' );

    register_post_type( 'customer',
        array(
            'labels'        => $labels,
            'public'        => true,
            'taxonomies'    => array('category' ),
            'hierarchical'  => false,
            'has_archive'   => false,
            'supports'      => $supports,
            'rewrite'       => array( 'slug' => 'customer', 'with_front' => false )
        )
    );
}
add_action( 'init', 'create_customer_post_type' );
*/

// EVENTS... FOR MEETUPS, TRADE-SHOWS, ETC
function create_event_post_type()
{
    $labels = array(
        'name' => _x('Events', 'post type general name'),
        'singular_name' => _x('Event', 'post type singular name'),
        'add_new' => _x('Add New', 'Event'),
        'add_new_item' => __('Add New Event'),
        'edit_item' => __('Edit Event'),
        'new_item' => __('New Event'),
        'view_item' => __('View Event'),
        'search_items' => __('Search Events'),
        'not_found' => __('No Events found'),
        'not_found_in_trash' => __('No Events found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'editor', 'excerpt', 'thumbnail', 'revisions');

    register_post_type(
        'event',
        array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'taxonomies' => array('category', 'event_series'),
            'hierarchical' => false,
            'supports' => $supports,
            'exclude_from_search' => true,
            'rewrite' => array('slug' => 'events', 'with_front' => false),
            'menu_icon' => 'dashicons-calendar-alt'
        )
    );
}
// add_action('init', 'create_event_post_type');

// RESOURCES... FOR RESOURCES
function create_resource_post_type()
{
    $labels = array(
        'name' => _x('Resources', 'post type general name'),
        'singular_name' => _x('Resource', 'post type singular name'),
        'add_new' => _x('Add New', 'Resource'),
        'add_new_item' => __('Add New Resource'),
        'edit_item' => __('Edit Resource'),
        'new_item' => __('New Resource'),
        'view_item' => __('View Resource'),
        'search_items' => __('Search Resources'),
        'not_found' => __('No Resources found'),
        'not_found_in_trash' => __('No Resources found in Trash'),
        'parent_item_colon' => ''
    );

    $supports = array('title', 'editor', 'excerpt', 'thumbnail', 'revisions');

    register_post_type(
        'resource',
        array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'taxonomies' => array('category'),
            'hierarchical' => false,
            'exclude_from_search' => true,
            'supports' => $supports,
            'rewrite' => array('slug' => 'resource', 'with_front' => false),
            'menu_icon' => 'dashicons-calendar-alt'
        )
    );
}
// add_action('init', 'create_resource_post_type');

// PARTNERS... FOR COMPANIES THAT WE PARTNER WITH.
function create_partner_post_type()
{
    $labels = array(
        'name' => _x('Partners', 'post type general name'),
        'singular_name' => _x('Partner', 'post type singular name'),
        'add_new' => _x('Add New', 'Partner'),
        'add_new_item' => __('Add New Partner'),
        'edit_item' => __('Edit Partner'),
        'new_item' => __('New Partner'),
        'view_item' => __('View Partner'),
        'search_items' => __('Search Partners'),
        'not_found' => __('No Partners found'),
        'not_found_in_trash' => __('No Partners found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'revisions', 'editor', 'excerpt', 'revisions', 'thumbnail');

    register_post_type(
        'partner',
        array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'rewrite' => array('slug' => 'partner', 'with_front' => false),
            'supports' => $supports
        )
    );
}
// add_action('init', 'create_partner_post_type');

function create_tutorial_post_type()
{
    $labels = array(
        'name' => _x('Tutorials', 'post type general name'),
        'singular_name' => _x('Tutorial', 'post type singular name'),
        'add_new' => _x('Add New', 'Tutorial'),
        'add_new_item' => __('Add New Tutorial'),
        'edit_item' => __('Edit Tutorial'),
        'new_item' => __('New Tutorial'),
        'view_item' => __('View Tutorial'),
        'search_items' => __('Search Tutorials'),
        'not_found' => __('No Tutorials found'),
        'not_found_in_trash' => __('No Tutorials found in Trash'),
        'parent_item_colon' => ''
    );
    $supports = array('title', 'author', 'revisions', 'editor', 'comments', 'excerpt', 'thumbnail', 'page-attributes');

    register_post_type(
        'tutorial',
        array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('category', 'tuts-series'),
            'supports' => $supports,
            'exclude_from_search' => true,
            'show_in_admin_bar' => true,
            'menu_icon' => 'dashicons-book-alt',
            'rewrite' => array('slug' => 'tutorial', 'with_front' => false)
        )
    );
}
// add_action('init', 'create_tutorial_post_type');

/*
function create_podcast_post_type() {
    $labels = array(
        'name'                  => _x( 'Podcasts', 'post type general name' ),
        'singular_name'         => _x( 'Podcast', 'post type singular name' ),
        'add_new'               => _x( 'Add New', 'Episode' ),
        'add_new_item'          => __( 'Add New Episode' ),
        'edit_item'             => __( 'Edit Episode' ),
        'new_item'              => __( 'New Episode' ),
        'view_item'             => __( 'View Episode' ),
        'search_items'          => __( 'Search Podcasts' ),
        'not_found'             => __( 'No Podcasts found' ),
        'not_found_in_trash'    => __( 'No Podcasts found in Trash' ),
        'parent_item_colon'     => '',
    );
    $supports = array( 'title', 'author', 'revisions', 'editor', 'comments', 'excerpt', 'thumbnail', 'page-attributes' );

    register_post_type( 'podcast',
        array(
            'labels'            => $labels,
            'public'            => true,
            'taxonomies'        => array('category'),
            'supports'          => $supports,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-microphone',
            'rewrite'           => array( 'slug' => 'podcast', 'with_front' => false )
        )
    );
}
add_action( 'init', 'create_podcast_post_type' );
*/
/**
 * MODIFY BLOG POST LABEL.
 */
function KIN_modify_posts_type($post_type, $args)
{
    // Make sure we're only editing the post type we want
    if ('post' != $post_type)
        return;

    // Set menu icon
    $args->labels->singular_name = _x('Blog', 'post type singular name');

    // Modify post type object
    global $wp_post_types;
    $wp_post_types[$post_type] = $args;
}
add_action('registered_post_type', 'KIN_modify_posts_type', 10, 2);