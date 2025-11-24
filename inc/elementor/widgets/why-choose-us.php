<?php
/**
 * Why Choose Us Widget
 *
 * @package TripKailash
 * @since 1.0.0
 */

namespace TripKailash\Widgets;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Why Choose Us Widget Class
 */
class Why_Choose_Us extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'trip-kailash-why-choose-us';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Why Choose Us', 'trip-kailash' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-star';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return array( 'trip-kailash' );
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return array( 'features', 'why', 'choose', 'benefits' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__( 'Content', 'trip-kailash' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'section_title',
            array(
                'label'       => esc_html__( 'Section Title', 'trip-kailash' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Why Choose Our Sacred Journeys', 'trip-kailash' ),
                'placeholder' => esc_html__( 'Enter section title', 'trip-kailash' ),
            )
        );

        $this->add_control(
            'section_subtitle',
            array(
                'label'       => esc_html__( 'Section Subtitle', 'trip-kailash' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Experience profound devotion and unparalleled comfort. Our meticulously curated pilgrimages blend spiritual enrichment with luxury travel, ensuring your journey is as inspiring as the destination.', 'trip-kailash' ),
                'placeholder' => esc_html__( 'Enter section subtitle', 'trip-kailash' ),
                'rows'        => 3,
            )
        );

        $this->add_control(
            'features',
            array(
                'label'       => esc_html__( 'Features', 'trip-kailash' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => array(
                    array(
                        'name'    => 'icon',
                        'label'   => esc_html__( 'Icon', 'trip-kailash' ),
                        'type'    => \Elementor\Controls_Manager::MEDIA,
                        'default' => array(
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ),
                    ),
                    array(
                        'name'        => 'title',
                        'label'       => esc_html__( 'Title', 'trip-kailash' ),
                        'type'        => \Elementor\Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Feature Title', 'trip-kailash' ),
                        'placeholder' => esc_html__( 'Enter feature title', 'trip-kailash' ),
                    ),
                    array(
                        'name'        => 'description',
                        'label'       => esc_html__( 'Description', 'trip-kailash' ),
                        'type'        => \Elementor\Controls_Manager::TEXTAREA,
                        'default'     => esc_html__( 'Feature description goes here', 'trip-kailash' ),
                        'placeholder' => esc_html__( 'Enter feature description', 'trip-kailash' ),
                        'rows'        => 3,
                    ),
                ),
                'default'     => array(
                    array(
                        'title'       => esc_html__( 'Expert Guides', 'trip-kailash' ),
                        'description' => esc_html__( 'Experienced guides with deep spiritual knowledge', 'trip-kailash' ),
                    ),
                    array(
                        'title'       => esc_html__( 'Comfortable Lodging', 'trip-kailash' ),
                        'description' => esc_html__( 'Clean and comfortable accommodations throughout', 'trip-kailash' ),
                    ),
                    array(
                        'title'       => esc_html__( 'Sacred Rituals', 'trip-kailash' ),
                        'description' => esc_html__( 'Authentic pujas and ceremonies at holy sites', 'trip-kailash' ),
                    ),
                    array(
                        'title'       => esc_html__( 'Small Groups', 'trip-kailash' ),
                        'description' => esc_html__( 'Intimate group sizes for personalized experience', 'trip-kailash' ),
                    ),
                ),
                'title_field' => '{{{ title }}}',
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $section_title    = ! empty( $settings['section_title'] ) ? $settings['section_title'] : '';
        $section_subtitle = ! empty( $settings['section_subtitle'] ) ? $settings['section_subtitle'] : '';
        $features         = ! empty( $settings['features'] ) ? $settings['features'] : array();
        
        ?>
        <section class="tk-why-choose-us">
            <?php if ( ! empty( $section_title ) ) : ?>
                <h2 class="tk-section-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>

            <?php if ( ! empty( $section_subtitle ) ) : ?>
                <p class="tk-section-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
            <?php endif; ?>
            
            <?php if ( ! empty( $features ) ) : ?>
                <div class="tk-features-grid">
                    <?php foreach ( $features as $feature ) : ?>
                        <div class="tk-feature">
                            <?php if ( ! empty( $feature['title'] ) ) : ?>
                                <h3 class="tk-feature__title"><?php echo esc_html( $feature['title'] ); ?></h3>
                            <?php endif; ?>

                            <?php if ( ! empty( $feature['icon']['url'] ) ) : ?>
                                <div class="tk-feature__icon">
                                    <img src="<?php echo esc_url( $feature['icon']['url'] ); ?>" 
                                         alt="<?php echo esc_attr( $feature['title'] ); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $feature['description'] ) ) : ?>
                                <p class="tk-feature__description"><?php echo esc_html( $feature['description'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
