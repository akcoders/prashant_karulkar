<?php
/**
 * Theme options for homepage sections.
 *
 * @package Prashant_Bootstrap
 */

function prashant_bootstrap_get_homepage_defaults() {
    return array(
        'linkedin_profile_url'    => 'https://www.linkedin.com/in/prashantkarulkar/',
        'linkedin_description'    => 'A direct path to Prashant Karulkar\'s LinkedIn profile for professional updates, thought leadership, and public activity.',
        'corporate_lens_points'   => implode(
            "\n",
            array(
                'Follow leadership insights, entrepreneurial updates, and public-impact perspectives through the official LinkedIn activity stream.',
                'A gateway to current business commentary, venture thinking, and professional announcements.',
                'This panel now acts as the homepage gateway to the live LinkedIn corporate lens presence.',
            )
        ),
        'linkedin_embeds'         => '',
        'achievements_entries'    => implode(
            "\n",
            array(
                '2024 | Global Corporate Presence | Strengthened positioning as an experienced investor and cross-sector business leader.',
                '2023 | Public Recognition | Invited for civic and institutional recognition linked to entrepreneurship and social contribution.',
                '2022 | Strategic Thought Leadership | Expanded visibility across business, media, and public platforms through curated initiatives.',
                '2021 | National Network Building | Strengthened engagement with policy, business, and impact-driven communities.',
                '2020 | Social Outreach | Focused on philanthropy, welfare support, and scalable civic contribution models.',
                '2019 | Investor Credibility | Continued to build a trusted reputation in capital allocation and growth-oriented ventures.',
                '2018 | Entrepreneurial Expansion | Broadened influence across multiple industries with a value-driven business outlook.',
                '2017 | Leadership Milestone | Recognized for aligning enterprise with impact and public-facing responsibility.',
            )
        ),
        'daily_quotes'            => implode(
            "\n",
            array(
                'Progress begins the moment courage becomes louder than doubt.',
                'A meaningful life is built by serving beyond your own success.',
                'Vision grows stronger when purpose and discipline move together.',
                'Transformation starts when ideas are backed by action.',
                'Leadership is not status, it is the ability to lift others.',
                'Optimism becomes powerful when it is paired with steady execution.',
                'Every day is a chance to invest in people, purpose, and possibility.',
            )
        ),
        'daily_quote_images'      => '',
    );
}

function prashant_bootstrap_get_homepage_options() {
    $defaults = prashant_bootstrap_get_homepage_defaults();
    $options  = get_option( 'prashant_bootstrap_homepage_options', array() );

    if ( ! is_array( $options ) ) {
        $options = array();
    }

    return wp_parse_args( $options, $defaults );
}

function prashant_bootstrap_get_allowed_embed_html() {
    return array(
        'iframe' => array(
            'src'             => true,
            'height'          => true,
            'width'           => true,
            'frameborder'     => true,
            'allowfullscreen' => true,
            'title'           => true,
            'allow'           => true,
            'loading'         => true,
            'referrerpolicy'  => true,
            'style'           => true,
        ),
    );
}

function prashant_bootstrap_sanitize_homepage_options( $input ) {
    $defaults = prashant_bootstrap_get_homepage_defaults();
    $input    = is_array( $input ) ? $input : array();

    return array(
        'linkedin_profile_url'  => ! empty( $input['linkedin_profile_url'] ) ? esc_url_raw( $input['linkedin_profile_url'] ) : $defaults['linkedin_profile_url'],
        'linkedin_description'  => isset( $input['linkedin_description'] ) ? sanitize_textarea_field( $input['linkedin_description'] ) : $defaults['linkedin_description'],
        'corporate_lens_points' => isset( $input['corporate_lens_points'] ) ? sanitize_textarea_field( $input['corporate_lens_points'] ) : $defaults['corporate_lens_points'],
        'linkedin_embeds'       => isset( $input['linkedin_embeds'] ) ? wp_kses( $input['linkedin_embeds'], prashant_bootstrap_get_allowed_embed_html() ) : '',
        'achievements_entries'  => isset( $input['achievements_entries'] ) ? sanitize_textarea_field( $input['achievements_entries'] ) : $defaults['achievements_entries'],
        'daily_quotes'          => isset( $input['daily_quotes'] ) ? sanitize_textarea_field( $input['daily_quotes'] ) : $defaults['daily_quotes'],
        'daily_quote_images'    => isset( $input['daily_quote_images'] ) ? prashant_bootstrap_sanitize_quote_images_text( $input['daily_quote_images'] ) : '',
    );
}

