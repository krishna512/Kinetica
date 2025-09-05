<?php

/**
 * 
 * call this function during development phaase to create css and json file 
 * OR
 * it is called during editor save process
 */
// set_kinetica_icons_resources();
function set_kinetica_icons_resources()
{


    $icons_lib_dirs = get_stylesheet_directory() . '/app/elementor-addon/assets/images';

    // Query Media Library for SVG files
    $args = [
        'post_type'      => 'attachment',
        'posts_per_page' => -1,
        'post_status'    => 'inherit',
        'post_mime_type' => 'image/svg+xml', // Only get SVG files
    ];

    $query = new WP_Query($args);
    $icons_css = '.elementor-icons-manager__tab__item__icon{max-height:1.5625rem;max-width:4.5rem;}';
    // Loop through each SVG file
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $icon_name = sanitize_title(get_the_title());  // Use the title as the icon name
            $icon_key =  str_replace([' ', '_'], '-', strtolower($icon_name));
            $icon_url  = wp_get_attachment_url(get_the_ID()); // Get the URL of the icon

            $icons[] = $icon_key;

            $icons_css .= '.kinetica-icons.kinetica-icon-' . $icon_key . '{content:url(' . $icon_url . ')}';
        }
    }
    // Restore original post data
    wp_reset_postdata();

    // Generate the dynamically
    file_put_contents($icons_lib_dirs . '/icons.json', json_encode(['icons' => $icons]));
    file_put_contents($icons_lib_dirs . '/icons.css', $icons_css);
}
/**
 * https://developers.elementor.com/docs/hooks/php/
 */
add_filter('elementor/icons_manager/additional_tabs', function ($tabs) {
    // 
    $svg_icons_url = get_stylesheet_directory_uri() . '/app/elementor-addon/assets/images';
    // 
    // Add the custom icon tab to Elementor
    $tabs['kinetica_icons'] = [
        'name'          => 'kinetica_icons',
        'label'         => __('Kinetica Icons', 'kinetica'),
        'url'           => $svg_icons_url . '/icons.css',
        'prefix'        => 'kinetica-icon-',
        'displayPrefix' => 'kinetica-icons',
        'labelIcon'     => 'eicon-font-awesome',
        'ver'           => '1.0',
        'fetchJson'     => $svg_icons_url . '/icons.json',
        'native'        => false,
    ];
    return $tabs;
});
/**
 * 
 * https://developers.elementor.com/docs/hooks/save-editor-data/
 * 
 */
add_action('elementor/editor/after_save', function () {
    set_kinetica_icons_resources();
});
/**
 * https://developers.elementor.com/docs/hooks/render-widget-content/
 *
 * @since 1.0.0
 * @param string                 $widget_content The widget HTML output.
 * @param \Elementor\Widget_Base $widget         The widget instance.
 * @return string The changed widget content.
 */
function change_widget_icon_content($widget_content, $widget)
{
    // <i aria-hidden="true" class="kinetica-icons kinetica-icon-title-global"></i>
    // Use regex to extract the part after "kinetica-icon-"
    if (preg_match('/kinetica-icons kinetica-icon-([\w-]+)/', $widget_content, $matches)) {
        $iconName = $matches[1]; // The extracted part
        if ($iconName) {
            $i_tag_icon = '<i aria-hidden="true" class="kinetica-icons kinetica-icon-' . $iconName . '"></i>';
            $svg_icon = get_stylesheet_directory() . '/app/elementor-addon/assets/icons/' . $iconName . '.svg';
            $svg_icon_content =  @file_get_contents($svg_icon);
            if ($svg_icon_content) {
                // $svg_icon_content = preg_replace('/<svg /', '<svg class="my-class" ', $svg_icon_content);
                $attribute = " aria-hidden='true' class='kinetica-icon-{$iconName}' ";
                $svg_icon_content = preg_replace('/<svg(.*?)>/', '<svg$1 ' . $attribute . '>', $svg_icon_content);
                $widget_content = str_replace($i_tag_icon, $svg_icon_content, $widget_content);
            }
        }
    }
    return $widget_content;
}
add_filter('elementor/widget/render_content', 'change_widget_icon_content', 10, 2);
