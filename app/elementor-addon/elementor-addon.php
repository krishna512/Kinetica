<?php

/**
 * Custom elementor extension
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

/**
 * Register Widgets.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

function register_custom_widgets($widgets_manager)
{
    $widgetFolder = '/includes/widgets';

    // includes widget files
    require_once __DIR__ . $widgetFolder . '/logo-listing/Logo_Listing.php';
    require_once __DIR__ . $widgetFolder . '/content-slider/Content_Slider.php';
    require_once __DIR__ . $widgetFolder . '/question-card/Question_Card.php';
    require_once __DIR__ . $widgetFolder . '/icon-list/Icon_List.php';
    require_once __DIR__ . $widgetFolder . '/code-highlight/Code_Highlight.php';
    require_once __DIR__ . $widgetFolder . '/hero-banner/Hero_Banner.php';
    require_once __DIR__ . $widgetFolder . '/hero-banner/Hero_Banner_Video.php';
    require_once __DIR__ . $widgetFolder . '/cube-3D/Cube-3D.php';
    require_once __DIR__ . $widgetFolder . '/tab-widget/Tab_Widget.php';
    require_once __DIR__ . $widgetFolder . '/four-Card/Four_Card.php';
    require_once __DIR__ . $widgetFolder . '/testimonial-carousel/Testimonial_Carousel.php';
    require_once __DIR__ . $widgetFolder . '/tab-widget-card/Tab_Widget_Card.php';
    require_once __DIR__ . $widgetFolder . '/content-carousel/Content_Carousel.php';
    require_once __DIR__ . $widgetFolder . '/table-content/Content_Table.php';
    require_once __DIR__ . $widgetFolder . '/chat-widget/Chat_Widget.php';
    require_once __DIR__ . $widgetFolder . '/tab-inneritem-widget/Tab_Inner_Widget.php';
    require_once __DIR__ . $widgetFolder . '/new-hero-banner/New_Hero_Banner.php';

    // Register class of widgets
    $widgets_manager->register(new \Elementor_Logo_Listing());
    $widgets_manager->register(new \Elementor_Content_Slider());
    $widgets_manager->register(new \Elementor_Question_Cards());
    $widgets_manager->register(new \Icon_List_With_Description());
    $widgets_manager->register(new \Code_Highlight());
    $widgets_manager->register(new \Hero_banner());
    $widgets_manager->register(new \Hero_banner_video());
    $widgets_manager->register(new \Cube_3D());
    $widgets_manager->register(new \Elementor_Tab_Widget());
    $widgets_manager->register(new \Four_Card());
    $widgets_manager->register(new \Elementor_Testimonial_Widget());
    $widgets_manager->register(new \Elementor_Tab_Widget_Card());
    $widgets_manager->register(new \Elementor_Content_Widget());
    $widgets_manager->register(new \Elementor_Table_Widget());
    $widgets_manager->register(new \Elementor_Chat_Widget());
    $widgets_manager->register(new \Elementor_Tab_InnerItem_Widget());
    $widgets_manager->register(new \New_Hero_banner());
}


/**
 * Register Custom Category for widgets.
 *
 * @since 1.0.0
 * @return void
 */
function register_custom_categories($elements_manager)
{
    $elements_manager->add_category(
        'kinetica',
        [
            'title' => __('Kinetica', 'young-innovation'),
        ]
    );
}

/**
 * Register scripts only
 *
 * @since 1.0.0
 * @return void
 */

