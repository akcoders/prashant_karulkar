<?php
/**
 * One-time production database migration.
 *
 * Delete this file automatically after a successful migration.
 */

$migration_key = '500d97c0ab6f132f9fcf160b3877e45a0a4286eb979dbc5e';
$provided_key  = isset( $_GET['key'] ) ? (string) $_GET['key'] : '';

header( 'Content-Type: application/json; charset=utf-8' );
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );

if ( ! hash_equals( $migration_key, $provided_key ) ) {
    http_response_code( 403 );
    echo json_encode( array( 'success' => false, 'message' => 'Invalid migration key.' ) );
    exit;
}

require_once __DIR__ . '/wp-load.php';

$migration_id = 'prashant_one_time_db_migration_20260604';
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

$post = get_page_by_path( 'demo-awards-and-felicitation-archive', OBJECT, 'post' );
if ( ! $post ) {
    $post = get_page_by_path( 'demo-awards-and-felicitation-collection', OBJECT, 'post' );
}

if ( $post ) {
    $updated_post = wp_update_post(
        array(
            'ID'           => $post->ID,
            'post_title'   => 'Awards and Felicitation Collection',
            'post_name'    => 'demo-awards-and-felicitation-collection',
            'post_excerpt' => str_ireplace( 'archive', 'collection', $post->post_excerpt ),
            'post_content' => str_ireplace( 'archive', 'collection', $post->post_content ),
        ),
        true
    );

    if ( is_wp_error( $updated_post ) ) {
        http_response_code( 500 );
        echo wp_json_encode( array( 'success' => false, 'message' => $updated_post->get_error_message() ) );
        exit;
    }

    $changes[] = 'Updated Awards and Felicitation Collection demo post.';
}

$profile_options = get_option( 'prashant_bootstrap_profile_pages_options', array() );
$profile_options = is_array( $profile_options ) ? $profile_options : array();

$profile_options['picture-gallery']['lead'] = 'Album-wise collections of portraits, public meetings, recognitions, old memories, and institutional moments.';
$profile_options['video-gallery']['lead']   = 'Album-wise video collections for interviews, speeches, launch moments, field stories, and social media features.';

update_option( 'prashant_bootstrap_profile_pages_options', $profile_options );
$changes[] = 'Updated saved Picture Gallery and Video Gallery lead text.';

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
        'message'      => 'Database migration completed successfully.',
        'changes'      => $changes,
        'file_deleted' => $deleted,
    )
);
