<?php
/**
 * One-time production migration for admin-managed homepage slides.
 *
 * Delete this file automatically after a successful migration.
 */

$migration_key = '3dc8f164581443c68cf75d0d558fbb091273419816004fe0bff0dd39e280f5e6';
$provided_key  = isset( $_GET['key'] ) ? (string) $_GET['key'] : '';

header( 'Content-Type: application/json; charset=utf-8' );
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );

if ( ! hash_equals( $migration_key, $provided_key ) ) {
    http_response_code( 403 );
    echo json_encode( array( 'success' => false, 'message' => 'Invalid migration key.' ) );
    exit;
}

require_once __DIR__ . '/wp-load.php';

$migration_id = 'prashant_home_slides_migration_20260604';
$changes      = array();

if ( get_option( $migration_id ) ) {
    $deleted = @unlink( __FILE__ );

    echo wp_json_encode(
        array(
            'success'      => true,
            'message'      => 'Migration was already completed.',
            'file_deleted' => $deleted,
        )
    );
    exit;
}

if ( ! function_exists( 'prashant_bootstrap_import_local_image_to_media' ) ) {
    http_response_code( 500 );
    echo wp_json_encode( array( 'success' => false, 'message' => 'The Prashant Bootstrap theme must be active before running this migration.' ) );
    exit;
}

$existing_slides = get_posts(
    array(
        'post_type'      => 'home_slide',
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    )
);

if ( empty( $existing_slides ) ) {
    $slides = array(
        array(
            'eyebrow' => 'Recognition',
            'title'   => 'Public life, media presence, and institutional recognition.',
            'image'   => 'slider-image-1.jpg',
        ),
        array(
            'eyebrow' => 'Leadership',
            'title'   => 'Conversations that connect governance, enterprise, and people.',
            'image'   => 'slider-image-2.jpg',
        ),
        array(
            'eyebrow' => 'Impact',
            'title'   => 'A journey shaped by entrepreneurship, service, and influence.',
            'image'   => 'slider-image-3.jpg',
        ),
        array(
            'eyebrow' => 'Service',
            'title'   => 'A visual collection of purpose-led engagement.',
            'image'   => 'slider-image-4.jpg',
        ),
    );

    foreach ( $slides as $order => $slide ) {
        $post_id = wp_insert_post(
            array(
                'post_type'   => 'home_slide',
                'post_status' => 'publish',
                'post_title'  => $slide['title'],
                'menu_order'  => $order,
            ),
            true
        );

        if ( is_wp_error( $post_id ) ) {
            http_response_code( 500 );
            echo wp_json_encode( array( 'success' => false, 'message' => $post_id->get_error_message() ) );
            exit;
        }

        update_post_meta( $post_id, '_prashant_slide_eyebrow', $slide['eyebrow'] );

        $image_path    = get_template_directory() . '/assets/images/' . $slide['image'];
        $image_url     = prashant_bootstrap_import_local_image_to_media( $image_path, $slide['eyebrow'] . ' highlight' );
        $attachment_id = attachment_url_to_postid( $image_url );

        if ( $attachment_id ) {
            set_post_thumbnail( $post_id, $attachment_id );
        }

        $changes[] = sprintf( 'Created homepage slide: %s', $slide['eyebrow'] );
    }
} else {
    $changes[] = 'Skipped initial slides because homepage slide records already exist.';
}

update_option(
    $migration_id,
    array(
        'completed_at' => current_time( 'mysql' ),
        'changes'      => $changes,
    ),
    false
);

$deleted = @unlink( __FILE__ );

echo wp_json_encode(
    array(
        'success'      => true,
        'message'      => 'Homepage slides migration completed successfully.',
        'changes'      => $changes,
        'file_deleted' => $deleted,
    )
);
