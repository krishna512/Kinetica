<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

trait NewHeroControlTrait {

    /**
     * Register all controls for the widget.
     */
    public function _register_controls() {

        /**
         * =========================
         * Heading Section
         * =========================
         */
        $this->start_controls_section( 'section_heading', [
            'label' => __( 'Heading', 'HelloElementorChild' ),
        ] );

        $this->add_control( 'main_heading', [
            'label'       => __( 'Heading', 'HelloElementorChild' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'AI and Analytics for Real-Time Data', 'HelloElementorChild' ),
            'placeholder' => __( 'Enter heading', 'HelloElementorChild' ),
        ] );

        $this->end_controls_section();

        /**
         * =========================
         * Background Controls
         * =========================
         */
        $this->start_controls_section( 'section_background', [
            'label' => __( 'Background', 'HelloElementorChild' ),
        ] );

        $this->add_control( 'use_lottie', [
            'label'        => __( 'Use Lottie Animation?', 'HelloElementorChild' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'HelloElementorChild' ),
            'label_off'    => __( 'No', 'HelloElementorChild' ),
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'lottie_url', [
            'label'       => __( 'Lottie Animation JSON URL', 'HelloElementorChild' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => 'https://assets.lottiefiles.com/...',
            'condition'   => [
                'use_lottie' => 'yes',
            ],
        ] );

        $this->add_control( 'vector_image', [
            'label'     => __( 'Background Vector Image', 'HelloElementorChild' ),
            'type'      => Controls_Manager::MEDIA,
            'condition' => [
                'use_lottie!' => 'yes',
            ],
        ] );

        $this->end_controls_section();

        /**
         * =========================
         * Card Repeater
         * =========================
         */
        $this->start_controls_section( 'section_cards', [
            'label' => __( 'Cards', 'HelloElementorChild' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'card_image', [
            'label'   => __( 'Card Image', 'HelloElementorChild' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ] );

        $repeater->add_control( 'card_title', [
            'label'   => __( 'Title', 'HelloElementorChild' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Card Title', 'HelloElementorChild' ),
        ] );

        $repeater->add_control( 'card_link', [
            'label'         => __( 'Card Link', 'HelloElementorChild' ),
            'type'          => Controls_Manager::URL,
            'placeholder'   => __( 'https://your-link.com', 'HelloElementorChild' ),
            'show_external' => true,
            'default'       => [
                'url'        => '',
                'is_external'=> false,
                'nofollow'   => false,
            ],
        ] );

        $this->add_control( 'cards', [
            'label'   => __( 'Repeater Cards', 'HelloElementorChild' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'card_title' => __( 'Card One', 'HelloElementorChild' ) ],
                [ 'card_title' => __( 'Card Two', 'HelloElementorChild' ) ],
            ],
        ] );

        $this->end_controls_section();
    }
}
