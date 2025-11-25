<?php
/**
 * Page Duplication Functionality
 *
 * Allows administrators to duplicate posts/pages with all Elementor data,
 * meta fields, and taxonomies preserved.
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Add duplicate link to post row actions
 *
 * @param array   $actions An array of row action links.
 * @param WP_Post $post    The post object.
 * @return array Modified array of row action links.
 */
function trip_kailash_add_duplicate_link( $actions, $post ) {
    // Check if user has permission to edit posts
    if ( ! current_user_can( 'edit_posts' ) ) {
        return $actions;
    }

    // Generate nonce-protected URL
    $duplicate_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => 'duplicate_post',
                'post'   => $post->ID,
            ),
            admin_url( 'admin.php' )
        ),
        'duplicate_post_' . $post->ID,
        'duplicate_nonce'
    );

    // Add duplicate action link
    $actions['duplicate'] = sprintf(
        '<a href="%s" title="%s">%s</a>',
        esc_url( $duplicate_url ),
        esc_attr__( 'Duplicate this item', 'trip-kailash' ),
        esc_html__( 'Duplicate', 'trip-kailash' )
    );

    return $actions;
}
add_filter( 'post_row_actions', 'trip_kailash_add_duplicate_link', 10, 2 );
add_filter( 'page_row_actions', 'trip_kailash_add_duplicate_link', 10, 2 );


/**
 * Handle duplicate post action
 *
 * Processes the duplication request, validates permissions and nonce,
 * then redirects to the appropriate page.
 */
function trip_kailash_handle_duplicate_post() {
    // Check if we have a post ID
    if ( ! isset( $_GET['post'] ) || ! isset( $_GET['duplicate_nonce'] ) ) {
        return;
    }

    $post_id = absint( $_GET['post'] );
    $nonce   = sanitize_text_field( $_GET['duplicate_nonce'] );

    // Verify nonce
    if ( ! wp_verify_nonce( $nonce, 'duplicate_post_' . $post_id ) ) {
        wp_die(
            esc_html__( 'Security check failed. Please try again.', 'trip-kailash' ),
            esc_html__( 'Error', 'trip-kailash' ),
            array( 'response' => 403 )
        );
    }

    // Check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
        error_log( 'Page Duplication: Permission denied for user ' . get_current_user_id() );
        wp_die(
            esc_html__( 'You do not have permission to duplicate posts.', 'trip-kailash' ),
            esc_html__( 'Permission Denied', 'trip-kailash' ),
            array( 'response' => 403 )
        );
    }

    // Get the original post
    $post = get_post( $post_id );

    // Check if post exists
    if ( ! $post ) {
        error_log( 'Page Duplication: Post not found - ID: ' . $post_id );
        
        // Set error notice
        set_transient( 'trip_kailash_duplicate_error', __( 'The original post could not be found.', 'trip-kailash' ), 30 );
        
        // Redirect back to post list
        wp_safe_redirect( admin_url( 'edit.php?post_type=' . get_post_type( $post_id ) ) );
        exit;
    }

    // Duplicate the post
    $new_post_id = trip_kailash_duplicate_post( $post_id );

    // Check for errors
    if ( is_wp_error( $new_post_id ) ) {
        error_log( 'Page Duplication: Failed - ' . $new_post_id->get_error_message() );
        
        // Set error notice
        set_transient( 'trip_kailash_duplicate_error', $new_post_id->get_error_message(), 30 );
        
        // Redirect back to post list
        wp_safe_redirect( admin_url( 'edit.php?post_type=' . $post->post_type ) );
        exit;
    }

    // Set success notice
    set_transient( 'trip_kailash_duplicate_success', __( 'Post duplicated successfully!', 'trip-kailash' ), 30 );

    // Redirect to edit screen of new post
    wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
}
add_action( 'admin_action_duplicate_post', 'trip_kailash_handle_duplicate_post' );


/**
 * Duplicate a post with all its data
 *
 * @param int $post_id The ID of the post to duplicate.
 * @return int|WP_Error The ID of the new post on success, WP_Error on failure.
 */
