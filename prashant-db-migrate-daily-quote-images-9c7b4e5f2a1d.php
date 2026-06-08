<?php
/**
 * One-time production migration for Daily Quote Images homepage setting.
 *
 * Delete this file automatically after a successful migration.
 */

$migration_key = '9c7b4e5f2a1d4e6f8b0c3a5d7e9f1024365879abcdef0123456789abcdef0123';
$provided_key  = isset( $_GET['key'] ) ? (string) $_GET['key'] : '';

header( 'Content-Type: application/json; charset=utf-8' );
header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );

if ( ! hash_equals( $migration_key, $provided_key ) ) {
    http_response_code( 403 );
    echo json_encode( array( 'success' => false, 'message' => 'Invalid migration key.' ) );
    exit;
}

require_once __DIR__ . '/wp-load.php';

$migration_id = 'prashant_daily_quote_images_migration_20260608';
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

$homepage_options = get_option( 'prashant_bootstrap_homepage_options', array() );
$homepage_options = is_array( $homepage_options ) ? $homepage_options : array();

if ( ! array_key_exists( 'daily_quote_images', $homepage_options ) ) {
    $homepage_options['daily_quote_images'] = '';
    update_option( 'prashant_bootstrap_homepage_options', $homepage_options, false );
    $changes[] = 'Added empty Daily Quote Images homepage option.';
} else {
    $changes[] = 'Daily Quote Images homepage option already exists.';
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
        'message'      => 'Daily Quote Images migration completed successfully.',
        'changes'      => $changes,
        'file_deleted' => $deleted,
    )
);
