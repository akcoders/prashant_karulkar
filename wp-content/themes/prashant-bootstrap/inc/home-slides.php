<?php
/**
 * Admin-managed homepage slides.
 *
 * @package Prashant_Bootstrap
 */

function prashant_bootstrap_register_home_slide_post_type() {
    $labels = array(
        'name'                  => __( 'Homepage Slides', 'prashant-bootstrap' ),
        'singular_name'         => __( 'Homepage Slide', 'prashant-bootstrap' ),
        'menu_name'             => __( 'Homepage Slides', 'prashant-bootstrap' ),
        'add_new'               => __( 'Add Slide', 'prashant-bootstrap' ),
        'add_new_item'          => __( 'Add Homepage Slide', 'prashant-bootstrap' ),
        'edit_item'             => __( 'Edit Homepage Slide', 'prashant-bootstrap' ),
        'new_item'              => __( 'New Homepage Slide', 'prashant-bootstrap' ),
        'view_item'             => __( 'View Homepage Slide', 'prashant-bootstrap' ),
        'search_items'          => __( 'Search Homepage Slides', 'prashant-bootstrap' ),
        'not_found'             => __( 'No homepage slides found.', 'prashant-bootstrap' ),
        'not_found_in_trash'    => __( 'No homepage slides found in Trash.', 'prashant-bootstrap' ),
        'featured_image'        => __( 'Slide Image', 'prashant-bootstrap' ),
        'set_featured_image'    => __( 'Set slide image', 'prashant-bootstrap' ),
        'remove_featured_image' => __( 'Remove slide image', 'prashant-bootstrap' ),
        'use_featured_image'    => __( 'Use as slide image', 'prashant-bootstrap' ),
    );

    register_post_type(
        'home_slide',
        array(
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'menu_icon'           => 'dashicons-images-alt2',
            'menu_position'       => 21,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
            'hierarchical'        => false,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'rewrite'             => false,
        )
    );
}
add_action( 'init', 'prashant_bootstrap_register_home_slide_post_type' );

