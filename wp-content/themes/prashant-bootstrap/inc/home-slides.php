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
    $eyebrow = get_post_meta( $post->ID, '_prashant_slide_eyebrow', true );

    wp_nonce_field( 'prashant_bootstrap_save_home_slide', 'prashant_home_slide_nonce' );
    ?>
    <p>
        <label for="prashant-slide-eyebrow"><strong><?php esc_html_e( 'Eyebrow', 'prashant-bootstrap' ); ?></strong></label>
    </p>
    <p>
        <input type="text" class="widefat" id="prashant-slide-eyebrow" name="prashant_slide_eyebrow" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="<?php esc_attr_e( 'Example: Leadership', 'prashant-bootstrap' ); ?>">
    </p>
    <p class="description"><?php esc_html_e( 'Use the title for the main heading, the editor for supporting content, the slide image panel for the image, and Order to control slide position.', 'prashant-bootstrap' ); ?></p>
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

    $eyebrow = isset( $_POST['prashant_slide_eyebrow'] ) ? sanitize_text_field( wp_unslash( $_POST['prashant_slide_eyebrow'] ) ) : '';

    if ( '' === $eyebrow ) {
        delete_post_meta( $post_id, '_prashant_slide_eyebrow' );
        return;
    }

    update_post_meta( $post_id, '_prashant_slide_eyebrow', $eyebrow );
}
add_action( 'save_post_home_slide', 'prashant_bootstrap_save_home_slide' );

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
        $image = get_the_post_thumbnail_url( $slide_post, 'full' );

        if ( ! $image ) {
            continue;
        }

        $image_path = wp_parse_url( $image, PHP_URL_PATH );

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
        );
    }

    return $slides;
}

function prashant_bootstrap_home_slide_columns( $columns ) {
    return array(
        'cb'         => $columns['cb'],
        'thumbnail'  => __( 'Image', 'prashant-bootstrap' ),
        'title'      => __( 'Title', 'prashant-bootstrap' ),
        'eyebrow'    => __( 'Eyebrow', 'prashant-bootstrap' ),
        'menu_order' => __( 'Order', 'prashant-bootstrap' ),
        'date'       => $columns['date'],
    );
}
add_filter( 'manage_home_slide_posts_columns', 'prashant_bootstrap_home_slide_columns' );

function prashant_bootstrap_home_slide_column_content( $column, $post_id ) {
    if ( 'thumbnail' === $column ) {
        echo get_the_post_thumbnail( $post_id, array( 80, 56 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } elseif ( 'eyebrow' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_prashant_slide_eyebrow', true ) );
    } elseif ( 'menu_order' === $column ) {
        echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
    }
}
add_action( 'manage_home_slide_posts_custom_column', 'prashant_bootstrap_home_slide_column_content', 10, 2 );
