<?php
/**
 * Front page template.
 *
 * @package Prashant_Bootstrap
 */

get_header();

$homepage_options = prashant_bootstrap_get_homepage_options();
$asset_base       = trailingslashit( get_template_directory_uri() ) . 'assets/images/';
$home_images      = array(
    'slider-image-1.jpg' => prashant_bootstrap_theme_image_media_url( 'slider-image-1.jpg', 'Recognition highlight' ),
    'slider-image-2.jpg' => prashant_bootstrap_theme_image_media_url( 'slider-image-2.jpg', 'Leadership highlight' ),
    'slider-image-3.jpg' => prashant_bootstrap_theme_image_media_url( 'slider-image-3.jpg', 'Impact highlight' ),
    'slider-image-4.jpg' => prashant_bootstrap_theme_image_media_url( 'slider-image-4.jpg', 'Service highlight' ),
);
$keyword_line     = $homepage_options['hero_keyword_line'];
$hero_quote       = $homepage_options['hero_quote'];
$daily_quotes     = prashant_bootstrap_get_daily_quotes();
$daily_quote      = ! empty( $daily_quotes ) ? $daily_quotes[ (int) current_time( 'z' ) % count( $daily_quotes ) ] : 'Purpose-led thinking builds enduring legacy.';
$daily_quote_images = function_exists( 'prashant_bootstrap_get_daily_quote_images' ) ? prashant_bootstrap_get_daily_quote_images() : array();
$daily_quote_image  = ! empty( $daily_quote_images ) ? $daily_quote_images[ (int) current_time( 'z' ) % count( $daily_quote_images ) ] : array();
$daily_quote_is_image = ! empty( $daily_quote_image['url'] ) || ( function_exists( 'prashant_bootstrap_is_image_url' ) && prashant_bootstrap_is_image_url( $daily_quote ) );
$today_quote_date = wp_date( 'F j, Y' );
$default_slides   = array(
    array(
        'eyebrow' => 'Recognition',
        'title'   => 'Public life, media presence, and institutional recognition.',
        'content' => '',
        'image'   => $home_images['slider-image-1.jpg'],
    ),
    array(
        'eyebrow' => 'Leadership',
        'title'   => 'Conversations that connect governance, enterprise, and people.',
        'content' => '',
        'image'   => $home_images['slider-image-2.jpg'],
    ),
    array(
        'eyebrow' => 'Impact',
        'title'   => 'A journey shaped by entrepreneurship, service, and influence.',
        'content' => '',
        'image'   => $home_images['slider-image-3.jpg'],
    ),
    array(
        'eyebrow' => 'Service',
        'title'   => 'A visual collection of purpose-led engagement.',
        'content' => '',
        'image'   => $home_images['slider-image-4.jpg'],
    ),
);
$carousel_slides  = prashant_bootstrap_get_home_slides();
$carousel_slides  = ! empty( $carousel_slides ) ? $carousel_slides : $default_slides;
$felicitations    = prashant_bootstrap_get_felicitations();
$achievements     = prashant_bootstrap_get_achievements();
$corporate_lens   = prashant_bootstrap_get_corporate_lens_points();
$linkedin_url     = $homepage_options['linkedin_profile_url'];
$linkedin_embeds  = prashant_bootstrap_get_linkedin_embeds();
$profile_images   = prashant_bootstrap_get_home_profile_images();
$profile_images   = array_pad(
    $profile_images,
    3,
    array(
        'url' => '',
        'alt' => get_bloginfo( 'name' ),
    )
);
$profile_image_fallbacks = array(
    array(
        'url' => $home_images['slider-image-1.jpg'],
        'alt' => get_bloginfo( 'name' ),
    ),
    array(
        'url' => $home_images['slider-image-2.jpg'],
        'alt' => '',
    ),
    array(
        'url' => $home_images['slider-image-4.jpg'],
        'alt' => '',
    ),
);

foreach ( $profile_images as $index => $profile_image ) {
    if ( empty( $profile_image['url'] ) && isset( $profile_image_fallbacks[ $index ] ) ) {
        $profile_images[ $index ] = $profile_image_fallbacks[ $index ];
    }
}

$recent_posts = new WP_Query(
    array(
        'post_type'           => 'post',
        'posts_per_page'      => 4,
        'ignore_sticky_posts' => true,
    )
);
?>