function elementor_scripts_register()
{
    /**
     * =======================================
     * CDN URL
     * =======================================
     */

    // Gsap CDN
    wp_register_script('gsap-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '', false);

    wp_register_script('swiper-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js', [], 11, true);

    // Slick carousel cdn
    wp_register_script('slick-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', [], 1, true);

    // Highlight js cdn
    wp_register_script('highlight-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js', [], 1, true);

    // Chart js cdn
    wp_enqueue_script('chart-cdn', 'https://cdn.jsdelivr.net/npm/chart.js', [], 1, true);

    /**
     * =======================================
     * Elemenetor widgets
     * =======================================
     */
    $jsDir = 'app/elementor-addon/assets/js/';

    // Content Slider widget
    wp_register_script('content-slider', Vite::asset($jsDir . 'content-slider.js'), ['elementor-frontend', 'gsap-cdn'], null, false);

    // Question card widget
    wp_register_script('question-card', Vite::asset($jsDir . 'question-card.js'), ['elementor-frontend', 'gsap-cdn'], null, false);

    // Question Answer Card
    wp_localize_script(
        'question-card',
        'question_card_data',
        array(
            'card_data' => get_questions_card_data(),
        )
    );

    // Hero banner logo list
    wp_register_script('logo-list', Vite::asset($jsDir . 'logo-list.js'), ['elementor-frontend', 'swiper-cdn'], null, false);

    // code highlight
    wp_register_script('highlight-source-shell', Vite::asset($jsDir . 'code-highlight.js'), ['elementor-frontend', 'highlight-cdn'], null, false);

    // new hero banner
    wp_register_script('hero-banner', Vite::asset($jsDir . 'hero-banner.js'), ['elementor-frontend', 'gsap-cdn'], null, false);

    // new hero banner with video
    wp_register_script('hero-banner-video', Vite::asset($jsDir . 'hero-banner-video.js'), ['elementor-frontend', 'gsap-cdn'], null, false);

    // Tab content widget
    wp_register_script('tab-widget', Vite::asset($jsDir . 'tab-widget.js'), [], null, false);

    // Testimonial carousel in career page
    wp_register_script('testimonial-card', Vite::asset($jsDir . 'testimonial-carousel.js'), [], null, false);

    // Carousel in graph analysis page
    wp_register_script('content-carousel', Vite::asset($jsDir . 'content-carousel.js'), [], null, false);

    // Table of contents in single blog page
    wp_register_script('table-carousel', Vite::asset($jsDir . 'table-of-contents.js'), [], null, false);

    // CVS Chart page
    wp_register_script('chart-graph', Vite::asset($jsDir . 'csv-chart-loader.js'), [], null, false);

    // Nested tab widget
    wp_register_script('tab-inner-widget', Vite::asset($jsDir . 'tab-inner-widget.js'), [], null, false);
}


/**
 * Register styles only
 *
 * @since 1.0.0
 * @return void
 */
function elementor_styles_register()
{
    $scssDir = 'app/elementor-addon/assets/scss/';

    // Swiper CDN
    wp_register_style('swiper-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css', [], 1);

    // Slick CDN
    wp_register_style('slick-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', [], 1);

    // Highlight CDN
    wp_register_style('highlight-cdn-css', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css', [], 1);

    //Logo grid widget
    wp_register_style('logo-style', Vite::asset($scssDir . 'logo-style.scss'), [], null, false);

    // Content Slider widget
    wp_register_style('content-slider', Vite::asset($scssDir . 'content-slider-style.scss'), [], null, false);

    // Question card widget
    wp_register_style('question-card', Vite::asset($scssDir . 'question-card-style.scss'), [], null, false);

    // custom icon list widget
    wp_register_style('customIconListWidget', Vite::asset($scssDir . 'icon-list.scss'), [], null, false);

    // code highlight
    wp_register_style('highlight-source-shell', Vite::asset($scssDir . 'highlight.scss'), [], null, false);

    // new hero banner
    wp_register_style('hero-banner', Vite::asset($scssDir . 'hero-banner.scss'), [], null, false);

    // new hero banner with video
    wp_register_style('hero-banner-video', Vite::asset($scssDir . 'hero-banner-video.scss'), [], null, false);

    // 3D Cube
    wp_register_style('cube-3D', Vite::asset($scssDir . 'cube-3D.scss'), [], null, false);

    // Tab content widget
    wp_register_style('tab-widget', Vite::asset($scssDir . 'tab-widget.scss'), [], null, false);

    // Four card widget
    wp_register_style('four-card', Vite::asset($scssDir . 'four-card.scss'), [], null, false);

    // Testimonial carousel in career page
    wp_register_style('testimonial-card', Vite::asset($scssDir . 'testimonial-carousel.scss'), [], null, false);

    // Image with mini cards, just below the hero banner
    wp_register_style('image-with-cards', Vite::asset($scssDir . 'image-with-cards.scss'), [], null, false);

    // Carousel in the graph analysis page
    wp_register_style('content-carousel', Vite::asset($scssDir . 'content-carousel.scss'), [], null, false);

    // Table of contents in single blog page
    wp_register_style('table-carousel', Vite::asset($scssDir . 'table-of-contents.scss'), [], null, false);

    // Dynamic chart in the homepage
    wp_register_style('dynamic-chart', Vite::asset($scssDir . 'dynamic-chart.scss'), [], null, false);

    // Nested chart widget
    wp_register_style('tab-inner-widget', Vite::asset($scssDir . 'tab-inner-widget.scss'), [], null, false);

    // New hero banner
    wp_register_style('new-hero-banner', Vite::asset($scssDir . 'new-hero-banner.scss'), [], null, false);
}


if (is_plugin_active('elementor/elementor.php')) {

    add_action('elementor/widgets/register', 'register_custom_widgets');

    add_action('elementor/elements/categories_registered', 'register_custom_categories');

    add_action('elementor/frontend/before_enqueue_scripts', 'elementor_scripts_register');

    add_action('wp_enqueue_scripts', 'elementor_styles_register', 20);
}
