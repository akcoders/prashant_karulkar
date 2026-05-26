<?php
/**
 * Template Name: Legacy Experience
 * Description: A premium editorial page template for profile, vision, and influence storytelling.
 *
 * @package Prashant_Bootstrap
 */

get_header();

$pillars = array(
    array(
        'eyebrow' => 'Enterprise',
        'title'   => 'Business thinking shaped by long-term conviction.',
        'text'    => 'Strategic vision, cross-sector experience, and leadership credibility presented with clarity and elegance.',
    ),
    array(
        'eyebrow' => 'Influence',
        'title'   => 'Public presence with a curated, premium narrative.',
        'text'    => 'Recognitions, institutional conversations, and thought leadership brought together in an elevated narrative.',
    ),
    array(
        'eyebrow' => 'Purpose',
        'title'   => 'A visual profile that feels polished and authoritative.',
        'text'    => 'Impact storytelling, editorial rhythm, and a polished experience across desktop and mobile.',
    ),
);

$milestones = array(
    array(
        'year'   => '01',
        'title'  => 'Vision',
        'text'   => 'Craft a page that goes beyond basic biography and instead feels like a leadership profile with atmosphere and authority.',
    ),
    array(
        'year'   => '02',
        'title'  => 'Reach',
        'text'   => 'Present work, recognitions, social initiatives, and public identity inside a structured storytelling sequence.',
    ),
    array(
        'year'   => '03',
        'title'  => 'Legacy',
        'text'   => 'Use rich typography, layered cards, and elegant motion to make the visitor experience feel intentional and memorable.',
    ),
);

$focus_cards = array(
    array(
        'number' => '30,000+',
        'label'  => 'Families positively impacted through sustained social outreach.',
    ),
    array(
        'number' => '10,000+',
        'label'  => 'Volunteers aligned with purposeful on-ground work.',
    ),
    array(
        'number' => 'Multi-Sector',
        'label'  => 'Experience spanning enterprise, public engagement, and philanthropy.',
    ),
);

$latest_posts = new WP_Query(
    array(
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
    )
);
?>

