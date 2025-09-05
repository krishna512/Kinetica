<?php

use ElementorPro\Plugin;

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

class Code_Highlight extends \Elementor\Widget_Base
{

    use HighlightControlTrait;

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
        return 'kinetica-code-highlight';
    }

    public function get_title()
    {
        return esc_html__('Highlight Source Shell', 'elementor-pro');
    }

    public function get_icon()
    {
        return 'eicon-code-highlight';
    }

    public function get_keywords()
    {
        return ['code', 'highlight'];
    }

    public function get_style_depends()
    {
        return ['highlight-cdn-css', 'highlight-source-shell', 'kinetica-code-highlight'];
    }

    public function get_categories()
    {
        return ['kinetica'];
    }

    public function get_script_depends()
    {
        return ['highlight-cdn', 'highlight-source-shell', 'kinetica-code-highlight'];
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

        $this->contentTab();
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
        <div class="highlight highlight-source-shell">
            <div class="code-wrapper">
                <pre class="hljs language-sql"><?php echo $settings['code'] ?></pre>
            </div>
            <div class="js-clipboard-copy">
                <div class='flex gap-x-1 items-center'>
                    <span class="copy-icon"><?php echo useSVG('copy') ?></span>
                    <span class="label"> Copy </span>
                </div>
            </div>
        </div>
    <?php
    }

    protected function content_template()
    {
    ?>
        <div class="highlight highlight-source-shell">
            <pre>{{{ settings.code }}}</pre>

            <div class="js-clipboard-copy">
                <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path
                        d="M21.3385 17.2052v5.6c0 4.6667-1.8666 6.5333-6.5333 6.5333h-5.6c-4.6667 0-6.5333-1.8666-6.5333-6.5333v-5.6c0-4.6667 1.8666-6.5333 6.5333-6.5333h5.6c4.6667 0 6.5333 1.8666 6.5333 6.5333Z"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M29.3385 9.2052v5.6c0 4.6667-1.8666 6.5333-6.5333 6.5333h-1.4667v-4.1333c0-4.6667-1.8666-6.5333-6.5333-6.5333h-4.1333V9.2052c0-4.6667 1.8666-6.5333 6.5333-6.5333h5.6c4.6667 0 6.5333 1.8666 6.5333 6.5333Z"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
<?php
    }
}
