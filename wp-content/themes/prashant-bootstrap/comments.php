<?php
/**
 * Comments template.
 *
 * @package Prashant_Bootstrap
 */

if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="comments-area mx-auto" style="max-width: 900px;">
    <?php if ( have_comments() ) : ?>
        <div class="content-card mb-4">
            <h2 class="h4 mb-4">
                <?php
                printf(
                    /* translators: %s: comment count. */
                    esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'prashant-bootstrap' ) ),
                    esc_html( number_format_i18n( get_comments_number() ) )
                );
                ?>
            </h2>

            <ol class="comment-list">
                <?php
                wp_list_comments(
                    array(
                        'style'      => 'ol',
                        'short_ping' => true,
                    )
                );
                ?>
            </ol>
        </div>
    <?php endif; ?>

    <div class="content-card">
        <?php
        comment_form(
            array(
                'class_submit' => 'submit',
                'title_reply'  => __( 'Leave a Reply', 'prashant-bootstrap' ),
            )
        );
        ?>
    </div>
</section>
