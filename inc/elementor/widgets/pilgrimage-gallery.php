<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_Gallery extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-gallery';
    }

    public function get_title() {
        return __( 'Pilgrimage Gallery', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-gallery-masonry';
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
                'default' => __( 'Gallery', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'images',
            [
                'label'   => __( 'Gallery Images', 'trip-kailash' ),
                'type'    => Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => __( 'Columns', 'trip-kailash' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '2' => __( '2 Columns', 'trip-kailash' ),
                    '3' => __( '3 Columns', 'trip-kailash' ),
                    '4' => __( '4 Columns', 'trip-kailash' ),
                    '6' => __( '6 Columns', 'trip-kailash' ),
                ],
                'default' => '3',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $images   = $settings['images'];

        if ( empty( $images ) ) {
            return;
        }

        $columns = $settings['columns'];
        ?>
        <section class="tk-pilgrimage-gallery">
            <div class="tk-container">
                <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                    <h2 class="tk-pilgrimage-gallery__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                <?php endif; ?>

                <div class="tk-gallery-grid tk-gallery-grid--columns-<?php echo esc_attr( $columns ); ?>">
                    <?php foreach ( $images as $image ) : ?>
                        <div class="tk-gallery-item">
                            <img src="<?php echo esc_url( $image['url'] ); ?>" 
                                 alt="<?php echo esc_attr( get_post_meta( $image['id'], '_wp_attachment_image_alt', true ) ); ?>" 
                                 loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <style>
        .tk-pilgrimage-gallery {
            padding: var(--tk-space-lg, 89px) 0;
            background: var(--tk-bg-main, #F5F2ED);
        }

        .tk-pilgrimage-gallery__title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h2, 36px);
            color: var(--tk-text-main, #2C2B28);
            margin: 0 0 var(--tk-space-md, 55px) 0;
            font-weight: 400;
        }

        .tk-gallery-grid {
            display: grid;
            gap: var(--tk-space-xs, 21px);
        }

        .tk-gallery-grid--columns-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .tk-gallery-grid--columns-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .tk-gallery-grid--columns-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .tk-gallery-grid--columns-6 {
            grid-template-columns: repeat(6, 1fr);
        }

        .tk-gallery-item {
            aspect-ratio: 4/3;
            overflow: hidden;
            border-radius: var(--tk-border-radius, 10px);
            cursor: pointer;
            box-shadow: var(--tk-shadow-card, 0 4px 20px rgba(44, 43, 40, 0.08));
        }

        .tk-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--tk-transition-slow, 0.5s ease);
        }

        .tk-gallery-item:hover img {
            transform: scale(1.1);
        }

        @media (max-width: 1024px) {
            .tk-gallery-grid--columns-6 {
                grid-template-columns: repeat(3, 1fr);
            }

            .tk-gallery-grid--columns-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .tk-pilgrimage-gallery {
                padding: var(--tk-space-md, 55px) 0;
            }

            .tk-gallery-grid--columns-3,
            .tk-gallery-grid--columns-4,
            .tk-gallery-grid--columns-6 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        </style>
        <?php
    }
}
