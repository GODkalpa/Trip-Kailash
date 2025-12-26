<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Booking Page Search Bar Widget
 *
 * Compact "booking search" style bar for the Book Yatra page.
 * Uses existing Trip Kailash form styling and AJAX contact handler.
 */
class Booking_Page_Search extends Widget_Base
{

    public function get_name()
    {
        return 'tk-booking-page-search';
    }

    public function get_title()
    {
        return __('Booking Page – Search Bar', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-search';
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
            'heading',
            [
                'label' => __('Heading', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Plan Your Kailash Yatra', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'subheading',
            [
                'label' => __('Subheading', 'trip-kailash'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => __('Tell us when you wish to travel and we will confirm availability, pricing, and the best route for your group.', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label' => __('Button Text', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Check Availability', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label' => __('Success Message', 'trip-kailash'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __('Thank you. Our Kailash team will reach out shortly with availability and next steps.', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'email_recipient',
            [
                'label' => __('Email Recipient', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => get_option('admin_email'),
                'description' => __('Address that will receive booking enquiries from this widget.', 'trip-kailash'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Get all pilgrimage packages for the dropdown
        $packages = get_posts([
            'post_type' => 'pilgrimage_package',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);
        ?>
        <section class="tk-booking-search">
            <div class="tk-container">
                <div class="tk-booking-search__inner">
                    <?php if (!empty($settings['heading'])): ?>
                        <h2 class="tk-booking-search__heading"><?php echo esc_html($settings['heading']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['subheading'])): ?>
                        <p class="tk-booking-search__subheading"><?php echo esc_html($settings['subheading']); ?></p>
                    <?php endif; ?>

                    <form class="tk-form tk-contact-form tk-booking-search__form" method="post">
                        <?php wp_nonce_field('tk_contact_form', 'tk_contact_nonce'); ?>
                        <input type="hidden" name="action" value="tk_submit_contact_form">
                        <input type="hidden" name="email_recipient"
                            value="<?php echo esc_attr($settings['email_recipient']); ?>">
                        <input type="hidden" name="success_message"
                            value="<?php echo esc_attr($settings['success_message']); ?>">
                        <input type="hidden" name="form_context" value="booking_search">

                        <!-- Honeypot spam trap - hidden from users, bots will fill it -->
                        <div style="position: absolute; left: -9999px;" aria-hidden="true">
                            <input type="text" name="tk_website_url" value="" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="tk-booking-search__grid">
                            <div class="tk-form-group tk-booking-search__field">
                                <label class="tk-form-label" for="tk-booking-name">
                                    <?php esc_html_e('Your Name', 'trip-kailash'); ?>
                                </label>
                                <input type="text" id="tk-booking-name" name="name" class="tk-form-input" required>
                            </div>

                            <div class="tk-form-group tk-booking-search__field">
                                <label class="tk-form-label" for="tk-booking-email">
                                    <?php esc_html_e('Email Address', 'trip-kailash'); ?>
                                </label>
                                <input type="email" id="tk-booking-email" name="email" class="tk-form-input" required>
                            </div>

                            <div class="tk-form-group tk-booking-search__field">
                                <label class="tk-form-label" for="tk-booking-package">
                                    <?php esc_html_e('Preferred Route / Package', 'trip-kailash'); ?>
                                </label>
                                <select id="tk-booking-package" name="package_interest" class="tk-form-select">
                                    <option value=""><?php esc_html_e('Any Yatra', 'trip-kailash'); ?></option>
                                    <?php foreach ($packages as $package): ?>
                                        <option value="<?php echo esc_attr($package->post_title); ?>">
                                            <?php echo esc_html($package->post_title); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="tk-form-group tk-booking-search__field">
                                <label class="tk-form-label" for="tk-booking-dates-start">
                                    <?php esc_html_e('Travel Dates', 'trip-kailash'); ?>
                                </label>
                                <div class="tk-booking-search__dates">
                                    <input type="date" id="tk-booking-dates-start" name="travel_start"
                                        class="tk-form-input tk-booking-search__date">
                                    <span class="tk-booking-search__date-separator">&#8594;</span>
                                    <input type="date" id="tk-booking-dates-end" name="travel_end"
                                        class="tk-form-input tk-booking-search__date">
                                </div>
                            </div>

                            <div class="tk-form-group tk-booking-search__field">
                                <label class="tk-form-label" for="tk-booking-travellers">
                                    <?php esc_html_e('Travellers', 'trip-kailash'); ?>
                                </label>
                                <input type="number" id="tk-booking-travellers" name="group_size" class="tk-form-input" min="1"
                                    value="2">
                            </div>

                            <div class="tk-form-group tk-booking-search__field tk-booking-search__submit">
                                <button type="submit" class="tk-btn tk-btn-gold">
                                    <?php echo esc_html($settings['submit_button_text']); ?>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="tk-form-message" style="display:none;"></div>
                </div>
            </div>
        </section>

        <style>
            .tk-booking-search {
                padding: var(--tk-space-md, 55px) 0;
                background: linear-gradient(135deg, rgba(26, 27, 58, 0.96), rgba(44, 43, 40, 0.96));
            }

            .tk-booking-search__inner {
                max-width: var(--tk-max-width, 1180px);
                margin: 0 auto;
                background-color: var(--tk-bg-main, #F5F2ED);
                border-radius: var(--tk-border-radius, 14px);
                box-shadow: var(--tk-shadow-card, 0 18px 40px rgba(0, 0, 0, 0.35));
                padding: var(--tk-space-sm, 34px);
            }

            .tk-booking-search__heading {
                font-family: var(--tk-font-heading, serif);
                font-size: clamp(26px, 3vw, 32px);
                margin: 0 0 4px 0;
                color: var(--tk-text-main, #2C2B28);
            }

            .tk-booking-search__subheading {
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-small, 16px);
                color: rgba(44, 43, 40, 0.8);
                margin: 0 0 var(--tk-space-sm, 26px) 0;
            }

            .tk-booking-search__grid {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: var(--tk-space-xs, 16px);
                align-items: flex-end;
            }

            .tk-booking-search__field {
                margin: 0;
            }

            /* Layout: name, email, package, dates, travellers, button */
            .tk-booking-search__field:nth-child(1) {
                grid-column: span 2;
            }

            .tk-booking-search__field:nth-child(2) {
                grid-column: span 2;
            }

            .tk-booking-search__field:nth-child(3),
            .tk-booking-search__field:nth-child(4),
            .tk-booking-search__field:nth-child(5),
            .tk-booking-search__field:nth-child(6) {
                grid-column: span 1;
            }

            .tk-booking-search__dates {
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                gap: 6px;
                align-items: center;
            }

            .tk-booking-search__date-separator {
                font-size: 18px;
                color: rgba(44, 43, 40, 0.7);
            }

            .tk-booking-search__submit {
                text-align: right;
            }

            .tk-booking-search__submit .tk-btn {
                width: 100%;
            }

            @media (max-width: 1024px) {
                .tk-booking-search__grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .tk-booking-search__field:nth-child(1),
                .tk-booking-search__field:nth-child(2),
                .tk-booking-search__field:nth-child(3),
                .tk-booking-search__field:nth-child(4),
                .tk-booking-search__field:nth-child(5) {
                    grid-column: span 1;
                }

                .tk-booking-search__submit {
                    grid-column: span 2;
                }
            }

            @media (max-width: 768px) {
                .tk-booking-search__inner {
                    padding: var(--tk-space-xs, 20px);
                }

                .tk-booking-search__grid {
                    grid-template-columns: 1fr;
                }

                .tk-booking-search__field:nth-child(n) {
                    grid-column: span 1;
                }

                .tk-booking-search__submit {
                    text-align: center;
                }

                .tk-booking-search__submit .tk-btn {
                    width: 100%;
                }
            }
        </style>
        <?php
    }
}
