<?php
/**
 * GEO Content Module - AI-Friendly Content Structure
 *
 * Optimizes content for Generative Engine Optimization (GEO)
 * to improve visibility in AI-powered search engines.
 *
 * @package TripKailash
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Quick Facts data for a pilgrimage package
 *
 * @param int|WP_Post $package Package ID or post object
 * @return array Quick facts data
 */
function tk_get_quick_facts($package = null)
{
    if (!$package) {
        $package = get_post();
    }

    if (is_numeric($package)) {
        $package = get_post($package);
    }

    if (!$package || $package->post_type !== 'pilgrimage_package') {
        return array();
    }

    $trip_length = get_post_meta($package->ID, 'trip_length', true);
    $difficulty = get_post_meta($package->ID, 'difficulty', true);
    $best_months = get_post_meta($package->ID, 'best_months', true);
    $price_from = get_post_meta($package->ID, 'price_from', true);
    $key_stops = get_post_meta($package->ID, 'key_stops', true);
    $has_lodge = get_post_meta($package->ID, 'has_lodge', true);
    $has_helicopter = get_post_meta($package->ID, 'has_helicopter', true);
    $includes_meals = get_post_meta($package->ID, 'includes_meals', true);
    $includes_rituals = get_post_meta($package->ID, 'includes_rituals', true);

    // Get deity
    $deity_terms = get_the_terms($package->ID, 'deity');
    $deity = $deity_terms && !is_wp_error($deity_terms) ? $deity_terms[0]->name : '';

    // Build includes array
    $includes = array();
    if ($has_lodge)
        $includes[] = 'Lodge Accommodation';
    if ($includes_meals)
        $includes[] = 'All Meals';
    if ($includes_rituals)
        $includes[] = 'Puja & Rituals';
    if ($has_helicopter)
        $includes[] = 'Helicopter Service';

    return array(
        'duration' => $trip_length ?: 'Contact for details',
        'difficulty' => $difficulty ?: 'Moderate',
        'best_months' => is_array($best_months) ? $best_months : array('May', 'June', 'September', 'October'),
        'price_from' => $price_from ? '$' . number_format($price_from) : 'Contact for pricing',
        'includes' => $includes,
        'key_stops' => is_array($key_stops) ? $key_stops : array(),
        'deity' => $deity,
        'last_updated' => get_the_modified_date('F Y', $package),
    );
}

/**
 * Output Quick Facts section HTML
 *
 * @param int|WP_Post $package Package ID or post object
 * @param bool $echo Whether to echo or return
 * @return string|void HTML output
 */
function tk_output_quick_facts($package = null, $echo = true)
{
    $facts = tk_get_quick_facts($package);

    if (empty($facts)) {
        return '';
    }

    ob_start();
    ?>
    <aside class="tk-quick-facts" role="complementary" aria-label="<?php esc_attr_e('Quick Facts', 'trip-kailash'); ?>">
        <h2 class="tk-quick-facts__title"><?php esc_html_e('Quick Facts', 'trip-kailash'); ?></h2>

        <dl class="tk-quick-facts__list">
            <div class="tk-quick-facts__item">
                <dt><?php esc_html_e('Duration', 'trip-kailash'); ?></dt>
                <dd><?php echo esc_html($facts['duration']); ?></dd>
            </div>

            <div class="tk-quick-facts__item">
                <dt><?php esc_html_e('Difficulty', 'trip-kailash'); ?></dt>
                <dd><?php echo esc_html($facts['difficulty']); ?></dd>
            </div>

            <div class="tk-quick-facts__item">
                <dt><?php esc_html_e('Best Months', 'trip-kailash'); ?></dt>
                <dd><?php echo esc_html(implode(', ', $facts['best_months'])); ?></dd>
            </div>

            <div class="tk-quick-facts__item">
                <dt><?php esc_html_e('Starting Price', 'trip-kailash'); ?></dt>
                <dd><?php echo esc_html($facts['price_from']); ?></dd>
            </div>

            <?php if ($facts['deity']): ?>
                <div class="tk-quick-facts__item">
                    <dt><?php esc_html_e('Deity Track', 'trip-kailash'); ?></dt>
                    <dd><?php echo esc_html($facts['deity']); ?></dd>
                </div>
            <?php endif; ?>

            <?php if (!empty($facts['includes'])): ?>
                <div class="tk-quick-facts__item tk-quick-facts__item--full">
                    <dt><?php esc_html_e('Includes', 'trip-kailash'); ?></dt>
                    <dd><?php echo esc_html(implode(' • ', $facts['includes'])); ?></dd>
                </div>
            <?php endif; ?>

            <?php if (!empty($facts['key_stops'])): ?>
                <div class="tk-quick-facts__item tk-quick-facts__item--full">
                    <dt><?php esc_html_e('Key Destinations', 'trip-kailash'); ?></dt>
                    <dd><?php echo esc_html(implode(' → ', $facts['key_stops'])); ?></dd>
                </div>
            <?php endif; ?>
        </dl>

        <p class="tk-quick-facts__updated">
            <small><?php printf(esc_html__('Last updated: %s', 'trip-kailash'), esc_html($facts['last_updated'])); ?></small>
        </p>
    </aside>
    <?php

    $output = ob_get_clean();

    if ($echo) {
        echo $output;
    }

    return $output;
}

