<?php

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Pilgrimage_Inquiry_Form extends Widget_Base
{

    public function get_name()
    {
        return 'tk-pilgrimage-inquiry-form';
    }

    public function get_title()
    {
        return __('Pilgrimage Inquiry Form', 'trip-kailash');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
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
                'default' => __('Ready to Begin Your Journey?', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Section Subtitle', 'trip-kailash'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => __('Contact us to learn more about this pilgrimage package', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'name_label',
            [
                'label' => __('Name Field Label', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Name', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'email_label',
            [
                'label' => __('Email Field Label', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Email Address', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'message_label',
            [
                'label' => __('Message Field Label', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Message', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'submit_text',
            [
                'label' => __('Submit Button Text', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Send Inquiry', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'form_action',
            [
                'label' => __('Form Action URL', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Leave empty for default', 'trip-kailash'),
                'description' => __('Where the form data should be submitted', 'trip-kailash'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $form_action = !empty($settings['form_action']) ? $settings['form_action'] : admin_url('admin-post.php');
        ?>
        <section class="tk-pilgrimage-inquiry">
            <div class="tk-container">
                <div class="tk-inquiry-form-wrapper">
                    <div class="tk-inquiry-header">
                        <?php if (!empty($settings['section_title'])): ?>
                            <h2 class="tk-inquiry-header__title"><?php echo esc_html($settings['section_title']); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($settings['section_subtitle'])): ?>
                            <p class="tk-inquiry-header__subtitle"><?php echo esc_html($settings['section_subtitle']); ?></p>
                        <?php endif; ?>
                    </div>

                    <form class="tk-inquiry-form" method="post" action="<?php echo esc_url($form_action); ?>">
                        <div class="tk-form-row">
                            <div class="tk-form-group">
                                <label for="inquiry-name" class="tk-form-label">
                                    <?php echo esc_html($settings['name_label']); ?>
                                </label>
                                <input type="text" id="inquiry-name" name="inquiry_name" class="tk-form-input" required>
                            </div>

                            <div class="tk-form-group">
                                <label for="inquiry-email" class="tk-form-label">
                                    <?php echo esc_html($settings['email_label']); ?>
                                </label>
                                <input type="email" id="inquiry-email" name="inquiry_email" class="tk-form-input" required>
                            </div>
                        </div>

                        <div class="tk-form-group">
                            <label for="inquiry-message" class="tk-form-label">
                                <?php echo esc_html($settings['message_label']); ?>
                            </label>
                            <textarea id="inquiry-message" name="inquiry_message" class="tk-form-textarea" rows="6"
                                required></textarea>
                        </div>

                        <input type="hidden" name="action" value="tk_inquiry_form">
                        <input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                        <?php wp_nonce_field('tk_inquiry_form', 'tk_inquiry_nonce'); ?>

                        <div class="tk-form-submit">
                            <button type="submit" class="tk-btn tk-btn--gold">
                                <?php echo esc_html($settings['submit_text']); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <style>
            .tk-pilgrimage-inquiry {
                padding: var(--tk-space-lg, 89px) 0;
                background: var(--tk-bg-main, #F5F2ED);
            }

            .tk-inquiry-form-wrapper {
                max-width: 800px;
                margin: 0 auto;
            }

            .tk-inquiry-header {
                text-align: center;
                margin-bottom: var(--tk-space-md, 55px);
            }

            .tk-inquiry-header__title {
                font-family: var(--tk-font-heading, serif);
                font-size: var(--tk-font-size-h2, 36px);
                color: var(--tk-text-main, #2C2B28);
                margin: 0 0 var(--tk-space-xs, 21px) 0;
                font-weight: 400;
            }

            .tk-inquiry-header__subtitle {
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-body, 18px);
                color: var(--tk-text-main, #2C2B28);
                margin: 0;
                line-height: 1.6;
            }

            .tk-inquiry-form {
                background: #FFFFFF;
                padding: var(--tk-space-md, 55px);
                border-radius: var(--tk-border-radius, 10px);
                box-shadow: var(--tk-shadow-card, 0 4px 20px rgba(44, 43, 40, 0.08));
            }

            .tk-form-row {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: var(--tk-space-sm, 34px);
                margin-bottom: var(--tk-space-sm, 34px);
            }

            .tk-form-group {
                margin-bottom: var(--tk-space-sm, 34px);
            }

            .tk-form-label {
                display: block;
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-small, 16px);
                font-weight: 600;
                color: var(--tk-text-main, #2C2B28);
                margin-bottom: 8px;
            }

            .tk-form-input,
            .tk-form-textarea {
                width: 100%;
                padding: 16px;
                font-family: var(--tk-font-body, sans-serif);
                font-size: var(--tk-font-size-small, 16px);
                color: var(--tk-text-main, #2C2B28);
                border: 1px solid rgba(44, 43, 40, 0.2);
                border-radius: var(--tk-border-radius-sm, 8px);
                transition: border-color var(--tk-transition-fast, 0.2s ease);
            }

            .tk-form-input:focus,
            .tk-form-textarea:focus {
                outline: none;
                border-color: var(--tk-gold, #B8860B);
            }

            .tk-form-textarea {
                resize: vertical;
            }

            .tk-form-submit {
                text-align: center;
                margin-top: var(--tk-space-sm, 34px);
            }

            @media (max-width: 768px) {
                .tk-pilgrimage-inquiry {
                    padding: var(--tk-space-md, 55px) 0;
                }

                .tk-inquiry-form {
                    padding: var(--tk-space-sm, 34px);
                }

                .tk-form-row {
                    grid-template-columns: 1fr;
                    gap: 0;
                }
            }
        </style>
        <?php
    }
}
