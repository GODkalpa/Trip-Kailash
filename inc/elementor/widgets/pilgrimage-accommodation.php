<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_Accommodation extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-accommodation';
    }

    public function get_title() {
        return __( 'Pilgrimage Accommodation', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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
                'default' => __( 'Accommodation', 'trip-kailash' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'property_image',
            [
                'label'   => __( 'Property Image', 'trip-kailash' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $repeater->add_control(
            'property_name',
            [
                'label'   => __( 'Property Name', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Guest House', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'property_type',
            [
                'label'   => __( 'Property Type', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Standard Hotel', 'trip-kailash' ),
            ]
        );

        $repeater->add_control(
            'property_description',
            [
                'label'   => __( 'Description', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 3,
                'default' => '',
            ]
        );

        $this->add_control(
            'properties',
            [
                'label'       => __( 'Properties', 'trip-kailash' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'property_name'        => __( 'Guest House', 'trip-kailash' ),
                        'property_type'        => __( 'Standard Hotel', 'trip-kailash' ),
                        'property_description' => __( 'Comfortable accommodation with modern amenities', 'trip-kailash' ),
                    ],
                ],
                'title_field' => '{{{ property_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="tk-pilgrimage-accommodation">
            <div class="tk-container">
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="tk-pilgrimage-accommodation__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $settings['properties'] ) ) : ?>
                    <div class="tk-accommodation-grid">
                        <?php foreach ( $settings['properties'] as $property ) : ?>
                            <div class="tk-accommodation-card">
                                <?php if ( ! empty( $property['property_image']['url'] ) ) : ?>
                                    <div class="tk-accommodation-card__image">
                                        <img src="<?php echo esc_url( $property['property_image']['url'] ); ?>" 
                                             alt="<?php echo esc_attr( $property['property_name'] ); ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="tk-accommodation-card__content">
                                    <?php if ( ! empty( $property['property_name'] ) ) : ?>
                                        <h3 class="tk-accommodation-card__name"><?php echo esc_html( $property['property_name'] ); ?></h3>
                                    <?php endif; ?>
                                    
                                    <?php if ( ! empty( $property['property_type'] ) ) : ?>
                                        <p class="tk-accommodation-card__type"><?php echo esc_html( $property['property_type'] ); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ( ! empty( $property['property_description'] ) ) : ?>
                                        <p class="tk-accommodation-card__description"><?php echo esc_html( $property['property_description'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <style>
        .tk-pilgrimage-accommodation {
            padding: var(--tk-space-lg, 89px) 0;
            background: #FFFFFF;
        }

        .tk-pilgrimage-accommodation__title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h2, 36px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-md, 55px) 0;
            font-weight: 400;
        }

        .tk-accommodation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--tk-space-sm, 34px);
        }

        .tk-accommodation-card {
            background: #FFFFFF;
            border-radius: var(--tk-border-radius, 10px);
            overflow: hidden;
            box-shadow: var(--tk-shadow-card, 0 4px 20px rgba(44, 43, 40, 0.08));
            transition: transform var(--tk-transition-normal, 0.3s ease), 
                        box-shadow var(--tk-transition-normal, 0.3s ease);
        }

        .tk-accommodation-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--tk-shadow-card-hover, 0 12px 40px rgba(44, 43, 40, 0.15));
        }

        .tk-accommodation-card__image {
            aspect-ratio: 4/3;
            overflow: hidden;
        }

        .tk-accommodation-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--tk-transition-slow, 0.5s ease);
        }

        .tk-accommodation-card:hover .tk-accommodation-card__image img {
            transform: scale(1.05);
        }

        .tk-accommodation-card__content {
            padding: var(--tk-space-sm, 34px);
        }

        .tk-accommodation-card__name {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h3, 24px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-xs, 21px) 0;
            font-weight: 400;
        }

        .tk-accommodation-card__type {
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-small, 16px);
            color: var(--tk-gold, #B8860B);
            margin: 0 0 var(--tk-space-xs, 21px) 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .tk-accommodation-card__description {
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-small, 16px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .tk-pilgrimage-accommodation {
                padding: var(--tk-space-md, 55px) 0;
            }

            .tk-accommodation-grid {
                grid-template-columns: 1fr;
            }
        }
        </style>
        <?php
    }
}