/**
 * Format FAQ content with proper semantic HTML
 *
 * @param array $faqs Array of FAQ items
 * @param bool $echo Whether to echo or return
 * @return string|void HTML output
 */
function tk_format_faq_content($faqs, $echo = true)
{
    if (empty($faqs) || !is_array($faqs)) {
        return '';
    }

    // Register FAQs for schema
    tk_register_page_faqs($faqs);

    ob_start();
    ?>
    <section class="tk-faq" aria-labelledby="faq-heading">
        <h2 id="faq-heading" class="tk-faq__title"><?php esc_html_e('Frequently Asked Questions', 'trip-kailash'); ?></h2>

        <div class="tk-faq__list" itemscope itemtype="https://schema.org/FAQPage">
            <?php foreach ($faqs as $index => $faq): ?>
                <?php if (!empty($faq['question']) && !empty($faq['answer'])): ?>
                    <article class="tk-faq__item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="tk-faq__question" itemprop="name">
                            <?php echo esc_html($faq['question']); ?>
                        </h3>
                        <div class="tk-faq__answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <?php echo wp_kses_post($faq['answer']); ?>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php

    $output = ob_get_clean();

    if ($echo) {
        echo $output;
    }

    return $output;
}

/**
 * Add content timestamps to posts
 *
 * @param string $content Post content
 * @return string Modified content
 */
function tk_add_content_timestamps($content)
{
    if (!is_singular(array('pilgrimage_package', 'guide', 'lodge'))) {
        return $content;
    }

    $post = get_post();
    $published = get_the_date('F j, Y', $post);
    $modified = get_the_modified_date('F j, Y', $post);

    $timestamp_html = '<div class="tk-content-meta">';
    $timestamp_html .= '<time datetime="' . esc_attr(get_the_date('c', $post)) . '" itemprop="datePublished">';
    $timestamp_html .= sprintf(esc_html__('Published: %s', 'trip-kailash'), $published);
    $timestamp_html .= '</time>';

    if ($modified !== $published) {
        $timestamp_html .= ' | <time datetime="' . esc_attr(get_the_modified_date('c', $post)) . '" itemprop="dateModified">';
        $timestamp_html .= sprintf(esc_html__('Updated: %s', 'trip-kailash'), $modified);
        $timestamp_html .= '</time>';
    }

    $timestamp_html .= '</div>';

    return $timestamp_html . $content;
}
add_filter('the_content', 'tk_add_content_timestamps', 5);

/**
 * Wrap main content in semantic article element
 * Skip wrapping for pages built with Elementor
 *
 * @param string $content Post content
 * @return string Modified content
 */
function tk_wrap_semantic_content($content)
{
    if (!is_singular()) {
        return $content;
    }

    $post = get_post();
    $post_type = $post->post_type;

    // Skip wrapping for Elementor-built pages - they handle their own structure
    if (function_exists('elementor_load_plugin_textdomain')) {
        $elementor_data = get_post_meta($post->ID, '_elementor_data', true);
        if (!empty($elementor_data) && $elementor_data !== '[]') {
            return $content; // Don't wrap Elementor content
        }
    }

    // Add semantic wrapper based on post type (for non-Elementor content)
    $itemtype = 'Article';
    if ($post_type === 'pilgrimage_package') {
        $itemtype = 'Product';
    } elseif ($post_type === 'guide') {
        $itemtype = 'Person';
    } elseif ($post_type === 'lodge') {
        $itemtype = 'LodgingBusiness';
    }

    return '<div class="tk-content-wrapper" itemscope itemtype="https://schema.org/' . $itemtype . '">' . $content . '</div>';
}
add_filter('the_content', 'tk_wrap_semantic_content', 20);

/**
 * Output breadcrumb navigation HTML
 *
 * @param bool $echo Whether to echo or return
 * @return string|void HTML output
 */
