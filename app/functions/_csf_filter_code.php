<?php
// Add filter fields for default post "update" archive page Filter
add_filter('set_csf_search_fields', 'post_update_filter_fields');
function post_update_filter_fields($csf_filters)
{
    $filter_fields = $csf_filters['csf_unique_default_filter_name'];
   
    
    $sort_filter_items = [
        [
            'slug' => 'DESC',
            'name' => 'Newest First'
        ],
        [
            'slug' => 'ASC',
            'name' => 'Oldest First'
        ],
    ];
    // Update post archive page Filter
   
    $filter_fields_name = 'event_resource'; //filter name should be post type to query and filter by main wp query 
    $filter_fields['post_type']  = $filter_fields_name; // post type to filter
    $filter_fields['is_main_query'] = false;
    $filter_fields['search_filter_title'] = ''; // Search filter title in the search form
    $filter_fields['field_relation'] = "AND";
    $filter_fields['display_count'] = 0;
    // $filter_fields['result_template'] = "";
    $filter_fields['update_url'] = true;
    $filter_fields['fields_actions']  = [
        'auto_submit' => true,
        'submit_btn_show' => false,
        'submit_display_name' => 'Search',
        'reset_btn_show' => false,
        'reset_display_name' => 'Reset'
    ];
    $filter_items = [
        [
            'slug' => '',
            'name' => 'View all'
        ],
        [
            'slug' => 'webinar',
            'name' => 'Webinar'
        ],
    ];
    $resource_type_taxonomy = 'resource-type';

    $resource_type = get_terms(array(
        'taxonomy'   => $resource_type_taxonomy,
        'hide_empty' => true,
    ));

    foreach ($resource_type as $key => $value) {
        $filter_items[] = [
            'slug' => $value->slug,
            'name' => $value->name
        ];
    }

    $filter_fields['fields']  = [
        ['display_name' => 'Sort by', 'filter_term_type' => 'metadata', 'filter_items' => $sort_filter_items, 'filter_term_key' => 'date', 'metadata_reference' => 'asc_desc_sort_by', 'search_field_type' => 'dropdown'],
        ['display_name' => 'Filter by Type', 'filter_term_type' => 'metadata', 'filter_items' => $filter_items, 'filter_term_key' => 'filter_items_key_test', 'metadata_reference' => '', 'search_field_type' => 'radio'],
    ];

    $csf_filters['event_resource'] = $filter_fields; ////filter name should be post type to query and filter by main wp query 
    return $csf_filters;

}

function custom_query_callback($query)
{
    $query->set('posts_per_page', '12');
    $query->set('post_type', ['event', 'resource']);
    // 
    // csf_filter_by_type
    $resource_type_taxonomy = 'resource-type';
    $csf_filter_by_type = isset($_GET['csf_filter_by_type']) ? $_GET['csf_filter_by_type'] : '';
    if ($csf_filter_by_type == 'webinar') {
        $tax_query = [
            'relation' => 'OR',
            \csf_search_filter\CSF_Query::tax_filter_query('event-type', 'webinar')
        ];
    } elseif ($csf_filter_by_type) {
        $tax_query = [
            'relation' => 'OR',
            \csf_search_filter\CSF_Query::tax_filter_query($resource_type_taxonomy, $csf_filter_by_type)
        ];
    } else {
        $tax_query = [
            'relation' => 'OR',
            \csf_search_filter\CSF_Query::tax_filter_query('event-type', 'webinar')
        ];

        $resource_type = get_terms(array(
            'taxonomy'   => $resource_type_taxonomy,
            'hide_empty' => false,
        ));

        foreach ($resource_type as $key => $value) {
            $tax_query[] = \csf_search_filter\CSF_Query::tax_filter_query($resource_type_taxonomy, $value->slug);
        }
    }

    // 
    $csf_sort_by = isset($_GET['csf_sort_by']) ? $_GET['csf_sort_by'] : '';
    if ($csf_sort_by) {
        $query->set('order', $csf_sort_by);
        $query->set('orderby', 'date');
    }


    $query->set('tax_query', $tax_query);
}
add_action('elementor/query/resources_query', 'custom_query_callback');
