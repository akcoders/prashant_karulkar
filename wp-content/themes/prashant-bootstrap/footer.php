<?php
/**
 * The footer for our theme.
 *
 * @package Prashant_Bootstrap
 */

$footer_profile_links = array(
    array( 'label' => __( 'About', 'prashant-bootstrap' ), 'url' => home_url( '/about-prashant-karulkar/' ) ),
    array( 'label' => __( 'Timeline', 'prashant-bootstrap' ), 'url' => home_url( '/timeline/' ) ),
    array( 'label' => __( 'Awards', 'prashant-bootstrap' ), 'url' => home_url( '/awards-achievements-felicitations/' ) ),
    array( 'label' => __( 'Accolades', 'prashant-bootstrap' ), 'url' => home_url( '/accolades/' ) ),
);

$footer_gallery_links = array(
    array( 'label' => __( 'Picture Gallery', 'prashant-bootstrap' ), 'url' => home_url( '/picture-gallery/' ) ),
    array( 'label' => __( 'Video Gallery', 'prashant-bootstrap' ), 'url' => home_url( '/video-gallery/' ) ),
    array( 'label' => __( 'Publications', 'prashant-bootstrap' ), 'url' => home_url( '/publications/' ) ),
    array( 'label' => __( 'Media Coverage', 'prashant-bootstrap' ), 'url' => home_url( '/media-coverage/' ) ),
);

$footer_social_page = function_exists( 'prashant_bootstrap_get_profile_page_data' ) ? prashant_bootstrap_get_profile_page_data( 'social-media' ) : array();
$footer_socials     = ! empty( $footer_social_page['social_links'] ) ? $footer_social_page['social_links'] : array(
    array( 'label' => 'Prashant Karulkar Linktree', 'url' => 'https://linktr.ee/prashantkarulkar', 'metric' => '' ),
    array( 'label' => 'Vivaan Karulkar Linktree', 'url' => 'https://linktree.com/vivaankarulkar', 'metric' => '' ),
);
?>
<footer id="connect" class="site-footer">
    <div class="container">
        <div class="footer-cta">
            <div>
                <p class="section-eyebrow mb-2"><?php esc_html_e( 'Official Profile', 'prashant-bootstrap' ); ?></p>
                <h2 class="footer-cta-title mb-0"><?php bloginfo( 'name' ); ?></h2>
            </div>
            <a class="footer-cta-link" href="<?php echo esc_url( home_url( '/karulkar-pratishthan/' ) ); ?>"><?php esc_html_e( 'Karulkar Pratishthan', 'prashant-bootstrap' ); ?></a>
        </div>

        <div class="footer-main">
            <div class="footer-brand-panel">
                <div class="footer-brand">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img class="brand-fallback-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-black.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
                    <?php endif; ?>
                    <a class="footer-brand-name" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                </div>
                <p class="footer-brand-copy"><?php esc_html_e( 'Enterprise, public life, philanthropy, publications, media presence, and purpose-led impact through a complete public profile collection.', 'prashant-bootstrap' ); ?></p>
                <div class="footer-impact-strip">
                    <span><?php esc_html_e( '30,000+ Families', 'prashant-bootstrap' ); ?></span>
                    <span><?php esc_html_e( '10,000+ Volunteers', 'prashant-bootstrap' ); ?></span>
                    <span><?php esc_html_e( 'Public Recognition', 'prashant-bootstrap' ); ?></span>
                </div>
            </div>

            <nav class="footer-link-panel" aria-label="<?php esc_attr_e( 'Profile links', 'prashant-bootstrap' ); ?>">
                <h3 class="widget-title"><?php esc_html_e( 'Profile', 'prashant-bootstrap' ); ?></h3>
                <ul>
                    <?php foreach ( $footer_profile_links as $footer_link ) : ?>
                        <li><a href="<?php echo esc_url( $footer_link['url'] ); ?>"><?php echo esc_html( $footer_link['label'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <nav class="footer-link-panel" aria-label="<?php esc_attr_e( 'Gallery and media links', 'prashant-bootstrap' ); ?>">
                <h3 class="widget-title"><?php esc_html_e( 'Explore', 'prashant-bootstrap' ); ?></h3>
                <ul>
                    <?php foreach ( $footer_gallery_links as $footer_link ) : ?>
                        <li><a href="<?php echo esc_url( $footer_link['url'] ); ?>"><?php echo esc_html( $footer_link['label'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div class="footer-social-panel">
                <h3 class="widget-title"><?php esc_html_e( 'Social Presence', 'prashant-bootstrap' ); ?></h3>
                <div class="footer-social-list">
                    <?php foreach ( array_slice( $footer_socials, 0, 4 ) as $footer_social ) : ?>
                        <?php
                        $social_label = isset( $footer_social['label'] ) ? $footer_social['label'] : '';
                        $social_url   = isset( $footer_social['url'] ) ? $footer_social['url'] : '';
                        if ( '' === $social_url ) {
                            continue;
                        }
                        $social_class = function_exists( 'prashant_bootstrap_get_social_platform_class' ) ? prashant_bootstrap_get_social_platform_class( $social_label, $social_url ) : '';
                        ?>
                        <a class="footer-social-link footer-social-link-<?php echo esc_attr( $social_class ); ?>" href="<?php echo esc_url( $social_url ); ?>" target="_blank" rel="noopener noreferrer">
                            <span class="footer-social-icon">
                                <?php
                                if ( function_exists( 'prashant_bootstrap_get_social_icon_svg' ) ) {
                                    echo prashant_bootstrap_get_social_icon_svg( $social_label, $social_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                }
                                ?>
                            </span>
                            <span>
                                <strong><?php echo esc_html( $social_label ); ?></strong>
                                <?php if ( ! empty( $footer_social['metric'] ) ) : ?>
                                    <small><?php echo esc_html( $footer_social['metric'] ); ?></small>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="site-footer-bottom">
            <p class="mb-0">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'prashant-bootstrap' ); ?></p>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'footer-bottom-menu',
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