function prashant_bootstrap_add_home_slide_meta_boxes() {
    add_meta_box(
        'prashant-home-slide-details',
        __( 'Slide Details', 'prashant-bootstrap' ),
        'prashant_bootstrap_render_home_slide_meta_box',
        'home_slide',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes_home_slide', 'prashant_bootstrap_add_home_slide_meta_boxes' );

function prashant_bootstrap_render_home_slide_meta_box( $post ) {
    $eyebrow          = get_post_meta( $post->ID, '_prashant_slide_eyebrow', true );
    $media_type       = get_post_meta( $post->ID, '_prashant_slide_media_type', true );
    $youtube_url      = get_post_meta( $post->ID, '_prashant_slide_youtube_url', true );
    $custom_video_url = get_post_meta( $post->ID, '_prashant_slide_custom_video_url', true );

    if ( ! in_array( $media_type, array( 'image', 'youtube', 'video' ), true ) ) {
        $media_type = 'image';
    }

    wp_nonce_field( 'prashant_bootstrap_save_home_slide', 'prashant_home_slide_nonce' );
    ?>
    <p>
        <label for="prashant-slide-eyebrow"><strong><?php esc_html_e( 'Eyebrow', 'prashant-bootstrap' ); ?></strong></label>
    </p>
    <p>
        <input type="text" class="widefat" id="prashant-slide-eyebrow" name="prashant_slide_eyebrow" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="<?php esc_attr_e( 'Example: Leadership', 'prashant-bootstrap' ); ?>">
    </p>
    <hr>
    <p><strong><?php esc_html_e( 'Slide Media', 'prashant-bootstrap' ); ?></strong></p>
    <p>
        <label><input type="radio" name="prashant_slide_media_type" value="image" <?php checked( $media_type, 'image' ); ?>> <?php esc_html_e( 'Image', 'prashant-bootstrap' ); ?></label><br>
        <label><input type="radio" name="prashant_slide_media_type" value="youtube" <?php checked( $media_type, 'youtube' ); ?>> <?php esc_html_e( 'YouTube Video', 'prashant-bootstrap' ); ?></label><br>
        <label><input type="radio" name="prashant_slide_media_type" value="video" <?php checked( $media_type, 'video' ); ?>> <?php esc_html_e( 'Custom Video URL', 'prashant-bootstrap' ); ?></label>
    </p>
    <p>
        <label for="prashant-slide-youtube-url"><strong><?php esc_html_e( 'YouTube URL', 'prashant-bootstrap' ); ?></strong></label>
        <input type="url" class="widefat" id="prashant-slide-youtube-url" name="prashant_slide_youtube_url" value="<?php echo esc_attr( $youtube_url ); ?>" placeholder="https://www.youtube.com/watch?v=...">
    </p>
    <p>
        <label for="prashant-slide-custom-video-url"><strong><?php esc_html_e( 'Custom Video URL', 'prashant-bootstrap' ); ?></strong></label>
        <input type="url" class="widefat" id="prashant-slide-custom-video-url" name="prashant_slide_custom_video_url" value="<?php echo esc_attr( $custom_video_url ); ?>" placeholder="https://example.com/video.mp4">
    </p>
    <p class="description"><?php esc_html_e( 'Image slides use the featured image. Video slides autoplay muted when their slide becomes active. Order controls slide position.', 'prashant-bootstrap' ); ?></p>
    <?php
}

function prashant_bootstrap_save_home_slide( $post_id ) {
    if (
        ! isset( $_POST['prashant_home_slide_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['prashant_home_slide_nonce'] ) ), 'prashant_bootstrap_save_home_slide' )
    ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $eyebrow          = isset( $_POST['prashant_slide_eyebrow'] ) ? sanitize_text_field( wp_unslash( $_POST['prashant_slide_eyebrow'] ) ) : '';
    $media_type       = isset( $_POST['prashant_slide_media_type'] ) ? sanitize_key( wp_unslash( $_POST['prashant_slide_media_type'] ) ) : 'image';
    $youtube_url      = isset( $_POST['prashant_slide_youtube_url'] ) ? esc_url_raw( wp_unslash( $_POST['prashant_slide_youtube_url'] ) ) : '';
    $custom_video_url = isset( $_POST['prashant_slide_custom_video_url'] ) ? esc_url_raw( wp_unslash( $_POST['prashant_slide_custom_video_url'] ) ) : '';

    if ( ! in_array( $media_type, array( 'image', 'youtube', 'video' ), true ) ) {
        $media_type = 'image';
    }

    if ( '' === $eyebrow ) {
        delete_post_meta( $post_id, '_prashant_slide_eyebrow' );
    } else {
        update_post_meta( $post_id, '_prashant_slide_eyebrow', $eyebrow );
    }

    update_post_meta( $post_id, '_prashant_slide_media_type', $media_type );

    if ( $youtube_url ) {
        update_post_meta( $post_id, '_prashant_slide_youtube_url', $youtube_url );
    } else {
        delete_post_meta( $post_id, '_prashant_slide_youtube_url' );
    }

    if ( $custom_video_url ) {
        update_post_meta( $post_id, '_prashant_slide_custom_video_url', $custom_video_url );
    } else {
        delete_post_meta( $post_id, '_prashant_slide_custom_video_url' );
    }
}
add_action( 'save_post_home_slide', 'prashant_bootstrap_save_home_slide' );

function prashant_bootstrap_youtube_embed_url( $url ) {
    $parts = wp_parse_url( $url );

    if ( empty( $parts['host'] ) ) {
        return '';
    }

    $host     = strtolower( $parts['host'] );
    $video_id = '';

    if ( false !== strpos( $host, 'youtu.be' ) && ! empty( $parts['path'] ) ) {
        $video_id = trim( $parts['path'], '/' );
    } elseif ( false !== strpos( $host, 'youtube.com' ) ) {
        if ( ! empty( $parts['query'] ) ) {
            parse_str( $parts['query'], $query );
            $video_id = ! empty( $query['v'] ) ? $query['v'] : '';
        }

        if ( ! $video_id && ! empty( $parts['path'] ) && preg_match( '#/(embed|shorts)/([^/?]+)#', $parts['path'], $matches ) ) {
            $video_id = $matches[2];
        }
    }

    $video_id = preg_replace( '/[^A-Za-z0-9_-]/', '', $video_id );

    if ( ! $video_id ) {
        return '';
    }

    return add_query_arg(
        array(
            'autoplay'    => 1,
            'mute'        => 1,
            'controls'    => 0,
            'playsinline' => 1,
            'rel'         => 0,
            'enablejsapi' => 1,
        ),
        'https://www.youtube.com/embed/' . $video_id
    );
}

function prashant_bootstrap_get_home_slides() {
    $posts  = get_posts(
        array(
            'post_type'      => 'home_slide',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => array(
                'menu_order' => 'ASC',
                'date'       => 'ASC',
            ),
        )
    );
    $slides = array();

    foreach ( $posts as $slide_post ) {
        $image            = get_the_post_thumbnail_url( $slide_post, 'full' );
        $media_type       = get_post_meta( $slide_post->ID, '_prashant_slide_media_type', true );
        $youtube_url      = get_post_meta( $slide_post->ID, '_prashant_slide_youtube_url', true );
        $custom_video_url = get_post_meta( $slide_post->ID, '_prashant_slide_custom_video_url', true );
        $youtube_embed    = $youtube_url ? prashant_bootstrap_youtube_embed_url( $youtube_url ) : '';

        if ( ! in_array( $media_type, array( 'image', 'youtube', 'video' ), true ) ) {
            $media_type = 'image';
        }

        if ( 'youtube' === $media_type && ! $youtube_embed ) {
            continue;
        }

        if ( 'video' === $media_type && ! $custom_video_url ) {
            continue;
        }

        if ( 'image' === $media_type && ! $image ) {
            continue;
        }

        $image_path = $image ? wp_parse_url( $image, PHP_URL_PATH ) : '';

        if ( $image_path ) {
            $uploads = wp_get_upload_dir();
            $uploads_path = wp_parse_url( $uploads['baseurl'], PHP_URL_PATH );

            if ( $uploads_path && 0 === strpos( $image_path, $uploads_path ) ) {
                $relative_image = ltrim( substr( $image_path, strlen( $uploads_path ) ), '/' );
                $local_image    = trailingslashit( $uploads['basedir'] ) . str_replace( '/', DIRECTORY_SEPARATOR, $relative_image );

                if ( ! file_exists( $local_image ) ) {
                    continue;
                }
            }
        }

        $slides[] = array(
            'eyebrow' => get_post_meta( $slide_post->ID, '_prashant_slide_eyebrow', true ),
            'title'   => get_the_title( $slide_post ),
            'content' => apply_filters( 'the_content', $slide_post->post_content ),
            'image'   => $image,
            'type'    => $media_type,
            'video'   => 'youtube' === $media_type ? $youtube_embed : $custom_video_url,
        );
    }

    return $slides;
}

function prashant_bootstrap_home_slide_columns( $columns ) {
    return array(
        'cb'         => $columns['cb'],
        'thumbnail'  => __( 'Image', 'prashant-bootstrap' ),
        'title'      => __( 'Title', 'prashant-bootstrap' ),
        'media_type' => __( 'Media', 'prashant-bootstrap' ),
        'eyebrow'    => __( 'Eyebrow', 'prashant-bootstrap' ),
        'menu_order' => __( 'Order', 'prashant-bootstrap' ),
        'date'       => $columns['date'],
    );
}
add_filter( 'manage_home_slide_posts_columns', 'prashant_bootstrap_home_slide_columns' );

function prashant_bootstrap_home_slide_column_content( $column, $post_id ) {
    if ( 'thumbnail' === $column ) {
        echo get_the_post_thumbnail( $post_id, array( 80, 56 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } elseif ( 'media_type' === $column ) {
        $media_type = get_post_meta( $post_id, '_prashant_slide_media_type', true );
        echo esc_html( $media_type ? ucfirst( $media_type ) : __( 'Image', 'prashant-bootstrap' ) );
    } elseif ( 'eyebrow' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_prashant_slide_eyebrow', true ) );
    } elseif ( 'menu_order' === $column ) {
        echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
    }
}
add_action( 'manage_home_slide_posts_custom_column', 'prashant_bootstrap_home_slide_column_content', 10, 2 );
