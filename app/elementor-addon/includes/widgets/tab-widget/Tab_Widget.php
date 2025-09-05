<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/TabControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Tab_Widget extends \Elementor\Widget_Base
{

    use TabControlTrait;

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
        return 'tab-card';
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
        return esc_html__('Tab With Content', 'HelloElementorChild');
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
        return ['tab-widget'];
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
        return ['gsap-cdn', 'tab-card', 'tab-widget'];
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
        $button_text = $settings['button_text'];
        $link = $settings['link'];
        $link = is_array($link) ? implode('', $link) : $link;
        $paragraph = $settings['paragraph'];


        // $card_data = array_reverse(get_tab_widget_data());

        echo '<div class="custom-tabs">';
        echo '<div class="title-text title-text--mobile">';
        echo '<h3>' . $heading . '</h3>';
        echo '<p>' . $sub_heading . '</p>';
        echo '</div>'; // Ending title text container
        echo '<div class="first-column">';
        echo '<div class="title-text title-text--desktop">';
        echo '<h3>' . $heading . '</h3>';
        echo '<p>' . $sub_heading . '</p>';
        echo '</div>'; // Ending title text container
        echo '<div class="tabs-list">';
        foreach ($settings['tabs'] as $index => $tab) {
            $tab_id = 'custom-tab-' . $index;
            echo '<div class="tab">';
            echo '<div class="tab__first-row">';
            echo '<div class="tab__icon-and-title">';
            echo '<div class="tab__list-icon">';
            Icons_Manager::render_icon($tab['tab_icon'], ['aria-hidden' => 'true']);
            echo '</div>';
            echo '<span class="tab__list-title">' . esc_html($tab['tab_title']) . '</span>';
            echo '</div>'; // End the icon and title container
            echo '<div class="tab__caret">';
            echo useSVG('accordion-caret');
            echo '</div>';
            echo '</div>'; // End the first row

            echo '<div class="accordion description__list-title">';
            echo '<div>'; // Mandatory single div inside the accordion
            echo esc_html($tab['tab_description']);

            // Display the tab images within the tab itself on smaller screens
            echo '<div id="' . esc_attr($tab_id) . '" class="tab__animation mobile">';
            echo '<img src="' . esc_url($tab['image_content']['url']) . '" alt="' . esc_attr($tab['tab_title']) . '">';
            echo '</div>'; // End the mobile view image container
            echo '</div>'; // End the inner div of the accordion
            echo '</div>'; // End the accordion
            echo '</div>'; // End the tab itself
        }
        echo '</div>'; // Ending tabs list container

        echo '<div class="custom-tabs__cta">';

        if ($paragraph) {
            echo '<p>' . $paragraph . '</p>';
        }

        if ($button_text) {
            echo '<a href="' . $link . '">' . $button_text . '</a>';
        }
        echo '</div>'; // Ending cta container
        echo '</div>'; // Ending first column container


        echo '<div class="custom-tab-contents">';

        foreach ($settings['tabs'] as $index => $tab) {
            $tab_id = 'custom-tab' . $index;
            echo '<div id="' . esc_attr($tab_id) . '" class="tab__animation desktop">';

            echo '<img src="' . esc_url($tab['image_content']['url']) . '" alt="' . esc_attr($tab['tab_title']) . '">';

            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
?>



<?php
    }
}
