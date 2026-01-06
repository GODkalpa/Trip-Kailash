<?php
/**
 * Performance Optimization Module
 *
 * Optimizes Core Web Vitals and page load performance.
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add defer attribute to non-critical scripts
 *
 * @param string $tag Script tag
 * @param string $handle Script handle
 * @param string $src Script source
 * @return string Modified script tag
 */
function tk_defer_scripts($tag, $handle, $src)
{
    // Scripts that should NOT be deferred
    $no_defer = array(
        'jquery-core',
        'jquery-migrate',
        'wp-polyfill',
    );

    // Skip if already has defer or async
    if (strpos($tag, 'defer') !== false || strpos($tag, 'async') !== false) {
        return $tag;
    }

    // Skip admin scripts
    if (is_admin()) {
        return $tag;
    }

    // Skip scripts that shouldn't be deferred
    if (in_array($handle, $no_defer)) {
        return $tag;
    }

    // Add defer attribute
    return str_replace(' src=', ' defer src=', $tag);
}
add_filter('script_loader_tag', 'tk_defer_scripts', 10, 3);

/**
 * Preload critical assets
 */
function tk_preload_critical_assets()
{
    // Preload main CSS
    echo '<link rel="preload" href="' . esc_url(TRIP_KAILASH_URI . '/assets/css/base.css') . '" as="style">' . "\n";

    // Preload fonts if using custom fonts
    // echo '<link rel="preload" href="' . esc_url(TRIP_KAILASH_URI . '/assets/fonts/font.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";

    // Preload hero image on homepage
    if (is_front_page()) {
        // Get hero video poster or fallback image
        $hero_image = TRIP_KAILASH_URI . '/assets/images/hero-poster.jpg';
        echo '<link rel="preload" href="' . esc_url($hero_image) . '" as="image">' . "\n";
    }

    // Preload featured image on single package pages
    if (is_singular('pilgrimage_package') && has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if ($image_url) {
            echo '<link rel="preload" href="' . esc_url($image_url) . '" as="image">' . "\n";
        }
    }
}
add_action('wp_head', 'tk_preload_critical_assets', 1);

/**
 * Add resource hints for external resources
 */
function tk_add_resource_hints()
{
    // DNS prefetch for common external resources
    $dns_prefetch = array(
        '//fonts.googleapis.com',
        '//fonts.gstatic.com',
        '//www.google-analytics.com',
        '//www.googletagmanager.com',
    );

    foreach ($dns_prefetch as $url) {
        echo '<link rel="dns-prefetch" href="' . esc_url($url) . '">' . "\n";
    }

    // Preconnect for resources we'll definitely use
    $preconnect = array(
        array('url' => 'https://fonts.googleapis.com', 'crossorigin' => false),
        array('url' => 'https://fonts.gstatic.com', 'crossorigin' => true),
    );

    foreach ($preconnect as $resource) {
        $crossorigin = $resource['crossorigin'] ? ' crossorigin' : '';
        echo '<link rel="preconnect" href="' . esc_url($resource['url']) . '"' . $crossorigin . '>' . "\n";
    }
}
add_action('wp_head', 'tk_add_resource_hints', 2);

/**
 * Remove unnecessary WordPress features for performance
 */
function tk_remove_unnecessary_features()
{
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove RSD link
    remove_action('wp_head', 'rsd_link');

    // Remove Windows Live Writer manifest
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove WordPress version
    remove_action('wp_head', 'wp_generator');

    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // Remove REST API link
    remove_action('wp_head', 'rest_output_link_wp_head');

    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
}
add_action('init', 'tk_remove_unnecessary_features');

/**
 * Disable emoji DNS prefetch
 *
 * @param array $urls URLs to prefetch
 * @param string $relation_type Relation type
 * @return array Modified URLs
 */
