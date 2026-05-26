<?php
/**
 * Search form template.
 *
 * @package Prashant_Bootstrap
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'prashant-bootstrap' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'prashant-bootstrap' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
    </label>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'prashant-bootstrap' ); ?>">
</form>
