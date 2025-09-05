<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/ControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Hero_banner extends \Elementor\Widget_Base
{

    use HeroControlTrait;

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
        return 'hero-slider';
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
        return esc_html__('Hero Slider', 'HelloElementorChild');
    }


    /**
     * Style Dependencies
     *
     * @since 1.0.0
     * @access public
     * @return array Widget title.
     */
    public function get_style_depends()
    {
        return [
            'swiper-cdn',
            'hero-banner',
        ];
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
        $depends = [
            'swiper-cdn',
            'gsap-cdn',
            'hero-banner',
        ];

        return $depends;
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
        return ['hero', 'images', 'list', 'lists', 'ordered', 'unordered'];
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

        //Content Repeater
        $this->sectionContent();

        //Animation Speed Controls
        $this->animationSpeed();

        $this->headingStyles();

        // Title Styles
        $this->titleStyles();

        //Content Styles
        $this->contentStyles();

        // Code Styles
        // $this->codeStyles();

        // Slider Styles
        // $this->sliderStyles();

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

        $slider = $settings['slider'];

        if (! empty($settings['tutorial_link']['url'])) {
            $this->add_link_attributes('tutorial_link', $settings['tutorial_link']);
        }

        ?>
        <div class="kinetica__hero_slider">

            <?php
            /**
             * Left Column
             */
            ?>
            <div class="kinetica__content">
                <div class="kinetica__content--wrapper">

                    <?php

                    /**
                     * <h1><?php echo strip_tags($settings['banner_title'], '<span><a><strong><br>'); ?></h1>
                     */
                    $banner_title = $settings['banner_title'];

                    // Remove the last closing </p> tag
                    $banner_title = preg_replace('/<\/p>\s*$/', '', $banner_title);

                    // Replace all other closing </p> tags with <br> and remove opening <p> tags
                    $banner_title = preg_replace(
                        ['/<p[^>]*>/', '/<\/p>/'],
                        ['', '<br>'],
                        $banner_title
                    );
                    ?>

                    <h1><?php echo $banner_title; ?></h1>

                    <?php
                    /**
                     * Text Slider
                     */
                    ?>
                    <?php if ($slider) { ?>
                        <div class="kinetica__content--titleswiper swiper swiper-no-swiping">
                            <div class="swiper-wrapper">
                                <?php foreach ($slider as $item) { ?>
                                    <div class="swiper-slide kinetica__content--item">
                                        <h2 class="kinetica__content--title">
                                            <?php echo $item['slider_title']; ?>
                                        </h2>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    /**
                     * Content Slider
                     */
                    ?>
                    <?php if ($slider) { ?>
                        <div class="kinetica__content--swiper swiper swiper-no-swiping">
                            <div class="swiper-wrapper">
                                <?php foreach ($slider as $item) { ?>
                                    <div class="swiper-slide kinetica__content--item">
                                        <div class="content">
                                            <?php echo $item['slider_content']; ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="kinetica__content--paginationwrapper">
                            <div class="kinetica__content--previous"><?php echo useSvg('arrow-right-pagination'); ?></div>
                            <div class="kinetica__content--pagination"></div>
                            <div class="kinetica__content--next"><?php echo useSvg('arrow-right-pagination'); ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
            /**
             * Right Column
             * Code Slider
             */
            ?>
            <div class="kinetica__code">
                <div class="kinetica__code--wrapper">

                    <?php
                    //<div class="kinetica__code--border"></div>
                    //<div class="kinetica__code--border-animation"></div>
                    ?>

                    <div class="kinetica__border">
                        <?php
                        /**
                         * First border animation
                         */
                        ?>
                        <div class="kinetica__border-glow"></div>
                        <div class="kinetica__border-box"></div>

                        <?php
                        /**
                         * Second border animation
                         */
                        ?>
                        <div class="kinetica__border-glow opposite"></div>
                        <div class="kinetica__border-box opposite"></div>
                    </div>


                    <?php
                    /**
                     * Swiper slider
                     */
                    ?>
                    <div class="kinetica__code--swiper swiper">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($slider as $item) {
                                ?>
                                <div class="swiper-slide">
                                    <div class="link" data-link="<?php echo $item['tutorial_link']['url']; ?>"></div>
                                    <?php echo '<div class="code-snippet-wrapper"><div class="custom-scroll-bar">' . do_shortcode('[dm_code_snippet background="no" background-mobile="no" slim="yes" line-numbers="no" theme="dark" language="sql" wrapped="yes" copy-text="" copy-confirmed=""]'
                                        . '<pre class="slider-code"> ' . $item['sql_code'] . '</pre>' . '[/dm_code_snippet]') . '</div></div>'; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="kinetica__code--tutorial-link">
                    <a href="<?php echo $slider[0]['tutorial_link']['url'] ?>">
                        <span>Explore tutorial</span>
                        <?php echo useSvg('arrow-right'); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
}