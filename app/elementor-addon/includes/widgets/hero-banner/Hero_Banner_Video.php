<?php

use Elementor\Group_Control_Image_Size;

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

class Hero_banner_video extends \Elementor\Widget_Base
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
        return 'hero-slider-video';
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
        return esc_html__('Hero Slider with Video', 'HelloElementorChild');
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
            'hero-banner-video',
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
            'hero-banner-video',
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

        // video thumbnail
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', \Elementor\Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', \Elementor\Control_Media::get_image_title($settings['image']));
        $this->add_render_attribute('image', 'class', 'kinetica__video--thumbnail-image');

        // video url
        $video_url = $settings['video']['url'];

        // To change the cursor if there is no video
        if (empty($video_url)) {
            $this->add_render_attribute('image', 'style', 'cursor: default;');
        }

        // button
        if (! empty($settings['slider_button_url']['url'])) {
            $this->add_link_attributes('slider_button_url', $settings['slider_button_url']);
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

                    // Pattern to match the last closing </p> tag followed by optional whitespace at the end of the string
                    $pattern_last_p = '/<\ /p>\s*$/';

                    // Remove the last closing </p> tag if pattern is valid
                    if (@preg_match($pattern_last_p, '') !== false) {
                        $banner_title = preg_replace($pattern_last_p, '', $banner_title);
                    }

                    // Patterns for replacing other <p> tags and </p> tags
                    $pattern_open_p = '/<p[^>]*>/'; // Matches opening <p> tags (with or without attributes)
                    $pattern_close_p = '/<\ /p>/'; // Matches closing </p> tags

                    // Ensure both patterns are valid before applying the replacements
                    if (@preg_match($pattern_open_p, '') !== false && @preg_match($pattern_close_p, '') !== false) {
                        // Replace opening <p> tags with nothing and closing </p> tags with <br>
                        $banner_title = preg_replace(
                            [$pattern_open_p, $pattern_close_p],
                            ['', '<br>'],
                            $banner_title
                        );
                    }
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
                            <div class="kinetica__content--previous"><?php echo useSvg('arrow-right-pagination'); ?>
                            </div>
                            <div class="kinetica__content--pagination"></div>
                            <div class="kinetica__content--next"><?php echo useSvg('arrow-right-pagination'); ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    /**
                     * Try free button
                     */

                    if ($settings['slider_button_text']) {
                    ?>
                        <div class="kinetica__content--try-free primary-btn-fill">
                            <a <?php $this->print_render_attribute_string('slider_button_url'); ?>>
                                <?php echo $settings['slider_button_text']; ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
            /**
             * Right Column
             */
            ?>
            <div class="kinetica__video">
                <div class="kinetica__video--wrapper">
                    <?php
                    /**
                     * Video Player
                     */
                    ?>
                    <div class="hidden kinetica__video--player">
                        <a href="javascript:void(0);" class="kinetica__video--close">
                            <?php echo useSVG('close'); ?>
                        </a>
                        <video class="kinetica__video--controls" controls preload="none">
                            <source src="<?php echo esc_attr($video_url); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>

                    <?php
                    /**
                     * Image overlay
                     */
                    ?>
                    <div class="kinetica__video--thumbnail">
                        <?php echo '<img ' . $this->get_render_attribute_string('image') . '>'; ?>

                        <?php if ($video_url) { ?>
                            <a href="javascript:void(0);" class="kinetica__video--playbtn">
                                <?php echo useSVG('play'); ?>
                                Watch Video
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
