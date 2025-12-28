<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Pilgrimage_Map extends Widget_Base
{

    public function get_name()
    {
        return 'tk-pilgrimage-map';
    }

    public function get_title()
    {
        return __('Pilgrimage Map & Routes', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-google-maps';
    }

    public function get_categories()
    {
        return ['trip-kailash'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Map & Routes', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'map_image',
            [
                'label' => __('Map Image', 'trip-kailash'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description (Optional)', 'trip-kailash'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['map_image']['url'])) {
            return;
        }
        ?>
        <section class="tk-pilgrimage-map">
            <div class="tk-container">
                <?php if (!empty($settings['section_title'])): ?>
                    <h2 class="tk-pilgrimage-map__title"><?php echo esc_html($settings['section_title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($settings['description'])): ?>
                    <p class="tk-pilgrimage-map__description"><?php echo esc_html($settings['description']); ?></p>
                <?php endif; ?>

                <div class="tk-pilgrimage-map__image-wrapper">
                    <img src="<?php echo esc_url($settings['map_image']['url']); ?>"
                        alt="<?php echo esc_attr($settings['section_title']); ?>" class="tk-pilgrimage-map__image">
                </div>
            </div>
        </section>

        <style>
            .tk-pilgrimage-map {
                padding: var(--tk-space-lg, 89px) 0;
                background: var(--tk-bg-main, #F5F2ED);
            }

            .tk-pilgrimage-map__title {
                font-family: var(--tk-font-heading, serif);
                font-size: var(--tk-font-size-h2, 36px);
                color: var(--tk-text-main, #2C2B28);
                margin: 0 0 var(--tk-space-sm, 34px) 0;
                font-weight: 400;
            }

            .tk-pilgrimage-map__description {
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                color: var(--tk-text-main, #2C2B28);
                margin-bottom: var(--tk-space-sm, 34px);
                line-height: 1.8;
            }

            .tk-pilgrimage-map__image-wrapper {
                border-radius: var(--tk-border-radius, 10px);
                overflow: hidden;
                box-shadow: var(--tk-shadow-card, 0 4px 20px rgba(44, 43, 40, 0.08));
            }

            .tk-pilgrimage-map__image {
                width: 100%;
                height: auto;
                display: block;
            }

            @media (max-width: 768px) {
                .tk-pilgrimage-map {
                    padding: var(--tk-space-md, 55px) 0;
                }
            }
        </style>
        <?php
    }
}
