<?php
/**
 * Template for single posts.
 *
 * @package Prashant_Bootstrap
 */

get_header();
?>

<main id="primary" class="site-main section-shell">
    <div class="container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article <?php post_class( 'mx-auto' ); ?> style="max-width: 900px;">
                <header class="mb-5">
                    <p class="section-eyebrow mb-3"><?php echo esc_html( get_the_date() ); ?></p>
                    <h1 class="display-font mb-3"><?php the_title(); ?></h1>
                    <div class="entry-meta"><?php echo esc_html( get_the_author() ); ?></div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-hero-thumb mb-4">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="content-card">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>

                <div class="cta-panel mt-4">
                    <div class="row align-items-center g-3">
                        <div class="col-md">
                            <h2 class="h4 mb-1"><?php esc_html_e( 'Explore more updates', 'prashant-bootstrap' ); ?></h2>
                            <p class="mb-0 text-secondary"><?php esc_html_e( 'Read more notes, media moments, and public-life highlights from the profile collection.', 'prashant-bootstrap' ); ?></p>
                        </div>
                        <div class="col-md-auto">
                            <a class="btn btn-outline-dark rounded-pill px-4" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'prashant-bootstrap' ); ?></a>
                        </div>
                    </div>
                </div>
            </article>
            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
