<?php
/**
 * Deity Cards Widget
 *
 * @package TripKailash
 * @since 1.0.0
 */

namespace TripKailash\Elementor\Widgets;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Deity Cards Widget Class
 */
class Deity_Cards extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     */
    public function get_name()
    {
        return 'trip-kailash-deity-cards';
    }

    /**
     * Get widget title
     */
    public function get_title()
    {
        return esc_html__('Deity Cards', 'trip-kailash');
    }

    /**
     * Get widget icon
     */
    public function get_icon()
    {
        return 'eicon-gallery-grid';
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
        return array('deity', 'cards', 'shiva', 'vishnu', 'devi', 'grid');
    }

    /**
     * Register widget controls
     */
    protected function register_controls()
    {

        // Section Header
        $this->start_controls_section(
            'section_header',
            array(
                'label' => esc_html__('Section Header', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'section_title',
            array(
                'label' => esc_html__('Section Title', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Choose Your Sacred Path', 'trip-kailash'),
                'placeholder' => esc_html__('Enter section title', 'trip-kailash'),
            )
        );

        $this->add_control(
            'section_subtitle',
            array(
                'label' => esc_html__('Section Subtitle', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Each pilgrimage is blessed by the divine trinity, offering unique spiritual experiences.', 'trip-kailash'),
                'placeholder' => esc_html__('Enter section subtitle', 'trip-kailash'),
                'rows' => 3,
            )
        );

        $this->end_controls_section();

        // Deity Cards (Repeater)
        $this->start_controls_section(
            'deity_cards_section',
            array(
                'label' => esc_html__('Deity Cards', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'enabled',
            array(
                'label' => esc_html__('Show Card', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $repeater->add_control(
            'background_image',
            array(
                'label' => esc_html__('Background Image', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $repeater->add_control(
            'title',
            array(
                'label' => esc_html__('Title', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $repeater->add_control(
            'description',
            array(
                'label' => esc_html__('Description', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'rows' => 3,
            )
        );

        $repeater->add_control(
            'tagline',
            array(
                'label' => esc_html__('Subtitle / Tagline', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $repeater->add_control(
            'mantra',
            array(
                'label' => esc_html__('Mantra / Script Line', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $repeater->add_control(
            'cta_text',
            array(
                'label' => esc_html__('CTA Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $repeater->add_control(
            'style',
            array(
                'label' => esc_html__('Style / Theme', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'shiva' => esc_html__('Shiva Style', 'trip-kailash'),
                    'vishnu' => esc_html__('Vishnu Style', 'trip-kailash'),
                    'devi' => esc_html__('Devi Style', 'trip-kailash'),
                    'custom' => esc_html__('Custom / Neutral', 'trip-kailash'),
                ),
                'default' => 'shiva',
            )
        );

        $repeater->add_control(
            'link',
            array(
                'label' => esc_html__('Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->add_control(
            'deity_cards',
            array(
                'label' => esc_html__('Deity Cards', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            )
        );

        $this->end_controls_section();

        // Shiva Card Section (legacy)
        $this->start_controls_section(
            'shiva_card_section',
            array(
                'label' => esc_html__('Shiva Card', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'shiva_enabled',
            array(
                'label' => esc_html__('Show Shiva Card', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'shiva_background_image',
            array(
                'label' => esc_html__('Background Image', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'description' => esc_html__('Select a background image for the Shiva card.', 'trip-kailash'),
            )
        );

        $this->add_control(
            'shiva_title',
            array(
                'label' => esc_html__('Title', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Lord of Kailash', 'trip-kailash'),
                'placeholder' => esc_html__('Enter title', 'trip-kailash'),
            )
        );

        $this->add_control(
            'shiva_description',
            array(
                'label' => esc_html__('Description', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Journey to the abode of Lord Shiva at Mount Kailash and the sacred waters of Gosaikunda.', 'trip-kailash'),
                'placeholder' => esc_html__('Enter description', 'trip-kailash'),
                'rows' => 3,
            )
        );

        $this->add_control(
            'shiva_tagline',
            array(
                'label' => esc_html__('Subtitle / Tagline', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Cosmic Transcendence', 'trip-kailash'),
                'placeholder' => esc_html__('Enter subtitle or tagline', 'trip-kailash'),
            )
        );

        $this->add_control(
            'shiva_mantra',
            array(
                'label' => esc_html__('Mantra / Script Line', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('ॐ नमः शिवाय', 'trip-kailash'),
                'placeholder' => esc_html__('Enter mantra or short script line', 'trip-kailash'),
            )
        );

        $this->add_control(
            'shiva_cta_text',
            array(
                'label' => esc_html__('CTA Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Explore Shiva Yatras', 'trip-kailash'),
                'placeholder' => esc_html__('Enter CTA label', 'trip-kailash'),
            )
        );

        $this->add_control(
            'shiva_link',
            array(
                'label' => esc_html__('Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->end_controls_section();

        // Vishnu Card Section (legacy)
        $this->start_controls_section(
            'vishnu_card_section',
            array(
                'label' => esc_html__('Vishnu Card', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'vishnu_enabled',
            array(
                'label' => esc_html__('Show Vishnu Card', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'vishnu_background_image',
            array(
                'label' => esc_html__('Background Image', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'description' => esc_html__('Select a background image for the Vishnu card.', 'trip-kailash'),
            )
        );

        $this->add_control(
            'vishnu_title',
            array(
                'label' => esc_html__('Title', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('The Preserver', 'trip-kailash'),
                'placeholder' => esc_html__('Enter title', 'trip-kailash'),
            )
        );

        $this->add_control(
            'vishnu_description',
            array(
                'label' => esc_html__('Description', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Visit ancient Vishnu temples and experience the warmth of sacred rituals and blessings.', 'trip-kailash'),
                'placeholder' => esc_html__('Enter description', 'trip-kailash'),
                'rows' => 3,
            )
        );

        $this->add_control(
            'vishnu_tagline',
            array(
                'label' => esc_html__('Subtitle / Tagline', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Divine Protection', 'trip-kailash'),
                'placeholder' => esc_html__('Enter subtitle or tagline', 'trip-kailash'),
            )
        );

        $this->add_control(
            'vishnu_mantra',
            array(
                'label' => esc_html__('Mantra / Script Line', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('ॐ नमो भगवते वासुदेवाय', 'trip-kailash'),
                'placeholder' => esc_html__('Enter mantra or short script line', 'trip-kailash'),
            )
        );

        $this->add_control(
            'vishnu_cta_text',
            array(
                'label' => esc_html__('CTA Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Explore Vishnu Yatras', 'trip-kailash'),
                'placeholder' => esc_html__('Enter CTA label', 'trip-kailash'),
            )
        );

        $this->add_control(
            'vishnu_link',
            array(
                'label' => esc_html__('Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->end_controls_section();

        // Devi Card Section (legacy)
        $this->start_controls_section(
            'devi_card_section',
            array(
                'label' => esc_html__('Devi Card', 'trip-kailash'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'devi_enabled',
            array(
                'label' => esc_html__('Show Devi Card', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'trip-kailash'),
                'label_off' => esc_html__('Hide', 'trip-kailash'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'devi_background_image',
            array(
                'label' => esc_html__('Background Image', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'description' => esc_html__('Select a background image for the Devi card.', 'trip-kailash'),
            )
        );

        $this->add_control(
            'devi_title',
            array(
                'label' => esc_html__('Title', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('The Mother Goddess', 'trip-kailash'),
                'placeholder' => esc_html__('Enter title', 'trip-kailash'),
            )
        );

        $this->add_control(
            'devi_description',
            array(
                'label' => esc_html__('Description', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Seek blessings at Shakti Peethas and witness the divine feminine energy of the Himalayas.', 'trip-kailash'),
                'placeholder' => esc_html__('Enter description', 'trip-kailash'),
                'rows' => 3,
            )
        );

        $this->add_control(
            'devi_tagline',
            array(
                'label' => esc_html__('Subtitle / Tagline', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Shakti Potency', 'trip-kailash'),
                'placeholder' => esc_html__('Enter subtitle or tagline', 'trip-kailash'),
            )
        );

        $this->add_control(
            'devi_mantra',
            array(
                'label' => esc_html__('Mantra / Script Line', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('ॐ ऐं ह्रीं क्लीं चामुण्डायै विचे', 'trip-kailash'),
                'placeholder' => esc_html__('Enter mantra or short script line', 'trip-kailash'),
            )
        );

        $this->add_control(
            'devi_cta_text',
            array(
                'label' => esc_html__('CTA Text', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Explore Devi Yatras', 'trip-kailash'),
                'placeholder' => esc_html__('Enter CTA label', 'trip-kailash'),
            )
        );

        $this->add_control(
            'devi_link',
            array(
                'label' => esc_html__('Link', 'trip-kailash'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'trip-kailash'),
                'default' => array(
                    'url' => '#',
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

        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : '';
        $section_subtitle = !empty($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $deity_cards = !empty($settings['deity_cards']) ? $settings['deity_cards'] : array();

        // Shiva card data
        $shiva_title = !empty($settings['shiva_title']) ? $settings['shiva_title'] : '';
        $shiva_description = !empty($settings['shiva_description']) ? $settings['shiva_description'] : '';
        $shiva_link = !empty($settings['shiva_link']['url']) ? esc_url($settings['shiva_link']['url']) : '#';
        $shiva_tagline = !empty($settings['shiva_tagline']) ? $settings['shiva_tagline'] : '';
        $shiva_mantra = !empty($settings['shiva_mantra']) ? $settings['shiva_mantra'] : '';
        $shiva_cta_text = !empty($settings['shiva_cta_text']) ? $settings['shiva_cta_text'] : '';
        $shiva_background = !empty($settings['shiva_background_image']['url']) ? esc_url($settings['shiva_background_image']['url']) : esc_url(\Elementor\Utils::get_placeholder_image_src());
        $shiva_enabled = isset($settings['shiva_enabled']) ? ('yes' === $settings['shiva_enabled']) : true;

        // Vishnu card data
        $vishnu_title = !empty($settings['vishnu_title']) ? $settings['vishnu_title'] : '';
        $vishnu_description = !empty($settings['vishnu_description']) ? $settings['vishnu_description'] : '';
        $vishnu_link = !empty($settings['vishnu_link']['url']) ? esc_url($settings['vishnu_link']['url']) : '#';
        $vishnu_tagline = !empty($settings['vishnu_tagline']) ? $settings['vishnu_tagline'] : '';
        $vishnu_mantra = !empty($settings['vishnu_mantra']) ? $settings['vishnu_mantra'] : '';
        $vishnu_cta_text = !empty($settings['vishnu_cta_text']) ? $settings['vishnu_cta_text'] : '';
        $vishnu_background = !empty($settings['vishnu_background_image']['url']) ? esc_url($settings['vishnu_background_image']['url']) : esc_url(\Elementor\Utils::get_placeholder_image_src());
        $vishnu_enabled = isset($settings['vishnu_enabled']) ? ('yes' === $settings['vishnu_enabled']) : true;

        // Devi card data
        $devi_title = !empty($settings['devi_title']) ? $settings['devi_title'] : '';
        $devi_description = !empty($settings['devi_description']) ? $settings['devi_description'] : '';
        $devi_link = !empty($settings['devi_link']['url']) ? esc_url($settings['devi_link']['url']) : '#';
        $devi_tagline = !empty($settings['devi_tagline']) ? $settings['devi_tagline'] : '';
        $devi_mantra = !empty($settings['devi_mantra']) ? $settings['devi_mantra'] : '';
        $devi_cta_text = !empty($settings['devi_cta_text']) ? $settings['devi_cta_text'] : '';
        $devi_background = !empty($settings['devi_background_image']['url']) ? esc_url($settings['devi_background_image']['url']) : esc_url(\Elementor\Utils::get_placeholder_image_src());
        $devi_enabled = isset($settings['devi_enabled']) ? ('yes' === $settings['devi_enabled']) : true;

        ?>
        <section class="tk-deity-section">
            <?php if (!empty($section_title) || !empty($section_subtitle)): ?>
                <div class="tk-deity-section__header">
                    <?php if (!empty($section_title)): ?>
                        <h2 class="tk-section-title"><?php echo esc_html($section_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($section_subtitle)): ?>
                        <p class="tk-section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="tk-deity-cards">
                <?php if ($shiva_enabled): ?>
                    <!-- Shiva Card -->
                    <div class="tk-deity-card tk-deity-card--shiva"
                        style="background-image: url('<?php echo $shiva_background; ?>');">
                        <div class="tk-deity-card__overlay"></div>
                        <div class="tk-deity-card__content">
                            <?php if (!empty($shiva_mantra)): ?>
                                <div class="tk-deity-card__mantra"><?php echo esc_html($shiva_mantra); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($shiva_title)): ?>
                                <h2 class="tk-deity-card__title"><?php echo esc_html($shiva_title); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($shiva_tagline)): ?>
                                <div class="tk-deity-card__tagline"><?php echo esc_html($shiva_tagline); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($shiva_description)): ?>
                                <p class="tk-deity-card__description"><?php echo esc_html($shiva_description); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($shiva_cta_text)): ?>
                                <span class="tk-deity-card__cta tk-deity-card__cta--shiva">
                                    <?php echo esc_html($shiva_cta_text); ?>
                                    <span class="tk-deity-card__cta-arrow">→</span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo $shiva_link; ?>" class="tk-deity-card__link"
                            aria-label="<?php echo esc_attr(sprintf(__('Explore %s pilgrimages', 'trip-kailash'), $shiva_title)); ?>"></a>
                    </div>
                <?php endif; ?>

                <?php if ($vishnu_enabled): ?>
                    <!-- Vishnu Card -->
                    <div class="tk-deity-card tk-deity-card--vishnu"
                        style="background-image: url('<?php echo $vishnu_background; ?>');">
                        <div class="tk-deity-card__overlay"></div>
                        <div class="tk-deity-card__content">
                            <?php if (!empty($vishnu_title)): ?>
                                <h2 class="tk-deity-card__title"><?php echo esc_html($vishnu_title); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($vishnu_tagline)): ?>
                                <div class="tk-deity-card__tagline"><?php echo esc_html($vishnu_tagline); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($vishnu_description)): ?>
                                <p class="tk-deity-card__description"><?php echo esc_html($vishnu_description); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($vishnu_cta_text)): ?>
                                <span class="tk-deity-card__cta tk-deity-card__cta--vishnu">
                                    <?php echo esc_html($vishnu_cta_text); ?>
                                    <span class="tk-deity-card__cta-arrow">→</span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo $vishnu_link; ?>" class="tk-deity-card__link"
                            aria-label="<?php echo esc_attr(sprintf(__('Explore %s pilgrimages', 'trip-kailash'), $vishnu_title)); ?>"></a>
                    </div>
                <?php endif; ?>

                <?php if ($devi_enabled): ?>
                    <!-- Devi Card -->
                    <div class="tk-deity-card tk-deity-card--devi"
                        style="background-image: url('<?php echo $devi_background; ?>');">
                        <div class="tk-deity-card__overlay"></div>
                        <div class="tk-deity-card__content">
                            <?php if (!empty($devi_title)): ?>
                                <h2 class="tk-deity-card__title"><?php echo esc_html($devi_title); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($devi_tagline)): ?>
                                <div class="tk-deity-card__tagline"><?php echo esc_html($devi_tagline); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($devi_description)): ?>
                                <p class="tk-deity-card__description"><?php echo esc_html($devi_description); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($devi_cta_text)): ?>
                                <span class="tk-deity-card__cta tk-deity-card__cta--devi">
                                    <?php echo esc_html($devi_cta_text); ?>
                                    <span class="tk-deity-card__cta-arrow">→</span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo $devi_link; ?>" class="tk-deity-card__link"
                            aria-label="<?php echo esc_attr(sprintf(__('Explore %s pilgrimages', 'trip-kailash'), $devi_title)); ?>"></a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($deity_cards)): ?>
                    <?php foreach ($deity_cards as $card): ?>
                        <?php
                        $card_title = !empty($card['title']) ? $card['title'] : '';
                        $card_description = !empty($card['description']) ? $card['description'] : '';
                        $card_tagline = !empty($card['tagline']) ? $card['tagline'] : '';
                        $card_mantra = !empty($card['mantra']) ? $card['mantra'] : '';
                        $card_cta_text = !empty($card['cta_text']) ? $card['cta_text'] : '';
                        $card_style = !empty($card['style']) ? $card['style'] : 'custom';
                        $card_link = !empty($card['link']['url']) ? esc_url($card['link']['url']) : '#';
                        $card_background = !empty($card['background_image']['url']) ? esc_url($card['background_image']['url']) : esc_url(\Elementor\Utils::get_placeholder_image_src());
                        $card_enabled = isset($card['enabled']) ? ('yes' === $card['enabled']) : true;
                        $card_classes = 'tk-deity-card';
                        if (!empty($card_style)) {
                            $card_classes .= ' tk-deity-card--' . $card_style;
                        }
                        ?>
                        <?php if ($card_enabled): ?>
                            <div class="<?php echo esc_attr($card_classes); ?>"
                                style="background-image: url('<?php echo $card_background; ?>');">
                                <div class="tk-deity-card__overlay"></div>
                                <div class="tk-deity-card__content">
                                    <?php if (!empty($card_mantra)): ?>
                                        <div class="tk-deity-card__mantra"><?php echo esc_html($card_mantra); ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($card_title)): ?>
                                        <h2 class="tk-deity-card__title"><?php echo esc_html($card_title); ?></h2>
                                    <?php endif; ?>
                                    <?php if (!empty($card_tagline)): ?>
                                        <div class="tk-deity-card__tagline"><?php echo esc_html($card_tagline); ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($card_description)): ?>
                                        <p class="tk-deity-card__description"><?php echo esc_html($card_description); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($card_cta_text)): ?>
                                        <span class="tk-deity-card__cta tk-deity-card__cta--<?php echo esc_attr($card_style); ?>">
                                            <?php echo esc_html($card_cta_text); ?>
                                            <span class="tk-deity-card__cta-arrow">→</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo $card_link; ?>" class="tk-deity-card__link"
                                    aria-label="<?php echo esc_attr(sprintf(__('Explore %s pilgrimages', 'trip-kailash'), $card_title)); ?>"></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}
