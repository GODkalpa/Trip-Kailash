<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class Pilgrimage_Inclusions extends Widget_Base
{

    public function get_name()
    {
        return 'tk-pilgrimage-inclusions';
    }

    public function get_title()
    {
        return __('Pilgrimage Inclusions & Exclusions', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-checkbox';
    }

    public function get_categories()
    {
        return ['trip-kailash'];
    }

    protected function register_controls()
    {
        // Inclusions Section
        $this->start_controls_section(
            'inclusions_section',
            [
                'label' => __('Inclusions', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'inclusions_title',
            [
                'label' => __('Inclusions Title', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('What\'s Included', 'trip-kailash'),
            ]
        );

        $inclusions_repeater = new Repeater();

        $inclusions_repeater->add_control(
            'item_text',
            [
                'label' => __('Item', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Included item', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'inclusions',
            [
                'label' => __('Included Items', 'trip-kailash'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $inclusions_repeater->get_controls(),
                'default' => [
                    ['item_text' => __('Accommodation in hotels/lodges', 'trip-kailash')],
                    ['item_text' => __('All meals during the trip', 'trip-kailash')],
                    ['item_text' => __('Transportation as per itinerary', 'trip-kailash')],
                    ['item_text' => __('Experienced guide', 'trip-kailash')],
                    ['item_text' => __('All permits and entry fees', 'trip-kailash')],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        // Exclusions Section
        $this->start_controls_section(
            'exclusions_section',
            [
                'label' => __('Exclusions', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'exclusions_title',
            [
                'label' => __('Exclusions Title', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('What\'s Not Included', 'trip-kailash'),
            ]
        );

        $exclusions_repeater = new Repeater();

        $exclusions_repeater->add_control(
            'item_text',
            [
                'label' => __('Item', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Excluded item', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'exclusions',
            [
                'label' => __('Excluded Items', 'trip-kailash'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $exclusions_repeater->get_controls(),
                'default' => [
                    ['item_text' => __('International airfare', 'trip-kailash')],
                    ['item_text' => __('Travel insurance', 'trip-kailash')],
                    ['item_text' => __('Personal expenses', 'trip-kailash')],
                    ['item_text' => __('Tips and gratuities', 'trip-kailash')],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="tk-pilgrimage-inclusions">
            <div class="tk-container">
                <div class="tk-inclusions-grid">
                    <!-- Inclusions Column -->
                    <div class="tk-inclusions-column tk-inclusions-column--included">
                        <?php if (!empty($settings['inclusions_title'])): ?>
                            <h3 class="tk-inclusions-column__title">
                                <svg class="tk-inclusions-column__icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                    <path d="M8 12L11 15L16 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <?php echo esc_html($settings['inclusions_title']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($settings['inclusions'])): ?>
                            <ul class="tk-inclusions-list">
                                <?php foreach ($settings['inclusions'] as $item): ?>
                                    <li class="tk-inclusions-list__item">
                                        <svg class="tk-inclusions-list__check" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M4 10L8 14L16 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span><?php echo esc_html($item['item_text']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Exclusions Column -->
                    <div class="tk-inclusions-column tk-inclusions-column--excluded">
                        <?php if (!empty($settings['exclusions_title'])): ?>
                            <h3 class="tk-inclusions-column__title">
                                <svg class="tk-inclusions-column__icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                    <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <?php echo esc_html($settings['exclusions_title']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($settings['exclusions'])): ?>
                            <ul class="tk-inclusions-list">
                                <?php foreach ($settings['exclusions'] as $item): ?>
                                    <li class="tk-inclusions-list__item tk-inclusions-list__item--excluded">
                                        <svg class="tk-inclusions-list__cross" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M14 6L6 14M6 6L14 14" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                        <span><?php echo esc_html($item['item_text']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .tk-pilgrimage-inclusions {
                padding: var(--tk-space-lg, 89px) 0;
                background: var(--tk-bg-main, #F5F2ED);
            }

            .tk-inclusions-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: var(--tk-space-md, 55px);
                max-width: 1000px;
            }

            .tk-inclusions-column {
                background: #FFFFFF;
                border-radius: var(--tk-border-radius, 10px);
                padding: var(--tk-space-sm, 34px);
            }

            .tk-inclusions-column__title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-family: var(--tk-font-heading, serif);
                font-size: var(--tk-font-size-h3, 24px);
                font-weight: 400;
                margin: 0 0 var(--tk-space-sm, 34px) 0;
            }

            .tk-inclusions-column--included .tk-inclusions-column__title {
                color: #2E7D32;
            }

            .tk-inclusions-column--included .tk-inclusions-column__icon {
                color: #2E7D32;
            }

            .tk-inclusions-column--excluded .tk-inclusions-column__title {
                color: #C62828;
            }

            .tk-inclusions-column--excluded .tk-inclusions-column__icon {
                color: #C62828;
            }

            .tk-inclusions-list {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .tk-inclusions-list__item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px solid rgba(44, 43, 40, 0.1);
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                color: var(--tk-text-main, #2C2B28);
                line-height: 1.5;
            }

            .tk-inclusions-list__item:last-child {
                border-bottom: none;
            }

            .tk-inclusions-list__check {
                color: #2E7D32;
                flex-shrink: 0;
                margin-top: 2px;
            }

            .tk-inclusions-list__cross {
                color: #C62828;
                flex-shrink: 0;
                margin-top: 2px;
            }

            @media (max-width: 768px) {
                .tk-pilgrimage-inclusions {
                    padding: var(--tk-space-md, 55px) 0;
                }

                .tk-inclusions-grid {
                    grid-template-columns: 1fr;
                    gap: var(--tk-space-sm, 34px);
                }

                .tk-inclusions-column {
                    padding: var(--tk-space-xs, 21px);
                }

                .tk-inclusions-column__title {
                    font-size: 20px;
                }

                .tk-inclusions-list__item {
                    font-size: 16px;
                }
            }
        </style>
        <?php
    }
}
