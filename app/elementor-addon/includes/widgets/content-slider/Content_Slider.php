<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once (__DIR__ . '/ControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Content_Slider extends \Elementor\Widget_Base
{

    use ControlTrait;

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
        return 'content-slider';
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
        return esc_html__('Content Slider', 'HelloElementorChild');
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
            // 'prismjs_style', 
            'content-slider'
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
            'content-slider',
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
        return ['images', 'list', 'lists', 'ordered', 'unordered'];
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

        // Title Styles
        $this->titleStyles();

        //Content Styles
        $this->contentStyles();

        // Code Styles
        $this->codeStyles();

        // Slider Styles
        $this->sliderStyles();

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

        if ($settings['slider']) { ?>
            <div class="animating-slider">

                <?php
                /**
                 * title slider
                 */
                ?>

                <div class="swiper text-swiper swiper-no-swiping">
                    <div class="swiper-wrapper">
                        <?php foreach ($slider as $item) { ?>
                            <div class="swiper-slide">
                                <h1 class="slider_title">
                                    <?php echo $item['slider_title']; ?>
                                </h1>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                /**
                 * animating progress bar 
                 */
                ?>
                <div class="slider-progress-bar">
                    <div class="progress">
                        <progress class="bar" value="0" max="100"></progress>
                        <progress class="bar" value="0" max="100"></progress>
                        <progress class="bar" value="0" max="100"></progress>
                    </div>
                    <div class="dropdown_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 11" height="1em">
                            <path
                                d="m9.91399 9.78234 5.56491-5.5649c1.2599-1.25993.3676-3.414217-1.4142-3.414217H2.93487c-1.78181 0-2.67414 2.154287-1.41421 3.414217l5.56491 5.5649c.78105.78106 2.04738.78106 2.82842 0Z" />
                        </svg>
                    </div>

                    <?php
                    /**
                     * Slider Jump / Navigation
                     */

                    if ($settings['slider']) { ?>
                        <div class="custom-select">
                            <div class="placeholder">
                                <div class="empty-space"></div>
                            </div>
                            <div class="dropdown" style="display: none;">
                                <?php foreach ($slider as $key => $item) { ?>
                                    <a href="#" class="jumpTo" data-number="<?php echo $key; ?>">
                                        <?php echo $item['slider_title']; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                /**
                 * content slider 
                 */
                ?>
                <div class="slider-content swiper content-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($slider as $item) { ?>
                            <div class="swiper-slide">
                                <div class="content">
                                    <?php echo $item['slider_content']; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <?php
                /**
                 * Code slider
                 */
                ?>

                <div class="slider-code swiper code-swiper">
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

                    <div class="tutorial-link">
                        <a href="<?php echo $slider[0]['tutorial_link']['url'] ?>">
                            <span>Explore tutorial</span>
                            <?php echo useSvg('arrow-right'); ?>
                        </a>
                    </div>
                </div>
            </div>

        <?php } else {
            echo esc_html__('Please add data into the slider', 'HelloElementorChild');
        }
    }

    protected function playPauseIcon()
    { ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 22" height="1em">
            <rect width="20" height="20" x=".5" y="1" fill="#1A1E19" stroke="currentColor" rx=".5" />
            <path class="pause-icon" fill="#E6D9EE"
                d="M12.8597 17.0002c-.1215-.036-.2466-.0588-.361-.1078-.5862-.2547-.8615-.6857-.8615-1.2735V6.39118c0-.46367.1716-.85224.5862-1.12653.4647-.30694.9723-.34939 1.4871-.11428.5076.23183.7864.62694.7864 1.14612.0072 3.13796.0036 6.27591 0 9.41391 0 .6204-.4933 1.1526-1.1582 1.2669-.025.0033-.0464.0163-.0715.0229h-.411.0035ZM7.72967 16.9985c-.24307-.0588-.48257-.1273-.68275-.2775-.35032-.258-.54335-.5911-.54692-1.0025V6.28177c0-.66613.61841-1.24735 1.32618-1.27347.80787-.02613 1.45845.47673 1.52279 1.18204.00715.06857.01073.14041.01073.20898v9.20488c0 .5355-.22163.9568-.73638 1.2245-.14655.0784-.32171.1143-.48614.1665h-.41109l.00358.0033Z" />
            <path class="play-icon"
                d="M6 6.91493V14.0861C6 15.5548 7.59608 16.4764 8.86995 15.7421L11.9797 13.9512L15.0894 12.1528C16.3633 11.4184 16.3633 9.58256 15.0894 8.84821L11.9797 7.04981L8.86995 5.2589C7.59608 4.52455 6 5.43874 6 6.91493Z"
                fill="#E6D9EE" style="display: none;" />
        </svg>
        <?php
    }

}