<main id="primary" class="site-main">
    <section class="author-home pt-4 pb-5">
        <div class="container author-home-container">
            <section id="hero-slideshow" class="author-section pb-4">
                <div class="hero-slider-shell card-shell">
                    <div id="authorCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php foreach ( $carousel_slides as $index => $slide ) : ?>
                                <button type="button" data-bs-target="#authorCarousel" data-bs-slide-to="<?php echo esc_attr( $index ); ?>" class="<?php echo 0 === $index ? 'active' : ''; ?>" aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( $slide['eyebrow'] ); ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ( $carousel_slides as $index => $slide ) : ?>
                                <div class="carousel-item <?php echo 0 === $index ? 'active' : ''; ?>">
                                    <div class="hero-slide">
                                        <div class="hero-visual-shell">
                                            <img class="hero-slide-image" src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#authorCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php esc_html_e( 'Previous', 'prashant-bootstrap' ); ?></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#authorCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php esc_html_e( 'Next', 'prashant-bootstrap' ); ?></span>
                        </button>
                    </div>
                </div>
            </section>

            <div class="author-section author-intro home-premium-hero">
                <div class="home-hero-shell">
                    <div class="row align-items-center g-4">
                        <div class="col-xl-7" data-reveal="up">
                            <p class="hero-eyebrow mb-3"><?php echo esc_html( $homepage_options['hero_eyebrow'] ); ?></p>
                            <h1 class="author-title mb-3"><?php echo esc_html( $homepage_options['hero_title'] ); ?></h1>
                            <p class="author-keyword mb-4"><?php echo esc_html( $keyword_line ); ?></p>
                            <blockquote class="author-quote mb-4"><?php echo esc_html( $hero_quote ); ?></blockquote>
                            <div class="home-hero-actions">
                                <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( $homepage_options['hero_primary_button_url'] ); ?>"><?php echo esc_html( $homepage_options['hero_primary_button_text'] ); ?></a>
                                <a class="btn btn-outline-dark rounded-pill px-4" href="<?php echo esc_url( $homepage_options['hero_secondary_button_url'] ); ?>"><?php echo esc_html( $homepage_options['hero_secondary_button_text'] ); ?></a>
                            </div>
                        </div>
                        <div class="col-xl-5" data-reveal="left">
                            <div class="home-hero-visual">
                                <img class="home-hero-main" src="<?php echo esc_url( $profile_images[0]['url'] ); ?>" alt="<?php echo esc_attr( $profile_images[0]['alt'] ); ?>">
                                <img class="home-hero-float home-hero-float-a" src="<?php echo esc_url( $profile_images[1]['url'] ); ?>" alt="<?php echo esc_attr( $profile_images[1]['alt'] ); ?>">
                                <img class="home-hero-float home-hero-float-b" src="<?php echo esc_url( $profile_images[2]['url'] ); ?>" alt="<?php echo esc_attr( $profile_images[2]['alt'] ); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="author-section pt-2">
                <div class="row g-4 align-items-start">
                    <div class="col-xl-3">
                        <div id="top-felicitations" class="card-shell info-panel mb-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <h2 class="panel-title mb-0"><?php echo esc_html( $homepage_options['felicitations_title'] ); ?></h2>
                                </div>
                            </div>
                            <div class="author-story">
                                <ul class="felicitation-list">
                                    <?php for ( $i = 0; $i < min( 2, count( $felicitations ) ); $i++ ) : ?>
                                        <li><?php echo esc_html( $felicitations[ $i ] ); ?></li>
                                    <?php endfor; ?>
                                </ul>
                                <div class="collapse" id="felicitationsMore">
                                    <ul class="felicitation-list felicitation-list-more">
                                        <?php for ( $i = 2; $i < count( $felicitations ); $i++ ) : ?>
                                            <li><?php echo esc_html( $felicitations[ $i ] ); ?></li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                                <button class="btn btn-link read-more-toggle px-0 mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#felicitationsMore" aria-expanded="false" aria-controls="felicitationsMore">
                                    <?php esc_html_e( 'Read More', 'prashant-bootstrap' ); ?>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-9">
                        <div id="achievements-panel" class="card-shell achievement-panel">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <p class="section-eyebrow mb-2"><?php echo esc_html( $homepage_options['achievements_eyebrow'] ); ?></p>
                                    <h2 class="panel-title mb-0"><?php echo esc_html( $homepage_options['achievements_title'] ); ?></h2>
                                </div>
                            </div>
                            <div class="achievement-scroll">
                                <?php foreach ( $achievements as $achievement ) : ?>
                                    <article class="achievement-item">
                                        <div class="achievement-year"><?php echo esc_html( $achievement['year'] ); ?></div>
                                        <div>
                                            <h3 class="h5 mb-2"><?php echo esc_html( $achievement['title'] ); ?></h3>
                                            <p class="mb-0 text-secondary"><?php echo esc_html( $achievement['detail'] ); ?></p>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="our-news" class="author-section home-news-feature">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end mb-4">
                    <div>
                        <p class="section-eyebrow mb-2"><?php echo esc_html( $homepage_options['news_eyebrow'] ); ?></p>
                        <h2 class="panel-title mb-0"><?php echo esc_html( $homepage_options['news_title'] ); ?></h2>
                    </div>
                    <a class="news-link" href="<?php echo esc_url( $homepage_options['news_button_url'] ); ?>"><?php echo esc_html( $homepage_options['news_button_text'] ); ?></a>
                </div>

                <?php if ( $recent_posts->have_posts() ) : ?>
                    <div id="homeNewsCarousel" class="carousel slide home-news-carousel" data-bs-ride="carousel" data-bs-interval="3500" data-bs-wrap="true">
                        <div class="carousel-inner">
                            <?php
                            $news_posts       = $recent_posts->posts;
                            $news_posts_count = count( $news_posts );
                            foreach ( $news_posts as $post_index => $news_post ) :
                                ?>
                                <div class="carousel-item <?php echo 0 === $post_index ? 'active' : ''; ?>">
                                    <div class="home-news-grid">
                                        <?php
                                        for ( $news_offset = 0; $news_offset < 3; $news_offset++ ) :
                                            $post = $news_posts[ ( $post_index + $news_offset ) % $news_posts_count ];
                                            setup_postdata( $post );
                                            ?>
                                            <article <?php post_class( 'home-news-card' ); ?> data-reveal="up">
                                                <?php if ( has_post_thumbnail() ) : ?>
                                                    <a class="home-news-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                                                <?php endif; ?>
                                                <div class="home-news-body">
                                                    <p class="post-meta mb-2"><?php echo esc_html( get_the_date() ); ?></p>
                                                    <h3 class="home-news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    <p class="mb-3 text-secondary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                                                    <a class="news-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'prashant-bootstrap' ); ?></a>
                                                </div>
                                            </article>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                        <?php if ( $recent_posts->post_count > 1 ) : ?>
                            <button class="carousel-control-prev home-news-control home-news-control-prev" type="button" data-bs-target="#homeNewsCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden"><?php esc_html_e( 'Previous', 'prashant-bootstrap' ); ?></span>
                            </button>
                            <button class="carousel-control-next home-news-control home-news-control-next" type="button" data-bs-target="#homeNewsCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden"><?php esc_html_e( 'Next', 'prashant-bootstrap' ); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="author-section pt-2">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-6">
                        <div id="corporate-lens" class="card-shell bottom-panel h-100">
                            <?php if ( ! empty( $linkedin_embeds ) ) : ?>
                                <div id="linkedinLensCarousel" class="carousel slide linkedin-lens-carousel" data-bs-ride="false">
                                    <div class="carousel-indicators linkedin-lens-indicators">
                                        <?php foreach ( $linkedin_embeds as $index => $linkedin_embed ) : ?>
                                            <button type="button" data-bs-target="#linkedinLensCarousel" data-bs-slide-to="<?php echo esc_attr( $index ); ?>" class="<?php echo 0 === $index ? 'active' : ''; ?>" aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( $linkedin_embed['title'] ); ?>"></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php foreach ( $linkedin_embeds as $index => $linkedin_embed ) : ?>
                                            <div class="carousel-item <?php echo 0 === $index ? 'active' : ''; ?>">
                                                <div class="linkedin-embed-slide">
                                                    <div class="linkedin-embed-shell">
                                                        <?php echo $linkedin_embed['embed_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev linkedin-lens-control" type="button" data-bs-target="#linkedinLensCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden"><?php esc_html_e( 'Previous', 'prashant-bootstrap' ); ?></span>
                                    </button>
                                    <button class="carousel-control-next linkedin-lens-control" type="button" data-bs-target="#linkedinLensCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden"><?php esc_html_e( 'Next', 'prashant-bootstrap' ); ?></span>
                                    </button>
                                </div>
                            <?php else : ?>
                                <div class="linkedin-lens-card mt-4">
                                    <a class="linkedin-link" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $linkedin_url ); ?></a>
                                    <div class="mt-3">
                                        <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $homepage_options['linkedin_button_text'] ); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="daily-quote" class="card-shell bottom-panel quote-panel <?php echo $daily_quote_is_image ? 'quote-panel-has-image' : ''; ?>">
                            <div class="quote-panel-inner">
                                <div class="quote-panel-top">
                                    <p class="section-eyebrow mb-0"><?php echo esc_html( $homepage_options['quote_eyebrow'] ); ?></p>
                                    <time class="quote-date" datetime="<?php echo esc_attr( wp_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( $today_quote_date ); ?></time>
                                </div>
                                <?php if ( $daily_quote_is_image ) : ?>
                                    <img class="daily-quote-image" src="<?php echo esc_url( ! empty( $daily_quote_image['url'] ) ? $daily_quote_image['url'] : $daily_quote ); ?>" alt="<?php echo esc_attr( ! empty( $daily_quote_image['alt'] ) ? $daily_quote_image['alt'] : __( "Today's Quote", 'prashant-bootstrap' ) ); ?>">
                                <?php else : ?>
                                    <blockquote class="daily-quote mb-0"><?php echo esc_html( $daily_quote ); ?></blockquote>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>

<?php
get_footer();
