<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class Pilgrimage_Itinerary extends Widget_Base
{

    public function get_name()
    {
        return 'tk-pilgrimage-itinerary';
    }

    public function get_title()
    {
        return __('Pilgrimage Detailed Itinerary', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-accordion';
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
                'default' => __('Detailed Itinerary', 'trip-kailash'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'day_number',
            [
                'label' => __('Day Number', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Day 1', 'trip-kailash'),
            ]
        );

        $repeater->add_control(
            'day_title',
            [
                'label' => __('Day Title', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Arrival in Kathmandu', 'trip-kailash'),
            ]
        );

        $repeater->add_control(
            'day_description',
            [
                'label' => __('Description', 'trip-kailash'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'open_by_default',
            [
                'label' => __('Open by Default', 'trip-kailash'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'days',
            [
                'label' => __('Itinerary Days', 'trip-kailash'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'day_number' => __('Day 1', 'trip-kailash'),
                        'day_title' => __('Arrival in Kathmandu', 'trip-kailash'),
                        'day_description' => __('Welcome to Nepal! Upon arrival at Tribhuvan International Airport, you will be greeted by our representative and transferred to your hotel.', 'trip-kailash'),
                        'open_by_default' => 'yes',
                    ],
                ],
                'title_field' => '{{{ day_number }}}: {{{ day_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $total_days = count($settings['days']);
        $show_more_button = $total_days > 5;

        // Register package info for Schema
        if (function_exists('tk_register_package_info') && !empty($settings['days'])) {
            $itinerary_data = [];
            foreach ($settings['days'] as $day) {
                $itinerary_data[] = [
                    'day' => $day['day_number'],
                    'title' => $day['day_title'],
                    'description' => $day['day_description'],
                ];
            }
            tk_register_package_info([
                'itinerary' => $itinerary_data,
            ]);
        }
        ?>
        <section class="tk-pilgrimage-itinerary">
            <div class="tk-container">
                <?php if (!empty($settings['section_title'])): ?>
                    <h2 class="tk-pilgrimage-itinerary__title"><?php echo esc_html($settings['section_title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($settings['days'])): ?>
                    <div class="tk-itinerary-accordion">
                        <?php foreach ($settings['days'] as $index => $day):
                            $is_hidden = $show_more_button && $index >= 5;
                            ?>
                            <details class="tk-itinerary-item <?php echo $is_hidden ? 'tk-itinerary-item--hidden' : ''; ?>" <?php echo ('yes' === $day['open_by_default']) ? 'open' : ''; ?>>
                                <summary class="tk-itinerary-item__summary">
                                    <span class="tk-itinerary-item__day"><?php echo esc_html($day['day_number']); ?></span>
                                    <span class="tk-itinerary-item__title"><?php echo esc_html($day['day_title']); ?></span>
                                    <svg class="tk-itinerary-item__icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </summary>
                                <div class="tk-itinerary-item__content">
                                    <?php echo wp_kses_post($day['day_description']); ?>
                                </div>
                            </details>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($show_more_button): ?>
                        <div class="tk-itinerary-show-more">
                            <button class="tk-itinerary-show-more__btn" type="button">
                                <span class="tk-itinerary-show-more__text">Show More</span>
                                <svg class="tk-itinerary-show-more__icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>

        <style>
            .tk-pilgrimage-itinerary {
                padding: var(--tk-space-lg, 89px) 0;
                background: #FFFFFF;
            }

            .tk-pilgrimage-itinerary__title {
                font-family: var(--tk-font-heading, serif);
                font-size: var(--tk-font-size-h2, 36px);
                color: var(--tk-text-main, #2C2B28);
                margin: 0 0 var(--tk-space-md, 55px) 0;
                font-weight: 400;
            }

            .tk-itinerary-accordion {
                max-width: 900px;
            }

            .tk-itinerary-item {
                border: 1px solid rgba(44, 43, 40, 0.1);
                border-radius: var(--tk-border-radius, 10px);
                margin-bottom: var(--tk-space-xs, 21px);
                overflow: hidden;
                transition: opacity 0.3s ease, max-height 0.3s ease;
            }

            .tk-itinerary-item--hidden {
                display: none;
            }

            .tk-itinerary-item__summary {
                display: flex;
                align-items: center;
                padding: var(--tk-space-sm, 34px);
                cursor: pointer;
                list-style: none;
                user-select: none;
                transition: background-color var(--tk-transition-fast, 0.2s ease);
            }

            .tk-itinerary-item__summary::-webkit-details-marker {
                display: none;
            }

            .tk-itinerary-item__summary:hover {
                background-color: var(--tk-bg-main, #F5F2ED);
            }

            .tk-itinerary-item__day {
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-small, 16px);
                font-weight: 600;
                color: var(--tk-gold, #B8860B);
                margin-right: var(--tk-space-xs, 21px);
                min-width: 60px;
            }

            .tk-itinerary-item__title {
                font-family: var(--tk-font-heading, serif);
                font-size: var(--tk-font-size-body, 18px);
                color: var(--tk-text-main, #2C2B28);
                flex: 1;
            }

            .tk-itinerary-item__icon {
                color: var(--tk-gold, #B8860B);
                transition: transform var(--tk-transition-fast, 0.2s ease);
                flex-shrink: 0;
            }

            .tk-itinerary-item[open] .tk-itinerary-item__icon {
                transform: rotate(180deg);
            }

            .tk-itinerary-item__content {
                padding: 0 var(--tk-space-sm, 34px) var(--tk-space-sm, 34px) var(--tk-space-sm, 34px);
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                line-height: 1.8;
                color: var(--tk-text-main, #2C2B28);
            }

            .tk-itinerary-show-more {
                display: flex;
                justify-content: center;
                margin-top: var(--tk-space-md, 55px);
            }

            .tk-itinerary-show-more__btn {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                padding: 16px 32px;
                background: transparent;
                border: 2px solid var(--tk-gold, #B8860B);
                border-radius: var(--tk-border-radius, 10px);
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                font-weight: 600;
                color: var(--tk-gold, #B8860B);
                cursor: pointer;
                transition: all var(--tk-transition-fast, 0.2s ease);
            }

            .tk-itinerary-show-more__btn:hover {
                background: var(--tk-gold, #B8860B);
                color: #FFFFFF;
            }

            .tk-itinerary-show-more__btn:hover .tk-itinerary-show-more__icon {
                color: #FFFFFF;
            }

            .tk-itinerary-show-more__icon {
                color: var(--tk-gold, #B8860B);
                transition: transform var(--tk-transition-fast, 0.2s ease), color var(--tk-transition-fast, 0.2s ease);
            }

            .tk-itinerary-show-more__btn.is-expanded .tk-itinerary-show-more__icon {
                transform: rotate(180deg);
            }

            @media (max-width: 768px) {
                .tk-pilgrimage-itinerary {
                    padding: var(--tk-space-md, 55px) 0;
                }

                .tk-itinerary-item__summary {
                    padding: var(--tk-space-xs, 21px);
                    flex-wrap: wrap;
                }

                .tk-itinerary-item__day {
                    width: 100%;
                    margin-bottom: 8px;
                }

                .tk-itinerary-item__content {
                    padding: 0 var(--tk-space-xs, 21px) var(--tk-space-xs, 21px) var(--tk-space-xs, 21px);
                }
            }
        </style>
        <?php
    }
}
