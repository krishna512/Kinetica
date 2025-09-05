<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

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

class Cube_3D extends \Elementor\Widget_Base
{

    use CubeControlTrait;

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
        return 'cube-3D';
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
        return esc_html__('3D Cube', 'HelloElementorChild');
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
        return ['cube-3D'];
    }

    /**
     * Script Dependencies
     *
     * @since 1.0.0
     * @access public
     * @return array Widget title.
     */
    // public function get_script_depends()
    // {
    //     $depends = [];

    //     return $depends;
    // }

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
        return 'eicon-navigator';
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
        return ['3D', 'cube', 'list', 'lists'];
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
        $this->sectionCube();

        $this->sectionContent();

        $this->sectionTitles();

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
        $leftRepeater = $settings['left_repeater'];
        $rightRepeater = $settings['right_repeater'];

        $title_1 = $settings['title_1'];
        $title_2 = $settings['title_2'];
        $title_3 = $settings['title_3'];
        $title_4 = $settings['title_4'];
?>
        <div class="cube">

            <?php
            /**
             * Left Content Grouped
             */
            ?>
            <div class="cube__left">
                <div class="cube__left-list">
                    <?php
                    if ($leftRepeater) {
                        echo '<div class="cube__list">';
                        foreach ($leftRepeater as $index => $item) {
                            $link_key = 'link_' . $index;

                            if (! empty($item['repeater_link']['url'])) {
                                $this->add_link_attributes($link_key, $item['repeater_link']);
                            }

                            echo "<a " . $this->get_render_attribute_string($link_key) . "class=\"cube__list-item cube__list-item-" . esc_attr($item["_id"]) . "\">";
                            echo '<div class="cube__list-icon">';
                            Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                            echo '</div>';
                            echo '<div class="cube__list-title">' . $item['repeater_title'] . '</div>';
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="cube__left-brace cube__right-brace">
                    <div class="brace-left">
                        <div class="brace-top"></div>
                        <div class="brace-bottom"></div>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Center Content Grouped
             */
            ?>
            <div class="cube__center">
                <div class="cube__title left">
                    <div><?php echo $title_1; ?></div>
                    <div><?php echo $title_2; ?></div>
                </div>
                <?php
                /**
                 * Image setting
                 */
                if ($settings['image']['url']) { ?>
                    <div class="cube__animation">
                        <?php
                        $this->add_render_attribute('image', 'src', $settings['image']['url']);
                        $this->add_render_attribute(
                            'image',
                            'alt',
                            Control_Media::get_image_alt($settings['image'])
                        );
                        $this->add_render_attribute('image', 'title', Control_Media::get_image_title(
                            $settings['image']
                        ));
                        $this->add_render_attribute('image', 'width', '188px');
                        echo Group_Control_Image_Size::get_attachment_image_html($settings, 'full', 'image');
                        ?>
                    </div>
                <?php } ?>
                <div class="cube__title right">
                    <div><?php echo $title_3; ?></div>
                    <div><?php echo $title_4; ?></div>
                </div>
            </div>

            <?php
            /**
             * Right Content Grouped
             */
            ?>
            <div class="cube__right">
                <div class="cube__right-brace">
                    <div class="brace-left">
                        <div class="brace-top"></div>
                        <div class="brace-bottom"></div>
                    </div>
                </div>
                <div class="cube__right-list">
                    <?php
                    if ($rightRepeater) {
                        echo '<ul class="cube__list">';
                        foreach ($rightRepeater as $item) {
                            $link_key = 'link_' . $index;

                            if (! empty($item['repeater_link']['url'])) {
                                $this->add_link_attributes($link_key, $item['repeater_link']);
                            }

                            echo "<a " . $this->get_render_attribute_string($link_key) . "class=\"cube__list-item cube__list-item-" . esc_attr($item["_id"]) . "\">";
                            echo '<div class="cube__list-icon">';
                            Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']);
                            echo '</div>';
                            echo '<div class="cube__list-title">' . $item['repeater_title'] . '</div>';
                            echo '</a>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
<?php
    }
}