function tk_disable_emoji_dns_prefetch($urls, $relation_type)
{
    if ($relation_type === 'dns-prefetch') {
        $urls = array_filter($urls, function ($url) {
            return strpos($url, 'emoji') === false;
        });
    }
    return $urls;
}
add_filter('wp_resource_hints', 'tk_disable_emoji_dns_prefetch', 10, 2);

/**
 * Add fetchpriority to LCP images
 *
 * @param array $attr Image attributes
 * @param WP_Post $attachment Attachment post object
 * @param string|array $size Image size
 * @return array Modified attributes
 */
function tk_add_fetchpriority($attr, $attachment, $size)
{
    // Only add to large images that might be LCP
    if (is_array($size)) {
        return $attr;
    }

    $large_sizes = array('large', 'full', 'hero', 'featured');

    if (in_array($size, $large_sizes)) {
        // Check if this is likely the first/hero image
        static $first_large_image = true;

        if ($first_large_image && !is_admin()) {
            $attr['fetchpriority'] = 'high';
            $first_large_image = false;
        }
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'tk_add_fetchpriority', 10, 3);

/**
 * Optimize script loading order
 *
 * @param array $deps Script dependencies
 * @param string $handle Script handle
 * @return array Modified dependencies
 */
function tk_optimize_script_deps($deps, $handle)
{
    // Remove jQuery dependency from theme scripts if not needed
    $no_jquery_needed = array(
        'trip-kailash-main',
        'trip-kailash-mobile-nav',
        'trip-kailash-video-controls',
    );

    if (in_array($handle, $no_jquery_needed)) {
        $deps = array_diff($deps, array('jquery'));
    }

    return $deps;
}
add_filter('script_loader_tag', function ($tag, $handle) {
    // Add type="module" for ES6 modules if needed
    return $tag;
}, 10, 2);

/**
 * Add browser caching headers via PHP (fallback if .htaccess not available)
 */
function tk_add_cache_headers()
{
    if (is_admin()) {
        return;
    }

    // Don't cache dynamic pages
    if (is_user_logged_in() || is_search() || is_404()) {
        return;
    }

    // Set cache headers for static pages
    $cache_time = 3600; // 1 hour

    if (is_singular()) {
        $cache_time = 86400; // 24 hours for single posts
    }

    if (is_front_page()) {
        $cache_time = 3600; // 1 hour for homepage
    }

    // Only set if headers not already sent
    if (!headers_sent()) {
        header('Cache-Control: public, max-age=' . $cache_time);
        header('Vary: Accept-Encoding');
    }
}
add_action('send_headers', 'tk_add_cache_headers');

/**
 * Inline critical CSS for above-the-fold content
 */
function tk_inline_critical_css()
{
    // Only on frontend
    if (is_admin()) {
        return;
    }

    // Critical CSS for initial render
    $critical_css = '
    /* Critical CSS for LCP */
    :root {
        --tk-bg-main: #F5F2ED;
        --tk-text-main: #2C2B28;
        --tk-gold: #B8860B;
    }
    body {
        margin: 0;
        font-family: system-ui, -apple-system, sans-serif;
        background: var(--tk-bg-main);
        color: var(--tk-text-main);
    }
    .tk-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: rgba(255,255,255,0.95);
    }
    ';

    echo '<style id="tk-critical-css">' . $critical_css . '</style>' . "\n";
}
add_action('wp_head', 'tk_inline_critical_css', 1);

/**
 * Remove query strings from static resources
 *
 * @param string $src Resource URL
 * @return string Modified URL
 */
function tk_remove_query_strings($src)
{
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'tk_remove_query_strings', 10);
add_filter('script_loader_src', 'tk_remove_query_strings', 10);

/**
 * Force swap for Google Fonts to prevent FOIT
 */
function tk_optimize_google_fonts($src, $handle)
{
    if (strpos($src, 'fonts.googleapis.com') !== false) {
        if (strpos($src, 'display=swap') === false) {
            $src = add_query_arg('display', 'swap', $src);
        }
    }
    return $src;
}
add_filter('style_loader_src', 'tk_optimize_google_fonts', 10, 2);
