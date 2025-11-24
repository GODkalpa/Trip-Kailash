<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Pilgrimage_Pricing_Bar extends Widget_Base {

    public function get_name() {
        return 'tk-pilgrimage-pricing-bar';
    }

    public function get_title() {
        return __( 'Pilgrimage Pricing Bar', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-price-table';
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
            'duration',
            [
                'label'       => __( 'Duration', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( '12 Days Trip', 'trip-kailash' ),
                'placeholder' => __( 'e.g. 12 Days Trip', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'price_label',
            [
                'label'       => __( 'Price Label', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Starting From', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'price',
            [
                'label'       => __( 'Price', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'NPR 125000', 'trip-kailash' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'price_suffix',
            [
                'label'       => __( 'Price Suffix', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( '/Person', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => __( 'Button Text', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Book Now', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'       => __( 'Button Link', 'trip-kailash' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'trip-kailash' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'trip-kailash' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_background_color',
            [
                'label'     => __( 'Background Color', 'trip-kailash' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .tk-pricing-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'bar_box_shadow',
                'label'    => __( 'Box Shadow', 'trip-kailash' ),
                'selector' => '{{WRAPPER}} .tk-pricing-bar',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        ?>
        <div id="tk-pricing-bar-<?php echo esc_attr( $widget_id ); ?>" class="tk-pricing-bar-wrapper">
            <div class="tk-pricing-bar-placeholder"></div>
            <div class="tk-pricing-bar">
                <div class="tk-container tk-pricing-bar__inner">
                    
                    <!-- Left: Duration -->
                    <div class="tk-pricing-bar__left">
                        <?php if ( ! empty( $settings['duration'] ) ) : ?>
                            <div class="tk-pricing-bar__duration">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span><?php echo esc_html( $settings['duration'] ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Center: Price -->
                    <div class="tk-pricing-bar__center">
                        <div class="tk-pricing-bar__price-content">
                            <div class="tk-pricing-bar__label-row">
                                <?php if ( ! empty( $settings['price_label'] ) ) : ?>
                                    <span class="tk-pricing-bar__label"><?php echo esc_html( $settings['price_label'] ); ?></span>
                                <?php endif; ?>
                                
                                <div class="tk-pricing-bar__badge">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    <span>Best Deal</span>
                                </div>
                            </div>
                            
                            <div class="tk-pricing-bar__amount-wrap">
                                <?php if ( ! empty( $settings['price'] ) ) : ?>
                                    <span class="tk-pricing-bar__amount"><?php echo esc_html( $settings['price'] ); ?></span>
                                <?php endif; ?>

                                <?php if ( ! empty( $settings['price_suffix'] ) ) : ?>
                                    <span class="tk-pricing-bar__suffix"><?php echo esc_html( $settings['price_suffix'] ); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Action -->
                    <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                        <div class="tk-pricing-bar__right">
                            <a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>" class="tk-btn tk-btn--gold tk-pricing-bar__btn">
                                <span class="tk-pricing-bar__btn-label"><?php echo esc_html( $settings['button_text'] ); ?></span>
                                <span class="tk-pricing-bar__btn-arrow">&rarr;</span>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <style>
        .tk-pricing-bar-wrapper {
            position: relative;
            width: 100%;
        }

        .tk-pricing-bar-placeholder {
            display: none;
            width: 100%;
            height: 100px; /* Approximate height, adjusted by JS */
        }

        .tk-pricing-bar {
            width: 100%;
            padding: 20px 0;
            background: #FFFFFF;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            z-index: 99;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: box-shadow 0.3s ease, padding 0.3s ease;
        }

        .tk-pricing-bar.is-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 10px 0;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            animation: slideDown 0.3s ease forwards;
        }

        .tk-pricing-bar.is-sticky .tk-pricing-bar__duration {
            padding: 6px 14px;
            font-size: 14px;
        }

        .tk-pricing-bar.is-sticky .tk-pricing-bar__amount {
            font-size: 28px;
        }

        .tk-pricing-bar.is-sticky .tk-pricing-bar__suffix {
            font-size: 12px;
        }

        .tk-pricing-bar.is-sticky .tk-pricing-bar__btn {
            padding: 6px 20px;
            font-size: 13px;
        }

        body.admin-bar .tk-pricing-bar.is-sticky {
            top: 32px;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        .tk-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .tk-pricing-bar__inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        /* Duration Pill */
        .tk-pricing-bar__duration {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #F9F9F9;
            padding: 10px 20px;
            border-radius: 50px;
            font-family: var(--tk-font-heading, serif);
            font-weight: 600;
            font-size: 16px;
            color: var(--tk-text-main, #2C2B28);
            border: 1px solid #EEEEEE;
            transition: all 0.3s ease;
        }

        .tk-pricing-bar__duration:hover {
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transform: translateY(-1px);
        }

        .tk-pricing-bar__duration svg {
            color: var(--tk-gold, #B8860B);
        }

        /* Price Section */
        .tk-pricing-bar__center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .tk-pricing-bar__price-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tk-pricing-bar__label-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .tk-pricing-bar__label {
            font-family: var(--tk-font-body, sans-serif);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888888;
            font-weight: 500;
        }

        /* Badge */
        .tk-pricing-bar__badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #FFF8E1;
            color: #B8860B;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            line-height: 1;
            border: 1px solid rgba(184, 134, 11, 0.2);
        }

        .tk-pricing-bar__amount-wrap {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .tk-pricing-bar__amount {
            font-family: var(--tk-font-heading, serif);
            font-size: 36px;
            font-weight: 700;
            color: #00875A; /* Premium Green */
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .tk-pricing-bar__suffix {
            font-family: var(--tk-font-body, sans-serif);
            font-size: 14px;
            color: #666666;
            font-weight: 400;
        }

        /* Button */
        .tk-pricing-bar__btn {
            display: inline-flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border-radius: 999px;
            background: var(--tk-gold, #B8860B);
            color: #FFFFFF;
            text-decoration: none;
            text-align: center;
            transition: background 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
            box-shadow: 0 4px 15px rgba(184, 134, 11, 0.3);
            white-space: nowrap;
        }

        .tk-pricing-bar__btn:hover {
            background: #A67C0A;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(184, 134, 11, 0.4);
        }

        .tk-pricing-bar__btn-label {
            display: inline-block;
        }

        .tk-pricing-bar__btn-arrow {
            display: inline-block;
            margin-left: 4px;
            font-size: 1em;
            line-height: 1;
            transition: transform 0.2s ease;
        }

        .tk-pricing-bar__btn:hover .tk-pricing-bar__btn-arrow {
            transform: translateX(2px);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .tk-pricing-bar__amount {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .tk-pricing-bar__inner {
                flex-direction: column;
                gap: 16px;
                padding: 24px 20px;
            }

            .tk-pricing-bar__left,
            .tk-pricing-bar__center,
            .tk-pricing-bar__right {
                width: 100%;
                justify-content: center;
                display: flex;
            }

            .tk-pricing-bar__center {
                flex-direction: column;
                gap: 10px;
                padding: 10px 0;
                border-top: 1px solid #f0f0f0;
                border-bottom: 1px solid #f0f0f0;
            }

            .tk-pricing-bar__btn {
                width: 100%;
                justify-content: center;
            }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('tk-pricing-bar-<?php echo esc_attr( $widget_id ); ?>');
            const bar = wrapper.querySelector('.tk-pricing-bar');
            const placeholder = wrapper.querySelector('.tk-pricing-bar-placeholder');
            const header = document.querySelector('.tk-header');
            
            // Check sticky state
            const checkSticky = () => {
                const isMobile = window.innerWidth <= 768;

                // Disable sticky behavior on mobile
                if (isMobile) {
                    if (bar.classList.contains('is-sticky')) {
                        bar.classList.remove('is-sticky');
                        placeholder.style.display = 'none';

                        if (header) {
                            header.classList.remove('tk-header--hidden-by-pricing');
                        }
                    }
                    return;
                }

                const wrapperRect = wrapper.getBoundingClientRect();
                const headerHeight = header ? header.offsetHeight : 72;

                // If top of wrapper hits the header bottom
                if (wrapperRect.top <= headerHeight) {
                    if (!bar.classList.contains('is-sticky')) {
                        // Set placeholder height to prevent jump
                        placeholder.style.height = bar.offsetHeight + 'px';
                        placeholder.style.display = 'block';
                        
                        bar.classList.add('is-sticky');
                        
                        // Hide the navbar
                        if (header) {
                            header.classList.add('tk-header--hidden-by-pricing');
                        }
                    }
                } else {
                    if (bar.classList.contains('is-sticky')) {
                        bar.classList.remove('is-sticky');
                        placeholder.style.display = 'none';
                        
                        // Show the navbar again
                        if (header) {
                            header.classList.remove('tk-header--hidden-by-pricing');
                        }
                    }
                }
            };

            window.addEventListener('scroll', checkSticky);
            window.addEventListener('resize', checkSticky);
            checkSticky(); // Initial check
        });
        </script>
        <?php
    }
}
