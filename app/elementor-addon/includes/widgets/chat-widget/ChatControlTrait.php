<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

trait ChatControlTrait
{
    public function sectionContent()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Chart Graph Content', 'HelloElementorChild'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title Field
        $this->add_control(
            'toc_title',
            [
                'label' => __('Title', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Table of Contents', 'HelloElementorChild'),
            ]
        );


        // Title Field
        $this->add_control(
            'x_axis_title',
            [
                'label' => __('X-axis label', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Executed Queries', 'HelloElementorChild'),
            ]
        );


        // Title Field
        $this->add_control(
            'y_axis_title',
            [
                'label' => __('Y-axis label', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Query execution time (capped at 140s)', 'HelloElementorChild'),
            ]
        );

        // Subtitle Field
        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Kinetica is a real-time GPU accelerated database that is custom built for generative AI workloads.', 'HelloElementorChild'),
            ]
        );

        // Flag to show whether to show the benchmark table or not
        $this->add_control(
            'show_benchmark_table',
            [
                'label' => __('Show Benchmark Table', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'HelloElementorChild'),
                'label_off' => __('Hide', 'HelloElementorChild'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // Text to show alongside the info icon
        $this->add_control(
            'info_text',
            [
                'label' => __('Info Text', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('The TPC-DS Benchmarks were run on the following hardware: 40 CPU cores, 384GB of memory (Intel(R) Xeon(R) CPU E5-2690 v2 @ 3.00GHz) ', 'HelloElementorChild'),
            ]
        );

        // Text to show beneath the info icon - database versions
        $this->add_control(
            'database_versions_text',
            [
                'label' => __('Database Versions', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,

            ]
        );

        // Reference link for the benchmark page
        $this->add_control(
            'reference_link',
            [
                'label' => __('Reference link', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('https://github.com/RadiantAdvisors/TPC-DS-2022/blob/main/Kinetica%20TPC-DS/kinetica-tpcds-bm99.sql', 'HelloElementorChild'),
            ]
        );


        // Heading Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'heading_text',
            [
                'label' => __('Heading', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => __(' Example Kinetica is 5x faster than BigQuery', 'HelloElementorChild'),
            ]
        );

        $this->add_control(
            'headings_list',
            [
                'label' => __('Headings', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ heading_text }}}', // Display heading text in repeater list
            ]
        );

        // CSV File Upload Field
        $this->add_control(
            'chart_file',
            [
                'label' => __('Upload Chart CSV File', 'HelloElementorChild'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['text/csv'], // Allow only CSV files
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
