<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

trait TabInnerControlTrait
{
    public function sectionContent()
    {
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => 'Tabs',
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Build GenAI Apps that have an impact on your bottom line',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label' => esc_html__('Sub Heading', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Kinetica unlocks all of your data - text and tabular for Generative AI applications.',
                'label_block' => true,
            ]
        );

        $inner_repeater = new Repeater();

        $inner_repeater->add_control(
            'item_title',
            [
                'label' => __('Item Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Item Title',
                'label_block' => true,
            ]
        );

        $inner_repeater->add_control(
            'item_description',
            [
                'label' => __('Description', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Default item description',
                'label_block' => true,
            ]
        );


        $inner_repeater->add_control(
            'item_icon',
            [
                'label' => __('Item Icon', 'HelloElementorChild'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $inner_repeater->add_control(
            'item_image',
            [
                'label' => __('Item Image', 'HelloElementorChild'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => __('Tab Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Main Tab',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_items',
            [
                'label' => __('Inner Tab Items', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $inner_repeater->get_controls(),
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __('Tabs', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * List Style
     * 
     * inside style tab
     * ========================================
     */

    public function listStyles()
    {
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Tab List', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label' => esc_html__('Text Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tab__list-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description _color',
            [
                'label' => esc_html__('Description Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .description__list-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'list_icon_color',
            [
                'label' => esc_html__('Icon Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tab__list-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_content_typography',
                'selector' => '{{WRAPPER}} .tab__list-title',
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * GIF Image
     * 
     * inside style tab
     * ========================================
     */

    public function imageStyles()
    {
        $this->start_controls_section(
            'section_iimage',
            [
                'label' => esc_html__('Image', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image-width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Max-Width', 'HelloElementorChild'),
                'size_units' => ['rem', 'custom'],
                'range' => [
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tab__animation img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
