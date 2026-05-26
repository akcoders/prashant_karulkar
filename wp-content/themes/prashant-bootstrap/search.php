<?php
/**
 * Search results template.
 *
 * @package Prashant_Bootstrap
 */

get_header();
?>

<main id="primary" class="site-main section-shell">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <p class="section-eyebrow mb-3"><?php esc_html_e( 'Search Results', 'prashant-bootstrap' ); ?></p>
                <h1 class="display-font"><?php printf( esc_html__( 'Results for: %s', 'prashant-bootstrap' ), get_search_query() ); ?></h1>
            </div>
        </div>

        <div class="row g-4">
            <?php if ( have_posts() ) : ?>
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <div class="col-12">
                        <article <?php post_class( 'content-card' ); ?>>
                            <p class="post-meta mb-2"><?php echo esc_html( get_the_date() ); ?></p>
                            <h2 class="h4 mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="mb-0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
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
