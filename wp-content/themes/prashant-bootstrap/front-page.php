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
$keyword_line     = 'Corporate Member- WCFA, Davos | Optimist Visionary Entrepreneur | Social Transformer | Philanthropist | Venture Capitalist | Experienced Investor';
$hero_quote       = "Believe in yourself, that's where the magic begins.";
$daily_quotes     = prashant_bootstrap_get_daily_quotes();
$daily_quote      = ! empty( $daily_quotes ) ? $daily_quotes[ (int) current_time( 'z' ) % count( $daily_quotes ) ] : 'Purpose-led thinking builds enduring legacy.';
$carousel_slides  = array(
    array(
        'eyebrow' => 'Recognition',
        'title'   => 'Public life, media presence, and institutional recognition.',
        'image'   => $home_images['slider-image-1.jpg'],
        'tag'     => 'Featured press',
    ),
    array(
        'eyebrow' => 'Leadership',
        'title'   => 'Conversations that connect governance, enterprise, and people.',
        'image'   => $home_images['slider-image-2.jpg'],
        'tag'     => 'Official meeting',
    ),
    array(
        'eyebrow' => 'Impact',
        'title'   => 'A journey shaped by entrepreneurship, service, and influence.',
        'image'   => $home_images['slider-image-3.jpg'],
        'tag'     => 'Presentation moment',
    ),
    array(
        'eyebrow' => 'Service',
        'title'   => 'A visual archive of purpose-led engagement.',
        'image'   => $home_images['slider-image-4.jpg'],
        'tag'     => 'Institutional visit',
    ),
);
$felicitations    = array(
    'First generation entrepreneur and social reformer with active interests in real estate, insurance, AIF, news media, sand mining, pharma, solar, FMCG.',
    'Head of Karulkar Pratishthan, a five decade old non-profit family foundation dedicated to the welfare and education of underprivileged section of the society impacting lives of 30,000+ families without donations or fundraising from any external sources, through a team of 10,000+ volunteers on ground.',
    'Felicitated by the Hon\'ble Home Minister of India, Shri Amit Shah, for social work and activities for the welfare of the nation, at the event of book launch "Karmayoddha," chronicling the public life of the Hon\'ble Prime Minister of India, Shri Narendra Modi, for his contributions as a Co-Author and Initiative Partner in publishing the book.',
    'Felicitated for social contributions and as a Young Entrepreneur by RSS Sarsanghchalak Shri Mohan Bhagwat, in the presence of the Hon\'ble Vice President of India, Shri Venkaiah Naidu, at Vigyan Bhawan, New Delhi, during the launch of the book "YogGranth."',
    'Felicitated and awarded with the "Achievers Award" by the Hon\'ble Finance Minister of India, Smt. Nirmala Sitharaman, during the "Swah 75" book launch.',
    'Felicitated and awarded with the Tarun Bharat Wealth Creators - Young Achiever in Business World Award by Shri Nitin Gadkari Ji, Hon\'ble Minister of Roads, Transport and Highways of India.',
    'Felicitated by Padma Shri Ujjwal Nikam, Special Public Prosecutor, for Karulkar Pratishthan\'s social service in rural and tribal areas.',
    'Felicitated with Indian Navy Commendation Citation by Vice Chief of Naval Staff, Vice Admiral S. N. Ghormade, for contributions towards society.',
    'Invited by Ratan Tata as the Chief Guest at the 59th Annual Award Ceremony of the ABCI Annual Awards pioneered by Late Naval Tata; a platform previously graced by eminent personalities such as Late Naval Tata, Late Nani Palkhivala, and Late Manohar Parrikar.',
    'Felicitated at Bombay Stock Exchange (BSE), Mumbai, by Mr. G. N. Bajpai (Former Chairman, SEBI), Mr. Ashish Chauhan (MD and CEO, BSE), and Mr. Shailesh Haribhakti (Chairman, Blue Star Ltd.).',
    'Awarded the Corona Devdoot Award (COVID-19 Wave) by the Hon\'ble Governor of Maharashtra, Shri Bhagat Singh Koshyari, for large-scale humanitarian work including food, shelter, migration support, sanitization drives, and rural outreach.',
    'Honoured and awarded by Dr. Bhagwat Karad, Minister of State, Finance, Government of India, at the World Hindu Economic Forum - Mumbai Chapter, for business achievements and social responsibility.',
);
$achievements     = prashant_bootstrap_get_achievements();
$corporate_lens   = prashant_bootstrap_get_corporate_lens_points();
$linkedin_url     = $homepage_options['linkedin_profile_url'];
$linkedin_embeds  = prashant_bootstrap_get_linkedin_embeds();

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
            <div class="author-section author-intro home-premium-hero">
                <div class="home-hero-shell">
                    <div class="row align-items-center g-4">
                        <div class="col-xl-7" data-reveal="up">
                            <p class="hero-eyebrow mb-3"><?php esc_html_e( 'Official Profile', 'prashant-bootstrap' ); ?></p>
                            <h1 class="author-title mb-3"><?php bloginfo( 'name' ); ?></h1>
                            <p class="author-keyword mb-4"><?php echo esc_html( $keyword_line ); ?></p>
                            <blockquote class="author-quote mb-4"><?php echo esc_html( $hero_quote ); ?></blockquote>
                            <div class="home-hero-actions">
                                <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( home_url( '/about-prashant-karulkar/' ) ); ?>"><?php esc_html_e( 'Explore Profile', 'prashant-bootstrap' ); ?></a>
                                <a class="btn btn-outline-dark rounded-pill px-4" href="<?php echo esc_url( home_url( '/picture-gallery/' ) ); ?>"><?php esc_html_e( 'View Gallery', 'prashant-bootstrap' ); ?></a>
                            </div>
                        </div>
                        <div class="col-xl-5" data-reveal="left">
                            <div class="home-hero-visual">
                                <img class="home-hero-main" src="<?php echo esc_url( $home_images['slider-image-1.jpg'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                                <img class="home-hero-float home-hero-float-a" src="<?php echo esc_url( $home_images['slider-image-2.jpg'] ); ?>" alt="">
                                <img class="home-hero-float home-hero-float-b" src="<?php echo esc_url( $home_images['slider-image-4.jpg'] ); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                        <div class="row align-items-center g-4">
                                            <div class="col-lg-6">
                                                <p class="hero-eyebrow mb-3"><?php echo esc_html( $slide['eyebrow'] ); ?></p>
                                                <h2 class="hero-slide-title mb-3"><?php echo esc_html( $slide['title'] ); ?></h2>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="hero-visual-shell">
                                                    <img class="hero-slide-image" src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                                                </div>
                                            </div>
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

            <section class="author-section pt-2">
                <div class="row g-4 align-items-start">
                    <div class="col-xl-4">
                        <div id="top-felicitations" class="card-shell info-panel mb-4">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <h2 class="panel-title mb-0"><?php esc_html_e( 'Felicitations', 'prashant-bootstrap' ); ?></h2>
                                </div>
                            </div>
                            <div class="author-story">
                                <p class="author-story-lead"><?php echo esc_html( $felicitations[0] ); ?></p>
                                <div class="collapse show" id="felicitationsPreview">
                                    <p><?php echo esc_html( $felicitations[1] ); ?></p>
                                    <p class="mb-0"><?php echo esc_html( $felicitations[2] ); ?></p>
                                </div>
                                <div class="collapse" id="felicitationsMore">
                                    <?php for ( $i = 3; $i < count( $felicitations ); $i++ ) : ?>
                                        <p><?php echo esc_html( $felicitations[ $i ] ); ?></p>
                                    <?php endfor; ?>
                                </div>
                                <button class="btn btn-link read-more-toggle px-0 mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#felicitationsMore" aria-expanded="false" aria-controls="felicitationsMore">
                                    <?php esc_html_e( 'Read More', 'prashant-bootstrap' ); ?>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-8">
                        <div id="achievements-panel" class="card-shell achievement-panel">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <p class="section-eyebrow mb-2"><?php esc_html_e( 'Achievements', 'prashant-bootstrap' ); ?></p>
                                    <h2 class="panel-title mb-0"><?php esc_html_e( 'Achievements', 'prashant-bootstrap' ); ?></h2>
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
                        <p class="section-eyebrow mb-2"><?php esc_html_e( 'Latest Updates', 'prashant-bootstrap' ); ?></p>
                        <h2 class="panel-title mb-0"><?php esc_html_e( 'News and Media Notes', 'prashant-bootstrap' ); ?></h2>
                    </div>
                    <a class="news-link" href="<?php echo esc_url( home_url( '/media-coverage/' ) ); ?>"><?php esc_html_e( 'View media coverage', 'prashant-bootstrap' ); ?></a>
                </div>

                <?php if ( $recent_posts->have_posts() ) : ?>
                    <div class="home-news-grid">
                        <?php
                        while ( $recent_posts->have_posts() ) :
                            $recent_posts->the_post();
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
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
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
                                        <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open LinkedIn Profile', 'prashant-bootstrap' ); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="daily-quote" class="card-shell bottom-panel quote-panel">
                            <p class="section-eyebrow mb-3"><?php esc_html_e( 'Daily Quote', 'prashant-bootstrap' ); ?></p>
                            <blockquote class="daily-quote mb-0"><?php echo esc_html( $daily_quote ); ?></blockquote>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>

<?php
get_footer();
