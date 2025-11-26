<?php
/**
 * Elementor Integration
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom Elementor widget category
 */
function trip_kailash_register_elementor_category( $elements_manager ) {
    $elements_manager->add_category(
        'trip-kailash',
        array(
            'title' => esc_html__( 'Trip Kailash', 'trip-kailash' ),
            'icon'  => 'fa fa-plug',
        )
    );
}
add_action( 'elementor/elements/categories_registered', 'trip_kailash_register_elementor_category' );

/**
 * Register custom Elementor widgets
 */
function trip_kailash_register_elementor_widgets( $widgets_manager ) {
    // Hero Video Widget (New)
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/hero-video-v2.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Hero_Video_V2() );
    
    // Sacred Paths Hero Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/sacred-paths-hero.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Sacred_Paths_Hero() );
    
    // Deity Cards Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/deity-cards.php';
    $widgets_manager->register( new \TripKailash\Widgets\Deity_Cards() );
    
    // Why Choose Us Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/why-choose-us.php';
    $widgets_manager->register( new \TripKailash\Widgets\Why_Choose_Us() );
    
    // Package Card Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/package-card.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Package_Card() );
    
    // Featured Packages Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/featured-packages.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Featured_Packages() );
    
    // Package Grid Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/package-grid.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Package_Grid() );
    
    // Sacred Paths Packages Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/sacred-paths-packages.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Sacred_Paths_Packages() );
    
    // Deity Hero Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/deity-hero.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Deity_Hero() );
    
    // Package Filter Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/package-filter.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Package_Filter() );
    
    // Guides Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/guides.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Guides() );
    
    // Lodges Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/lodges.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Lodges() );
    
    // Contact Form Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/contact-form.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Contact_Form() );

    // NEW: Pilgrimage Package Detail Widgets for individual pilgrimage package pages
    
    // Sticky Sidebar Navigation (use in 30% column)
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-sidebar-nav.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Sidebar_Nav() );
    
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-hero.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Hero() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-pricing-bar.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Pricing_Bar() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-overview.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Overview() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-itinerary.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Itinerary() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-map.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Map() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-accommodation.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Accommodation() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-gallery.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Gallery() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-booking.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Booking() );

    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-inquiry-form.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Inquiry_Form() );

    // Pilgrimage Info Grid Widget (package details with icons)
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-info-grid.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Info_Grid() );

    // Pilgrimage Inclusions & Exclusions Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-inclusions.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Inclusions() );

    // Pilgrimage FAQ Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-faq.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_FAQ() );

    // Pilgrimage Highlights Widget
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/pilgrimage-highlights.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Pilgrimage_Highlights() );

    // Booking page dedicated widget: detailed enquiry form
    require_once TRIP_KAILASH_DIR . '/inc/elementor/widgets/booking-page-form.php';
    $widgets_manager->register( new \TripKailash\Elementor\Widgets\Booking_Page_Form() );
}
add_action( 'elementor/widgets/register', 'trip_kailash_register_elementor_widgets' );
