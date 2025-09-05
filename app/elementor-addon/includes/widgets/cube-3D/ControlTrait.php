<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

trait CubeControlTrait
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
                'label' => esc_html__('Repeater Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'HelloElementorChild'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'repeater_title',
            [
                'label' => esc_html__('Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('List Title', 'HelloElementorChild'),
                'label_block' => true,
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'repeater_link',
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

        $this->add_control(
            'left_repeater',
            [
                'label' => esc_html__('Left Content', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'frontend_available' => true,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'repeater_title' => esc_html__('Title #1', 'HelloElementorChild'),
                    ],
                    [
                        'repeater_title' => esc_html__('Title #2', 'HelloElementorChild'),
                    ],
                ],
                'title_field' => '{{{ repeater_title }}}',
            ]
        );

        $this->add_control(
            'right_repeater',
            [
                'label' => esc_html__('Right Content', 'HelloElementorChild'),
                'type' => Controls_Manager::REPEATER,
                'frontend_available' => true,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'repeater_title' => esc_html__('Title #1', 'HelloElementorChild'),
                    ],
                    [
                        'repeater_title' => esc_html__('Title #2', 'HelloElementorChild'),
                    ],
                ],
                'title_field' => '{{{ repeater_title }}}',
            ]
        );

        $this->end_controls_section();
    }


    /**
     * ========================================
     * Cube option
     * ========================================
     */

    public function sectionCube()
    {
        $this->start_controls_section(
            'section_cube',
            [
                'label' => esc_html__('3D Cube', 'HelloElementorChild'),
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
                'separator' => 'after'
            ]
        );

        $this->end_controls_section();
    }

    /**
     * ========================================
     * Cube option
     * ========================================
     */

    public function sectionTitles()
    {
        $this->start_controls_section(
            'section_titles',
            [
                'label' => esc_html__('Titles', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title_1',
            [
                'label' => esc_html__('Title 1', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'HelloElementorChild'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_2',
            [
                'label' => esc_html__('Title 2', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'HelloElementorChild'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_3',
            [
                'label' => esc_html__('Title 3', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'HelloElementorChild'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_4',
            [
                'label' => esc_html__('Title 4', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'HelloElementorChild'),
                'label_block' => true,
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
                'label' => esc_html__('Repeater List', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cube__list-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label' => esc_html__('Text Color', 'HelloElementorChild'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cube__list-title' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cube__list-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_content_typography',
                'selector' => '{{WRAPPER}} .cube__list-title',
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
                    '{{WRAPPER}} .cube__animation img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}