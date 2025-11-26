<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_Highlights extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-highlights';
    }

    public function get_title() {
        return __( 'Pilgrimage Highlights', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'trip-kailash' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'trip-kailash' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label'   => __( 'Section Title', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Trip Highlights', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => __( 'Columns', 'trip-kailash' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => __( '1 Column', 'trip-kailash' ),
                    '2' => __( '2 Columns', 'trip-kailash' ),
                    '3' => __( '3 Columns', 'trip-kailash' ),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'highlight_text',
            [
                'label'   => __( 'Highlight', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Highlight point', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'highlights',
            [
                'label'       => __( 'Highlights', 'trip-kailash' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'highlight_text' => __( 'Visit sacred temples and shrines', 'trip-kailash' ) ],
                    [ 'highlight_text' => __( 'Experience breathtaking Himalayan views', 'trip-kailash' ) ],
                    [ 'highlight_text' => __( 'Expert local guides throughout', 'trip-kailash' ) ],
                    [ 'highlight_text' => __( 'Comfortable accommodation included', 'trip-kailash' ) ],
                    [ 'highlight_text' => __( 'All meals and transportation', 'trip-kailash' ) ],
                    [ 'highlight_text' => __( 'Small group sizes for personal experience', 'trip-kailash' ) ],
                ],
                'title_field' => '{{{ highlight_text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns = $settings['columns'];
        ?>
        <section class="tk-pilgrimage-highlights">
            <div class="tk-container">
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="tk-pilgrimage-highlights__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $settings['highlights'] ) ) : ?>
                    <ul class="tk-highlights-list tk-highlights-list--cols-<?php echo esc_attr( $columns ); ?>">
                        <?php foreach ( $settings['highlights'] as $item ) : ?>
                            <li class="tk-highlights-list__item">
                                <svg class="tk-highlights-list__icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                </svg>
                                <span><?php echo esc_html( $item['highlight_text'] ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <style>
        .tk-pilgrimage-highlights {
            padding: var(--tk-space-lg, 89px) 0;
            background: var(--tk-bg-main, #F5F2ED);
        }

        .tk-pilgrimage-highlights__title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h2, 36px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-md, 55px) 0;
            font-weight: 400;
        }

        .tk-highlights-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: var(--tk-space-xs, 21px);
            max-width: 900px;
        }

        .tk-highlights-list--cols-1 {
            grid-template-columns: 1fr;
        }

        .tk-highlights-list--cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .tk-highlights-list--cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .tk-highlights-list__item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: var(--tk-space-xs, 21px);
            background: #FFFFFF;
            border-radius: var(--tk-border-radius, 10px);
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-body, 18px);
            color: var(--tk-text-main, #2C2B28);
            line-height: 1.5;
        }

        .tk-highlights-list__icon {
            color: var(--tk-gold, #B8860B);
            flex-shrink: 0;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .tk-pilgrimage-highlights {
                padding: var(--tk-space-md, 55px) 0;
            }

            .tk-highlights-list--cols-2,
            .tk-highlights-list--cols-3 {
                grid-template-columns: 1fr;
            }

            .tk-highlights-list__item {
                font-size: 16px;
                padding: 16px;
            }
        }
        </style>
        <?php
    }
}
