<?php
/**
 * Template for all pages.
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
            <article <?php post_class( 'content-card mx-auto' ); ?> style="max-width: 900px;">
                <header class="entry-header mb-4">
                    <p class="section-eyebrow mb-3"><?php esc_html_e( 'Page', 'prashant-bootstrap' ); ?></p>
                    <h1 class="display-font mb-0"><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail mb-4">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
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
