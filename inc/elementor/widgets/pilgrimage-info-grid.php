<?php
/**
 * Pilgrimage Info Grid Widget
 * 
 * Displays package details in a 3x3 grid with icons:
 * Destination, Duration, Max Altitude, Grading, Group Size, 
 * Accommodation, Transportation, Meals, Best Time
 */

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Pilgrimage_Info_Grid extends Widget_Base
{

    public function get_name()
    {
        return 'tk-pilgrimage-info-grid';
    }

    public function get_title()
    {
        return __('Pilgrimage Info Grid', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-info-box';
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
                'label' => __('Package Info', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'destination',
            [
                'label' => __('Destination', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Kailash Region', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => __('Duration', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('14 Days', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'max_altitude',
            [
                'label' => __('Max Altitude', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('5,636 m', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'grading',
            [
                'label' => __('Grading', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Moderate', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'group_size',
            [
                'label' => __('Group Size', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('2-15', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'accommodation',
            [
                'label' => __('Accommodation', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Hotel and Tea-House', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'transportation',
            [
                'label' => __('Transportation', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Bus, Van, and Jeep', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'meals',
            [
                'label' => __('Meals', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Breakfast, Lunch, Dinner', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'best_time',
            [
                'label' => __('Best Time', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Mar-May, Sept-Nov', 'trip-kailash'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $info_items = [
            [
                'icon' => 'destination',
                'label' => __('DESTINATION', 'trip-kailash'),
                'value' => $settings['destination'],
            ],
            [
                'icon' => 'duration',
                'label' => __('DURATION', 'trip-kailash'),
                'value' => $settings['duration'],
            ],
            [
                'icon' => 'altitude',
                'label' => __('MAX. ALTITUDE', 'trip-kailash'),
                'value' => $settings['max_altitude'],
            ],
            [
                'icon' => 'grading',
                'label' => __('GRADING', 'trip-kailash'),
                'value' => $settings['grading'],
            ],
            [
                'icon' => 'group',
                'label' => __('GROUP SIZE', 'trip-kailash'),
                'value' => $settings['group_size'],
            ],
            [
                'icon' => 'accommodation',
                'label' => __('ACCOMMODATION', 'trip-kailash'),
                'value' => $settings['accommodation'],
            ],
            [
                'icon' => 'transportation',
                'label' => __('TRANSPORTATION', 'trip-kailash'),
                'value' => $settings['transportation'],
            ],
            [
                'icon' => 'meals',
                'label' => __('MEALS', 'trip-kailash'),
                'value' => $settings['meals'],
            ],
            [
                'icon' => 'best_time',
                'label' => __('BEST TIME', 'trip-kailash'),
                'value' => $settings['best_time'],
            ],
        ];
        ?>
        <section class="tk-info-grid">
            <div class="tk-info-grid__container">
                <?php foreach ($info_items as $item): ?>
                    <div class="tk-info-grid__item">
                        <div class="tk-info-grid__icon">
                            <?php echo $this->get_icon_svg($item['icon']); ?>
                        </div>
                        <div class="tk-info-grid__content">
                            <span class="tk-info-grid__label"><?php echo esc_html($item['label']); ?></span>
                            <span class="tk-info-grid__value"><?php echo esc_html($item['value']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <style>
            .tk-info-grid {
                padding: var(--tk-space-sm, 34px) 0;
                background: var(--tk-bg-main, #F5F2ED);
            }

            .tk-info-grid__container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: var(--tk-space-sm, 34px) var(--tk-space-md, 55px);
                max-width: var(--tk-max-width, 1400px);
                margin: 0 auto;
                padding: 0 var(--tk-space-sm, 34px);
            }

            .tk-info-grid__item {
                display: flex;
                align-items: flex-start;
                gap: 16px;
            }

            .tk-info-grid__icon {
                flex-shrink: 0;
                width: 44px;
                height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .tk-info-grid__icon svg {
                width: 40px;
                height: 40px;
                fill: var(--tk-vishnu, #E67E22);
            }

            .tk-info-grid__content {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .tk-info-grid__label {
                font-family: var(--tk-font-body, sans-serif);
                font-size: 12px;
                font-weight: 500;
                color: rgba(44, 43, 40, 0.6);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .tk-info-grid__value {
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                font-weight: 500;
                color: var(--tk-text-main, #2C2B28);
                line-height: 1.3;
            }

            @media (max-width: 1024px) {
                .tk-info-grid__container {
                    grid-template-columns: repeat(2, 1fr);
                    gap: var(--tk-space-xs, 21px) var(--tk-space-sm, 34px);
                }
            }

            @media (max-width: 600px) {
                .tk-info-grid__container {
                    grid-template-columns: 1fr;
                    gap: var(--tk-space-xs, 21px);
                    padding: 0 var(--tk-space-xs, 21px);
                }

                .tk-info-grid__icon {
                    width: 36px;
                    height: 36px;
                }

                .tk-info-grid__icon svg {
                    width: 32px;
                    height: 32px;
                }

                .tk-info-grid__value {
                    font-size: 16px;
                }
            }
        </style>
        <?php
    }

    private function get_icon_svg($icon)
    {
        $icons = [
            'destination' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',

            'duration' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>',

            'altitude' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 22h20L12 2zm0 4.5L18.5 20h-13L12 6.5z"/></svg>',

            'grading' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/></svg>',

            'group' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',

            'accommodation' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z"/></svg>',

            'transportation' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>',

            'meals' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/></svg>',

            'best_time' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"/></svg>',
        ];

        return isset($icons[$icon]) ? $icons[$icon] : '';
    }
}
