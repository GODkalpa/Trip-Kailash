<?php
/**
 * XML Sitemap Generator
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disable WordPress core sitemaps (we use our own custom sitemaps)
 * This prevents empty/default sitemaps like wp-sitemap-posts-post-1.xml
 */
add_filter('wp_sitemaps_enabled', '__return_false');

/**
 * Register sitemap rewrite rules
 */
function tk_sitemap_rewrite_rules()
{
    add_rewrite_rule('^sitemap\.xml$', 'index.php?tk_sitemap=index', 'top');
    add_rewrite_rule('^sitemap-pages\.xml$', 'index.php?tk_sitemap=pages', 'top');
    add_rewrite_rule('^sitemap-packages\.xml$', 'index.php?tk_sitemap=packages', 'top');
    add_rewrite_rule('^sitemap-guides\.xml$', 'index.php?tk_sitemap=guides', 'top');
    add_rewrite_rule('^sitemap-lodges\.xml$', 'index.php?tk_sitemap=lodges', 'top');
    add_rewrite_rule('^sitemap-deities\.xml$', 'index.php?tk_sitemap=deities', 'top');
}
add_action('init', 'tk_sitemap_rewrite_rules');

/**
 * Register sitemap query var
 */
function tk_sitemap_query_vars($vars)
{
    $vars[] = 'tk_sitemap';
    return $vars;
}
add_filter('query_vars', 'tk_sitemap_query_vars');

/**
 * Handle sitemap requests
 */
function tk_sitemap_template_redirect()
{
    $sitemap_type = get_query_var('tk_sitemap');

    if (!$sitemap_type) {
        return;
    }

    // Set XML content type
    header('Content-Type: application/xml; charset=UTF-8');
    header('X-Robots-Tag: noindex, follow');

    switch ($sitemap_type) {
        case 'index':
            tk_output_sitemap_index();
            break;
        case 'pages':
            tk_output_pages_sitemap();
            break;
        case 'packages':
            tk_output_packages_sitemap();
            break;
        case 'guides':
            tk_output_guides_sitemap();
            break;
        case 'lodges':
            tk_output_lodges_sitemap();
            break;
        case 'deities':
            tk_output_deities_sitemap();
            break;
        default:
            status_header(404);
            exit;
    }

    exit;
}
add_action('template_redirect', 'tk_sitemap_template_redirect');

/**
 * Check if a post type has published posts
 *
 * @param string $post_type Post type to check
 * @return bool True if has published posts
 */
function tk_has_published_posts($post_type)
{
    $count = wp_count_posts($post_type);
    return isset($count->publish) && $count->publish > 0;
}

/**
 * Check if a taxonomy has terms
 *
 * @param string $taxonomy Taxonomy to check
 * @return bool True if has terms
 */
function tk_has_taxonomy_terms($taxonomy)
{
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'number' => 1,
    ));
    return !is_wp_error($terms) && !empty($terms);
}

/**
 * Output sitemap index
 */
function tk_output_sitemap_index()
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Pages sitemap (always include - we at least have homepage)
    $xml .= '<sitemap>' . "\n";
    $xml .= '<loc>' . esc_url(home_url('/sitemap-pages.xml')) . '</loc>' . "\n";
    $xml .= '<lastmod>' . esc_html(tk_get_latest_post_date('page')) . '</lastmod>' . "\n";
    $xml .= '</sitemap>' . "\n";

    // Packages sitemap (only if has published packages)
    if (tk_has_published_posts('pilgrimage_package')) {
        $xml .= '<sitemap>' . "\n";
        $xml .= '<loc>' . esc_url(home_url('/sitemap-packages.xml')) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(tk_get_latest_post_date('pilgrimage_package')) . '</lastmod>' . "\n";
        $xml .= '</sitemap>' . "\n";
    }

    // Guides sitemap (only if has published guides)
    if (tk_has_published_posts('guide')) {
        $xml .= '<sitemap>' . "\n";
        $xml .= '<loc>' . esc_url(home_url('/sitemap-guides.xml')) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(tk_get_latest_post_date('guide')) . '</lastmod>' . "\n";
        $xml .= '</sitemap>' . "\n";
    }

    // Lodges sitemap (only if has published lodges)
    if (tk_has_published_posts('lodge')) {
        $xml .= '<sitemap>' . "\n";
        $xml .= '<loc>' . esc_url(home_url('/sitemap-lodges.xml')) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(tk_get_latest_post_date('lodge')) . '</lastmod>' . "\n";
        $xml .= '</sitemap>' . "\n";
    }

    // Deities sitemap (only if has deity terms)
    if (tk_has_taxonomy_terms('deity')) {
        $xml .= '<sitemap>' . "\n";
        $xml .= '<loc>' . esc_url(home_url('/sitemap-deities.xml')) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(date('c')) . '</lastmod>' . "\n";
        $xml .= '</sitemap>' . "\n";
    }

    $xml .= '</sitemapindex>';

    echo $xml;
}

