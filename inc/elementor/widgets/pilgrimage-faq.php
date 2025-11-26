<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_FAQ extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-faq';
    }

    public function get_title() {
        return __( 'Pilgrimage FAQ', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-help-o';
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
                'default' => __( 'Frequently Asked Questions', 'trip-kailash' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'question',
            [
                'label'   => __( 'Question', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'What is the best time to visit?', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'answer',
            [
                'label'   => __( 'Answer', 'trip-kailash' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __( 'The best time to visit is during the pilgrimage season from May to October.', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'open_by_default',
            [
                'label'        => __( 'Open by Default', 'trip-kailash' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'faqs',
            [
                'label'       => __( 'FAQ Items', 'trip-kailash' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'question'        => __( 'What is the best time to visit?', 'trip-kailash' ),
                        'answer'          => __( 'The best time to visit is during the pilgrimage season from May to October when the weather is favorable and all routes are accessible.', 'trip-kailash' ),
                        'open_by_default' => 'yes',
                    ],
                    [
                        'question' => __( 'What is the difficulty level of this pilgrimage?', 'trip-kailash' ),
                        'answer'   => __( 'This pilgrimage is moderate in difficulty. Basic physical fitness is required as there will be walking at high altitudes.', 'trip-kailash' ),
                    ],
                    [
                        'question' => __( 'What should I pack for the journey?', 'trip-kailash' ),
                        'answer'   => __( 'Essential items include warm clothing, comfortable walking shoes, rain gear, sunscreen, and any personal medications.', 'trip-kailash' ),
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="tk-pilgrimage-faq">
            <div class="tk-container">
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="tk-pilgrimage-faq__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $settings['faqs'] ) ) : ?>
                    <div class="tk-faq-accordion">
                        <?php foreach ( $settings['faqs'] as $index => $faq ) : ?>
                            <details class="tk-faq-item" <?php echo ( 'yes' === $faq['open_by_default'] ) ? 'open' : ''; ?>>
                                <summary class="tk-faq-item__question">
                                    <span class="tk-faq-item__number"><?php echo esc_html( $index + 1 ); ?></span>
                                    <span class="tk-faq-item__text"><?php echo esc_html( $faq['question'] ); ?></span>
                                    <svg class="tk-faq-item__icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </summary>
                                <div class="tk-faq-item__answer">
                                    <?php echo wp_kses_post( $faq['answer'] ); ?>
                                </div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <style>
        .tk-pilgrimage-faq {
            padding: var(--tk-space-lg, 89px) 0;
            background: #FFFFFF;
        }

        .tk-pilgrimage-faq__title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h2, 36px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-md, 55px) 0;
            font-weight: 400;
        }

        .tk-faq-accordion {
            max-width: 900px;
        }

        .tk-faq-item {
            background: var(--tk-bg-main, #F5F2ED);
            border-radius: var(--tk-border-radius, 10px);
            margin-bottom: var(--tk-space-xs, 21px);
            overflow: hidden;
        }

        .tk-faq-item__question {
            display: flex;
            align-items: center;
            padding: var(--tk-space-sm, 34px);
            cursor: pointer;
            list-style: none;
            user-select: none;
            transition: background-color var(--tk-transition-fast, 0.2s ease);
        }

        .tk-faq-item__question::-webkit-details-marker {
            display: none;
        }

        .tk-faq-item__question:hover {
            background-color: rgba(184, 134, 11, 0.1);
        }

        .tk-faq-item__number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--tk-gold, #B8860B);
            color: #FFFFFF;
            border-radius: 50%;
            font-family: var(--tk-font-body, sans-serif);
            font-size: 14px;
            font-weight: 600;
            margin-right: var(--tk-space-xs, 21px);
            flex-shrink: 0;
        }

        .tk-faq-item__text {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-body, 18px);
            color: var(--tk-text-main, #2C2B28);
            flex: 1;
            line-height: 1.4;
        }

        .tk-faq-item__icon {
            color: var(--tk-gold, #B8860B);
            transition: transform var(--tk-transition-fast, 0.2s ease);
            flex-shrink: 0;
            margin-left: 16px;
        }

        .tk-faq-item[open] .tk-faq-item__icon {
            transform: rotate(45deg);
        }

        .tk-faq-item__answer {
            padding: 0 var(--tk-space-sm, 34px) var(--tk-space-sm, 34px);
            padding-left: calc(var(--tk-space-sm, 34px) + 32px + var(--tk-space-xs, 21px));
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-body, 18px);
            line-height: 1.8;
            color: var(--tk-text-main, #2C2B28);
        }

        .tk-faq-item__answer p {
            margin: 0 0 1em 0;
        }

        .tk-faq-item__answer p:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .tk-pilgrimage-faq {
                padding: var(--tk-space-md, 55px) 0;
            }

            .tk-faq-item__question {
                padding: var(--tk-space-xs, 21px);
            }

            .tk-faq-item__number {
                width: 28px;
                height: 28px;
                font-size: 12px;
                margin-right: 16px;
            }

            .tk-faq-item__text {
                font-size: 16px;
            }

            .tk-faq-item__answer {
                padding: 0 var(--tk-space-xs, 21px) var(--tk-space-xs, 21px);
                padding-left: calc(var(--tk-space-xs, 21px) + 28px + 16px);
                font-size: 16px;
            }
        }
        </style>
        <?php
    }
}
