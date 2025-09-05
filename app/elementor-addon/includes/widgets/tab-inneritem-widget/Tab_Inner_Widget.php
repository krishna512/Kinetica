<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/TabInnerControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Tab_InnerItem_Widget extends \Elementor\Widget_Base
{

    use TabInnerControlTrait;

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
        return 'tab-inner-card';
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
        return esc_html__('Tab With Inner Content', 'HelloElementorChild');
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
        return ['tab-inner-widget'];
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
        return ['gsap-cdn', 'tab-inner-widget'];
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
        return 'eicon-flip-box';
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
        return ['tab', 'cards'];
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
        $heading = $settings['heading'];
        $sub_heading = $settings['sub_heading'];

?>

        <div class="nested-tab-widget">
            <!-- Centered section containing title, subtitle and primary tabs -->
            <div class="tabs__header">
                <div class="title-text">
                    <h3> <?php echo esc_html($heading); ?></h3>
                    <p> <?php echo esc_html($sub_heading); ?></p>
                </div>

                <!-- For the tabs -->
                <div class="primary-tabs-container">
                    <?php foreach ($settings['tabs'] as $index => $tab) { ?>
                        <button
                            class="primary-tab tab-button<?php echo $index === 0 ? ' active' : ''; ?>"><?php echo esc_html($tab['tab_title']); ?></button>
                    <?php } ?>
                </div>
            </div>

            <!-- Main content in which all the contents of the primary tabs overlap with each other -->
            <section class="main-content">
                <!-- We require two nested for loops for this: one for the primary tab containers and for the inner ones -->
                <?php foreach ($settings['tabs'] as $index => $tab) { ?>
                    <div class="primary-tab-contents">
                        <!-- Within the primary tab contents, there are two columns: one for the nested tabs list and the other for the corresponding image -->
                        <?php if (!empty($tab['tab_items'])) { ?>
                            <div class="inner-tabs-list">
                                <?php foreach ($tab['tab_items'] as $item) { ?>
                                    <div class="inner-tab">
                                        <div class="inner-tab__first-row">
                                            <?php if (!empty($item['item_icon'])) { ?>
                                                <div class="inner-tab__icon">
                                                    <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="inner-tab__title">
                                                <?php echo esc_html($item['item_title']); ?>
                                            </div>

                                        </div>
                                        <div class="accordion">
                                            <!-- Required div for the accordion -->
                                            <div>
                                                <div class="inner-tab__description">
                                                    <?php echo esc_html($item['item_description']); ?>
                                                </div>
                                                <!-- Mobile image -->
                                                <div class="inner-tab__image--mobile">
                                                    <img src="
                                                    <?php echo esc_url($item['item_image']['url']); ?>"
                                                        alt="<?php echo esc_attr($item['item_title']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="inner-tabs-image">
                                <?php foreach ($tab['tab_items'] as $item) { ?>
                                    <div class="inner-tab__image--desktop">
                                        <img src="<?php echo esc_url($item['item_image']['url']); ?>"
                                            alt="<?php echo esc_attr($item['item_title']); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </section>
        </div>
<?php
    }
}