<main id="primary" class="site-main lux-page">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <section class="lux-hero">
            <div class="container">
                <div class="lux-shell lux-shell-lg">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6" data-reveal="up">
                            <p class="lux-kicker"><?php esc_html_e( 'Profile Narrative', 'prashant-bootstrap' ); ?></p>
                            <h1 class="lux-title"><?php the_title(); ?></h1>
                            <?php if ( has_excerpt() ) : ?>
                                <p class="lux-subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
                            <?php endif; ?>
                            <div class="lux-divider"></div>
                            <div class="lux-copy">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="col-lg-6" data-reveal="left">
                            <div class="lux-hero-visual">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'large', array( 'class' => 'lux-hero-image' ) ); ?>
                                <?php else : ?>
                                    <div class="lux-abstract-stage">
                                        <div class="lux-orbit lux-orbit-a"></div>
                                        <div class="lux-orbit lux-orbit-b"></div>
                                        <div class="lux-orbit lux-orbit-c"></div>
                                        <div class="lux-stage-card">
                                            <span class="lux-stage-label"><?php esc_html_e( 'Signature Profile', 'prashant-bootstrap' ); ?></span>
                                            <strong><?php bloginfo( 'name' ); ?></strong>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="lux-section">
            <div class="container">
                <div class="row g-4" data-reveal-group>
                    <?php foreach ( $focus_cards as $card ) : ?>
                        <div class="col-md-6 col-xl-4" data-reveal="up">
                            <article class="lux-stat-card">
                                <div class="lux-stat-number"><?php echo esc_html( $card['number'] ); ?></div>
                                <p class="mb-0"><?php echo esc_html( $card['label'] ); ?></p>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="lux-section">
            <div class="container">
                <div class="row g-4 align-items-start">
                    <div class="col-xl-5" data-reveal="up">
                        <div class="lux-shell h-100">
                            <p class="lux-kicker"><?php esc_html_e( 'Positioning', 'prashant-bootstrap' ); ?></p>
                            <h2 class="lux-section-title"><?php esc_html_e( 'A high-value personal profile experience built around legacy, impact, and public trust.', 'prashant-bootstrap' ); ?></h2>
                            <p class="lux-soft-text mb-0"><?php esc_html_e( 'Vision, leadership, public image, impact initiatives, institutional relationships, and long-form story moments come together in one refined narrative.', 'prashant-bootstrap' ); ?></p>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="row g-4" data-reveal-group>
                            <?php foreach ( $pillars as $pillar ) : ?>
                                <div class="col-md-6 col-xl-4" data-reveal="up">
                                    <article class="lux-pillar-card h-100">
                                        <p class="lux-kicker mb-2"><?php echo esc_html( $pillar['eyebrow'] ); ?></p>
                                        <h3 class="lux-card-title"><?php echo esc_html( $pillar['title'] ); ?></h3>
                                        <p class="mb-0 lux-soft-text"><?php echo esc_html( $pillar['text'] ); ?></p>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="lux-section">
            <div class="container">
                <div class="lux-shell lux-timeline-wrap" data-reveal="up">
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-4">
                            <p class="lux-kicker"><?php esc_html_e( 'Story Flow', 'prashant-bootstrap' ); ?></p>
                            <h2 class="lux-section-title"><?php esc_html_e( 'A clean sequence for presenting vision, reach, and legacy.', 'prashant-bootstrap' ); ?></h2>
                        </div>
                        <div class="col-lg-8">
                            <div class="lux-timeline">
                                <?php foreach ( $milestones as $milestone ) : ?>
                                    <article class="lux-timeline-item">
                                        <div class="lux-timeline-index"><?php echo esc_html( $milestone['year'] ); ?></div>
                                        <div class="lux-timeline-body">
                                            <h3 class="lux-card-title mb-2"><?php echo esc_html( $milestone['title'] ); ?></h3>
                                            <p class="mb-0 lux-soft-text"><?php echo esc_html( $milestone['text'] ); ?></p>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="lux-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-7" data-reveal="up">
                        <div class="lux-shell h-100">
                            <p class="lux-kicker"><?php esc_html_e( 'Editorial Block', 'prashant-bootstrap' ); ?></p>
                            <h2 class="lux-section-title"><?php esc_html_e( 'A refined narrative for biography, public presence, influence, and legacy.', 'prashant-bootstrap' ); ?></h2>
                            <p class="lux-soft-text mb-0"><?php esc_html_e( 'The story brings together enterprise, service, public relationships, recognitions, and long-term impact.', 'prashant-bootstrap' ); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-5" data-reveal="left">
                        <div class="lux-quote-card">
                            <blockquote><?php esc_html_e( 'A powerful page does more than inform. It creates presence, clarity, and memory.', 'prashant-bootstrap' ); ?></blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="lux-section lux-section-last">
            <div class="container">
                <div class="row g-4" data-reveal-group>
                    <?php if ( $latest_posts->have_posts() ) : ?>
                        <?php
                        while ( $latest_posts->have_posts() ) :
                            $latest_posts->the_post();
                            ?>
                            <div class="col-md-6 col-xl-4" data-reveal="up">
                                <article class="lux-news-card h-100">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="lux-news-thumb mb-3"><?php the_post_thumbnail( 'large' ); ?></div>
                                    <?php endif; ?>
                                    <p class="lux-news-meta"><?php echo esc_html( get_the_date() ); ?></p>
                                    <h3 class="lux-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p class="lux-soft-text mb-0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                                </article>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <div class="col-12" data-reveal="up">
                            <div class="lux-shell">
                                <h2 class="lux-section-title mb-0"><?php esc_html_e( 'Latest profile notes and public updates continue the narrative.', 'prashant-bootstrap' ); ?></h2>
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
