<?php
/**
 * Template Name: Profile Section
 * Description: Structured profile pages for biography, timeline, awards, galleries, foundation, media, and social presence.
 *
 * @package Prashant_Bootstrap
 */

get_header();

while ( have_posts() ) :
    the_post();

    $data = prashant_bootstrap_get_profile_page_data( get_post_field( 'post_name', get_the_ID() ) );
    if ( ! $data ) {
        $data = array(
            'eyebrow' => __( 'Profile', 'prashant-bootstrap' ),
            'title'   => get_the_title(),
            'lead'    => get_the_excerpt(),
        );
    }
    ?>
    <main id="primary" class="site-main profile-section-page page-<?php echo esc_attr( get_post_field( 'post_name', get_the_ID() ) ); ?>">
        <section class="profile-hero section-shell">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7" data-reveal="up">
                        <p class="section-eyebrow mb-3"><?php echo esc_html( $data['eyebrow'] ); ?></p>
                        <h1 class="profile-page-title mb-3"><?php echo esc_html( $data['title'] ); ?></h1>
                        <?php if ( ! empty( $data['lead'] ) ) : ?>
                            <p class="profile-lead mb-0"><?php echo esc_html( $data['lead'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5" data-reveal="left">
                        <div class="profile-hero-card">
                            <span><?php esc_html_e( 'Prashant Karulkar', 'prashant-bootstrap' ); ?></span>
                            <strong><?php echo esc_html( $data['title'] ); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if ( ! empty( $data['about_spotlight'] ) ) : ?>
            <section class="profile-band about-creative-band">
                <div class="container">
                    <div class="about-creative-shell" data-reveal="up">
                        <div class="row g-4 align-items-stretch">
                            <div class="col-xl-5">
                                <div class="about-portrait-stage">
                                    <?php foreach ( array_slice( $data['images'], 0, 3 ) as $index => $image ) : ?>
                                        <figure class="about-portrait-card about-portrait-<?php echo esc_attr( $index + 1 ); ?>">
                                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="about-creative-copy">
                                    <p class="signature-kicker"><?php esc_html_e( 'The Identity', 'prashant-bootstrap' ); ?></p>
                                    <h2 class="about-creative-title"><?php echo esc_html( $data['about_spotlight']['title'] ); ?></h2>
                                    <p class="about-creative-text"><?php echo esc_html( $data['about_spotlight']['text'] ); ?></p>
                                    <blockquote class="about-signature-quote"><?php echo esc_html( $data['about_spotlight']['quote'] ); ?></blockquote>
                                    <div class="about-pill-row">
                                        <?php foreach ( $data['about_spotlight']['pills'] as $pill ) : ?>
                                            <span><?php echo esc_html( $pill ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['stats'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['stats'] as $stat ) : ?>
                            <div class="<?php echo ! empty( $data['about_spotlight'] ) ? 'col-md-4' : 'col-md-6 col-xl-3'; ?>" data-reveal="up">
                                <article class="profile-stat-card">
                                    <?php if ( ! empty( $data['social_links'] ) ) : ?>
                                        <div class="profile-stat-icon profile-stat-icon-<?php echo esc_attr( prashant_bootstrap_get_social_platform_class( $stat['label'] ) ); ?>">
                                            <?php echo prashant_bootstrap_get_social_icon_svg( $stat['label'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="profile-stat-number"><?php echo esc_html( $stat['number'] ); ?></div>
                                    <p class="mb-0"><?php echo esc_html( $stat['label'] ); ?></p>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        $show_section_images = empty( $data['about_spotlight'] ) && ! empty( $data['images'] );
        ?>
        <?php if ( ! empty( $data['sections'] ) || $show_section_images ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4 align-items-start">
                        <?php if ( ! empty( $data['sections'] ) ) : ?>
                            <div class="<?php echo $show_section_images ? 'col-lg-6' : 'col-12'; ?>">
                                <div class="profile-stack">
                                    <?php foreach ( $data['sections'] as $section ) : ?>
                                        <article class="profile-content-panel" data-reveal="up">
                                            <h2 class="profile-card-title"><?php echo esc_html( $section['heading'] ); ?></h2>
                                            <p class="mb-0 text-secondary"><?php echo esc_html( $section['text'] ); ?></p>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ( $show_section_images ) : ?>
                            <div class="col-lg-6">
                                <div class="profile-image-mosaic" data-reveal="left">
                                    <?php foreach ( array_slice( $data['images'], 0, 6 ) as $image ) : ?>
                                        <figure>
                                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['timeline'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="profile-timeline">
                        <?php foreach ( $data['timeline'] as $index => $item ) : ?>
                            <article class="profile-timeline-item" data-reveal="up">
                                <span class="profile-timeline-dot"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
                                <div class="profile-timeline-year"><?php echo esc_html( $item['year'] ); ?></div>
                                <div>
                                    <h2 class="profile-card-title mb-2"><?php echo esc_html( $item['title'] ); ?></h2>
                                    <p class="mb-0 text-secondary"><?php echo esc_html( $item['text'] ); ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['cards'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['cards'] as $card ) : ?>
                            <?php
                            $card_images = array();
                            if ( ! empty( $card['folder'] ) ) {
                                if ( prashant_bootstrap_profile_is_image_url( $card['folder'] ) ) {
                                    $card_images[] = array(
                                        'url' => $card['folder'],
                                        'alt' => $card['title'],
                                    );
                                } else {
                                    $card_images = prashant_bootstrap_profile_images( $card['folder'], 1 );
                                }
                            }
                            ?>
                            <div class="col-md-6 col-xl-4" data-reveal="up">
                                <article class="profile-feature-card">
                                    <?php if ( ! empty( $card_images ) ) : ?>
                                        <div class="profile-card-media">
                                            <img class="profile-card-image" src="<?php echo esc_url( $card_images[0]['url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="profile-card-body">
                                        <p class="profile-card-kicker mb-2"><?php echo esc_html( $data['eyebrow'] ); ?></p>
                                        <h2 class="profile-card-title"><?php echo esc_html( $card['title'] ); ?></h2>
                                        <p class="mb-0 text-secondary"><?php echo esc_html( $card['text'] ); ?></p>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['lists'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['lists'] as $list ) : ?>
                            <div class="col-md-6 col-xl-4" data-reveal="up">
                                <article class="profile-content-panel h-100">
                                    <h2 class="profile-card-title"><?php echo esc_html( $list['heading'] ); ?></h2>
                                    <ul class="profile-list">
                                        <?php foreach ( $list['items'] as $item ) : ?>
                                            <li><?php echo esc_html( $item ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['galleries'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <?php foreach ( $data['galleries'] as $gallery ) : ?>
                        <?php
                        if ( ! empty( $gallery['images'] ) && is_array( $gallery['images'] ) ) {
                            $gallery_images = $gallery['images'];
                        } else {
                            $gallery_images = ! empty( $gallery['folder'] ) ? prashant_bootstrap_profile_images( $gallery['folder'], 12 ) : array();
                        }
                        ?>
                        <div class="profile-gallery-block" data-reveal="up">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
                                <div>
                                    <p class="section-eyebrow mb-2"><?php esc_html_e( 'Archive', 'prashant-bootstrap' ); ?></p>
                                    <h2 class="profile-section-title mb-0"><?php echo esc_html( $gallery['title'] ); ?></h2>
                                </div>
                                <span class="mini-chip"><?php echo esc_html( count( $gallery_images ) ); ?> <?php esc_html_e( 'selected images', 'prashant-bootstrap' ); ?></span>
                            </div>
                            <div class="profile-gallery-grid">
                                <?php foreach ( $gallery_images as $image ) : ?>
                                    <figure>
                                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['video_cards'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['video_cards'] as $card ) : ?>
                            <div class="col-md-6 col-xl-4" data-reveal="up">
                                <article class="profile-video-card">
                                    <div class="profile-play-mark"><?php esc_html_e( 'Play', 'prashant-bootstrap' ); ?></div>
                                    <h2 class="profile-card-title"><?php echo esc_html( $card['title'] ); ?></h2>
                                    <p class="mb-0 text-secondary"><?php echo esc_html( $card['text'] ); ?></p>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty( $data['social_links'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['social_links'] as $link ) : ?>
                            <div class="col-md-6" data-reveal="up">
                                <article class="profile-social-card">
                                    <div class="profile-social-icon profile-social-icon-<?php echo esc_attr( prashant_bootstrap_get_social_platform_class( $link['label'], $link['url'] ) ); ?>">
                                        <?php echo prashant_bootstrap_get_social_icon_svg( $link['label'], $link['url'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </div>
                                    <div>
                                        <h2 class="profile-card-title mb-2"><?php echo esc_html( $link['label'] ); ?></h2>
                                        <p class="text-secondary mb-3"><?php echo esc_html( $link['metric'] ); ?></p>
                                        <a class="btn btn-primary rounded-pill px-4" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open Profile', 'prashant-bootstrap' ); ?></a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="profile-band profile-band-last">
            <div class="container">
                <div class="cta-panel">
                    <div class="row align-items-center g-3">
                        <div class="col-md">
                            <h2 class="h4 mb-1"><?php esc_html_e( 'Explore the complete profile', 'prashant-bootstrap' ); ?></h2>
                            <p class="mb-0 text-secondary"><?php esc_html_e( 'Use the navigation to move through biography, timeline, awards, galleries, publications, media, and social presence.', 'prashant-bootstrap' ); ?></p>
                        </div>
                        <div class="col-md-auto">
                            <a class="btn btn-outline-dark rounded-pill px-4" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'prashant-bootstrap' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();
