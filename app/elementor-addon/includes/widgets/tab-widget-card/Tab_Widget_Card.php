<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/TabCardControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Tab_Widget_Card extends \Elementor\Widget_Base
{

    use TabCardControlTrait;

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
        return 'image-with-cards';
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
        return esc_html__('Image With Card', 'HelloElementorChild');
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
        return ['image-with-cards'];
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
        return ['gsap-cdn', 'image-with-cards', 'tab-widget-card'];
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
        return ['image', 'cards'];
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
        $image_content = $settings['image_content'];

        $sub_heading = $settings['sub_heading'];
        $paragraph = $settings['paragraph'];
        $survey = $settings['survey'];
?>

        <div class='image-with-cards'>
            <div class="grid-system">
                <div class="first-column">
                    <div class="title-text">
                        <h3><?php echo $heading; ?></h3>
                    </div>
                    <div class="image-container">
                        <?php
                        if (!empty($settings['image_content']['url'])) {
                            echo '<img src="' . esc_url($settings['image_content']['url']) . '" alt="' . esc_attr($settings['heading']) . '">';
                        }
                        ?>
                    </div>
                </div>
                <div class="second-column">
                    <div class="tabs-list">
                        <?php
                        foreach ($settings['tabs'] as $index => $tab) {
                            $tab_id = 'custom-tab-' . $index;
                        ?>
                            <a class="tab" href="<?php echo $tab['link']['url']; ?>">
                                <div class="tab__inner">
                                    <div class="tab__first-row">
                                        <div class="tab__icon">
                                            <?php Icons_Manager::render_icon($tab['tab_icon'], ['aria-hidden' => 'true']); ?>
                                        </div>
                                        <div class='tab__body'>
                                            <div class='tab__title'>
                                                <?php echo esc_html($tab['tab_title']); ?>
                                            </div>
                                            <div class="tab__description">
                                                <?php echo esc_html($tab['tab_description']); ?>
                                            </div>
                                            <div class="tab__learn-more">
                                                <div class="arrow-container">
                                                    <?php echo '<span class="label-text">' . $tab['button_text'] . '</span>' . '<span>' . useSVG('arrow-right-card') . '</span>'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="grid-system">
                <div class="first-column">
                    <p class='sub-heading'>
                        <?php echo $sub_heading; ?>
                    </p>
                </div>

                <div class="second-column">
                    <p class='paragraph'>
                        <?php echo $paragraph; ?>
                    </p>
                </div>
            </div>

            <div class='survey'>
                <?php echo $survey; ?>
            </div>
        </div>
<?php
    }
}
