<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait QuestionsControlTrait
{
    public function sectionContent()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'HelloElementorChild'),
                'placeholder' => esc_html__('Type your title here', 'HelloElementorChild'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'excerpt',
            [
                'label' => esc_html__('Excerpt', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Default description', 'HelloElementorChild'),
                'placeholder' => esc_html__('Type your description here', 'HelloElementorChild'),
            ]
        );

        $this->add_control(
            'pass_mark',
            [
                'label' => esc_html__('Pass Mark Score', 'HelloElementorChild'),
                'type' => Controls_Manager::NUMBER,
                'default' => esc_html__('40', 'HelloElementorChild'),
                'label_block' => true
            ]
        );

        $this->end_controls_section();

        // ------------------------------------------------------

        $this->start_controls_section(
            'pass_section',
            [
                'label' => esc_html__('Pass Result Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pass_result_info',
            [
                'label' => esc_html__('Pass Result Information', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__('Your score of {score_point} is above our threshold of {pass_mark}', 'HelloElementorChild'),
                'placeholder' => esc_html__('Your score of {score_point} is above our threshold of {pass_mark}', 'HelloElementorChild'),
            ]
        );

        $this->add_control(
            'pass_label',
            [
                'label' => esc_html__('Pass Success Label', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Book a Demo', 'HelloElementorChild'),
                'placeholder' => esc_html__('Type your title here', 'HelloElementorChild'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'pass_redirect_url',
            [
                'label' => esc_html__('Pass Redirection Link', 'HelloElementorChild'),
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

        // ------------------------------------------------------

        $this->start_controls_section(
            'fail_section',
            [
                'label' => esc_html__('Fail Result Content', 'HelloElementorChild'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'fail_result_info',
            [
                'label' => esc_html__('Fail Result Information', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__('Your score does not meet our threshold of {pass_mark}', 'HelloElementorChild'),
                'placeholder' => esc_html__('Your score does not meet our threshold of {pass_mark}', 'HelloElementorChild'),
            ]
        );

        $this->add_control(
            'fail_label',
            [
                'label' => esc_html__('Fail Label', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Try Free', 'HelloElementorChild'),
                'placeholder' => esc_html__('Type your title here', 'HelloElementorChild'),
                'label_block' => true
            ]
        );

        $this->add_control(
            'fail_redirect_url',
            [
                'label' => esc_html__('Fail Redirection Link', 'HelloElementorChild'),
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
}
