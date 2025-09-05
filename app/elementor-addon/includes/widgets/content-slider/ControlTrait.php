<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait ControlTrait
{

    /**
     * ========================================
     * Repeater Content Controls
     * 
     * @Inside Content tab
     * ========================================
     */
    public function sectionContent()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Slider', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'type' => Controls_Manager::CHOOSE,
                'label' => esc_html__('Content Alignment', 'HelloElementorChild'),
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Start', 'HelloElementorChild'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'HelloElementorChild'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('End', 'HelloElementorChild'),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'HelloElementorChild'),
                        'icon' => 'eicon-align-stretch-h',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .animating-slider' => 'align-items: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_text_align',
            [
                'type' => Controls_Manager::CHOOSE,
                'label' => esc_html__('Text Alignment', 'HelloElementorChild'),
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'HelloElementorChild'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'HelloElementorChild'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'HelloElementorChild'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Justified', 'HelloElementorChild'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .animating-slider' => 'text-align: {{VALUE}}',
                ],
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slider_title',
            [
                'label' => esc_html__('Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('List Title', 'HelloElementorChild'),
                'label_block' => true,
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'slider_content',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('List Content', 'HelloElementorChild'),
                'show_label' => false,
                'separator' => 'after'
            ]
        );

        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $repeater->add_control(
            'sql_code',
            [
                'label' => esc_html__('Code', 'HelloElementorChild'),
                'type' => Controls_Manager::CODE,
                'default' => $sql,
                'language' => 'sql',
                'rows' => 20,
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'tutorial_link',
            [
                'label' => esc_html__('Tutorial Link', 'HelloElementorChild'),
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
            'slider',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'frontend_available' => true,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slider_title' => esc_html__('Title #1', 'HelloElementorChild'),
                        'slider_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'HelloElementorChild'),
                    ],
                    [
                        'slider_title' => esc_html__('Title #2', 'HelloElementorChild'),
                        'slider_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'HelloElementorChild'),
                    ],
                ],
                'title_field' => '{{{ slider_title }}}',
            ]
        );

        // $this->add_control(
        //     'tutorial_link',
        //     [
        //         'label' => esc_html__('Tutorial Link', 'HelloElementorChild'),
        //         'type' => Controls_Manager::URL,
        //         'options' => ['url', 'is_external', 'nofollow'],
        //         'default' => [
        //             'url' => '',
        //             'is_external' => false,
        //             'nofollow' => false,
        //         ],
        //         'label_block' => true,
        //     ]
        // );

        $this->end_controls_section();
    }



    /**
     * ========================================
     * Slider Animation Spped Controls
     * 
     * Inside Content tab
     * ========================================
     */

    public function animationSpeed()
    {
        $this->start_controls_section(
            'option_section',
            [
                'label' => esc_html__('Options', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'progress_speed',
            [
                'label' => esc_html__('Progress Speed', 'HelloElementorChild'),
                'type' => Controls_Manager::NUMBER,
                'min' => 2,
                'max' => 100,
                'step' => 1,
                'default' => 5,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'label' => esc_html__('Animation Speed', 'HelloElementorChild'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 1.5,
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * ========================================
     * Title Style
     * 
     * inside style tab
     * ========================================
     */

    public function titleStyles()
    {
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .text-swiper' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_content_typography',
                'selector' => '{{WRAPPER}} .text-swiper .slider_title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'HelloElementorChild'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-swiper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title-width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Width', 'HelloElementorChild'),
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-swiper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * Content Style
     * 
     * inside Style tab
     * ========================================
     */
    public function contentStyles()
    {
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .content-swiper .content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_content_typography',
                'selector' => '{{WRAPPER}} .content-swiper .content',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'HelloElementorChild'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-swiper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content-width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Width', 'HelloElementorChild'),
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'rem' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .content-swiper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * Code Style
     * 
     * inside Style tab
     * ========================================
     */

    public function codeStyles()
    {
        $this->start_controls_section(
            'section_code_style',
            [
                'label' => esc_html__('Code', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'default_color',
            [
                'label' => esc_html__('Default Text Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .prismjs-twilight code[class*=language-]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'token_color',
            [
                'label' => esc_html__('Token Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} div.prismjs-twilight pre.language-sql code span.token' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'string_color',
            [
                'label' => esc_html__('String Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} div.prismjs-twilight pre.language-sql code span.string' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'comment_color',
            [
                'label' => esc_html__('Comment Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} div.prismjs-twilight pre.language-sql code span.comment' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'linenumber_color',
            [
                'label' => esc_html__('Line Number Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} pre.line-numbers .line-numbers-rows' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'code_typography',
                'selector' => '{{WRAPPER}} .code-swiper .prismjs-twilight code[class*="language-"]',
            ]
        );

        $this->add_responsive_control(
            'code-width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Width', 'HelloElementorChild'),
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'rem' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 32.063,
                ],
                'selectors' => [
                    '{{WRAPPER}} .code-swiper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * Slider Style
     * 
     * inside Style tab
     * ========================================
     */

    public function sliderStyles()
    {
        $this->start_controls_section(
            'section_slider_style',
            [
                'label' => esc_html__('Progress Bar', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'progress_color',
            [
                'label' => esc_html__('Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} progress::-webkit-progress-value' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} progress::-moz-progress-bar' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .play-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .custom-select .placeholder svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'progress-width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Width', 'HelloElementorChild'),
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-progress-bar' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

}