function prashant_bootstrap_register_homepage_settings() {
    register_setting(
        'prashant_bootstrap_homepage_options_group',
        'prashant_bootstrap_homepage_options',
        'prashant_bootstrap_sanitize_homepage_options'
    );
}
add_action( 'admin_init', 'prashant_bootstrap_register_homepage_settings' );

function prashant_bootstrap_add_theme_options_page() {
    add_theme_page(
        __( 'Homepage Settings', 'prashant-bootstrap' ),
        __( 'Homepage Settings', 'prashant-bootstrap' ),
        'manage_options',
        'prashant-bootstrap-homepage-settings',
        'prashant_bootstrap_render_homepage_settings_page'
    );
}
add_action( 'admin_menu', 'prashant_bootstrap_add_theme_options_page' );

function prashant_bootstrap_homepage_admin_assets( $hook_suffix ) {
    if ( 'appearance_page_prashant-bootstrap-homepage-settings' !== $hook_suffix ) {
        return;
    }

    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'prashant_bootstrap_homepage_admin_assets' );

function prashant_bootstrap_render_homepage_settings_page() {
    $options = prashant_bootstrap_get_homepage_options();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Homepage Settings', 'prashant-bootstrap' ); ?></h1>
        <p><?php esc_html_e( 'Manage the LinkedIn Corporate Lens, Achievements, and Daily Quote content shown on the homepage.', 'prashant-bootstrap' ); ?></p>

        <form method="post" action="options.php">
            <?php settings_fields( 'prashant_bootstrap_homepage_options_group' ); ?>

            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="linkedin_profile_url"><?php esc_html_e( 'LinkedIn Profile URL', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <input name="prashant_bootstrap_homepage_options[linkedin_profile_url]" type="url" id="linkedin_profile_url" value="<?php echo esc_attr( $options['linkedin_profile_url'] ); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="linkedin_description"><?php esc_html_e( 'Corporate Lens Description', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[linkedin_description]" id="linkedin_description" class="large-text" rows="3"><?php echo esc_textarea( $options['linkedin_description'] ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="corporate_lens_points"><?php esc_html_e( 'Corporate Lens Points', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[corporate_lens_points]" id="corporate_lens_points" class="large-text" rows="6"><?php echo esc_textarea( $options['corporate_lens_points'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Add one line per point.', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="linkedin_embeds"><?php esc_html_e( 'LinkedIn Post Embed Codes', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[linkedin_embeds]" id="linkedin_embeds" class="large-text code" rows="12"><?php echo esc_textarea( $options['linkedin_embeds'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Paste public LinkedIn post iframe embeds here. Separate each post with ---POST--- on its own line.', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="achievements_entries"><?php esc_html_e( 'Achievements', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[achievements_entries]" id="achievements_entries" class="large-text" rows="10"><?php echo esc_textarea( $options['achievements_entries'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Add one achievement per line using this format: Year | Title | Detail', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="daily_quotes"><?php esc_html_e( 'Daily Quotes', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[daily_quotes]" id="daily_quotes" class="large-text" rows="8"><?php echo esc_textarea( $options['daily_quotes'] ); ?></textarea>
                            <p class="description"><?php esc_html_e( 'Fallback text only. If Daily Quote Images are added below, the homepage uses images instead.', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="daily_quote_images"><?php esc_html_e( 'Daily Quote Images', 'prashant-bootstrap' ); ?></label></th>
                        <td>
                            <textarea name="prashant_bootstrap_homepage_options[daily_quote_images]" id="daily_quote_images" class="large-text code pb-quote-images-textarea" rows="8"><?php echo esc_textarea( $options['daily_quote_images'] ); ?></textarea>
                            <div class="pb-quote-image-manager" data-target="#daily_quote_images">
                                <div class="pb-quote-image-list"></div>
                                <p>
                                    <button type="button" class="button button-secondary pb-quote-images-add"><?php esc_html_e( 'Add / Upload Images', 'prashant-bootstrap' ); ?></button>
                                </p>
                            </div>
                            <p class="description"><?php esc_html_e( 'Bulk select or upload quote images. One image is shown per day in this order, then the list repeats.', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <style>
        .pb-quote-images-textarea { display: none; }
        .pb-quote-image-list { display: grid; gap: 10px; margin: 12px 0; max-width: 760px; }
        .pb-quote-image-row { align-items: center; background: #fff; border: 1px solid #dcdcde; display: grid; gap: 10px; grid-template-columns: 72px 1fr auto auto; padding: 10px; }
        .pb-quote-image-row img { background: #f0f0f1; height: 54px; object-fit: contain; width: 72px; }
        .pb-quote-image-row input { width: 100%; }
        .pb-quote-image-actions { display: flex; gap: 6px; }
    </style>
    <script>
        (function ($) {
            function parseRows(value) {
                return (value || "").split(/\r?\n/).map(function (line) {
                    var parts = line.split("|").map(function (part) { return part.trim(); });
                    return { url: parts[0] || "", alt: parts.slice(1).join(" | ") || "" };
                }).filter(function (row) { return row.url; });
            }

            function serialize(manager) {
                var lines = [];

                manager.find(".pb-quote-image-row").each(function () {
                    var row = $(this);
                    var url = row.find(".pb-quote-image-url").val().trim();
                    var alt = row.find(".pb-quote-image-alt").val().trim();

                    if (!url) {
                        return;
                    }

                    lines.push(url + (alt ? " | " + alt : ""));
                });

                $($(manager).data("target")).val(lines.join("\n"));
            }

            function addRow(manager, data) {
                var row = $('<div class="pb-quote-image-row"></div>');
                var preview = $('<img alt="">').attr("src", data.url || "");
                var fields = $('<div></div>');
                var url = $('<input type="url" class="regular-text pb-quote-image-url" placeholder="Image URL">').val(data.url || "");
                var alt = $('<input type="text" class="regular-text pb-quote-image-alt" placeholder="Alt text">').val(data.alt || "");
                var actions = $('<div class="pb-quote-image-actions"></div>');
                var up = $('<button type="button" class="button pb-quote-image-up">Up</button>');
                var down = $('<button type="button" class="button pb-quote-image-down">Down</button>');
                var remove = $('<button type="button" class="button-link-delete pb-quote-image-remove">Remove</button>');

                fields.append(url, alt);
                actions.append(up, down);
                row.append(preview, fields, actions, remove);
                manager.find(".pb-quote-image-list").append(row);
                serialize(manager);
            }

            function initManager(manager) {
                var input = $($(manager).data("target"));
                parseRows(input.val()).forEach(function (row) {
                    addRow($(manager), row);
                });
            }

            $(document).on("click", ".pb-quote-images-add", function () {
                var manager = $(this).closest(".pb-quote-image-manager");
                var frame = wp.media({
                    title: "Select quote images",
                    button: { text: "Use selected images" },
                    multiple: true
                });

                frame.on("select", function () {
                    frame.state().get("selection").toJSON().forEach(function (attachment) {
                        addRow(manager, {
                            url: attachment.url,
                            alt: attachment.alt || attachment.title || ""
                        });
                    });
                });

                frame.open();
            });

            $(document).on("input", ".pb-quote-image-row input", function () {
                var row = $(this).closest(".pb-quote-image-row");
                var manager = row.closest(".pb-quote-image-manager");
                row.find("img").attr("src", row.find(".pb-quote-image-url").val());
                serialize(manager);
            });

            $(document).on("click", ".pb-quote-image-remove", function () {
                var manager = $(this).closest(".pb-quote-image-manager");
                $(this).closest(".pb-quote-image-row").remove();
                serialize(manager);
            });

            $(document).on("click", ".pb-quote-image-up", function () {
                var row = $(this).closest(".pb-quote-image-row");
                var prev = row.prev(".pb-quote-image-row");
                var manager = row.closest(".pb-quote-image-manager");

                if (prev.length) {
                    row.insertBefore(prev);
                    serialize(manager);
                }
            });

            $(document).on("click", ".pb-quote-image-down", function () {
                var row = $(this).closest(".pb-quote-image-row");
                var next = row.next(".pb-quote-image-row");
                var manager = row.closest(".pb-quote-image-manager");

                if (next.length) {
                    row.insertAfter(next);
                    serialize(manager);
                }
            });

            $(function () {
                $(".pb-quote-image-manager").each(function () {
                    initManager(this);
                });
            });
        })(jQuery);
    </script>
    <?php
}

function prashant_bootstrap_parse_text_list( $raw_text ) {
    $items = preg_split( '/\r\n|\r|\n/', (string) $raw_text );
    $items = array_map( 'trim', $items );

    return array_values( array_filter( $items ) );
}

function prashant_bootstrap_is_image_url( $value ) {
    $path = wp_parse_url( (string) $value, PHP_URL_PATH );

    if ( ! $path ) {
        return false;
    }

    return (bool) preg_match( '/\.(jpe?g|png|gif|webp|avif|svg)$/i', $path );
}

function prashant_bootstrap_sanitize_quote_images_text( $raw_text ) {
    $rows = prashant_bootstrap_parse_text_list( $raw_text );
    $clean = array();

    foreach ( $rows as $row ) {
        $parts = array_map( 'trim', explode( '|', $row ) );
        $url   = ! empty( $parts[0] ) ? esc_url_raw( $parts[0] ) : '';

        if ( ! $url || ! prashant_bootstrap_is_image_url( $url ) ) {
            continue;
        }

        $alt = ! empty( $parts[1] ) ? sanitize_text_field( implode( ' | ', array_slice( $parts, 1 ) ) ) : '';
        $clean[] = $url . ( $alt ? ' | ' . $alt : '' );
    }

    return implode( "\n", $clean );
}

function prashant_bootstrap_get_daily_quote_images() {
    $options = prashant_bootstrap_get_homepage_options();
    $rows    = prashant_bootstrap_parse_text_list( $options['daily_quote_images'] );
    $images  = array();

    foreach ( $rows as $row ) {
        $parts = array_map( 'trim', explode( '|', $row ) );
        $url   = ! empty( $parts[0] ) ? $parts[0] : '';

        if ( ! $url || ! prashant_bootstrap_is_image_url( $url ) ) {
            continue;
        }

        $images[] = array(
            'url' => $url,
            'alt' => ! empty( $parts[1] ) ? implode( ' | ', array_slice( $parts, 1 ) ) : __( "Today's Quote", 'prashant-bootstrap' ),
        );
    }

    return $images;
}

function prashant_bootstrap_get_corporate_lens_points() {
    $options = prashant_bootstrap_get_homepage_options();
    $items   = prashant_bootstrap_parse_text_list( $options['corporate_lens_points'] );

    if ( empty( $items ) ) {
        $defaults = prashant_bootstrap_get_homepage_defaults();
        $items    = prashant_bootstrap_parse_text_list( $defaults['corporate_lens_points'] );
    }

    return $items;
}

function prashant_bootstrap_get_daily_quotes() {
    $options = prashant_bootstrap_get_homepage_options();
    $items   = prashant_bootstrap_parse_text_list( $options['daily_quotes'] );

    if ( empty( $items ) ) {
        $defaults = prashant_bootstrap_get_homepage_defaults();
        $items    = prashant_bootstrap_parse_text_list( $defaults['daily_quotes'] );
    }

    return $items;
}

function prashant_bootstrap_get_achievements() {
    $options      = prashant_bootstrap_get_homepage_options();
    $raw_entries  = prashant_bootstrap_parse_text_list( $options['achievements_entries'] );
    $achievements = array();

    foreach ( $raw_entries as $entry ) {
        $parts = array_map( 'trim', explode( '|', $entry ) );

        if ( count( $parts ) < 3 ) {
            continue;
        }

        $achievements[] = array(
            'year'   => $parts[0],
            'title'  => $parts[1],
            'detail' => implode( ' | ', array_slice( $parts, 2 ) ),
        );
    }

    if ( empty( $achievements ) ) {
        $defaults     = prashant_bootstrap_get_homepage_defaults();
        $raw_entries  = prashant_bootstrap_parse_text_list( $defaults['achievements_entries'] );
        $achievements = array();

        foreach ( $raw_entries as $entry ) {
            $parts = array_map( 'trim', explode( '|', $entry ) );

            if ( count( $parts ) < 3 ) {
                continue;
            }

            $achievements[] = array(
                'year'   => $parts[0],
                'title'  => $parts[1],
                'detail' => implode( ' | ', array_slice( $parts, 2 ) ),
            );
        }
    }

    return $achievements;
}

function prashant_bootstrap_get_linkedin_embeds() {
    $options  = prashant_bootstrap_get_homepage_options();
    $raw_html = trim( (string) $options['linkedin_embeds'] );

    if ( '' === $raw_html ) {
        return array();
    }

    $blocks = preg_split( '/\r\n|\r|\n---POST---\r\n|\r---POST---\r|\n---POST---\n|\n---POST---|\r---POST---|---POST---\n|---POST---\r|---POST---/', $raw_html );
    $blocks = array_values( array_filter( array_map( 'trim', $blocks ) ) );
    $items  = array();

    foreach ( $blocks as $index => $block ) {
        $items[] = array(
            'title'      => sprintf( __( 'LinkedIn Post %d', 'prashant-bootstrap' ), $index + 1 ),
            'embed_html' => wp_kses( $block, prashant_bootstrap_get_allowed_embed_html() ),
        );
    }

    return $items;
}
