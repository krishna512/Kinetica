<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

trait HeroControlTrait
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
                'label' => esc_html__('Section', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'banner_title',
            [
                'label' => esc_html__('Section Title', 'HelloElementorChild'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Default description', 'HelloElementorChild'),
                'placeholder' => esc_html__('Type your description here', 'HelloElementorChild'),
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'video_content',
            [
                'label' => esc_html__('Video', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'textdomain'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->add_control(
            'video',
            [
                'label' => esc_html__('Choose Video File', 'HelloElementorChild'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_content',
            [
                'label' => esc_html__('Slider', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
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

        // $sql = "CREATE TABLE users (
        //     id INT AUTO_INCREMENT PRIMARY KEY,
        //     username VARCHAR(50) NOT NULL,
        //     email VARCHAR(100) NOT NULL,
        //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // )";

        // $repeater->add_control(
        //     'sql_code',
        //     [
        //         'label' => esc_html__('Code', 'HelloElementorChild'),
        //         'type' => Controls_Manager::CODE,
        //         'default' => $sql,
        //         'language' => 'sql',
        //         'rows' => 20,
        //         'separator' => 'after'
        //     ]
        // );

        // $repeater->add_control(
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

        $this->add_control(
            'slider',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
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

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_button',
            [
                'label' => esc_html__('Button', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slider_button_text',
            [
                'label' => esc_html__('Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'slider_button_url',
            [
                'label' => esc_html__('Link', 'HelloElementorChild'),
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
                'label' => esc_html__('Animation Options', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'progress_speed',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Slide Delay', 'HelloElementorChild'),
                'description' => 'in secs',
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .kinetica__content--pagination.swiper-pagination-horizontal span.swiper-pagination-bullet.swiper-pagination-bullet-active:before' => 'animation-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->add_control(
            'animation_speed',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Progress Animation Delay', 'HelloElementorChild'),
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .kinetica__content--pagination.swiper-pagination-horizontal span.swiper-pagination-bullet.swiper-pagination-bullet-active:before' => 'animation-delay: {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function headingStyles()
    {
        $this->start_controls_section(
            'section_head_style',
            [
                'label' => esc_html__('Section Title', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_title_typography',
                'selector' => '{{WRAPPER}} .kinetica__hero_slider h1',
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
                'label' => esc_html__('Slider Title', 'HelloElementorChild'),
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
                    '{{WRAPPER}} .kinetica__content--titleswiper h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_content_typography',
                'selector' => '{{WRAPPER}} .kinetica__content--titleswiper h2',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'HelloElementorChild'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .kinetica__content--titleswiper h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' => esc_html__('Slider Content', 'HelloElementorChild'),
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
                    '{{WRAPPER}} .kinetica__content--swiper .content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_content_typography',
                'selector' => '{{WRAPPER}} .kinetica__content--swiper .content',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'HelloElementorChild'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .kinetica__content--swiper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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