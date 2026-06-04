<?php
/**
 * The header for our theme.
 *
 * @package Prashant_Bootstrap
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<script>
    window.PRASHANT_PRELOADER_STARTED = Date.now();
</script>
<div id="site-preloader" class="site-preloader" aria-hidden="true">
    <?php
    $preloader_root_svg  = ABSPATH . 'signature_logo_preloader_3s.svg';
    $preloader_theme_svg = get_template_directory() . '/assets/images/signature_logo_preloader_3s.svg';

    if ( file_exists( $preloader_root_svg ) ) {
        $preloader_src = add_query_arg(
            array(
                'v' => filemtime( $preloader_root_svg ),
                'r' => wp_rand(),
            ),
            home_url( '/signature_logo_preloader_3s.svg' )
        );
    } elseif ( file_exists( $preloader_theme_svg ) ) {
        $preloader_src = add_query_arg(
            array(
                'v' => filemtime( $preloader_theme_svg ),
                'r' => wp_rand(),
            ),
            get_template_directory_uri() . '/assets/images/signature_logo_preloader_3s.svg'
        );
    } else {
        $preloader_src = get_template_directory_uri() . '/assets/images/logo-white.png';
    }
    ?>
    <img class="loader site-preloader-logo" src="<?php echo esc_url( $preloader_src ); ?>" alt="">
</div>
<header class="site-header position-sticky top-0 z-3">
    <nav class="navbar py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <img class="brand-fallback-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-black.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php
                }
                ?>
                <span class="brand-title"><?php bloginfo( 'name' ); ?></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#primaryNavbar" aria-controls="primaryNavbar" aria-label="<?php esc_attr_e( 'Toggle navigation', 'prashant-bootstrap' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>
<div class="offcanvas offcanvas-end primary-menu-drawer" tabindex="-1" id="primaryNavbar" aria-labelledby="primaryNavbarLabel">
    <div class="offcanvas-header">
        <div>
            <p class="section-eyebrow mb-1"><?php esc_html_e( 'Menu', 'prashant-bootstrap' ); ?></p>
            <h2 class="offcanvas-title display-font h3 mb-0" id="primaryNavbarLabel"><?php bloginfo( 'name' ); ?></h2>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'prashant-bootstrap' ); ?>"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav gap-2',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                    'walker'         => new Prashant_Bootstrap_Navwalker(),
                )
            );
        } else {
            prashant_bootstrap_fallback_nav();
        }
        ?>
    </div>
</div>
