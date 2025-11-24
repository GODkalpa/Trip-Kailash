<?php
/**
 * Sacred Paths Hero Widget
 *
 * Hero for the Sacred Yatra Packages page.
 */

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Sacred_Paths_Hero extends Widget_Base {

    public function get_name() {
        return 'tk-sacred-paths-hero';
    }

    public function get_title() {
        return __( 'Sacred Paths Hero', 'trip-kailash' );
    }

    public function get_icon() {
        return 'eicon-header';
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
            'heading',
            [
                'label'       => __( 'Heading', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Sacred Yatra Packages', 'trip-kailash' ),
                'placeholder' => __( 'Enter main heading', 'trip-kailash' ),
            ]
        );

        $this->add_control(
            'subheading',
            [
                'label'       => __( 'Subheading', 'trip-kailash' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Choose your divine path and embark on a journey of spiritual awakening across the sacred Himalayas.', 'trip-kailash' ),
                'rows'        => 3,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $heading    = ! empty( $settings['heading'] ) ? $settings['heading'] : '';
        $subheading = ! empty( $settings['subheading'] ) ? $settings['subheading'] : '';
        ?>
        <section class="tk-sacred-hero">
            <div class="tk-sacred-hero__inner">
                <div class="tk-sacred-hero__icon">
                    <span class="tk-sacred-hero__divider-line"></span>
                    <span class="tk-sacred-hero__arrow">&#8593;</span>
                </div>

                <?php if ( $heading ) : ?>
                    <h1 class="tk-sacred-hero__title"><?php echo esc_html( $heading ); ?></h1>
                <?php endif; ?>

                <?php if ( $subheading ) : ?>
                    <p class="tk-sacred-hero__subtitle"><?php echo esc_html( $subheading ); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
