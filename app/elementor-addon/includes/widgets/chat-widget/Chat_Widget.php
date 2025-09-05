<?php

use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/ChatControlTrait.php');

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class Elementor_Chat_Widget extends \Elementor\Widget_Base
{

    use ChatControlTrait;

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
        return 'chart-graph';
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
        return esc_html__('Chart Graph', 'HelloElementorChild');
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
        return ['chart-widget', 'chart-graph', 'chart-card', 'dynamic-chart'];
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
        return ['chart-cdn', 'chart-graph', 'csv-chart-loader'];
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
        return 'eicon-paragraph';
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
        return ['table', 'carousel'];
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
        $csv_url = !empty($settings['chart_file']['url']) ? $settings['chart_file']['url'] : '';
        $x_axis_title = $settings['x_axis_title'];
        $y_axis_title = $settings['y_axis_title'];
        $subtitle = $settings['subtitle'];
        $benchmarkTableFlag = $settings['show_benchmark_table'];
        $info_text = $settings['info_text'];
        $database_versions_text = !empty($settings['database_versions_text']) ? $settings['database_versions_text'] : '';
        $reference_link = $settings['reference_link'];
        echo "<div class='chart-widget'>";

        if ($csv_url) {
            echo '<script>
                     document.addEventListener("DOMContentLoaded", function() {
                         loadChartData("' . esc_url($csv_url) . '");
                     });
                   </script>';
        }

?>

        <?php if (!empty($settings['headings_list'])) {
            foreach ($settings['headings_list'] as $heading) {
                echo '<h2 class="benchmark-title">' . esc_html($heading['heading_text']) . '</h2>';
            }
        }
        ?>

        <div class='subtitle'>
            <?php echo $subtitle; ?>
        </div>

        <div class="button-container">
            <button type=" button" class="kineticaBtn">Kinetica</button>
            <div class="vs-text"> VS </div>
            <div class="toggle-button-container">
                <button data-val="clickhouse" type="button" class="toggleBtn--chart active">Clickhouse</button>
                <button type="button" data-val="singlestore" class="toggleBtn--chart">SingleStore</button>
                <button type="button" data-val="bigquery" class="toggleBtn--chart">BigQuery</button>
            </div>
        </div>

        <!-- Echo the chart legends and hide them. This is for use only in the javascript -->
        <div class="chart-axis-legends hidden">
            <span class='x-axis-title'> <?php echo $x_axis_title; ?> </span>
            <span class='y-axis-title'> <?php echo $y_axis_title; ?> </span>
        </div>

        <div class="legend">
            <div class="legend-item kinetica">
                <div class="box">
                </div>
                <span> Kinetica </span>
            </div>
            <div class="legend-item other-db">
                <div class="box">
                </div>
                <span> Clickhouse </span>
            </div>
        </div>

        <div class="chart-wrapper horizontal">
            <div class="axis-container">
                <canvas id="horizontal-chart-axis"></canvas>
            </div>
            <div class="scroll-container">
                <div class="chart-container">
                    <canvas id="horizontal-chart"></canvas>
                </div>
            </div>
        </div>

        <div class="footer-container">
            <div class="flex gap-x-2 items-center mx-auto w-fit">
                <span class='flex text-sm min-w-4'> <?php echo useSVG('info-icon'); ?></span>
                <span class="info-text"> <?php echo $info_text; ?> </span>
            </div>

            <div class='database-versions'>
                <?php echo $database_versions_text; ?>
            </div>

        </div>
<?php

        if ($benchmarkTableFlag) {
            echo '<div data-benchmark="true" class="results-table-wrapper"><div id="tab-results"></div></div>';
            echo '<p class="github-text">View the <a style="color: #0E7BF8;" href="' . $reference_link . '">Individual TPC-DS Queries Here</a></p>';
        }
        echo '</div>';
    }
}
