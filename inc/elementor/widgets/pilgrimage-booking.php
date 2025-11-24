<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_Booking extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-booking';
    }

    public function get_title() {
        return __( 'Pilgrimage Packages & Booking', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-table-of-contents';
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
                'default' => __( 'Packages & Booking', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label'   => __( 'Intro Text', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 2,
                'default' => '',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'row_label',
            [
                'label'   => __( 'Row Label', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Kathmandu', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'col_1_value',
            [
                'label'   => __( 'Column 1 Value', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '$800', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'col_2_value',
            [
                'label'   => __( 'Column 2 Value', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '$700', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'col_3_value',
            [
                'label'   => __( 'Column 3 Value', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '$650', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'col_4_value',
            [
                'label'   => __( 'Column 4 Value', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '$600', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'pricing_rows',
            [
                'label'       => __( 'Pricing Table Rows', 'trip-kailash' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [],
                'title_field' => '{{{ row_label }}}',
            ]
        );

        $this->add_control(
            'cta_text',
            [
                'label'   => __( 'CTA Button Text', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Book Now', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'cta_link',
            [
                'label'       => __( 'CTA Button Link', 'trip-kailash' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( '#contact', 'trip-kailash' ),
                'default'     => [
                    'url' => '#contact',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="tk-pilgrimage-booking">
            <div class="tk-container">
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="tk-pilgrimage-booking__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $settings['intro_text'] ) ) : ?>
                    <p class="tk-pilgrimage-booking__intro"><?php echo esc_html( $settings['intro_text'] ); ?></p>
                <?php endif; ?>

                <?php if ( ! empty( $settings['pricing_rows'] ) ) : ?>
                    <div class="tk-pricing-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>2 PAX</th>
                                    <th>4-6 PAX</th>
                                    <th>8-10 PAX</th>
                                    <th>10+ PAX</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $settings['pricing_rows'] as $row ) : ?>
                                    <tr>
                                        <td><?php echo esc_html( $row['row_label'] ); ?></td>
                                        <td><?php echo esc_html( $row['col_1_value'] ); ?></td>
                                        <td><?php echo esc_html( $row['col_2_value'] ); ?></td>
                                        <td><?php echo esc_html( $row['col_3_value'] ); ?></td>
                                        <td><?php echo esc_html( $row['col_4_value'] ); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $settings['cta_text'] ) ) : ?>
                    <div class="tk-pilgrimage-booking__cta">
                        <a href="<?php echo esc_url( $settings['cta_link']['url'] ); ?>" 
                           class="tk-btn tk-btn--gold">
                            <?php echo esc_html( $settings['cta_text'] ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <style>
        .tk-pilgrimage-booking {
            padding: var(--tk-space-lg, 89px) 0;
            background: #FFFFFF;
        }

        .tk-pilgrimage-booking__title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h2, 36px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-sm, 34px) 0;
            font-weight: 400;
        }

        .tk-pilgrimage-booking__intro {
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-body, 18px);
            color: var(--tk-text-main, #2C2B28);
            margin-bottom: var(--tk-space-sm, 34px);
            line-height: 1.8;
        }

        .tk-pricing-table {
            overflow-x: auto;
            margin-bottom: var(--tk-space-sm, 34px);
        }

        .tk-pricing-table table {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--tk-font-body, sans-serif);
        }

        .tk-pricing-table thead th {
            background-color: var(--tk-gold, #B8860B);
            color: #FFFFFF;
            padding: var(--tk-space-xs, 21px);
            text-align: left;
            font-weight: 600;
            font-size: var(--tk-font-size-small, 16px);
        }

        .tk-pricing-table tbody td {
            padding: var(--tk-space-xs, 21px);
            border-bottom: 1px solid rgba(44, 43, 40, 0.1);
            font-size: var(--tk-font-size-small, 16px);
            color: var(--tk-text-main, #2C2B28);
        }

        .tk-pricing-table tbody tr:hover {
            background-color: var(--tk-bg-main, #F5F2ED);
        }

        .tk-pricing-table tbody td:first-child {
            font-weight: 600;
        }

        .tk-pilgrimage-booking__cta {
            text-align: center;
            margin-top: var(--tk-space-md, 55px);
        }

        .tk-btn {
            display: inline-block;
            padding: 16px 48px;
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-body, 18px);
            font-weight: 600;
            text-decoration: none;
            border-radius: var(--tk-border-radius-sm, 8px);
            transition: all var(--tk-transition-normal, 0.3s ease);
            cursor: pointer;
        }

        .tk-btn--gold {
            background-color: var(--tk-gold, #B8860B);
            color: #FFFFFF;
        }

        .tk-btn--gold:hover {
            background-color: #A67C0A;
            transform: translateY(-2px);
            box-shadow: var(--tk-shadow-card, 0 4px 20px rgba(44, 43, 40, 0.15));
        }

        @media (max-width: 768px) {
            .tk-pilgrimage-booking {
                padding: var(--tk-space-md, 55px) 0;
            }

            .tk-pricing-table thead th,
            .tk-pricing-table tbody td {
                padding: 12px;
                font-size: 14px;
            }
        }
        </style>
        <?php
    }
}
