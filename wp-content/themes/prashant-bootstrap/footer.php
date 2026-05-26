<?php
/**
 * The footer for our theme.
 *
 * @package Prashant_Bootstrap
 */
?>
<footer id="connect" class="site-footer pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img class="brand-fallback-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-black.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <?php endif; ?>
                    <h2 class="footer-title mb-0"><?php bloginfo( 'name' ); ?></h2>
                </div>
                <p class="mb-4"><?php bloginfo( 'description' ); ?></p>
                <p class="small-label mb-0"><?php esc_html_e( 'Enterprise, public life, philanthropy, and purposeful impact.', 'prashant-bootstrap' ); ?></p>
            </div>
            <div class="col-sm-6 col-lg-3">
                <?php
                if ( is_active_sidebar( 'footer-1' ) ) {
                    dynamic_sidebar( 'footer-1' );
                } else {
                    ?>
                    <section class="widget">
                        <h3 class="widget-title"><?php esc_html_e( 'Highlights', 'prashant-bootstrap' ); ?></h3>
                        <ul>
                            <li><a href="#hero-slideshow"><?php esc_html_e( 'Slideshow', 'prashant-bootstrap' ); ?></a></li>
                            <li><a href="#top-felicitations"><?php esc_html_e( 'Top Felicitations', 'prashant-bootstrap' ); ?></a></li>
                            <li><a href="#achievements-panel"><?php esc_html_e( 'Achievements', 'prashant-bootstrap' ); ?></a></li>
                        </ul>
                    </section>
                    <?php
                }
                ?>
            </div>
            <div class="col-sm-6 col-lg-2">
                <?php
                if ( is_active_sidebar( 'footer-2' ) ) {
                    dynamic_sidebar( 'footer-2' );
                } else {
                    ?>
                    <section class="widget">
                        <h3 class="widget-title"><?php esc_html_e( 'Explore', 'prashant-bootstrap' ); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'prashant-bootstrap' ); ?></a></li>
                            <li><a href="#our-news"><?php esc_html_e( 'Our News', 'prashant-bootstrap' ); ?></a></li>
                            <li><a href="#daily-quote"><?php esc_html_e( 'Daily Quote', 'prashant-bootstrap' ); ?></a></li>
                            <li><a href="#connect"><?php esc_html_e( 'Contact', 'prashant-bootstrap' ); ?></a></li>
                        </ul>
                    </section>
                    <?php
                }
                ?>
            </div>
            <div class="col-lg-3">
                <?php
                if ( is_active_sidebar( 'footer-3' ) ) {
                    dynamic_sidebar( 'footer-3' );
                } else {
                    ?>
                    <section class="widget">
                        <h3 class="widget-title"><?php esc_html_e( 'Let’s Build', 'prashant-bootstrap' ); ?></h3>
                        <p><?php esc_html_e( 'For invitations, collaborations, media requests, and public engagements.', 'prashant-bootstrap' ); ?></p>
                    </section>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="site-footer-bottom d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center">
            <p class="mb-0">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'prashant-bootstrap' ); ?></p>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'list-unstyled d-flex flex-wrap gap-3 mb-0',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                )
            );
            ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
