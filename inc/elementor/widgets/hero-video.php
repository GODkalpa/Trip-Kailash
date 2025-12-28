<?php
/**
 * Hero Video Widget
 *
 * @package TripKailash
 * @since 1.0.0
 */

namespace TripKailash\Widgets;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hero Video Widget Class
 */
class Hero_Video extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     */
    public function get_name()
    {
        return 'trip-kailash-hero-video';
    }

    /**
     * Get widget title
     */
    public function get_title()
    {
        return esc_html__('Hero Video', 'trip-kailash');
    }

    /**
     * Get widget icon
     */
    public function get_icon()
    {
        return 'eicon-video-camera';
    }

    /**
     * Get widget categories
     */
    public function get_categories()
    {
        return array('trip-kailash');
    }

    /**
     * Get widget keywords
     */
    public function get_keywords()
    {
        return array('hero', 'video', 'banner', 'header');
    }

    /**
     * Register widget controls
     */
    protected function register_controls()
    {

        // Content Section
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__('Content', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'video_source',
            array(
                'label' => esc_html__('Video Source', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => array('video'),
                'default' => array(
                    'url' => '',
                ),
                'description' => esc_html__('Upload a video file from WordPress Media Library (MP4, WebM recommended)', 'trip-kailash'),
            )
        );

        $this->add_control(
            'show_trishul',
            array(
                'label' => esc_html__('Show Trishul Icon', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'heading',
            array(
                'label' => esc_html__('Heading', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Walk the Path of Gods', 'trip-kailash'),
                'placeholder' => esc_html__('Enter your heading', 'trip-kailash'),
            )
        );

        $this->add_control(
            'subheading',
            array(
                'label' => esc_html__('Subheading', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Experience sacred pilgrimages to the most revered temples and holy sites', 'trip-kailash'),
                'placeholder' => esc_html__('Enter your subheading', 'trip-kailash'),
                'rows' => 3,
            )
        );

        $this->end_controls_section();

        // CTA Buttons Section
        $this->start_controls_section(
            'cta_buttons_section',
            array(
                'label' => esc_html__('CTA Buttons', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'primary_button_text',
            array(
                'label' => esc_html__('Primary Button Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Begin Your Yatra', 'trip-kailash'),
            )
        );

        $this->add_control(
            'primary_button_link',
            array(
                'label' => esc_html__('Primary Button Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->add_control(
            'secondary_button_text',
            array(
                'label' => esc_html__('Secondary Button Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Speak with Tirtha Purohit', 'trip-kailash'),
            )
        );

        $this->add_control(
            'secondary_button_link',
            array(
                'label' => esc_html__('Secondary Button Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->end_controls_section();

        // Scroll Section
        $this->start_controls_section(
            'scroll_section',
            array(
                'label' => esc_html__('Scroll Indicator', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_scroll_indicator',
            array(
                'label' => esc_html__('Show Scroll Indicator', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'scroll_text',
            array(
                'label' => esc_html__('Scroll Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('DISCOVER SACRED JOURNEYS', 'trip-kailash'),
                'condition' => array(
                    'show_scroll_indicator' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            array(
                'label' => esc_html__('Style', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'overlay_opacity',
            array(
                'label' => esc_html__('Overlay Opacity', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('%'),
                'range' => array(
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 40,
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $video_url = !empty($settings['video_source']['url']) ? esc_url($settings['video_source']['url']) : '';
        $show_trishul = $settings['show_trishul'] === 'yes';
        $heading = !empty($settings['heading']) ? $settings['heading'] : '';
        $subheading = !empty($settings['subheading']) ? $settings['subheading'] : '';
        $primary_btn_text = !empty($settings['primary_button_text']) ? $settings['primary_button_text'] : '';
        $primary_btn_link = !empty($settings['primary_button_link']['url']) ? esc_url($settings['primary_button_link']['url']) : '#';
        $secondary_btn_text = !empty($settings['secondary_button_text']) ? $settings['secondary_button_text'] : '';
        $secondary_btn_link = !empty($settings['secondary_button_link']['url']) ? esc_url($settings['secondary_button_link']['url']) : '#';
        $show_scroll = $settings['show_scroll_indicator'] === 'yes';
        $scroll_text = !empty($settings['scroll_text']) ? $settings['scroll_text'] : '';
        $overlay_opacity = 40;
        if (isset($settings['overlay_opacity']['size']) && is_numeric($settings['overlay_opacity']['size'])) {
            $overlay_opacity = max(0, min(100, (float) $settings['overlay_opacity']['size']));
        }

        ?>
        <section class="tk-hero-video">
            <!-- Navbar -->
            <header class="tk-header">
                <div class="tk-header__container">
                    <div class="tk-header__logo">
                        <?php if (function_exists('trip_kailash_site_logo')) {
                            trip_kailash_site_logo();
                        } ?>
                    </div>

                    <nav class="tk-header__nav">
                        <ul class="tk-nav-menu">
                            <li><a href="<?php echo esc_url(home_url('/sacred-paths')); ?>">Sacred Paths</a></li>
                            <li><a href="<?php echo esc_url(home_url('/yatra-packages')); ?>">Yatra Packages</a></li>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>">About</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                        </ul>
                    </nav>

                    <div class="tk-header__cta">
                        <a href="<?php echo esc_url(home_url('/book-yatra')); ?>" class="tk-btn tk-btn-gold">Book Yatra</a>
                    </div>

                    <button class="tk-mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </header>

            <?php if (!empty($video_url)): ?>
                <video class="tk-hero-video__video" autoplay muted loop playsinline>
                    <source src="<?php echo $video_url; ?>" type="video/mp4">
                    <?php esc_html_e('Your browser does not support the video tag.', 'trip-kailash'); ?>
                </video>
            <?php endif; ?>

            <div class="tk-hero-overlay" style="--overlay-opacity: <?php echo esc_attr($overlay_opacity / 100); ?>;">
                <div class="tk-hero-content">
                    <?php if ($show_trishul): ?>
                        <div class="tk-hero-icon">
                            <svg width="40" height="60" viewBox="0 0 40 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 2L20 58M20 2L12 10M20 2L28 10M8 12C8 12 12 8 20 8C28 8 32 12 32 12M20 8L20 2"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($heading)): ?>
                        <h1 class="tk-hero-heading"><?php echo esc_html($heading); ?></h1>
                    <?php endif; ?>

                    <?php if (!empty($subheading)): ?>
                        <p class="tk-hero-subheading"><?php echo esc_html($subheading); ?></p>
                    <?php endif; ?>

                    <div class="tk-hero-buttons">
                        <?php if (!empty($primary_btn_text)): ?>
                            <a href="<?php echo $primary_btn_link; ?>" class="tk-btn tk-btn-primary">
                                <?php echo esc_html($primary_btn_text); ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($secondary_btn_text)): ?>
                            <a href="<?php echo $secondary_btn_link; ?>" class="tk-btn tk-btn-secondary">
                                <?php echo esc_html($secondary_btn_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($show_scroll && !empty($scroll_text)): ?>
                    <div class="tk-hero-scroll">
                        <span class="tk-hero-scroll-text"><?php echo esc_html($scroll_text); ?></span>
                        <svg class="tk-hero-scroll-arrow" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19M12 19L5 12M12 19L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Wave/Curve Bottom -->
            <div class="tk-hero-wave">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,64 C240,96 480,96 720,64 C960,32 1200,32 1440,64 L1440,120 L0,120 Z" fill="#f5f2ed" />
                </svg>
            </div>
        </section>
        <?php
    }
}
