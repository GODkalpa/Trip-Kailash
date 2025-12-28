<?php
/**
 * Schema Markup Module - JSON-LD Structured Data
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Organization schema for site-wide use
 *
 * @return array Organization schema
 */
function tk_get_organization_schema() {
    $logo_id = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    
    return array(
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => $logo_url ?: TRIP_KAILASH_URI . '/assets/images/logo.png',
        'description' => get_bloginfo('description'),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'telephone' => '+91-XXXXXXXXXX',
            'contactType' => 'customer service',
            'availableLanguage' => array('English', 'Hindi'),
        ),
        'sameAs' => array(
            'https://www.facebook.com/tripkailash',
            'https://www.instagram.com/tripkailash',
            'https://www.youtube.com/tripkailash',
        ),
        'areaServed' => array(
            array('@type' => 'Country', 'name' => 'India'),
            array('@type' => 'Country', 'name' => 'Nepal'),
            array('@type' => 'Country', 'name' => 'Tibet'),
        ),
    );
}

/**
 * Get LocalBusiness schema for homepage
 *
 * @return array LocalBusiness schema
 */
function tk_get_local_business_schema() {
    return array(
        '@type' => 'TravelAgency',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => 'Spiritual pilgrimage travel agency specializing in Kailash Mansarovar, Char Dham, and sacred journeys.',
        'priceRange' => '₹₹₹',
        'address' => array(
            '@type' => 'PostalAddress',
            'addressCountry' => 'IN',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '28.6139',
            'longitude' => '77.2090',
        ),
        'openingHoursSpecification' => array(
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
            'opens' => '09:00',
            'closes' => '18:00',
        ),
    );
}

/**
 * Get TravelAction schema for pilgrimage package
 *
 * @param WP_Post $post Package post object
 * @return array TravelAction schema
 */
function tk_get_travel_action_schema($post) {
    $trip_length = get_post_meta($post->ID, 'trip_length', true);
    $price_from = get_post_meta($post->ID, 'price_from', true);
    $key_stops = get_post_meta($post->ID, 'key_stops', true);
    $difficulty = get_post_meta($post->ID, 'difficulty', true);
    
    // Parse duration to ISO 8601 format
    $duration = 'P7D'; // Default 7 days
    if ($trip_length && preg_match('/(\d+)\s*nights?/i', $trip_length, $matches)) {
        $days = intval($matches[1]) + 1;
        $duration = 'P' . $days . 'D';
    }
    
    // Get destination from key stops
    $destination = 'Kailash Mansarovar';
    if (is_array($key_stops) && !empty($key_stops)) {
        $destination = end($key_stops);
    }
    
    return array(
        '@type' => 'TravelAction',
        'name' => $post->post_title,
        'description' => tk_generate_meta_description($post),
        'url' => get_permalink($post),
        'image' => get_the_post_thumbnail_url($post, 'large'),
        'toLocation' => array(
            '@type' => 'Place',
            'name' => $destination,
            'address' => array(
                '@type' => 'PostalAddress',
                'addressCountry' => 'CN',
                'addressRegion' => 'Tibet',
            ),
        ),
        'duration' => $duration,
    );
}

/**
 * Get Product schema for pilgrimage package
 *
 * @param WP_Post $post Package post object
 * @return array Product schema
 */
function tk_get_product_schema($post) {
    $price_from = get_post_meta($post->ID, 'price_from', true);
    $trip_length = get_post_meta($post->ID, 'trip_length', true);
    
    return array(
        '@type' => 'Product',
        'name' => $post->post_title,
        'description' => tk_generate_meta_description($post),
        'url' => get_permalink($post),
        'image' => get_the_post_thumbnail_url($post, 'large'),
        'brand' => array(
            '@type' => 'Brand',
            'name' => get_bloginfo('name'),
        ),
        'offers' => array(
            '@type' => 'Offer',
            'price' => $price_from ?: '85000',
            'priceCurrency' => 'INR',
            'availability' => 'https://schema.org/InStock',
            'validFrom' => date('Y-m-d'),
            'priceValidUntil' => date('Y-12-31'),
            'url' => get_permalink($post),
        ),
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => '4.8',
            'reviewCount' => '150',
        ),
    );
}

/**
 * Get Person schema for guide
 *
 * @param WP_Post $post Guide post object
 * @return array Person schema
 */
function tk_get_person_schema($post) {
    $years = get_post_meta($post->ID, 'years_of_experience', true);
    $bio = get_post_meta($post->ID, 'short_bio', true);
    
    return array(
        '@type' => 'Person',
        'name' => $post->post_title,
        'jobTitle' => 'Pilgrimage Guide',
        'description' => $bio ?: wp_trim_words($post->post_content, 30),
        'image' => get_the_post_thumbnail_url($post, 'medium'),
        'url' => get_permalink($post),
        'worksFor' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
        ),
    );
}

/**
 * Get LodgingBusiness schema for lodge
 *
 * @param WP_Post $post Lodge post object
 * @return array LodgingBusiness schema
 */
