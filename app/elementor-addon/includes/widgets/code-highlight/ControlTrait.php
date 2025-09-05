<?php

use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Controls_Manager;

trait HighlightControlTrait
{

    /**
     * ========================================
     * Repeater Content Controls
     * 
     * @Inside Content tab
     * ========================================
     */
    public function contentTab()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Highlight Source Shell', 'elementor-pro'),
            ]
        );

        $this->add_control(
            'code',
            [
                'label' => esc_html__('Code', 'elementor-pro'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'console.log( \'Code is Poetry\' );',
            ]
        );

        $this->add_control(
            'language',
            [
                'label' => esc_html__('Language', 'elementor-pro'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'javascript' => esc_html__('JavaScript', 'elementor-pro'),
                    'html' => esc_html__('HTML', 'elementor-pro'),
                    'css' => esc_html__('CSS', 'elementor-pro'),
                    'php' => esc_html__('PHP', 'elementor-pro'),
                    'sql' => esc_html__('SQL', 'elementor-pro'),
                ],
                'default' => 'javascript',
            ]
        );

        $this->end_controls_section();
    }
}
