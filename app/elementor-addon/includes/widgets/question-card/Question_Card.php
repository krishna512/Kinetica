<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/QuestionsControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Question_Cards extends \Elementor\Widget_Base
{

    use QuestionsControlTrait;

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
        return 'question-card';
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
        return esc_html__('Question Cards', 'elementor-list-widget');
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
        return ['question-card'];
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
        return ['gsap-cdn', 'question-card'];
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
        return ['question', 'cards'];
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
        $card_data = array_reverse(get_questions_card_data());

        $pass_mark = (int)$settings['pass_mark'];
        if (!$pass_mark) {
            $pass_mark = 40;
        }
        $pass_label = ($settings['pass_label']) ?: "Book a Demo";
        $fail_label = ($settings['fail_label']) ?: "Try Free";

        $pass_result_info = ($settings['pass_result_info']) ?: "Your score is";
        $pass_result_info = str_replace("{pass_mark}", $pass_mark, $pass_result_info);
        $fail_result_info = ($settings['fail_result_info']) ?: "Your score is";
        $fail_result_info = str_replace("{pass_mark}", $pass_mark, $fail_result_info);

        // Link 
        if (! empty($settings['pass_redirect_url']['url'])) {
            $this->add_link_attributes('pass_redirect_url', $settings['pass_redirect_url']);
        }
        if (! empty($settings['fail_redirect_url']['url'])) {
            $this->add_link_attributes('fail_redirect_url', $settings['fail_redirect_url']);
        }

?>
        <div class="question-section__container">
            <h3 class="question-section-title "><?php echo $settings['title']; ?></h3>
            <p class="question-section-description"><?php echo $settings['excerpt']; ?></p>
            <div class="questionCards">
                <div class="questionCards__level">
                    <span class='level'>Level 1</span>
                    <span class='question-counter'>
                        <span id='level-counter'>1 </span> / <span id='level-total-counter'>5</span>
                    </span>
                </div>
                <div class="questionCards__questions">
                    <div class="questionCards__score--card">
                        <div id="score-info">
                            <p id="pass_result_info" style="display:none;"><?php echo $pass_result_info; ?></p>
                            <p id="fail_result_info" style="display:none;"><?php echo $fail_result_info; ?></p>
                        </div>
                        <h6 id="total-score" pass_mark="<?php echo $pass_mark; ?>">0</h6>
                        <div id="pass-result-item" style="display:none;">
                            <a <?php $this->print_render_attribute_string('pass_redirect_url'); ?>>
                                <button><?php echo $pass_label; ?></button>
                            </a>
                        </div>
                        <div id="fail-result-item" style="display:none;">
                            <a <?php $this->print_render_attribute_string('fail_redirect_url'); ?>>
                                <button><?php echo $fail_label; ?></button>
                            </a>
                        </div>
                    </div>
                    <?php
                    foreach ($card_data as $key => $card) {
                    ?>
                        <div class="questionCards__questions--card" data-id="<?php echo $card['id']; ?>"
                            data-level="<?php echo $card['level_name']; ?>" initial-level-action="">
                            <?php echo $card['title']; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="selector__container">
                    <div class="selector__no">
                        <div></div>
                        <div>no</div>
                    </div>
                    <div class="selector__yes">
                        <div></div>
                        <div>yes</div>
                    </div>

                    <div class="questionCards__navigation">
                        <button id='card-no-btn'></button>
                        <button id='card-yes-btn'></button>
                    </div>
                    <div class="questionCards__hover">

                        <div class="button-hover"></div>
                        <div class="button-hover"></div>
                    </div>
                </div>
                <button class="restart__button">
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.666 8A6.669 6.669 0 0 1 8 14.667c-3.68 0-5.927-3.707-5.927-3.707m0 0h3.013m-3.013 0v3.333M1.333 8c0-3.68 2.96-6.667 6.667-6.667 4.446 0 6.666 3.707 6.666 3.707m0 0V1.707m0 3.333h-2.96"
                            stroke="#D39AFF" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div>Restart</div>
                </button>
            </div>
        </div>
<?php
    }
}
