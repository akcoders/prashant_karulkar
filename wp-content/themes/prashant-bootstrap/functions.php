<?php
/**
 * Theme functions and definitions.
 *
 * @package Prashant_Bootstrap
 */

require get_template_directory() . '/inc/class-prashant-bootstrap-navwalker.php';
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/profile-pages.php';
require get_template_directory() . '/inc/home-slides.php';

if ( ! isset( $content_width ) ) {
    $content_width = 1200;
}

function prashant_bootstrap_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'prashant-bootstrap' ),
            'footer'  => __( 'Footer Menu', 'prashant-bootstrap' ),
        )
    );
}
add_action( 'after_setup_theme', 'prashant_bootstrap_setup' );

function prashant_bootstrap_widgets_init() {
    $footer_areas = array(
        'footer-1' => __( 'Footer Column 1', 'prashant-bootstrap' ),
        'footer-2' => __( 'Footer Column 2', 'prashant-bootstrap' ),
        'footer-3' => __( 'Footer Column 3', 'prashant-bootstrap' ),
    );

    foreach ( $footer_areas as $id => $name ) {
        register_sidebar(
            array(
                'name'          => $name,
                'id'            => $id,
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }
}
add_action( 'widgets_init', 'prashant_bootstrap_widgets_init' );

function prashant_bootstrap_enqueue_assets() {
    $theme   = wp_get_theme();
    $version = $theme->get( 'Version' );

    wp_enqueue_style(
        'prashant-bootstrap-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );
    wp_enqueue_style(
        'prashant-bootstrap-framework',
        get_template_directory_uri() . '/assets/css/bootstrap.min.css',
        array(),
        '5.3.8'
    );
    wp_enqueue_style(
        'prashant-bootstrap-style',
        get_stylesheet_uri(),
        array( 'prashant-bootstrap-fonts', 'prashant-bootstrap-framework' ),
        $version
    );

    wp_enqueue_script(
        'prashant-bootstrap-framework',
        get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js',
        array(),
        '5.3.8',
        true
    );
    wp_enqueue_script(
        'prashant-bootstrap-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        array( 'prashant-bootstrap-framework' ),
        $version,
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'prashant_bootstrap_enqueue_assets' );

function prashant_bootstrap_excerpt_length( $length ) {
    return 24;
}
add_filter( 'excerpt_length', 'prashant_bootstrap_excerpt_length', 999 );

function prashant_bootstrap_excerpt_more() {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'prashant_bootstrap_excerpt_more' );

function prashant_bootstrap_pagination() {
    the_posts_pagination(
        array(
            'mid_size'  => 1,
            'prev_text' => __( 'Previous', 'prashant-bootstrap' ),
            'next_text' => __( 'Next', 'prashant-bootstrap' ),
        )
    );
}

function prashant_bootstrap_fallback_nav() {
    ?>
    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'prashant-bootstrap' ); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#hero-slideshow"><?php esc_html_e( 'Slideshow', 'prashant-bootstrap' ); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#achievements-panel"><?php esc_html_e( 'Achievements', 'prashant-bootstrap' ); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#our-news"><?php esc_html_e( 'News', 'prashant-bootstrap' ); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#corporate-lens"><?php esc_html_e( 'Corporate Lens', 'prashant-bootstrap' ); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#connect"><?php esc_html_e( 'Contact', 'prashant-bootstrap' ); ?></a></li>
    </ul>
    <?php
}
