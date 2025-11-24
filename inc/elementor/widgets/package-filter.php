<?php
/**
 * Package Filter Widget
 */

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Package_Filter extends Widget_Base {

    public function get_name() {
        return 'tk-package-filter';
    }

    public function get_title() {
        return __('Package Filter', 'trip-kailash');
    }

    public function get_icon() {
        return 'eicon-filter';
    }

    public function get_categories() {
        return ['trip-kailash'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Filter Options', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_duration',
            [
                'label' => __('Show Duration Filter', 'trip-kailash'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'trip-kailash'),
                'label_off' => __('No', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_difficulty',
            [
                'label' => __('Show Difficulty Filter', 'trip-kailash'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'trip-kailash'),
                'label_off' => __('No', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_helicopter',
            [
                'label' => __('Show Helicopter Filter', 'trip-kailash'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'trip-kailash'),
                'label_off' => __('No', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="tk-package-filter">
            <?php if ($settings['show_duration'] === 'yes'): ?>
                <div class="tk-filter-item">
                    <label for="tk-filter-duration"><?php _e('Duration', 'trip-kailash'); ?></label>
                    <select name="duration" id="tk-filter-duration" class="tk-filter-duration tk-form-select">
                        <option value=""><?php _e('All Durations', 'trip-kailash'); ?></option>
                        <option value="short"><?php _e('1-5 days', 'trip-kailash'); ?></option>
                        <option value="medium"><?php _e('6-10 days', 'trip-kailash'); ?></option>
                        <option value="long"><?php _e('11+ days', 'trip-kailash'); ?></option>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_difficulty'] === 'yes'): ?>
                <div class="tk-filter-item">
                    <label for="tk-filter-difficulty"><?php _e('Difficulty', 'trip-kailash'); ?></label>
                    <select name="difficulty" id="tk-filter-difficulty" class="tk-filter-difficulty tk-form-select">
                        <option value=""><?php _e('All Difficulties', 'trip-kailash'); ?></option>
                        <option value="easy"><?php _e('Easy', 'trip-kailash'); ?></option>
                        <option value="moderate"><?php _e('Moderate', 'trip-kailash'); ?></option>
                        <option value="challenging"><?php _e('Challenging', 'trip-kailash'); ?></option>
                    </select>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_helicopter'] === 'yes'): ?>
                <div class="tk-filter-item tk-filter-item--checkbox">
                    <label class="tk-filter-checkbox-label">
                        <input type="checkbox" name="helicopter" class="tk-filter-helicopter">
                        <span><?php _e('Helicopter Only', 'trip-kailash'); ?></span>
                    </label>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