function trip_kailash_duplicate_post( $post_id ) {
    // Get the original post
    $post = get_post( $post_id );

    // Validate post exists
    if ( ! $post ) {
        return new WP_Error( 'invalid_post', __( 'The original post does not exist.', 'trip-kailash' ) );
    }

    // Get current user
    $current_user = wp_get_current_user();

    // Prepare post data for duplication
    $new_post_data = array(
        'post_title'     => $post->post_title . ' (Copy)',
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_status'    => 'draft',
        'post_type'      => $post->post_type,
        'post_author'    => $current_user->ID,
        'post_parent'    => $post->post_parent,
        'menu_order'     => $post->menu_order,
        'comment_status' => $post->comment_status,
        'ping_status'    => $post->ping_status,
    );

    // Insert the new post
    $new_post_id = wp_insert_post( $new_post_data );

    // Check for errors
    if ( is_wp_error( $new_post_id ) ) {
        error_log( 'Page Duplication: wp_insert_post failed - ' . $new_post_id->get_error_message() );
        return $new_post_id;
    }

    // Copy post meta
    trip_kailash_copy_post_meta( $post_id, $new_post_id );

    // Copy taxonomies
    trip_kailash_copy_post_taxonomies( $post_id, $new_post_id );

    return $new_post_id;
}


/**
 * Copy post meta from source to destination
 *
 * @param int $source_post_id      The ID of the source post.
 * @param int $destination_post_id The ID of the destination post.
 */
function trip_kailash_copy_post_meta( $source_post_id, $destination_post_id ) {
    // Define meta keys to exclude from duplication
    $excluded_meta_keys = array(
        '_edit_lock',
        '_edit_last',
        '_wp_old_slug',
        '_wp_old_date',
    );

    // Get all meta for the source post
    $post_meta = get_post_meta( $source_post_id );

    // Check if Elementor data exists
    $has_elementor_data = false;

    // Loop through and copy meta
    foreach ( $post_meta as $meta_key => $meta_values ) {
        // Skip excluded meta keys
        if ( in_array( $meta_key, $excluded_meta_keys, true ) ) {
            continue;
        }

        // Check if this is Elementor data
        if ( strpos( $meta_key, '_elementor' ) === 0 ) {
            $has_elementor_data = true;
        }

        // Copy each meta value
        foreach ( $meta_values as $meta_value ) {
            // Unserialize if needed (WordPress handles this automatically)
            add_post_meta( $destination_post_id, $meta_key, maybe_unserialize( $meta_value ) );
        }
    }

    // Set a transient if no Elementor data was found
    if ( ! $has_elementor_data ) {
        set_transient(
            'trip_kailash_duplicate_warning',
            __( 'Post duplicated, but no Elementor data was found in the original post.', 'trip-kailash' ),
            30
        );
    }
}


/**
 * Copy taxonomies from source to destination post
 *
 * @param int $source_post_id      The ID of the source post.
 * @param int $destination_post_id The ID of the destination post.
 */
function trip_kailash_copy_post_taxonomies( $source_post_id, $destination_post_id ) {
    // Get the post type
    $post_type = get_post_type( $source_post_id );

    // Get all taxonomies for this post type
    $taxonomies = get_object_taxonomies( $post_type );

    // Loop through each taxonomy
    foreach ( $taxonomies as $taxonomy ) {
        // Get terms for the source post
        $terms = wp_get_object_terms( $source_post_id, $taxonomy, array( 'fields' => 'ids' ) );

        // Skip if error or no terms
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            continue;
        }

        // Set the same terms on the destination post
        $result = wp_set_object_terms( $destination_post_id, $terms, $taxonomy );

        // Log any errors
        if ( is_wp_error( $result ) ) {
            error_log( 'Page Duplication: Failed to copy taxonomy ' . $taxonomy . ' - ' . $result->get_error_message() );
        }
    }
}


/**
 * Display admin notices for duplication results
 */
function trip_kailash_duplicate_admin_notices() {
    // Check for success message
    $success_message = get_transient( 'trip_kailash_duplicate_success' );
    if ( $success_message ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo esc_html( $success_message ); ?></p>
        </div>
        <?php
        delete_transient( 'trip_kailash_duplicate_success' );
    }

    // Check for error message
    $error_message = get_transient( 'trip_kailash_duplicate_error' );
    if ( $error_message ) {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php echo esc_html( $error_message ); ?></p>
        </div>
        <?php
        delete_transient( 'trip_kailash_duplicate_error' );
    }

    // Check for warning message
    $warning_message = get_transient( 'trip_kailash_duplicate_warning' );
    if ( $warning_message ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php echo esc_html( $warning_message ); ?></p>
        </div>
        <?php
        delete_transient( 'trip_kailash_duplicate_warning' );
    }
}
add_action( 'admin_notices', 'trip_kailash_duplicate_admin_notices' );
