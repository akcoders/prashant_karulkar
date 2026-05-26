<?php
/**
 * Template part for displaying when no posts are found.
 *
 * @package Prashant_Bootstrap
 */
?>
<section class="content-card text-center">
    <p class="section-eyebrow mb-3"><?php esc_html_e( 'Nothing Here Yet', 'prashant-bootstrap' ); ?></p>
    <h2 class="display-font h1 mb-3"><?php esc_html_e( 'No results found.', 'prashant-bootstrap' ); ?></h2>
    <p class="text-secondary mb-4"><?php esc_html_e( 'Please try another search or return to the homepage.', 'prashant-bootstrap' ); ?></p>
    <?php get_search_form(); ?>
</section>
