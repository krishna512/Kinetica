<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait TableControlTrait
{
    public function sectionContent()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'HelloElementorChild'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'toc_title',
            [
                'label' => __('Title', 'HelloElementorChild'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Table of Contents', 'HelloElementorChild'),
            ]
        );

        $this->end_controls_section();
        
    }

}