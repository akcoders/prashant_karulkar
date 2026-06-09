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

    $page_slug = get_post_field( 'post_name', get_the_ID() );
    $data      = prashant_bootstrap_get_profile_page_data( $page_slug );
    if ( ! $data ) {
        $data = array(
            'eyebrow' => __( 'Profile', 'prashant-bootstrap' ),
            'title'   => get_the_title(),
            'lead'    => get_the_excerpt(),
        );
    }

    $selected_album = isset( $_GET['album'] ) ? sanitize_title( wp_unslash( $_GET['album'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $gallery_albums = array();
    $active_album   = null;

    if ( ! empty( $data['galleries'] ) && is_array( $data['galleries'] ) ) {
        foreach ( $data['galleries'] as $gallery ) {
            $album_title = ! empty( $gallery['title'] ) ? $gallery['title'] : __( 'Untitled Album', 'prashant-bootstrap' );
            $album_slug  = sanitize_title( $album_title );
            $cover_image = array();

            if ( ! empty( $gallery['images'] ) && is_array( $gallery['images'] ) ) {
                $album_images = $gallery['images'];
                $cover_image  = ! empty( $gallery['cover']['url'] ) ? $gallery['cover'] : ( ! empty( $album_images[0] ) ? $album_images[0] : array() );
            } else {
                $album_images = array();
                $cover_images = ! empty( $gallery['folder'] ) ? prashant_bootstrap_profile_images( $gallery['folder'], 1 ) : array();
                $cover_image  = ! empty( $gallery['cover']['url'] ) ? $gallery['cover'] : ( ! empty( $cover_images[0] ) ? $cover_images[0] : array() );
            }

            $album = array(
                'slug'   => $album_slug,
                'title'  => $album_title,
                'source' => ! empty( $gallery['folder'] ) ? $gallery['folder'] : '',
                'images' => $album_images,
                'cover'  => $cover_image,
            );

            $gallery_albums[] = $album;

            if ( $selected_album === $album_slug ) {
                $active_album = $album;
            }
        }
    }

    $profile_display_title   = $active_album ? $active_album['title'] : ( isset( $data['title'] ) ? $data['title'] : '' );
    $profile_display_eyebrow = $active_album ? __( 'Gallery Album', 'prashant-bootstrap' ) : $data['eyebrow'];
    $profile_display_lead    = $active_album ? sprintf( __( '%s album from %s.', 'prashant-bootstrap' ), $active_album['title'], $data['title'] ) : ( isset( $data['lead'] ) ? $data['lead'] : '' );
    $show_pratishthan_logo   = 'karulkar-pratishthan' === $page_slug && ! $active_album;
    $pratishthan_logo_url    = trailingslashit( get_template_directory_uri() ) . 'assets/images/karulkar-pratishthan-logo.png';
    ?>
    <main id="primary" class="site-main profile-section-page page-<?php echo esc_attr( $page_slug ); ?>">
        <section class="profile-hero section-shell">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="<?php echo $show_pratishthan_logo ? 'col-lg-7' : 'col-12'; ?>" data-reveal="up">
                        <nav class="profile-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'prashant-bootstrap' ); ?>">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'prashant-bootstrap' ); ?></a>
                            <span><?php echo esc_html( $data['title'] ); ?></span>
                            <?php if ( $active_album ) : ?>
                                <span><?php echo esc_html( $active_album['title'] ); ?></span>
                            <?php endif; ?>
                        </nav>
                        <?php if ( ! empty( $profile_display_eyebrow ) ) : ?>
                            <p class="section-eyebrow mb-3"><?php echo esc_html( $profile_display_eyebrow ); ?></p>
                        <?php endif; ?>
                        <?php if ( ! empty( $profile_display_title ) ) : ?>
                            <h1 class="profile-page-title mb-3"><?php echo esc_html( $profile_display_title ); ?></h1>
                        <?php endif; ?>
                        <?php if ( ! empty( $profile_display_lead ) ) : ?>
                            <p class="profile-lead mb-0"><?php echo esc_html( $profile_display_lead ); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ( $show_pratishthan_logo ) : ?>
                        <div class="col-lg-5" data-reveal="left">
                            <figure class="pratishthan-hero-logo-panel">
                                <img src="<?php echo esc_url( $pratishthan_logo_url ); ?>" alt="<?php esc_attr_e( 'Karulkar Pratishthan logo', 'prashant-bootstrap' ); ?>" width="1200" height="817">
                            </figure>
                        </div>
                    <?php endif; ?>
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
                                    <?php if ( ! empty( $data['about_spotlight']['title'] ) ) : ?>
                                        <p class="signature-kicker"><?php esc_html_e( 'The Identity', 'prashant-bootstrap' ); ?></p>
                                        <h2 class="about-creative-title"><?php echo esc_html( $data['about_spotlight']['title'] ); ?></h2>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $data['about_spotlight']['text'] ) ) : ?>
                                        <p class="about-creative-text"><?php echo esc_html( $data['about_spotlight']['text'] ); ?></p>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $data['about_spotlight']['quote'] ) ) : ?>
                                        <blockquote class="about-signature-quote"><?php echo esc_html( $data['about_spotlight']['quote'] ); ?></blockquote>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $data['about_spotlight']['pills'] ) ) : ?>
                                        <div class="about-pill-row">
                                            <?php foreach ( $data['about_spotlight']['pills'] as $pill ) : ?>
                                                <?php if ( '' !== trim( $pill ) ) : ?>
                                                    <span><?php echo esc_html( $pill ); ?></span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
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
                                    <?php
                                    $stat_number = isset( $stat['number'] ) ? trim( $stat['number'] ) : '';
                                    $stat_label  = isset( $stat['label'] ) ? trim( $stat['label'] ) : '';
                                    $stat_image  = 'social-media' === $page_slug && '' !== $stat_number && filter_var( $stat_number, FILTER_VALIDATE_URL );
                                    $stat_url    = '';

                                    if ( $stat_image && ! empty( $data['social_links'] ) ) {
                                        foreach ( $data['social_links'] as $social_link ) {
                                            if ( ! empty( $social_link['label'] ) && 0 === strcasecmp( $stat_label, $social_link['label'] ) && ! empty( $social_link['url'] ) ) {
                                                $stat_url = $social_link['url'];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if ( $stat_image && '' !== $stat_url ) : ?>
                                        <a class="profile-stat-platform-link profile-stat-platform-<?php echo esc_attr( prashant_bootstrap_get_social_platform_class( $stat_label, $stat_url ) ); ?>" href="<?php echo esc_url( $stat_url ); ?>" target="_blank" rel="noopener noreferrer">
                                            <span class="profile-stat-thumbnail-wrap">
                                                <img class="profile-stat-thumbnail" src="<?php echo esc_url( $stat_number ); ?>" alt="<?php echo esc_attr( $stat_label ); ?>">
                                                <span class="profile-stat-thumbnail-badge" aria-hidden="true">
                                                    <?php echo prashant_bootstrap_get_social_icon_svg( $stat_label, $stat_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                </span>
                                            </span>
                                            <?php if ( '' !== $stat_label ) : ?>
                                                <span class="profile-stat-platform-name">
                                                    <span class="profile-stat-platform-name-icon" aria-hidden="true">
                                                        <?php echo prashant_bootstrap_get_social_icon_svg( $stat_label, $stat_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                    </span>
                                                    <span><?php echo esc_html( $stat_label ); ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </a>
                                    <?php else : ?>
                                        <?php if ( $stat_image ) : ?>
                                            <img class="profile-stat-thumbnail" src="<?php echo esc_url( $stat_number ); ?>" alt="<?php echo esc_attr( $stat_label ); ?>">
                                        <?php elseif ( ! empty( $data['social_links'] ) ) : ?>
                                            <div class="profile-stat-icon profile-stat-icon-<?php echo esc_attr( prashant_bootstrap_get_social_platform_class( $stat['label'] ) ); ?>">
                                                <?php echo prashant_bootstrap_get_social_icon_svg( $stat['label'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( ! $stat_image && '' !== $stat_number ) : ?>
                                            <div class="profile-stat-number"><?php echo esc_html( $stat_number ); ?></div>
                                        <?php endif; ?>
                                        <?php if ( '' !== $stat_label ) : ?>
                                            <p class="mb-0"><?php echo esc_html( $stat_label ); ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        $show_section_images = empty( $data['about_spotlight'] ) && ! empty( $data['images'] ) && ! in_array( $page_slug, array( 'accolades', 'media-coverage' ), true );
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
                                            <?php if ( ! empty( $section['heading'] ) ) : ?>
                                                <h2 class="profile-card-title"><?php echo esc_html( $section['heading'] ); ?></h2>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $section['text'] ) ) : ?>
                                                <p class="mb-0 text-secondary"><?php echo esc_html( $section['text'] ); ?></p>
                                            <?php endif; ?>
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
                                <?php if ( ! empty( $item['year'] ) ) : ?>
                                    <div class="profile-timeline-year"><?php echo esc_html( $item['year'] ); ?></div>
                                <?php endif; ?>
                                <div>
                                    <?php if ( ! empty( $item['title'] ) ) : ?>
                                        <h2 class="profile-card-title mb-2"><?php echo esc_html( $item['title'] ); ?></h2>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $item['text'] ) ) : ?>
                                        <p class="mb-0 text-secondary"><?php echo esc_html( $item['text'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( 'media-coverage' === $page_slug ) : ?>
            <?php if ( ! empty( $data['images'] ) ) : ?>
                <section class="profile-band">
                    <div class="container">
                        <div class="profile-media-posts-head">
                            <div>
                                <p class="section-eyebrow mb-2"><?php esc_html_e( 'Media Gallery', 'prashant-bootstrap' ); ?></p>
                                <h2 class="profile-section-title mb-0"><?php esc_html_e( 'Coverage Highlights', 'prashant-bootstrap' ); ?></h2>
                            </div>
                        </div>
                        <div class="profile-media-image-grid">
                            <?php foreach ( $data['images'] as $image ) : ?>
                                <figure data-reveal="up">
                                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                </figure>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php
            $media_posts = new WP_Query(
                array(
                    'post_type'           => 'post',
                    'post_status'         => 'publish',
                    'posts_per_page'      => 12,
                    'ignore_sticky_posts' => true,
                )
            );
            ?>
            <?php if ( $media_posts->have_posts() ) : ?>
                <section class="profile-band">
                    <div class="container">
                        <div class="profile-media-posts-head">
                            <div>
                                <p class="section-eyebrow mb-2"><?php esc_html_e( 'Latest Coverage', 'prashant-bootstrap' ); ?></p>
                                <h2 class="profile-section-title mb-0"><?php esc_html_e( 'News and Media Posts', 'prashant-bootstrap' ); ?></h2>
                            </div>
                        </div>
                        <div class="profile-media-post-grid">
                            <?php
                            while ( $media_posts->have_posts() ) :
                                $media_posts->the_post();
                                ?>
                                <article <?php post_class( 'home-news-card profile-media-post-card' ); ?> data-reveal="up">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a class="home-news-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                                    <?php endif; ?>
                                    <div class="home-news-body">
                                        <p class="post-meta mb-2"><?php echo esc_html( get_the_date() ); ?></p>
                                        <h3 class="home-news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <p class="mb-3 text-secondary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                                        <a class="news-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'prashant-bootstrap' ); ?></a>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( ! empty( $data['cards'] ) && 'media-coverage' !== $page_slug ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="row g-4">
                        <?php foreach ( $data['cards'] as $card ) : ?>
                            <?php
                            $card_images = array();
                            $card_eyebrow = ! empty( $card['eyebrow'] ) ? $card['eyebrow'] : ( ! empty( $data['eyebrow'] ) ? $data['eyebrow'] : '' );
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
                                        <?php if ( ! empty( $card_eyebrow ) && ! in_array( $page_slug, array( 'awards-achievements-felicitations', 'accolades' ), true ) ) : ?>
                                            <p class="profile-card-kicker mb-2"><?php echo esc_html( $card_eyebrow ); ?></p>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $card['title'] ) ) : ?>
                                            <h2 class="profile-card-title"><?php echo esc_html( $card['title'] ); ?></h2>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $card['text'] ) ) : ?>
                                            <p class="mb-0 text-secondary"><?php echo esc_html( $card['text'] ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( 'media-coverage' === $page_slug && ! empty( $data['cards'] ) ) : ?>
            <section class="profile-band">
                <div class="container">
                    <div class="profile-media-posts-head">
                        <div>
                            <p class="section-eyebrow mb-2"><?php esc_html_e( 'More Stories', 'prashant-bootstrap' ); ?></p>
                            <h2 class="profile-section-title mb-0"><?php esc_html_e( 'Other News Highlights', 'prashant-bootstrap' ); ?></h2>
                        </div>
                    </div>
                    <div class="row g-4">
                        <?php foreach ( $data['cards'] as $card ) : ?>
                            <?php
                            $card_images = array();
                            $card_eyebrow = ! empty( $card['eyebrow'] ) ? $card['eyebrow'] : '';
                            if ( ! empty( $card['folder'] ) ) {
                                $card_images = prashant_bootstrap_profile_is_image_url( $card['folder'] )
                                    ? array( array( 'url' => $card['folder'], 'alt' => $card['title'] ) )
                                    : prashant_bootstrap_profile_images( $card['folder'], 1 );
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
                                        <?php if ( ! empty( $card_eyebrow ) ) : ?>
                                            <p class="profile-card-kicker mb-2"><?php echo esc_html( $card_eyebrow ); ?></p>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $card['title'] ) ) : ?>
                                            <h2 class="profile-card-title"><?php echo esc_html( $card['title'] ); ?></h2>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $card['text'] ) ) : ?>
                                            <p class="mb-0 text-secondary"><?php echo esc_html( $card['text'] ); ?></p>
                                        <?php endif; ?>
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
                                    <?php if ( ! empty( $list['heading'] ) ) : ?>
                                        <h2 class="profile-card-title"><?php echo esc_html( $list['heading'] ); ?></h2>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $list['items'] ) ) : ?>
                                        <ul class="profile-list">
                                            <?php foreach ( $list['items'] as $item ) : ?>
                                                <?php if ( '' !== trim( $item ) ) : ?>
                                                    <li><?php echo esc_html( $item ); ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
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
                    <?php
                    if ( $active_album ) :
                        $active_images = ! empty( $active_album['images'] ) ? $active_album['images'] : prashant_bootstrap_profile_images( $active_album['source'], 0 );
                        ?>
                        <div class="profile-gallery-block profile-album-detail" data-reveal="up">
                            <div class="profile-album-head">
                                <div>
                                    <p class="section-eyebrow mb-2"><?php esc_html_e( 'Gallery Album', 'prashant-bootstrap' ); ?></p>
                                    <h2 class="profile-section-title mb-0"><?php echo esc_html( $active_album['title'] ); ?></h2>
                                </div>
                                <div class="profile-album-actions">
                                    <span class="mini-chip"><?php echo esc_html( count( $active_images ) ); ?> <?php esc_html_e( 'images', 'prashant-bootstrap' ); ?></span>
                                    <a class="btn btn-outline-dark rounded-pill px-4" href="<?php echo esc_url( remove_query_arg( 'album', get_permalink() ) ); ?>"><?php esc_html_e( 'All Albums', 'prashant-bootstrap' ); ?></a>
                                </div>
                            </div>
                            <div class="profile-gallery-grid profile-album-grid">
                                <?php foreach ( $active_images as $image ) : ?>
                                    <figure>
                                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="profile-album-index" data-reveal="up">
                            <?php foreach ( $gallery_albums as $album ) : ?>
                                <a class="profile-album-card" href="<?php echo esc_url( add_query_arg( 'album', $album['slug'], get_permalink() ) ); ?>">
                                    <span class="profile-album-cover">
                                        <?php if ( ! empty( $album['cover']['url'] ) ) : ?>
                                            <img src="<?php echo esc_url( $album['cover']['url'] ); ?>" alt="<?php echo esc_attr( $album['title'] ); ?>">
                                        <?php endif; ?>
                                    </span>
                                    <span class="profile-album-body">
                                        <span class="section-eyebrow"><?php esc_html_e( 'Album', 'prashant-bootstrap' ); ?></span>
                                        <strong><?php echo esc_html( $album['title'] ); ?></strong>
                                        <span><?php esc_html_e( 'Open Gallery', 'prashant-bootstrap' ); ?></span>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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
                                    <?php if ( ! empty( $card['title'] ) ) : ?>
                                        <h2 class="profile-card-title"><?php echo esc_html( $card['title'] ); ?></h2>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $card['text'] ) ) : ?>
                                        <p class="mb-0 text-secondary"><?php echo esc_html( $card['text'] ); ?></p>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( 'social-media' !== $page_slug && ! empty( $data['social_links'] ) ) : ?>
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
                                        <?php if ( ! empty( $link['label'] ) ) : ?>
                                            <h2 class="profile-card-title mb-2"><?php echo esc_html( $link['label'] ); ?></h2>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $link['metric'] ) ) : ?>
                                            <p class="text-secondary mb-3"><?php echo esc_html( $link['metric'] ); ?></p>
                                        <?php endif; ?>
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
