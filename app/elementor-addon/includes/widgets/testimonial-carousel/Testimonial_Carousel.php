<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/TestimonialControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Testimonial_Widget extends \Elementor\Widget_Base
{

    use TestimonialControlTrait;

    /**
     * Get widget name.
     *
     * Retrieve list widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'testimonial-card';
    }

    /**
     * Get widget title.
     *
     * Retrieve list widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Testimonial Carousel', 'HelloElementorChild');
    }


    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget title.
     */
    public function get_style_depends()
    {
        return ['testimonial-widget', 'testimonial-carousel', 'testimonial-card'];
    }

    /**
     * Script Dependencies
     *
     * @since 1.0.0
     * @access public
     * @return array Widget title.
     */
    public function get_script_depends()
    {
        return ['gsap-cdn', 'testimonial-card', 'testimonial-widget', 'swiper-cdn'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve list widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-slides';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the list widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['kinetica'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the list widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['testimonial', 'carousel'];
    }

    /**
     * Register list widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $this->sectionContent();

        $this->listStyles();

        $this->imageStyles();
    }

    /**
     * Return the youtube id on the basis of the given link
     */
    public function getYoutubeId($link)
    {
        preg_match('/(?:\/|=)(.{11})(?:$|&|\?)/', $link, $matches);
        return $matches[1];
    }

    /**
     * Render list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // $card_data = array_reverse(get_tab_widget_data());

        echo '<div class="testimonial-carousel">';
        echo '<div class="swiper">'; // To select the swiper
        echo '<div class="swiper-wrapper">'; // Additional required wrapper
        foreach ($settings['carousel'] as $index => $carousel) {

            $link_key = 'link_' . $index;
            $does_link_exist = ! empty($carousel['link']['url']);

            if (! empty($carousel['link']['url'])) {
                $this->add_link_attributes($link_key, $carousel['link']);
            }

            // To extract the youtube id from the link
            $youtube_id = $this->getYoutubeId($carousel['link']['url']);

            $youtube_embedded_link = 'https://www.youtube.com/embed/' . $youtube_id;

            echo '<div class="carousel-item swiper-slide">'; // Wrapper for each carousel item

            echo '<div class="first-column">';
            echo '<div class="carousel-content">';

            // Show a quotation mark svg only if the description is present
            if ($carousel['carousel_title']) {
                echo useSVG('quotation-marks');
            }
            echo '<div class="carousel-description">';
            echo esc_html($carousel['carousel_description']);
            echo '</div>'; // End description

            echo '<div class="author-name">' . esc_html($carousel['carousel_title']) . '</div>'; // Author name - title
            echo '</div>'; // End content section

            echo '</div>'; // End first column

            // Image column
            echo '<div class="second-column">';
            echo '<div id="' . '" class="carousel-image-container">';
            if (!empty($carousel['image_content']['url'])) {
                echo '<img src="' . esc_url($carousel['image_content']['url']) . '" alt="' . esc_attr($carousel['carousel_title']) . '">';
            }
            echo '</div>'; // End image container
            if ($does_link_exist) {
                echo '<a class="youtube-link popup-trigger" data-youtube-id=' . $youtube_id . '>';
                echo '<span class="youtube-link__icon">' . useSVG('youtube-icon') . '</span>';
                echo '<span class="youtube-link__label">' . esc_html($carousel['button_text']) . '</span>';
                echo '</a>';
            }
            echo '</div>'; // End image column

            // For the video pop-up
            // echo '<div class="video-modal">';
            // echo '<iframe src="' . esc_url($youtube_embedded_link) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            // echo '</div>'; // End the video-pop-up container

            echo '</div>'; // End carousel item wrapper
        }
        echo '</div>'; // Ending main swiper container
        echo '</div>'; // Ending swiper-wrapper div

        echo '<div class="carousel-arrows">'; // For the two arrows
        echo '<div class="pagination-btn prev-btn">';
        echo useSVG('carousel-arrow');
        echo '</div>';
        echo '<div class="pagination-btn next-btn">';
        echo useSVG('carousel-arrow');
        echo '</div>';
        echo '</div>'; // End carousel arrows


        /**
         * We loop through the slides again for the video modals and place them outside the swiper.
         * This is is because swiper js uses css transforms to change slides, and if a transform is
         * used on any of the parent containers, an element with fixed positioning behaves like 
         * and absolute element and gets placed on top of the swiper.
         */
        foreach ($settings['carousel'] as $index => $carousel) {
            $link_key = 'link_' . $index;
            $does_link_exist = ! empty($carousel['link']['url']);
            $youtube_id = $this->getYoutubeId($carousel['link']['url']);
            $youtube_embedded_link = 'https://www.youtube.com/embed/' . $youtube_id;

            if (! $does_link_exist) {
                return;
            }

            echo '<div class="video-modal" data-youtube-id=' . $youtube_id . '>';
            echo '<div class="video-modal__overlay">';
            echo '<div class="iframe-container">';
            echo '<frame_video src="' . esc_url($youtube_embedded_link) . '" class="inner-iframe"></frame_video>';
            echo '</div>'; // End the iframe container
            echo '</div>'; // End the overlay container
            echo '</div>'; // End the video-pop-up container
        }
        echo '</div>';
?>
<?php
    }
}
