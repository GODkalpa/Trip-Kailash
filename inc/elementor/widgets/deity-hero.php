<?php
/**
 * Deity Hero Widget
 */

namespace TripKailash\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Deity_Hero extends Widget_Base {

    public function get_name() {
        return 'tk-deity-hero';
    }

    public function get_title() {
        return __('Deity Hero', 'trip-kailash');
    }

    public function get_icon() {
        return 'eicon-header';
    }

    public function get_categories() {
        return ['trip-kailash'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'trip-kailash'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $deity_options = [
            'shiva'  => __('Shiva', 'trip-kailash'),
            'vishnu' => __('Vishnu', 'trip-kailash'),
            'devi'   => __('Devi', 'trip-kailash'),
        ];

        $deity_terms = get_terms([
            'taxonomy'   => 'deity',
            'hide_empty' => false,
        ]);

        if (!is_wp_error($deity_terms) && !empty($deity_terms)) {
            $deity_options = [];
            foreach ($deity_terms as $term) {
                $deity_options[$term->slug] = $term->name;
            }
        }

        $this->add_control(
            'deity',
            [
                'label' => __('Deity', 'trip-kailash'),
                'type' => Controls_Manager::SELECT,
                'options' => $deity_options,
                'default' => 'shiva',
            ]
        );

        $this->add_control(
            'show_navbar',
            [
                'label' => __('Show Hero Navbar', 'trip-kailash'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'trip-kailash'),
                'label_off' => __('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'trip-kailash'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'trip-kailash'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Journey to the Divine', 'trip-kailash'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __('Subtitle', 'trip-kailash'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Experience the sacred pilgrimage', 'trip-kailash'),
                'rows' => 3,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $deity = $settings['deity'];
        $bg_image = $settings['background_image']['url'];
        $show_navbar = isset($settings['show_navbar']) ? $settings['show_navbar'] : 'yes';

        ?>
        <section class="tk-deity-hero tk-deity-hero--<?php echo esc_attr($deity); ?> tk-deity--<?php echo esc_attr($deity); ?>">
            <?php if ('yes' === $show_navbar): ?>
            <!-- Navbar -->
            <header class="tk-header">
                <div class="tk-header__container">
                    <div class="tk-header__logo">
                        <?php if ( function_exists( 'trip_kailash_site_logo' ) ) { trip_kailash_site_logo(); } ?>
                    </div>
                    
                    <nav class="tk-header__nav">
                        <ul class="tk-nav-menu">
                            <li><a href="<?php echo esc_url( home_url( '/sacred-paths' ) ); ?>">Sacred Paths</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/yatra-packages' ) ); ?>">Yatra Packages</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                        </ul>
                    </nav>
                    
                    <div class="tk-header__cta">
                        <a href="<?php echo esc_url( home_url( '/book-yatra' ) ); ?>" class="tk-btn tk-btn-gold">Book Yatra</a>
                    </div>
                    
                    <button class="tk-mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </header>
            <?php endif; ?>
            
            <?php if ($bg_image): ?>
                <div class="tk-deity-hero__bg" style="background-image: url(<?php echo esc_url($bg_image); ?>);"></div>
            <?php endif; ?>
            <div class="tk-deity-hero__overlay"></div>
            <div class="tk-deity-hero__content">
                <h1 class="tk-deity-hero__title"><?php echo esc_html($settings['title']); ?></h1>
                <?php if ($settings['subtitle']): ?>
                    <p class="tk-deity-hero__subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
