<?php
/**
 * The main template file
 *
 * @package TripKailash
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    else :
        ?>
        <p><?php esc_html_e( 'No content found.', 'trip-kailash' ); ?></p>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();
