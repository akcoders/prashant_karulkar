<?php
/**
 * Archive template.
 *
 * @package Prashant_Bootstrap
 */

get_header();
?>

<main id="primary" class="site-main section-shell">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <p class="section-eyebrow mb-3"><?php esc_html_e( 'Collection', 'prashant-bootstrap' ); ?></p>
                <h1 class="display-font"><?php the_archive_title(); ?></h1>
                <?php if ( get_the_archive_description() ) : ?>
                    <div class="text-secondary"><?php the_archive_description(); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4">
            <?php if ( have_posts() ) : ?>
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <div class="col-md-6 col-xl-4">
                        <article <?php post_class( 'insight-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="insight-thumb mb-4">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                                </div>
                            <?php endif; ?>
                            <p class="post-meta mb-2"><?php echo esc_html( get_the_date() ); ?></p>
                            <h2 class="h4 mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="mb-0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                        </article>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <?php get_template_part( 'template-parts/content', 'none' ); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="pagination mt-5 pt-3 text-center">
                <?php prashant_bootstrap_pagination(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
