<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/ContentControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Content_Widget extends \Elementor\Widget_Base
{

    use ContentControlTrait;

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
        return 'content-carousel';
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
        return esc_html__('Content With Image Carousel', 'HelloElementorChild');
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
        return ['content-widget', 'content-carousel', 'content-card'];
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
        return ['gsap-cdn', 'content-carousel', 'content-widget', 'swiper-cdn'];
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
        return ['content', 'carousel'];
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
?>
        <div class='content-carousel'>
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($settings['carousel'] as $index => $carousel) {

                        $link_key = 'link_' . $index;
                        $does_link_exist = ! empty($carousel['link']['url']);

                        if (! empty($carousel['link']['url'])) {
                            $this->add_link_attributes($link_key, $carousel['link']);
                        } ?>
                        <div class="carousel-item swiper-slide">
                            <div class="first-column">
                                <div class="carousel-content">
                                    <div class="carousel-title">
                                        <?php echo esc_html($carousel['carousel_title']); ?>
                                    </div>
                                    <div class="carousel-description">
                                        <?php echo esc_html($carousel['carousel_description']); ?>
                                    </div>
                                    <?php
                                    if ($does_link_exist) {
                                        echo '<a class="elementor-button" ' . $this->get_render_attribute_string($link_key) . '>';
                                        echo '<span class="youtube-link__label">' . esc_html($carousel['button_text']) . '</span>';
                                        echo '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="second-column">
                                <div class="carousel-image-container">
                                    <?php
                                    if (!empty($carousel['image_content']['url'])) {
                                        echo '<img src="' . esc_url($carousel['image_content']['url']) . '" alt="' . esc_attr($carousel['carousel_title']) . '">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination swiper-pagination--desktop"></div>
            </div>

            <div class="navigation-mobile-container">
                <div class="navigation navigation--mobile navigation-prev">
                    <?php echo useSVG('carousel-arrow') ?>
                </div>
                <div class="swiper-pagination swiper-pagination--mobile"></div>
                <div class="navigation navigation--mobile navigation-next">
                    <?php echo useSVG('carousel-arrow') ?>
                </div>
            </div>

            <div class="navigation navigation--desktop navigation-prev">
                <?php echo useSVG('carousel-arrow') ?>
            </div>
            <div class="navigation navigation--desktop navigation-next">
                <?php echo useSVG('carousel-arrow') ?>
            </div>
        </div>

<?php
    }
}
