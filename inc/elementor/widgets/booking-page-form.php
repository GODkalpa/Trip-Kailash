<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Booking Page Detailed Enquiry Form Widget
 *
 * Two-column layout: highlights on the left, full booking enquiry form on the right.
 * Uses existing Trip Kailash form styling and AJAX contact handler.
 */
class Booking_Page_Form extends Widget_Base {

    public function get_name() {
        return 'tk-booking-page-form';
    }

    public function get_title() {
        return __( 'Booking Page – Enquiry Form', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
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
                'default' => __( 'Complete Your Booking Request', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label'   => __( 'Section Subtitle', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 3,
                'default' => __( 'Share a few details about your group and ideal travel dates. Our Trip Kailash specialists will send you a customised Yatra plan.', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'highlights_title',
            [
                'label'   => __( 'Highlights Title', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Why book with Trip Kailash', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'highlights_text',
            [
                'label'       => __( 'Highlights (one per line)', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => "Dedicated Kailash pilgrimage specialists\nAll permits, logistics & rituals handled\nComfortable lodges and experienced guides\nFlexible dates for private & small groups",
                'description' => __( 'Each line will be shown as a separate bullet point.', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label'   => __( 'Submit Button Text', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Send Booking Request', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label'   => __( 'Success Message', 'trip-kailash' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 3,
                'default' => __( 'Thank you. Our team will review your request and reply with a detailed itinerary and quote.', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'email_recipient',
            [
                'label'       => __( 'Email Recipient', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => get_option( 'admin_email' ),
                'description' => __( 'Address that will receive booking enquiries from this widget.', 'trip-kailash' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Prepare highlights list
        $highlights = [];
        if ( ! empty( $settings['highlights_text'] ) ) {
            $lines = preg_split( '/\r\n|\r|\n/', $settings['highlights_text'] );
            foreach ( $lines as $line ) {
                $line = trim( $line );
                if ( '' !== $line ) {
                    $highlights[] = $line;
                }
            }
        }

        // Get packages for dropdown
        $packages = get_posts( [
            'post_type'      => 'pilgrimage_package',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ] );
        ?>
        <section class="tk-booking-detail">
            <div class="tk-container">
                <div class="tk-booking-detail__inner">
                    <div class="tk-booking-detail__info">
                        <?php if ( ! empty( $settings['section_title'] ) ) : ?>
                            <h2 class="tk-booking-detail__title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
                        <?php endif; ?>

                        <?php if ( ! empty( $settings['section_subtitle'] ) ) : ?>
                            <p class="tk-booking-detail__subtitle"><?php echo esc_html( $settings['section_subtitle'] ); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty( $settings['highlights_title'] ) || ! empty( $highlights ) ) : ?>
                            <div class="tk-booking-detail__highlights">
                                <?php if ( ! empty( $settings['highlights_title'] ) ) : ?>
                                    <h3 class="tk-booking-detail__highlights-title"><?php echo esc_html( $settings['highlights_title'] ); ?></h3>
                                <?php endif; ?>

                                <?php if ( ! empty( $highlights ) ) : ?>
                                    <ul class="tk-booking-detail__highlights-list">
                                        <?php foreach ( $highlights as $item ) : ?>
                                            <li><?php echo esc_html( $item ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tk-booking-detail__form">
                        <form class="tk-form tk-contact-form tk-booking-detail-form" method="post">
                            <?php wp_nonce_field( 'tk_contact_form', 'tk_contact_nonce' ); ?>
                            <input type="hidden" name="action" value="tk_submit_contact_form">
                            <input type="hidden" name="email_recipient" value="<?php echo esc_attr( $settings['email_recipient'] ); ?>">
                            <input type="hidden" name="success_message" value="<?php echo esc_attr( $settings['success_message'] ); ?>">
                            <input type="hidden" name="form_context" value="booking_detail">

                            <div class="tk-booking-detail-form__grid">
                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-full-name">
                                        <?php esc_html_e( 'Full Name', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="text" id="tk-booking-full-name" name="name" class="tk-form-input" required placeholder="<?php esc_attr_e( 'Full Name', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-email-detail">
                                        <?php esc_html_e( 'Email Address', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="email" id="tk-booking-email-detail" name="email" class="tk-form-input" required placeholder="<?php esc_attr_e( 'Email Address', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-phone">
                                        <?php esc_html_e( 'Phone / WhatsApp', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="tel" id="tk-booking-phone" name="phone" class="tk-form-input" placeholder="<?php esc_attr_e( 'Phone / WhatsApp', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-country">
                                        <?php esc_html_e( 'Country / City of Residence', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="text" id="tk-booking-country" name="country" class="tk-form-input" placeholder="<?php esc_attr_e( 'Country / City of Residence', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-package-detail">
                                        <?php esc_html_e( 'Preferred Yatra / Package', 'trip-kailash' ); ?>
                                    </label>
                                    <select id="tk-booking-package-detail" name="package_interest" class="tk-form-select">
                                        <option value=""><?php esc_html_e( 'I am exploring options', 'trip-kailash' ); ?></option>
                                        <?php foreach ( $packages as $package ) : ?>
                                            <option value="<?php echo esc_attr( $package->post_title ); ?>">
                                                <?php echo esc_html( $package->post_title ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-month">
                                        <?php esc_html_e( 'Preferred Travel Month / Season', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="text" id="tk-booking-month" name="travel_month" class="tk-form-input" placeholder="<?php esc_attr_e( 'Preferred Travel Month / Season', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-dates-detail">
                                        <?php esc_html_e( 'Approx. Travel Dates', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="text" id="tk-booking-dates-detail" name="travel_dates" class="tk-form-input" placeholder="<?php esc_attr_e( 'e.g. 15–28 May 2025', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-travellers-detail">
                                        <?php esc_html_e( 'Number of Travellers', 'trip-kailash' ); ?>
                                    </label>
                                    <input type="number" id="tk-booking-travellers-detail" name="group_size" class="tk-form-input" min="1" value="2" placeholder="<?php esc_attr_e( 'Number of Travellers', 'trip-kailash' ); ?>">
                                </div>

                                <div class="tk-form-group">
                                    <label class="tk-form-label" for="tk-booking-room-type">
                                        <?php esc_html_e( 'Room Type Preference', 'trip-kailash' ); ?>
                                    </label>
                                    <select id="tk-booking-room-type" name="room_type" class="tk-form-select">
                                        <option value=""><?php esc_html_e( 'Standard twin / double', 'trip-kailash' ); ?></option>
                                        <option value="single"><?php esc_html_e( 'Single room', 'trip-kailash' ); ?></option>
                                        <option value="triple"><?php esc_html_e( 'Triple room', 'trip-kailash' ); ?></option>
                                        <option value="custom"><?php esc_html_e( 'Mixed / custom', 'trip-kailash' ); ?></option>
                                    </select>
                                </div>

                                <div class="tk-form-group tk-booking-detail-form__full">
                                    <label class="tk-form-label" for="tk-booking-message-detail">
                                        <?php esc_html_e( 'Special Requests / Additional Details', 'trip-kailash' ); ?>
                                    </label>
                                    <textarea id="tk-booking-message-detail" name="message" class="tk-form-textarea" rows="4" placeholder="<?php esc_attr_e( 'Share any health considerations, rituals you wish to include, or flexibility with dates.', 'trip-kailash' ); ?>"></textarea>
                                </div>
                            </div>

                            <div class="tk-booking-detail-form__submit">
                                <button type="submit" class="tk-btn tk-btn-gold">
                                    <?php echo esc_html( $settings['submit_button_text'] ); ?>
                                </button>
                            </div>
                        </form>

                        <div class="tk-form-message" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </section>

        <style>
        .tk-booking-detail {
            padding: var(--tk-space-lg, 89px) 0;
            background-color: var(--tk-bg-main, #F5F2ED);
        }

        .tk-booking-detail__inner {
            max-width: var(--tk-max-width, 1180px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.3fr);
            gap: var(--tk-space-md, 42px);
            align-items: flex-start;
        }

        .tk-booking-detail__info {
            padding-right: var(--tk-space-xs, 20px);
            max-width: 440px;
        }

        .tk-booking-detail__title {
            font-family: var(--tk-font-heading, serif);
            font-size: clamp(28px, 3.2vw, 36px);
            font-weight: 400;
            margin: 0 0 10px 0;
            color: var(--tk-text-main, #2C2B28);
        }

        .tk-booking-detail__subtitle {
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-body, 18px);
            line-height: 1.6;
            color: rgba(44, 43, 40, 0.8);
            margin: 0 0 var(--tk-space-xs, 20px) 0;
            max-width: 36rem;
        }

        .tk-booking-detail__highlights {
            margin-top: var(--tk-space-xs, 18px);
            padding-top: 14px;
            border-top: 1px solid rgba(44, 43, 40, 0.08);
        }

        .tk-booking-detail__highlights-title {
            font-family: var(--tk-font-heading, serif);
            font-size: var(--tk-font-size-h4, 20px);
            margin: 0 0 12px 0;
            color: var(--tk-text-main, #2C2B28);
        }

        .tk-booking-detail__highlights-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            row-gap: 8px;
        }

        .tk-booking-detail__highlights-list li {
            position: relative;
            padding-left: 26px;
            margin-bottom: 0;
            font-family: var(--tk-font-body, sans-serif);
            font-size: var(--tk-font-size-small, 16px);
            color: rgba(44, 43, 40, 0.9);
        }

        .tk-booking-detail__highlights-list li::before {
            content: '\2713';
            position: absolute;
            left: 0;
            top: 0;
            color: var(--tk-gold, #B8860B);
            font-weight: 600;
        }

        .tk-booking-detail__form {
            background-color: #FFFFFF;
            border-radius: var(--tk-border-radius, 14px);
            box-shadow: var(--tk-shadow-card, 0 18px 40px rgba(0, 0, 0, 0.15));
            padding: 22px 26px 24px;
        }

        .tk-booking-detail-form__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 16px;
        }

        .tk-booking-detail-form__full {
            grid-column: 1 / -1;
        }

        .tk-booking-detail-form__submit {
            margin-top: var(--tk-space-xs, 18px);
            text-align: right;
        }

        .tk-booking-detail-form__submit .tk-btn {
            min-width: 220px;
        }

        /* Compact form sizing only for booking detail form */
        .tk-booking-detail__form .tk-form-label {
            margin-bottom: 4px;
            font-size: 13px;
        }

        .tk-booking-detail__form .tk-form-group {
            margin-bottom: 8px;
        }

        .tk-booking-detail__form .tk-form-group:last-of-type {
            margin-bottom: 0;
        }

        .tk-booking-detail__form .tk-form-input,
        .tk-booking-detail__form .tk-form-select {
            padding: 8px 14px;
            font-size: var(--tk-font-size-small, 15px);
            border-width: 1px;
            border-radius: 8px;
            border-color: rgba(44, 43, 40, 0.18);
        }

        .tk-booking-detail__form .tk-form-textarea {
            padding: 10px 14px;
            min-height: 96px;
            font-size: var(--tk-font-size-small, 15px);
            border-width: 1px;
            border-radius: 8px;
            border-color: rgba(44, 43, 40, 0.18);
        }

        .tk-booking-detail__form .tk-btn {
            padding: 10px 28px;
        }

        @media (max-width: 1024px) {
            .tk-booking-detail {
                padding: var(--tk-space-md, 64px) 0;
            }

            .tk-booking-detail__inner {
                grid-template-columns: 1fr;
                max-width: 640px;
            }

            .tk-booking-detail__info {
                padding-right: 0;
                margin-bottom: var(--tk-space-sm, 24px);
            }

            .tk-booking-detail__form {
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .tk-booking-detail {
                padding: var(--tk-space-md, 40px) 0;
            }

            .tk-booking-detail__inner {
                max-width: 100%;
            }

            .tk-booking-detail .tk-container {
                padding-left: var(--tk-space-xs, 12px);
                padding-right: var(--tk-space-xs, 12px);
            }

            .tk-booking-detail__info {
                text-align: center;
            }

            .tk-booking-detail__form {
                padding: 8px 0 14px;
                max-width: 100%;
                background-color: transparent;
                box-shadow: none;
            }

            .tk-booking-detail-form__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 6px 10px;
            }

            .tk-booking-detail-form__submit {
                margin-top: var(--tk-space-xs, 14px);
                text-align: center;
            }

            .tk-booking-detail-form__submit .tk-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .tk-booking-detail-form__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 6px 8px;
            }

            .tk-booking-detail__form .tk-form-label {
                display: none;
            }
        }
        </style>
        <?php
    }
}
