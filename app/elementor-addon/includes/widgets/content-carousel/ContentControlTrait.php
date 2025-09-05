<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait ContentControlTrait
{
    public function sectionContent()
    {
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => 'Content With Image Carousel',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'carousel_title',
            [
                'label' => esc_html__('Heading', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Optimal routing algorithm for trips involving thousands of ev-charging stations using Kinetica-Graph',
                'label_block' => true,
            ]
        );

      $repeater->add_control(
            'carousel_description',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Content for this ...',
                'label_block' => true,
            ]
        );

        // Add media upload options for video or image
        // Image upload
        $repeater->add_control(
            'image_content',
            [
                'label' => esc_html__('Images', 'HelloElementorChild'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Read this journal',
                'label_block' => true,
            ]
        );

       
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'HelloElementorChild'),
                'type' => Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'carousel',
            [
                'label' => 'Carousel',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'carousel_title' => 'Carousel #1',
                        'carousel_description' => 'Description for Carousel #1',
                        'media_type' => 'image',
                        'media_content' => [
                            'url' => 'https://via.placeholder.com/400', // Placeholder image
                        ],

                    ],
                ],
                'title_field' => '{{{ carousel_title }}}',
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
                'label' => esc_html__('Carousel List', 'HelloElementorChild'),
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