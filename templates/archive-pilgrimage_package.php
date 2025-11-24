<?php
/**
 * Archive Template for Pilgrimage Packages
 */

get_header();
?>

<main class="tk-archive-packages">
    <div class="tk-container">
        <header class="tk-archive-header">
            <h1 class="tk-archive-title"><?php post_type_archive_title(); ?></h1>
            <?php if (term_description()): ?>
                <div class="tk-archive-description"><?php echo term_description(); ?></div>
            <?php endif; ?>
        </header>

        <?php if (have_posts()): ?>
            <div class="tk-packages-grid tk-grid-3">
                <?php while (have_posts()): the_post(); ?>
                    <?php get_template_part('template-parts/content', 'package-card'); ?>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'trip-kailash'),
                'next_text' => __('Next', 'trip-kailash'),
            ));
            ?>
        <?php else: ?>
            <p><?php _e('No packages found.', 'trip-kailash'); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
