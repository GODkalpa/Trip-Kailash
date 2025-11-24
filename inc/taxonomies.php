<?php
/**
 * Register Custom Taxonomies
 *
 * @package TripKailash
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Wrapper function for theme activation
 */
function trip_kailash_register_taxonomies() {
    tk_register_deity_taxonomy();
}

/**
 * Register deity taxonomy
 */
function tk_register_deity_taxonomy() {
    $labels = array(
        'name'                       => _x('Deities', 'Taxonomy General Name', 'trip-kailash'),
        'singular_name'              => _x('Deity', 'Taxonomy Singular Name', 'trip-kailash'),
        'menu_name'                  => __('Deities', 'trip-kailash'),
        'all_items'                  => __('All Deities', 'trip-kailash'),
        'parent_item'                => __('Parent Deity', 'trip-kailash'),
        'parent_item_colon'          => __('Parent Deity:', 'trip-kailash'),
        'new_item_name'              => __('New Deity Name', 'trip-kailash'),
        'add_new_item'               => __('Add New Deity', 'trip-kailash'),
        'edit_item'                  => __('Edit Deity', 'trip-kailash'),
        'update_item'                => __('Update Deity', 'trip-kailash'),
        'view_item'                  => __('View Deity', 'trip-kailash'),
        'separate_items_with_commas' => __('Separate deities with commas', 'trip-kailash'),
        'add_or_remove_items'        => __('Add or remove deities', 'trip-kailash'),
        'choose_from_most_used'      => __('Choose from the most used', 'trip-kailash'),
        'popular_items'              => __('Popular Deities', 'trip-kailash'),
        'search_items'               => __('Search Deities', 'trip-kailash'),
        'not_found'                  => __('Not Found', 'trip-kailash'),
        'no_terms'                   => __('No deities', 'trip-kailash'),
        'items_list'                 => __('Deities list', 'trip-kailash'),
        'items_list_navigation'      => __('Deities list navigation', 'trip-kailash'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
        'rewrite'                    => array('slug' => 'deity'),
    );

    register_taxonomy('deity', array('pilgrimage_package'), $args);
}
add_action('init', 'tk_register_deity_taxonomy', 0);

/**
 * Create default deity terms
 */
function tk_create_default_deity_terms() {
    // Check if terms already exist to avoid duplicates
    $existing_terms = get_terms(array(
        'taxonomy'   => 'deity',
        'hide_empty' => false,
    ));

    // Only create terms if none exist
    if (empty($existing_terms) || is_wp_error($existing_terms)) {
        $default_terms = array(
            'shiva'  => 'Shiva',
            'vishnu' => 'Vishnu',
            'devi'   => 'Devi',
        );

        foreach ($default_terms as $slug => $name) {
            if (!term_exists($slug, 'deity')) {
                wp_insert_term(
                    $name,
                    'deity',
                    array(
                        'slug' => $slug,
                    )
                );
            }
        }
    }
}
add_action('init', 'tk_create_default_deity_terms', 1);