/**
 * Output pages sitemap
 */
function tk_output_pages_sitemap()
{
    $pages = get_posts(array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $xml .= '<url>' . "\n";
    $xml .= '<loc>' . esc_url(home_url('/')) . '</loc>' . "\n";
    $xml .= '<lastmod>' . esc_html(date('c')) . '</lastmod>' . "\n";
    $xml .= '<changefreq>daily</changefreq>' . "\n";
    $xml .= '<priority>1.0</priority>' . "\n";
    $xml .= '</url>' . "\n";

    // Pages
    foreach ($pages as $page) {
        $xml .= '<url>' . "\n";
        $xml .= '<loc>' . esc_url(get_permalink($page)) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(get_the_modified_date('c', $page)) . '</lastmod>' . "\n";
        $xml .= '<changefreq>weekly</changefreq>' . "\n";
        $xml .= '<priority>0.8</priority>' . "\n";
        $xml .= '</url>' . "\n";
    }

    $xml .= '</urlset>';

    echo $xml;
}

/**
 * Output packages sitemap
 */
function tk_output_packages_sitemap()
{
    $packages = get_posts(array(
        'post_type' => 'pilgrimage_package',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

    foreach ($packages as $package) {
        $xml .= '<url>' . "\n";
        $xml .= '<loc>' . esc_url(get_permalink($package)) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(get_the_modified_date('c', $package)) . '</lastmod>' . "\n";
        $xml .= '<changefreq>weekly</changefreq>' . "\n";
        $xml .= '<priority>0.9</priority>' . "\n";

        if (has_post_thumbnail($package)) {
            $xml .= '<image:image>' . "\n";
            $xml .= '<image:loc>' . esc_url(get_the_post_thumbnail_url($package, 'large')) . '</image:loc>' . "\n";
            $xml .= '<image:title>' . esc_html($package->post_title) . '</image:title>' . "\n";
            $xml .= '</image:image>' . "\n";
        }

        $xml .= '</url>' . "\n";
    }

    $xml .= '</urlset>';

    echo $xml;
}

/**
 * Output guides sitemap
 */
function tk_output_guides_sitemap()
{
    $guides = get_posts(array(
        'post_type' => 'guide',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($guides as $guide) {
        $xml .= '<url>' . "\n";
        $xml .= '<loc>' . esc_url(get_permalink($guide)) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(get_the_modified_date('c', $guide)) . '</lastmod>' . "\n";
        $xml .= '<changefreq>monthly</changefreq>' . "\n";
        $xml .= '<priority>0.6</priority>' . "\n";
        $xml .= '</url>' . "\n";
    }

    $xml .= '</urlset>';

    echo $xml;
}

/**
 * Output lodges sitemap
 */
function tk_output_lodges_sitemap()
{
    $lodges = get_posts(array(
        'post_type' => 'lodge',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($lodges as $lodge) {
        $xml .= '<url>' . "\n";
        $xml .= '<loc>' . esc_url(get_permalink($lodge)) . '</loc>' . "\n";
        $xml .= '<lastmod>' . esc_html(get_the_modified_date('c', $lodge)) . '</lastmod>' . "\n";
        $xml .= '<changefreq>monthly</changefreq>' . "\n";
        $xml .= '<priority>0.6</priority>' . "\n";
        $xml .= '</url>' . "\n";
    }

    $xml .= '</urlset>';

    echo $xml;
}

/**
 * Output deities sitemap
 */
function tk_output_deities_sitemap()
{
    $deities = get_terms(array(
        'taxonomy' => 'deity',
        'hide_empty' => false,
    ));

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    if (!is_wp_error($deities)) {
        foreach ($deities as $deity) {
            $term_link = get_term_link($deity);
            if (!is_wp_error($term_link)) {
                $xml .= '<url>' . "\n";
                $xml .= '<loc>' . esc_url($term_link) . '</loc>' . "\n";
                $xml .= '<changefreq>weekly</changefreq>' . "\n";
                $xml .= '<priority>0.8</priority>' . "\n";
                $xml .= '</url>' . "\n";
            }
        }
    }

    $xml .= '</urlset>';

    echo $xml;
}

/**
 * Get latest post date for a post type
 *
 * @param string $post_type Post type
 * @return string ISO 8601 date
 */
function tk_get_latest_post_date($post_type)
{
    $latest = get_posts(array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'modified',
        'order' => 'DESC',
    ));

    if (!empty($latest)) {
        return get_the_modified_date('c', $latest[0]);
    }

    return date('c');
}

/**
 * Ping search engines when content is updated
 *
 * @param int $post_id Post ID
 */
function tk_ping_search_engines($post_id)
{
    // Only ping for published posts
    if (get_post_status($post_id) !== 'publish') {
        return;
    }

    // Only ping for our custom post types
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, array('page', 'pilgrimage_package', 'guide', 'lodge'))) {
        return;
    }

    // Don't ping on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Ping Google (they handle Bing too via IndexNow)
    $sitemap_url = home_url('/sitemap.xml');
    wp_remote_get('https://www.google.com/ping?sitemap=' . urlencode($sitemap_url), array(
        'timeout' => 5,
        'blocking' => false,
    ));
}
add_action('save_post', 'tk_ping_search_engines');

/**
 * Flush rewrite rules on theme activation
 * Note: This is called from functions.php via after_switch_theme hook
 */
function tk_sitemap_flush_rules()
{
    tk_sitemap_rewrite_rules();
    flush_rewrite_rules();
}



/**
 * Custom robots.txt output
 *
 * @param string $output Default robots.txt output
 * @param bool $public Whether the site is public
 * @return string Modified robots.txt output
 */
function tk_robots_txt($output, $public)
{
    if (!$public) {
        return $output;
    }

    $robots = "# Trip Kailash Robots.txt\n";
    $robots .= "# Generated by Trip Kailash Theme\n\n";

    // Allow all crawlers
    $robots .= "User-agent: *\n";

    // Allow crawling of public content
    $robots .= "Allow: /\n";
    $robots .= "Allow: /packages/\n";
    $robots .= "Allow: /deity/\n";

    // Block admin and sensitive areas
    $robots .= "Disallow: /wp-admin/\n";
    $robots .= "Allow: /wp-admin/admin-ajax.php\n";
    $robots .= "Disallow: /wp-includes/\n";
    $robots .= "Disallow: /wp-content/plugins/\n";
    $robots .= "Disallow: /wp-content/cache/\n";
    $robots .= "Disallow: /wp-content/themes/*/inc/\n";
    $robots .= "Disallow: /trackback/\n";
    $robots .= "Disallow: /feed/\n";
    $robots .= "Disallow: /comments/\n";
    $robots .= "Disallow: /?s=\n";
    $robots .= "Disallow: /search/\n";
    $robots .= "Disallow: /*?*\n";
    $robots .= "Disallow: /*.php$\n";

    // Crawl delay for politeness
    $robots .= "\nCrawl-delay: 1\n";

    // Sitemap location
    $robots .= "\n# Sitemap\n";
    $robots .= "Sitemap: " . home_url('/sitemap.xml') . "\n";

    // Google specific
    $robots .= "\n# Google\n";
    $robots .= "User-agent: Googlebot\n";
    $robots .= "Allow: /\n";

    // Bing specific
    $robots .= "\n# Bing\n";
    $robots .= "User-agent: Bingbot\n";
    $robots .= "Allow: /\n";

    // AI crawlers (for GEO)
    $robots .= "\n# AI Crawlers\n";
    $robots .= "User-agent: GPTBot\n";
    $robots .= "Allow: /\n";
    $robots .= "User-agent: ChatGPT-User\n";
    $robots .= "Allow: /\n";
    $robots .= "User-agent: Google-Extended\n";
    $robots .= "Allow: /\n";
    $robots .= "User-agent: PerplexityBot\n";
    $robots .= "Allow: /\n";
    $robots .= "User-agent: ClaudeBot\n";
    $robots .= "Allow: /\n";

    return $robots;
}
add_filter('robots_txt', 'tk_robots_txt', 10, 2);