function tk_output_breadcrumbs($echo = true)
{
    if (is_front_page()) {
        return '';
    }

    ob_start();
    ?>
    <nav class="tk-breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb', 'trip-kailash'); ?>">
        <ol class="tk-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="tk-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?php echo esc_url(home_url('/')); ?>" itemprop="item">
                    <span itemprop="name"><?php esc_html_e('Home', 'trip-kailash'); ?></span>
                </a>
                <meta itemprop="position" content="1" />
            </li>

            <?php
            $position = 2;

            if (is_singular('pilgrimage_package')) {
                $post = get_post();
                $deity_terms = get_the_terms($post->ID, 'deity');

                if ($deity_terms && !is_wp_error($deity_terms)) {
                    $deity = $deity_terms[0];
                    ?>
                    <li class="tk-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="<?php echo esc_url(get_term_link($deity)); ?>" itemprop="item">
                            <span itemprop="name"><?php echo esc_html($deity->name); ?></span>
                        </a>
                        <meta itemprop="position" content="<?php echo $position++; ?>" />
                    </li>
                    <?php
                }
                ?>
                <li class="tk-breadcrumbs__item tk-breadcrumbs__item--current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php echo esc_html($post->post_title); ?></span>
                    <meta itemprop="position" content="<?php echo $position; ?>" />
                </li>
                <?php
            } elseif (is_singular('guide')) {
                ?>
                <li class="tk-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo esc_url(get_post_type_archive_link('guide')); ?>" itemprop="item">
                        <span itemprop="name"><?php esc_html_e('Guides', 'trip-kailash'); ?></span>
                    </a>
                    <meta itemprop="position" content="<?php echo $position++; ?>" />
                </li>
                <li class="tk-breadcrumbs__item tk-breadcrumbs__item--current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php the_title(); ?></span>
                    <meta itemprop="position" content="<?php echo $position; ?>" />
                </li>
                <?php
            } elseif (is_singular('lodge')) {
                ?>
                <li class="tk-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="<?php echo esc_url(get_post_type_archive_link('lodge')); ?>" itemprop="item">
                        <span itemprop="name"><?php esc_html_e('Lodges', 'trip-kailash'); ?></span>
                    </a>
                    <meta itemprop="position" content="<?php echo $position++; ?>" />
                </li>
                <li class="tk-breadcrumbs__item tk-breadcrumbs__item--current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php the_title(); ?></span>
                    <meta itemprop="position" content="<?php echo $position; ?>" />
                </li>
                <?php
            } elseif (is_tax('deity')) {
                $term = get_queried_object();
                ?>
                <li class="tk-breadcrumbs__item tk-breadcrumbs__item--current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php echo esc_html($term->name); ?>
                        <?php esc_html_e('Pilgrimages', 'trip-kailash'); ?></span>
                    <meta itemprop="position" content="<?php echo $position; ?>" />
                </li>
                <?php
            } elseif (is_singular()) {
                ?>
                <li class="tk-breadcrumbs__item tk-breadcrumbs__item--current" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <span itemprop="name"><?php the_title(); ?></span>
                    <meta itemprop="position" content="<?php echo $position; ?>" />
                </li>
                <?php
            }
            ?>
        </ol>
    </nav>
    <?php

    $output = ob_get_clean();

    if ($echo) {
        echo $output;
    }

    return $output;
}

/**
 * Output related packages section
 *
 * @param int|WP_Post $package Package ID or post object
 * @param int $count Number of related packages to show
 * @param bool $echo Whether to echo or return
 * @return string|void HTML output
 */
function tk_output_related_packages($package = null, $count = 3, $echo = true)
{
    if (!$package) {
        $package = get_post();
    }

    if (is_numeric($package)) {
        $package = get_post($package);
    }

    if (!$package || $package->post_type !== 'pilgrimage_package') {
        return '';
    }

    // Get deity term
    $deity_terms = get_the_terms($package->ID, 'deity');

    if (!$deity_terms || is_wp_error($deity_terms)) {
        return '';
    }

    $deity = $deity_terms[0];

    // Query related packages
    $related = new WP_Query(array(
        'post_type' => 'pilgrimage_package',
        'posts_per_page' => $count,
        'post__not_in' => array($package->ID),
        'tax_query' => array(
            array(
                'taxonomy' => 'deity',
                'field' => 'term_id',
                'terms' => $deity->term_id,
            ),
        ),
    ));

    if (!$related->have_posts()) {
        return '';
    }

    ob_start();
    ?>
    <section class="tk-related-packages" aria-labelledby="related-heading">
        <h2 id="related-heading" class="tk-related-packages__title">
            <?php printf(esc_html__('More %s Pilgrimages', 'trip-kailash'), esc_html($deity->name)); ?>
        </h2>

        <div class="tk-related-packages__grid">
            <?php while ($related->have_posts()):
                $related->the_post(); ?>
                <article class="tk-related-packages__item">
                    <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>" class="tk-related-packages__image">
                            <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                        </a>
                    <?php endif; ?>

                    <h3 class="tk-related-packages__name">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <?php
                    $price = get_post_meta(get_the_ID(), 'price_from', true);
                    $duration = get_post_meta(get_the_ID(), 'trip_length', true);
                    ?>

                    <p class="tk-related-packages__meta">
                        <?php if ($duration): ?>
                            <span class="tk-related-packages__duration"><?php echo esc_html($duration); ?></span>
                        <?php endif; ?>
                        <?php if ($price): ?>
                            <span
                                class="tk-related-packages__price"><?php echo esc_html('From $' . number_format($price)); ?></span>
                        <?php endif; ?>
                    </p>
                </article>
            <?php endwhile; ?>
        </div>

        <p class="tk-related-packages__more">
            <a href="<?php echo esc_url(get_term_link($deity)); ?>" class="tk-btn tk-btn--outline">
                <?php printf(esc_html__('View All %s Packages', 'trip-kailash'), esc_html($deity->name)); ?>
            </a>
        </p>
    </section>
    <?php
    wp_reset_postdata();

    $output = ob_get_clean();

    if ($echo) {
        echo $output;
    }

    return $output;
}
