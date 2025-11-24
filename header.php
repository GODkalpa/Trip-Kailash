<?php
/**
 * The header template
 *
 * @package TripKailash
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="tk-header">
    <div class="tk-header__container">
        <div class="tk-header__logo">
            <?php if ( function_exists( 'trip_kailash_site_logo' ) ) { trip_kailash_site_logo(); } ?>
        </div>

        <nav class="tk-header__nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'tk-nav-menu',
                'container'      => false,
            ) );
            ?>
        </nav>

        <div class="tk-header__cta">
            <a href="<?php echo esc_url( home_url( '/book-yatra' ) ); ?>" class="tk-btn tk-btn-gold">
                <?php esc_html_e( 'Book Yatra', 'trip-kailash' ); ?>
            </a>
        </div>

        <button class="tk-mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'trip-kailash' ); ?>" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<div id="page" class="site">
