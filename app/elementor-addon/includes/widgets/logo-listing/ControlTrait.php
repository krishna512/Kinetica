<?php
use Elementor\Controls_Manager;

trait LogoControlTrait
{

    /**
     * ========================================
     * Content Tab
     * ========================================
     */
    public function contentTabControls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('List Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => esc_html__('Add Images', 'HelloElementorChild'),
                'type' => Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Common Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Common Tittle for this Logo',
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * Style Tab
     * ========================================
     */

    public function styleTabControls()
    {
        $this->start_controls_section(
            'section_code_style',
            [
                'label' => esc_html__('Code', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'HelloElementorChild'),
                'type' => Controls_Manager::GAPS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'rem',
                ],
                'selectors' => [
                    '{{WRAPPER}} #logo-list' => 'gap: {{ROW}}{{UNIT}} {{COLUMN}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'HelloElementorChild'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 1.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} #logo-list img' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}