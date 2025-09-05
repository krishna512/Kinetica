<?php

if (! function_exists('add_custom_shape')) {
    function add_custom_shape($additional_shapes)
    {
        $additional_shapes['kineticawave'] = [
            'title' => esc_html__('Kinetica Wave', 'HelloElementorChild'),
            'url' => get_stylesheet_directory_uri() . '/resources/shapes/kinetica-wave-top.svg',
            'path' => get_stylesheet_directory() . '/resources/shapes/kinetica-wave-top.svg',
            'height_only' => true,
        ];

        return $additional_shapes;
    }

    add_filter('elementor/shapes/additional_shapes', 'add_custom_shape');
}