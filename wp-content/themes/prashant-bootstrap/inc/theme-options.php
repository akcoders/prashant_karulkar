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
                            <p class="description"><?php esc_html_e( 'Add one quote per line. The homepage rotates them automatically by day.', 'prashant-bootstrap' ); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function prashant_bootstrap_parse_text_list( $raw_text ) {
    $items = preg_split( '/\r\n|\r|\n/', (string) $raw_text );
    $items = array_map( 'trim', $items );

    return array_values( array_filter( $items ) );
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
