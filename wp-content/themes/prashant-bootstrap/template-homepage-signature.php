<?php
/**
 * Template Name: Homepage Signature
 * Description: An alternate premium homepage layout with bold editorial positioning.
 *
 * @package Prashant_Bootstrap
 */

get_header();

$asset_base = trailingslashit( get_template_directory_uri() ) . 'assets/images/';
$highlights = array(
    array(
        'number' => '30,000+',
        'label'  => 'Families touched through sustained welfare impact.',
    ),
    array(
        'number' => '10,000+',
        'label'  => 'Ground volunteers aligned with purposeful action.',
    ),
    array(
        'number' => 'Multi-Sector',
        'label'  => 'Leadership spanning business, policy, and philanthropy.',
    ),
);
$signature_blocks = array(
    array(
        'eyebrow' => 'Influence',
        'title'   => 'A commanding digital presence built around credibility and visual memory.',
    ),
    array(
        'eyebrow' => 'Recognition',
        'title'   => 'A curated digital presence shaped around credibility, memory, and public recognition.',
    ),
    array(
        'eyebrow' => 'Momentum',
        'title'   => 'Sections positioned to move from identity, to proof, to public perception.',
    ),
);
$gallery = array(
    $asset_base . 'slider-image-1.jpg',
    $asset_base . 'slider-image-2.jpg',
    $asset_base . 'slider-image-3.jpg',
    $asset_base . 'slider-image-4.jpg',
);
$recent_posts = new WP_Query(
    array(
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
    )
);
?>

<main id="primary" class="site-main signature-home">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <section class="signature-hero">
            <div class="container signature-container">
                <div class="signature-hero-shell">
                    <div class="row g-4 align-items-stretch">
                        <div class="col-xl-7" data-reveal="up">
                            <div class="signature-copy-card">
                                <p class="signature-kicker"><?php esc_html_e( 'Signature Profile', 'prashant-bootstrap' ); ?></p>
                                <h1 class="signature-title"><?php the_title(); ?></h1>
                                <p class="signature-meta"><?php bloginfo( 'name' ); ?></p>
                                <div class="signature-divider"></div>
                                <div class="signature-content">
                                    <?php the_content(); ?>
                                </div>
                                <div class="signature-stats">
                                    <?php foreach ( $highlights as $item ) : ?>
                                        <article class="signature-stat-pill">
                                            <strong><?php echo esc_html( $item['number'] ); ?></strong>
                                            <span><?php echo esc_html( $item['label'] ); ?></span>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5" data-reveal="left">
                            <div class="signature-visual-card">
                                <div class="signature-main-visual">
                                    <img src="<?php echo esc_url( $gallery[0] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                </div>
                                <div class="signature-float-card signature-float-top">
                                    <span><?php esc_html_e( 'Public Image', 'prashant-bootstrap' ); ?></span>
                                </div>
                                <div class="signature-float-card signature-float-bottom">
                                    <strong><?php esc_html_e( 'Presence with depth', 'prashant-bootstrap' ); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="signature-section">
            <div class="container signature-container">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5" data-reveal="up">
                        <div class="signature-editorial-card">
                            <p class="signature-kicker"><?php esc_html_e( 'Profile Narrative', 'prashant-bootstrap' ); ?></p>
                            <h2 class="signature-section-title"><?php esc_html_e( 'A public profile shaped with presence, credibility, and a refined editorial rhythm.', 'prashant-bootstrap' ); ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row g-4">
                            <?php foreach ( $signature_blocks as $block ) : ?>
                                <div class="col-md-6 col-xl-4" data-reveal="up">
                                    <article class="signature-feature-card h-100">
                                        <p class="signature-kicker mb-2"><?php echo esc_html( $block['eyebrow'] ); ?></p>
                                        <h3 class="signature-card-title mb-0"><?php echo esc_html( $block['title'] ); ?></h3>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="signature-section">
            <div class="container signature-container">
                <div class="signature-gallery-shell" data-reveal="up">
                    <div class="row g-3">
                        <div class="col-lg-5">
                            <div class="signature-gallery-tall">
                                <img src="<?php echo esc_url( $gallery[1] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="signature-gallery-wide">
                                        <img src="<?php echo esc_url( $gallery[2] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="signature-gallery-card">
                                        <img src="<?php echo esc_url( $gallery[3] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="signature-quote-tile">
                                        <blockquote><?php esc_html_e( 'Presence becomes powerful when purpose, memory, and action move together.', 'prashant-bootstrap' ); ?></blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="signature-section signature-section-last">
            <div class="container signature-container">
                <div class="row g-4">
                    <?php if ( $recent_posts->have_posts() ) : ?>
                        <?php
                        while ( $recent_posts->have_posts() ) :
                            $recent_posts->the_post();
                            ?>
                            <div class="col-md-6 col-xl-4" data-reveal="up">
                                <article class="signature-news-card h-100">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="signature-news-thumb mb-3"><?php the_post_thumbnail( 'large' ); ?></div>
                                    <?php endif; ?>
                                    <p class="signature-news-meta"><?php echo esc_html( get_the_date() ); ?></p>
                                    <h3 class="signature-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                </article>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <div class="col-12" data-reveal="up">
                            <div class="signature-editorial-card">
                                <h2 class="signature-section-title mb-0"><?php esc_html_e( 'A living archive of profile stories, photo highlights, and public updates.', 'prashant-bootstrap' ); ?></h2>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