function tk_get_lodging_schema($post) {
    $location = get_post_meta($post->ID, 'location', true);
    $amenities = get_post_meta($post->ID, 'amenities', true);
    
    $schema = array(
        '@type' => 'LodgingBusiness',
        'name' => $post->post_title,
        'description' => wp_trim_words($post->post_content, 30),
        'image' => get_the_post_thumbnail_url($post, 'large'),
        'url' => get_permalink($post),
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => $location ?: 'Kathmandu',
            'addressCountry' => 'NP',
        ),
    );
    
    if (is_array($amenities) && !empty($amenities)) {
        $schema['amenityFeature'] = array_map(function($amenity) {
            return array(
                '@type' => 'LocationFeatureSpecification',
                'name' => $amenity,
                'value' => true,
            );
        }, $amenities);
    }
    
    return $schema;
}


/**
 * Get FAQPage schema from FAQ content
 *
 * @param array $faqs Array of FAQ items with 'question' and 'answer' keys
 * @return array FAQPage schema
 */
function tk_get_faq_schema($faqs) {
    if (empty($faqs) || !is_array($faqs)) {
        return array();
    }
    
    $main_entity = array();
    
    foreach ($faqs as $faq) {
        if (!empty($faq['question']) && !empty($faq['answer'])) {
            $main_entity[] = array(
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => wp_strip_all_tags($faq['answer']),
                ),
            );
        }
    }
    
    if (empty($main_entity)) {
        return array();
    }
    
    return array(
        '@type' => 'FAQPage',
        'mainEntity' => $main_entity,
    );
}

/**
 * Get BreadcrumbList schema
 *
 * @return array BreadcrumbList schema
 */
function tk_get_breadcrumb_schema() {
    $breadcrumbs = array();
    $position = 1;
    
    // Home
    $breadcrumbs[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url('/'),
    );
    
    if (is_singular('pilgrimage_package')) {
        $post = get_post();
        $deity_terms = get_the_terms($post->ID, 'deity');
        
        // Deity archive
        if ($deity_terms && !is_wp_error($deity_terms)) {
            $deity = $deity_terms[0];
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $deity->name,
                'item' => get_term_link($deity),
            );
        }
        
        // Current package
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $post->post_title,
            'item' => get_permalink($post),
        );
    } elseif (is_singular('guide')) {
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Guides',
            'item' => get_post_type_archive_link('guide'),
        );
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('lodge')) {
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Lodges',
            'item' => get_post_type_archive_link('lodge'),
        );
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_tax('deity')) {
        $term = get_queried_object();
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name . ' Pilgrimages',
            'item' => get_term_link($term),
        );
    }
    
    return array(
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs,
    );
}

/**
 * Get WebPage schema for current page
 *
 * @return array WebPage schema
 */
function tk_get_webpage_schema() {
    $post = get_post();
    
    return array(
        '@type' => 'WebPage',
        'name' => tk_generate_meta_title($post),
        'description' => tk_generate_meta_description($post),
        'url' => tk_get_canonical_url(),
        'isPartOf' => array(
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
        ),
        'inLanguage' => get_locale(),
        'datePublished' => $post ? get_the_date('c', $post) : '',
        'dateModified' => $post ? get_the_modified_date('c', $post) : '',
    );
}

/**
 * Build complete schema for current page
 *
 * @return array Complete schema array
 */
function tk_build_page_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@graph' => array(),
    );
    
    // Always include Organization
    $schema['@graph'][] = tk_get_organization_schema();
    
    // Always include WebPage
    $schema['@graph'][] = tk_get_webpage_schema();
    
    // Always include Breadcrumbs
    $schema['@graph'][] = tk_get_breadcrumb_schema();
    
    // Homepage specific
    if (is_front_page() || is_home()) {
        $schema['@graph'][] = tk_get_local_business_schema();
    }
    
    // Package specific
    if (is_singular('pilgrimage_package')) {
        $post = get_post();
        $schema['@graph'][] = tk_get_travel_action_schema($post);
        $schema['@graph'][] = tk_get_product_schema($post);
        
        // Check for FAQ content in post meta
        $faqs = get_post_meta($post->ID, 'faqs', true);
        if (!empty($faqs)) {
            $faq_schema = tk_get_faq_schema($faqs);
            if (!empty($faq_schema)) {
                $schema['@graph'][] = $faq_schema;
            }
        }
    }
    
    // Guide specific
    if (is_singular('guide')) {
        $schema['@graph'][] = tk_get_person_schema(get_post());
    }
    
    // Lodge specific
    if (is_singular('lodge')) {
        $schema['@graph'][] = tk_get_lodging_schema(get_post());
    }
    
    return $schema;
}

/**
 * Output JSON-LD schema in footer
 */
function tk_output_schema_json_ld() {
    $schema = tk_build_page_schema();
    
    if (!empty($schema['@graph'])) {
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        echo "\n</script>\n";
    }
}
add_action('wp_footer', 'tk_output_schema_json_ld', 100);

/**
 * Helper function to add FAQ schema from Elementor widget
 *
 * @param array $faqs FAQ array from widget
 */
function tk_register_page_faqs($faqs) {
    global $tk_page_faqs;
    
    if (!isset($tk_page_faqs)) {
        $tk_page_faqs = array();
    }
    
    if (is_array($faqs)) {
        $tk_page_faqs = array_merge($tk_page_faqs, $faqs);
    }
}

/**
 * Get registered page FAQs
 *
 * @return array FAQs
 */
function tk_get_page_faqs() {
    global $tk_page_faqs;
    return $tk_page_faqs ?: array();
}
