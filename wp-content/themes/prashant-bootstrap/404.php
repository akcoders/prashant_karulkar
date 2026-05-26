<?php
/**
 * 404 template.
 *
 * @package Prashant_Bootstrap
 */

get_header();
?>

<main id="primary" class="site-main section-shell">
    <div class="container">
        <div class="content-card mx-auto text-center" style="max-width: 760px;">
            <p class="section-eyebrow mb-3"><?php esc_html_e( '404', 'prashant-bootstrap' ); ?></p>
            <h1 class="display-font mb-3"><?php esc_html_e( 'That page could not be found.', 'prashant-bootstrap' ); ?></h1>
            <p class="lead text-secondary mb-4"><?php esc_html_e( 'Try going back to the homepage or searching for the content you need.', 'prashant-bootstrap' ); ?></p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back Home', 'prashant-bootstrap' ); ?></a>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
