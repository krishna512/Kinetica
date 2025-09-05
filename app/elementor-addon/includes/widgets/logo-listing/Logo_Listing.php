<?php
if (!defined('ABSPATH')) {
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
class Elementor_Logo_Listing extends \Elementor\Widget_Base
{
    use LogoControlTrait;
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
        return 'logos';
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
        return esc_html__('Logos List', 'elementor-list-widget');
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
        return ['logo-style', 'slick-cdn'];
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
        return ['gsap-cdn', 'logo-list', 'slick-cdn'];
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
        return 'eicon-bullet-list';
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
        /**
         * Gallery Control
         */
        $this->contentTabControls();
        /**
         * Style Tab
         */
        $this->styleTabControls();
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
        $title = $settings['title'];
        $gallery = $settings['gallery'];
?>
        <div class="slick-wrapper">
            <div class="logo-list js-logo-carousel">
                <?php
                foreach ($gallery as $image) {
                    echo '<div class="logo px-[30px]">';
                    echo wp_get_attachment_image($image['id'], "full", false, array("class" => ""));
                    echo '</div>';
                }
                ?>
            </div>
            <?php
            if (!empty($title)) {
                echo '<p class="description">' . $title . '</p>';
            }
            ?>
        </div>
<?php
    }
}
