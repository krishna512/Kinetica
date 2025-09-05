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

class New_Hero_banner extends \Elementor\Widget_Base
{

    use NewHeroControlTrait;

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
        return esc_html__('Hero Banner', 'HelloElementorChild');
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
            'new-hero-banner',
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
            'new-hero-banner',
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

        // //Content Repeater
        // $this->sectionContent();
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
        <div class="animated-card-widget new-hero-banner">
            <?php if (! empty($settings['main_heading'])) : ?>
                <h1 class="main-title"><?php echo ($settings['main_heading']); ?></h1>
            <?php endif; ?>

            <div class="background-wrapper">
                <?php if ($settings['use_lottie'] === 'yes' && !empty($settings['lottie_url'])): ?>
                    <lottie-player src="<?php echo esc_url($settings['lottie_url']); ?>" background="transparent" speed="1" loop
                        autoplay></lottie-player>
                <?php elseif (!empty($settings['vector_image']['url'])): ?>
                    <img src="<?php echo esc_url($settings['vector_image']['url']); ?>" class="background-image" alt="Background" />
                <?php endif; ?>
            </div>

            <div class="card-list">
                <?php foreach ($settings['cards'] as $item) :
                    $link = isset($item['card_link']['url']) ? $item['card_link']['url'] : '';
                    $is_external = !empty($item['card_link']['is_external']) ? ' target="_blank"' : '';
                    $nofollow = !empty($item['card_link']['nofollow']) ? ' rel="nofollow"' : '';
                ?>
                    <div class="card-item">
                        <?php if ($link) : ?>
                            <a class='card-link' href="<?php echo esc_url($link); ?>" <?php echo $is_external . $nofollow; ?>>
                            <?php endif; ?>

                            <?php if (!empty($item['card_image']['url'])) : ?>
                                <img src="<?php echo esc_url($item['card_image']['url']); ?>"
                                    alt="<?php echo esc_attr($item['card_title']); ?>" class="card-icon" />
                            <?php endif; ?>

                            <h4 class='card-title'><?php echo esc_html($item['card_title']); ?></h4>

                            <div class="arrow-container">
                                <span> Learn more </span>
                                <?php echo useSVG('arrow-right-card'); ?>
                            </div>

                            <?php if ($link) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
