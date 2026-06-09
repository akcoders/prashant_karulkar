<?php
/**
 * Structured content helpers for profile section pages.
 *
 * @package Prashant_Bootstrap
 */

function prashant_bootstrap_profile_base_path() {
    return ABSPATH . 'content_images_data/';
}

function prashant_bootstrap_profile_base_url() {
    return home_url( '/content_images_data/' );
}

function prashant_bootstrap_profile_asset_url( $relative_path ) {
    $parts = array_map( 'rawurlencode', explode( '/', str_replace( '\\', '/', $relative_path ) ) );

    return prashant_bootstrap_profile_base_url() . implode( '/', $parts );
}

function prashant_bootstrap_import_local_image_to_media( $file_path, $title = '' ) {
    static $cache = array();

    $file_path = wp_normalize_path( $file_path );

    if ( isset( $cache[ $file_path ] ) ) {
        return $cache[ $file_path ];
    }

    if ( ! file_exists( $file_path ) || ! is_readable( $file_path ) ) {
        $cache[ $file_path ] = '';
        return '';
    }

    $existing = get_posts(
        array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'meta_key'       => '_prashant_source_file',
            'meta_value'     => $file_path,
            'fields'         => 'ids',
            'posts_per_page' => 1,
        )
    );

    if ( ! empty( $existing ) ) {
        $url = wp_get_attachment_url( (int) $existing[0] );
        $cache[ $file_path ] = $url ? $url : '';
        return $cache[ $file_path ];
    }

    $upload_dir = wp_upload_dir();

    if ( ! empty( $upload_dir['error'] ) ) {
        $cache[ $file_path ] = '';
        return '';
    }

    wp_mkdir_p( $upload_dir['path'] );

    $filename    = wp_unique_filename( $upload_dir['path'], basename( $file_path ) );
    $target_path = trailingslashit( $upload_dir['path'] ) . $filename;

    if ( ! copy( $file_path, $target_path ) ) {
        $cache[ $file_path ] = '';
        return '';
    }

    $filetype = wp_check_filetype( $target_path, null );

    if ( empty( $filetype['type'] ) ) {
        $cache[ $file_path ] = '';
        return '';
    }

    $attachment_id = wp_insert_attachment(
        array(
            'post_mime_type' => $filetype['type'],
            'post_title'     => $title ? $title : preg_replace( '/\.[^.]+$/', '', basename( $file_path ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ),
        $target_path
    );

    if ( is_wp_error( $attachment_id ) ) {
        $cache[ $file_path ] = '';
        return '';
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';

    $metadata = wp_generate_attachment_metadata( $attachment_id, $target_path );
    wp_update_attachment_metadata( $attachment_id, $metadata );
    update_post_meta( $attachment_id, '_prashant_source_file', $file_path );

    $url = wp_get_attachment_url( $attachment_id );
    $cache[ $file_path ] = $url ? $url : '';

    return $cache[ $file_path ];
}

function prashant_bootstrap_theme_image_media_url( $relative_path, $title = '' ) {
    $file_path = get_template_directory() . '/assets/images/' . ltrim( $relative_path, '/' );
    $url       = '';

    if ( file_exists( $file_path ) ) {
        $existing = get_posts(
            array(
                'post_type'      => 'attachment',
                'post_status'    => 'inherit',
                'meta_key'       => '_prashant_source_file',
                'meta_value'     => wp_normalize_path( $file_path ),
                'fields'         => 'ids',
                'posts_per_page' => 1,
            )
        );

        if ( ! empty( $existing ) ) {
            $url = wp_get_attachment_url( (int) $existing[0] );
        } elseif ( is_admin() ) {
            $url = prashant_bootstrap_import_local_image_to_media( $file_path, $title );
        }
    }

    return $url ? $url : get_template_directory_uri() . '/assets/images/' . ltrim( $relative_path, '/' );
}

function prashant_bootstrap_profile_images( $relative_dir, $limit = 8 ) {
    $base = prashant_bootstrap_profile_base_path();
    $dir  = $base . str_replace( '/', DIRECTORY_SEPARATOR, $relative_dir );

    if ( ! is_dir( $dir ) ) {
        return array();
    }

    $images   = array();
    $iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ) );

    foreach ( $iterator as $file ) {
        if ( ! $file->isFile() ) {
            continue;
        }

        $extension = strtolower( $file->getExtension() );
        if ( ! in_array( $extension, array( 'jpg', 'jpeg', 'png', 'webp', 'gif' ), true ) ) {
            continue;
        }

        $relative_file = str_replace( '\\', '/', substr( $file->getPathname(), strlen( $base ) ) );
        $media_url     = prashant_bootstrap_import_local_image_to_media( $file->getPathname(), ucwords( str_replace( array( '-', '_', '.jpg', '.jpeg', '.png', '.webp' ), ' ', basename( $relative_file ) ) ) );

        $images[]      = array(
            'url' => $media_url ? $media_url : prashant_bootstrap_profile_asset_url( $relative_file ),
            'alt' => ucwords( str_replace( array( '-', '_', '.jpg', '.jpeg', '.png', '.webp' ), ' ', basename( $relative_file ) ) ),
        );

        if ( $limit > 0 && count( $images ) >= $limit ) {
            break;
        }
    }

    return $images;
}

function prashant_bootstrap_profile_page_data() {
    $important = 'For Website (PK sir_s IMP Data)';

    return array(
        'about-prashant-karulkar' => array(
            'eyebrow' => 'Profile',
            'title'   => 'Who is Prashant Karulkar?',
            'lead'    => 'An optimist visionary entrepreneur, social transformer, philanthropist, venture capitalist, and experienced investor with a public journey across enterprise, service, and institutional recognition.',
            'images'  => prashant_bootstrap_profile_images( 'Pk sir Solo pics', 5 ),
            'about_spotlight' => array(
                'title' => 'A public-life profile shaped by enterprise, courage, and service.',
                'text'  => 'Prashant Karulkar brings together the pace of a first-generation entrepreneur, the discipline of an investor, and the emotional commitment of a social reformer. His story moves from high-value business execution to grassroots welfare, from institutional meetings to publication initiatives, and from private conviction to public recognition.',
                'quote' => 'Believe in yourself, that is where the magic begins.',
                'pills' => array(
                    'Visionary Entrepreneur',
                    'Social Transformer',
                    'Experienced Investor',
                    'Philanthropist',
                    'Venture Capitalist',
                ),
            ),
            'stats'   => array(
                array( 'number' => 'Rs. 1,111 Cr', 'label' => 'Historic Sahara Group land deal completed with Supreme Court approval.' ),
                array( 'number' => '96,000', 'label' => 'Housing project scale under PMAY.' ),
                array( 'number' => '30,000+', 'label' => 'Families supported through Karulkar Pratishthan.' ),
            ),
            'sections' => array(
                array(
                    'heading' => 'A multi-sector business leader',
                    'text'    => 'His work spans real estate, housing finance, insurance, news media, sand mining, pharma, solar, FMCG, AIF, NBFC, and consulting. His profile is shaped by bold business execution and purpose-led public contribution.',
                ),
                array(
                    'heading' => 'Enterprise with impact',
                    'text'    => 'He has led major initiatives including one of India\'s biggest land deals of its kind, Asia-scale sand mining operations, and large-format housing work, while continuing social outreach through a family foundation established in 1969.',
                ),
            ),
        ),
        'timeline-journey-so-far' => array(
            'eyebrow' => 'Journey So Far',
            'title'   => 'Timeline',
            'lead'    => '',
            'timeline' => array(
                array( 'year' => '1969', 'title' => 'Karulkar Pratishthan foundation legacy', 'text' => 'The Karulkar family foundation begins a long-running commitment to welfare and education.' ),
                array( 'year' => '2014', 'title' => 'INR 1,111 Crore land deal', 'text' => 'Completed a historic Sahara Group land acquisition after complex legal and institutional processes.' ),
                array( 'year' => '2018', 'title' => 'Ujjwal Nikam felicitation', 'text' => 'Recognised for social service in rural and tribal areas through Karulkar Pratishthan.' ),
                array( 'year' => '2019', 'title' => 'BSE and public recognition', 'text' => 'Felicitated at Bombay Stock Exchange by senior market and corporate leaders.' ),
                array( 'year' => '2020', 'title' => 'Karmayoddha contribution', 'text' => 'Felicitated by Shri Amit Shah for contribution as co-author and initiative partner.' ),
                array( 'year' => '2021', 'title' => 'WCFA Davos presence', 'text' => 'Honoured as part of the first couple in the world to be Corporate Members of WCFA at Davos.' ),
                array( 'year' => '2023', 'title' => 'Indian Navy citation', 'text' => 'Received Indian Navy Commendation Citation from Vice Admiral S. N. Ghormade.' ),
                array( 'year' => '2024+', 'title' => 'Public, media, and publication momentum', 'text' => 'Continued recognitions, social media visibility, and publication-led thought presence.' ),
            ),
        ),
        'awards-achievements-felicitations' => array(
            'eyebrow' => 'Recognition',
            'title'   => 'Awards, Achievements, Felicitations',
            'lead'    => '',
            'cards'   => array(
                array( 'title' => 'Shri Amit Shah', 'text' => 'Felicitated for social work and contribution as co-author and initiative partner for Karmayoddha.', 'folder' => "$important/Amit Shah- Home Minister (2020)" ),
                array( 'title' => 'Shri Mohan Bhagwat', 'text' => 'Felicitated for social contributions and as a young entrepreneur at Vigyan Bhawan, New Delhi.', 'folder' => "$important/mohanji bhagwat 2019-2019-2022-2024" ),
                array( 'title' => 'Smt. Nirmala Sitharaman', 'text' => 'Awarded the Achievers Award during the Swah 75 book launch.', 'folder' => "$important/Nirmala Sitharaman" ),
                array( 'title' => 'Shri Nitin Gadkari', 'text' => 'Tarun Bharat Wealth Creators Young Achiever in Business World Award.', 'folder' => "$important/Nitin Gadkari" ),
                array( 'title' => 'Indian Navy Citation', 'text' => 'Commendation citation for contributions toward society.', 'folder' => "$important/Indian Navy Citation 2023" ),
                array( 'title' => 'London Parliament Honour', 'text' => 'Bharat Bhagyavidhata Mahatma Gandhi Noble Award for social and national causes.', 'folder' => "$important/London Awards (Bharat Bhagay vidhata)" ),
            ),
        ),
        'accolades' => array(
            'eyebrow' => 'Accolades',
            'title'   => 'Institutional Accolades',
            'lead'    => '',
            'images'  => prashant_bootstrap_profile_images( 'Photos with Ministers and others/Ministers and others', 10 ),
            'lists'   => array(
                array( 'heading' => 'Institutional honours', 'items' => array( 'Chief Guest at the 59th ABCI Annual Awards Ceremony.', 'Corporate Member presence at WCFA, Davos.', 'Recognised by World Book of Records, London for social support during COVID-19.' ) ),
                array( 'heading' => 'Public-life meetings', 'items' => array( 'Shri Devendra Fadnavis', 'Shri Piyush Goyal', 'Shri Sanjeev Sanyal', 'Shri Vivek Joshi', 'Shri Suresh Prabhu', 'Shri Narayan Rane' ) ),
                array( 'heading' => 'Spiritual blessings', 'items' => array( 'Sri Sri Ravi Shankar Ji', 'Swami Ramdev Baba', 'Sadguru Swami Govind Dev Giri Maharaj', 'Jagadguru Rambhadracharya Guruji', 'Nayan Padma Sagar Maharaj' ) ),
            ),
        ),
        'picture-gallery' => array(
            'eyebrow' => 'Gallery',
            'title'   => 'Picture Gallery',
            'lead'    => 'Album-wise collections of portraits, public meetings, recognitions, old memories, and institutional moments.',
            'galleries' => array(
                array( 'title' => 'Portraits', 'folder' => 'Pk sir Solo pics' ),
                array( 'title' => 'Ministers and Public Life', 'folder' => 'Photos with Ministers and others/Ministers and others' ),
                array( 'title' => 'Important Website Data', 'folder' => $important ),
                array( 'title' => 'Old Photos With Friends', 'folder' => 'OLD pics with friends' ),
            ),
        ),
        'video-gallery' => array(
            'eyebrow' => 'Video',
            'title'   => 'Video Gallery',
            'lead'    => 'Album-wise video collections for interviews, speeches, launch moments, field stories, and social media features.',
            'video_cards' => array(
                array( 'title' => 'Public Addresses', 'text' => 'Speeches, interviews, felicitation clips, and stage appearances.' ),
                array( 'title' => 'Media Moments', 'text' => 'News features, digital clips, and public coverage highlights.' ),
                array( 'title' => 'Karulkar Pratishthan Work', 'text' => 'Show field videos, service activities, campaigns, and foundation impact stories.' ),
            ),
        ),
        'karulkar-pratishthan' => array(
            'eyebrow' => 'Foundation',
            'title'   => 'Karulkar Pratishthan',
            'lead'    => 'A non-profit foundation established by the Karulkar family in 1969, dedicated to welfare and education for underprivileged communities.',
            'images'  => prashant_bootstrap_profile_images( "$important/Bhagat Singh Koshiyari Corona Dut award 2021", 6 ),
            'stats'   => array(
                array( 'number' => '1969', 'label' => 'Established by the Karulkar family.' ),
                array( 'number' => '30,000+', 'label' => 'Families supported independently.' ),
                array( 'number' => '10,000+', 'label' => 'Volunteers connected with on-ground work.' ),
            ),
            'sections' => array(
                array( 'heading' => 'Independent service model', 'text' => 'The foundation supports welfare and education without accepting external donations or CSR funds.' ),
                array( 'heading' => 'Active areas', 'text' => 'Education, environment, employment, rural and tribal development, and construction or renovation of temples, ashrams, and schools.' ),
                array( 'heading' => 'COVID-19 humanitarian service', 'text' => 'Recognised for food, shelter, migration support, sanitization drives, oxygen cylinders, blood supplies, and emergency support during COVID-19 waves.' ),
            ),
        ),
        'publications' => array(
            'eyebrow' => 'Books',
            'title'   => 'Publications',
            'lead'    => 'Books, articles, and publication initiatives where Prashant Karulkar has been co-author, contributor, featured profile, or initiative partner.',
            'galleries' => array(
                array( 'title' => 'Books', 'folder' => "$important/Books (Article written by Sir)/BOOKS" ),
                array( 'title' => 'Corporate Lens', 'folder' => "$important/Books (Article written by Sir)/Corporate Lens" ),
            ),
            'cards' => array(
                array( 'title' => 'Samarth Bharat', 'text' => 'Article connected to a true incident from his life and the Hon\'ble Prime Minister Shri Narendra Modi.' ),
                array( 'title' => 'Karmayoddha Granth', 'text' => 'A book on Shri Narendra Modi, with contribution as co-author and initiative partner.' ),
                array( 'title' => 'Swah 75', 'text' => 'Publication linked to 75 years of Independence.' ),
                array( 'title' => 'Mahayoddha', 'text' => 'A book on the Hon\'ble Home Minister Shri Amit Shah.' ),
                array( 'title' => 'Sanyasi Yoddha', 'text' => 'A book on Shri Yogi Adityanath.' ),
                array( 'title' => 'Veer Savarkar Memoir Translation', 'text' => 'A mission to translate and widen access to the four-part memoir originally published in Marathi in 1972.' ),
            ),
        ),
        'media-coverage' => array(
            'eyebrow' => 'Media',
            'title'   => 'Media Coverage',
            'lead'    => '',
            'images'  => prashant_bootstrap_profile_images( "$important/Books (Article written by Sir)/Corporate Lens", 8 ),
            'cards'   => array(
                array( 'title' => 'India\'s biggest land deal headline', 'text' => 'On 29 November 2014, Prashant Karulkar was highlighted in leading newspapers for a landmark INR 1,111 Crore land deal.' ),
                array( 'title' => 'News Danka launch', 'text' => 'Appreciated and lauded by Shri Devendra Fadnavis during the launch of the media channel News Danka.' ),
                array( 'title' => 'Digital and print features', 'text' => 'Newspaper features, online articles, interviews, and public coverage highlights.' ),
            ),
        ),
        'social-media' => array(
            'eyebrow' => 'Digital Presence',
            'title'   => 'Social Media',
            'lead'    => '',
            'social_links' => array(
                array( 'label' => 'Prashant Karulkar Linktree', 'url' => 'https://linktr.ee/prashantkarulkar', 'metric' => 'Official social and digital presence' ),
                array( 'label' => 'Vivaan Karulkar Linktree', 'url' => 'https://linktree.com/vivaankarulkar', 'metric' => 'Books, media buzz, and youth author presence' ),
            ),
            'stats' => array(
                array( 'number' => 'Official', 'label' => 'Instagram followers' ),
                array( 'number' => 'Growing', 'label' => 'YouTube views' ),
                array( 'number' => 'Active', 'label' => 'LinkedIn reach' ),
                array( 'number' => 'Featured', 'label' => 'Press and social mentions' ),
            ),
        ),
    );
}

function prashant_bootstrap_get_profile_page_data( $slug ) {
    $pages = prashant_bootstrap_profile_page_data();

    if ( ! isset( $pages[ $slug ] ) ) {
        return null;
    }

    $data    = prashant_bootstrap_apply_profile_page_overrides( $slug, $pages[ $slug ] );
    $options = get_option( 'prashant_bootstrap_profile_pages_options', array() );

    if ( 'accolades' === $slug && empty( $options[ $slug ]['cards'] ) && ! empty( $data['images'] ) ) {
        $data['cards'] = prashant_bootstrap_accolade_cards_from_images( $data['images'] );
    }

    return $data;
}

function prashant_bootstrap_get_social_icon_label( $label, $url = '' ) {
    $haystack = strtolower( $label . ' ' . $url );

    if ( false !== strpos( $haystack, 'instagram' ) ) {
        return 'IG';
    }

    if ( false !== strpos( $haystack, 'youtube' ) ) {
        return 'YT';
    }

    if ( false !== strpos( $haystack, 'linkedin' ) ) {
        return 'in';
    }

    if ( false !== strpos( $haystack, 'twitter' ) || false !== strpos( $haystack, 'x.com' ) ) {
        return 'X';
    }

    if ( false !== strpos( $haystack, 'facebook' ) ) {
        return 'f';
    }

    if ( false !== strpos( $haystack, 'linktr.ee' ) || false !== strpos( $haystack, 'linktree' ) ) {
        return 'LT';
    }

    return strtoupper( substr( trim( $label ), 0, 1 ) );
}

function prashant_bootstrap_get_social_icon_svg( $label, $url = '' ) {
    $haystack = strtolower( $label . ' ' . $url );

    if ( false !== strpos( $haystack, 'instagram' ) ) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1.2"></circle></svg>';
    }

    if ( false !== strpos( $haystack, 'youtube' ) ) {
        return '<svg class="social-svg-youtube" viewBox="0 0 24 24" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="3.2"></rect><polygon points="10,9 16,12 10,15"></polygon></svg>';
    }

    if ( false !== strpos( $haystack, 'linkedin' ) ) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.2 8.8h3.2v10H5.2z"></path><path d="M6.8 4.2a1.9 1.9 0 1 1 0 3.8 1.9 1.9 0 0 1 0-3.8z"></path><path d="M10.4 8.8h3.1v1.4h.1c.4-.8 1.5-1.7 3.1-1.7 3.3 0 3.9 2.2 3.9 5v5.3h-3.2v-4.7c0-1.1 0-2.6-1.6-2.6s-1.8 1.2-1.8 2.5v4.8h-3.2z"></path></svg>';
    }

    if ( false !== strpos( $haystack, 'twitter' ) || false !== strpos( $haystack, 'x.com' ) ) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h4.8l3.9 5.4L17.3 4H20l-6.1 7.1L21 20h-4.8l-4.3-5.9L6.9 20H4.1l6.5-7.6z"></path></svg>';
    }

    if ( false !== strpos( $haystack, 'facebook' ) ) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h2.3V4.3c-.4 0-1.8-.1-3.4-.1-3.4 0-5.7 2.1-5.7 6v3.4H3.5V18h3.7v6h4.5v-6h3.7l.6-4.4h-4.3v-3c0-1.3.3-2.6 2.3-2.6z"></path></svg>';
    }

    if ( false !== strpos( $haystack, 'linktr.ee' ) || false !== strpos( $haystack, 'linktree' ) ) {
        return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.3 3h3.4v6.1l4.3-4.3 2.4 2.4-4.3 4.3H22v3.4h-5.9l4.3 4.3-2.4 2.4-4.3-4.3V23h-3.4v-5.7L6 21.6l-2.4-2.4 4.3-4.3H2v-3.4h5.9L3.6 7.2 6 4.8l4.3 4.3z"></path></svg>';
    }

    return '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M8 12h8M12 8v8"></path></svg>';
}

function prashant_bootstrap_get_social_platform_class( $label, $url = '' ) {
    $haystack = strtolower( $label . ' ' . $url );

    if ( false !== strpos( $haystack, 'instagram' ) ) {
        return 'instagram';
    }

    if ( false !== strpos( $haystack, 'youtube' ) ) {
        return 'youtube';
    }

    if ( false !== strpos( $haystack, 'linkedin' ) ) {
        return 'linkedin';
    }

    if ( false !== strpos( $haystack, 'twitter' ) || false !== strpos( $haystack, 'x.com' ) ) {
        return 'x';
    }

    if ( false !== strpos( $haystack, 'facebook' ) ) {
        return 'facebook';
    }

    if ( false !== strpos( $haystack, 'linktr.ee' ) || false !== strpos( $haystack, 'linktree' ) ) {
        return 'linktree';
    }

    return 'generic';
}

function prashant_bootstrap_profile_multiline_rows( $raw_text, $keys, $minimum_parts ) {
    $rows   = prashant_bootstrap_parse_text_list( $raw_text );
    $output = array();

    foreach ( $rows as $row ) {
        $parts = array_map( 'trim', explode( '|', $row ) );

        if ( count( $parts ) < $minimum_parts ) {
            continue;
        }

        $item = array();
        foreach ( $keys as $index => $key ) {
            if ( $index === count( $keys ) - 1 ) {
                $item[ $key ] = implode( ' | ', array_slice( $parts, $index ) );
            } else {
                $item[ $key ] = isset( $parts[ $index ] ) ? $parts[ $index ] : '';
            }
        }

        $output[] = $item;
    }

    return $output;
}

function prashant_bootstrap_profile_multiline_lists( $raw_text ) {
    $rows   = prashant_bootstrap_parse_text_list( $raw_text );
    $output = array();

    foreach ( $rows as $row ) {
        $parts = array_values( array_filter( array_map( 'trim', explode( '|', $row ) ) ) );

        if ( count( $parts ) < 2 ) {
            continue;
        }

        $output[] = array(
            'heading' => array_shift( $parts ),
            'items'   => $parts,
        );
    }

    return $output;
}

function prashant_bootstrap_profile_rows_to_text( $rows, $keys ) {
    if ( empty( $rows ) || ! is_array( $rows ) ) {
        return '';
    }

    $lines = array();

    foreach ( $rows as $row ) {
        $parts = array();

        foreach ( $keys as $key ) {
            $parts[] = isset( $row[ $key ] ) ? $row[ $key ] : '';
        }

        $lines[] = implode( ' | ', $parts );
    }

    return implode( "\n", $lines );
}

function prashant_bootstrap_profile_card_image_for_admin( $image_or_folder ) {
    $image_or_folder = trim( (string) $image_or_folder );

    if ( '' === $image_or_folder ) {
        return '';
    }

    if ( prashant_bootstrap_profile_is_image_url( $image_or_folder ) ) {
        return $image_or_folder;
    }

    $images = prashant_bootstrap_profile_images( $image_or_folder, 1 );

    return ! empty( $images[0]['url'] ) ? $images[0]['url'] : $image_or_folder;
}

function prashant_bootstrap_profile_cards_to_text( $cards ) {
    if ( empty( $cards ) || ! is_array( $cards ) ) {
        return '';
    }

    $lines = array();

    foreach ( $cards as $card ) {
        $lines[] = implode(
            ' | ',
            array(
                isset( $card['title'] ) ? $card['title'] : '',
                isset( $card['text'] ) ? $card['text'] : '',
                isset( $card['folder'] ) ? prashant_bootstrap_profile_card_image_for_admin( $card['folder'] ) : '',
                isset( $card['eyebrow'] ) ? $card['eyebrow'] : '',
            )
        );
    }

    return implode( "\n", $lines );
}

function prashant_bootstrap_profile_cards_text_with_previews( $raw_text ) {
    $cards = prashant_bootstrap_profile_multiline_rows( $raw_text, array( 'title', 'text', 'folder', 'eyebrow' ), 2 );

    return prashant_bootstrap_profile_cards_to_text( $cards );
}

function prashant_bootstrap_profile_images_to_text( $images ) {
    if ( empty( $images ) || ! is_array( $images ) ) {
        return '';
    }

    $lines = array();

    foreach ( $images as $image ) {
        if ( empty( $image['url'] ) ) {
            continue;
        }

        $lines[] = $image['url'] . ' | ' . ( isset( $image['alt'] ) ? $image['alt'] : '' );
    }

    return implode( "\n", $lines );
}

function prashant_bootstrap_accolade_cards_from_images( $images ) {
    if ( empty( $images ) || ! is_array( $images ) ) {
        return array();
    }

    $cards = array();

    foreach ( $images as $index => $image ) {
        if ( empty( $image['url'] ) ) {
            continue;
        }

        $cards[] = array(
            'title'  => sprintf( __( 'Accolade %02d', 'prashant-bootstrap' ), $index + 1 ),
            'text'   => '',
            'folder' => $image['url'],
        );
    }

    return $cards;
}

function prashant_bootstrap_profile_gallery_images_to_text( $galleries ) {
    if ( empty( $galleries ) || ! is_array( $galleries ) ) {
        return '';
    }

    $lines = array();

    foreach ( $galleries as $gallery ) {
        if ( empty( $gallery['images'] ) || ! is_array( $gallery['images'] ) ) {
            continue;
        }

        foreach ( $gallery['images'] as $image ) {
            if ( empty( $image['url'] ) ) {
                continue;
            }

            $lines[] = ( isset( $gallery['title'] ) ? $gallery['title'] : 'Gallery' ) . ' | ' . $image['url'] . ' | ' . ( isset( $image['alt'] ) ? $image['alt'] : '' );
        }
    }

    return implode( "\n", $lines );
}

function prashant_bootstrap_profile_albums_to_json( $galleries ) {
    if ( empty( $galleries ) || ! is_array( $galleries ) ) {
        return '[]';
    }

    $albums = array();

    foreach ( $galleries as $gallery ) {
        $title  = isset( $gallery['title'] ) ? $gallery['title'] : __( 'Gallery', 'prashant-bootstrap' );
        $images = array();
        $cover  = isset( $gallery['cover'] ) && is_array( $gallery['cover'] ) ? $gallery['cover'] : array();

        if ( ! empty( $gallery['images'] ) && is_array( $gallery['images'] ) ) {
            $images = $gallery['images'];
        } elseif ( ! empty( $gallery['folder'] ) ) {
            $images = prashant_bootstrap_profile_images( $gallery['folder'], 12 );
        }

        if ( empty( $cover['url'] ) && ! empty( $images[0]['url'] ) ) {
            $cover = $images[0];
        }

        $albums[] = array(
            'title'  => $title,
            'cover'  => array(
                'url' => isset( $cover['url'] ) ? $cover['url'] : '',
                'alt' => isset( $cover['alt'] ) ? $cover['alt'] : $title,
            ),
            'images' => array_values(
                array_filter(
                    array_map(
                        function ( $image ) use ( $title ) {
                            if ( empty( $image['url'] ) ) {
                                return null;
                            }

                            return array(
                                'url' => $image['url'],
                                'alt' => isset( $image['alt'] ) ? $image['alt'] : $title,
                            );
                        },
                        $images
                    )
                )
            ),
        );
    }

    return wp_json_encode( $albums, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
}

function prashant_bootstrap_profile_parse_albums_json( $raw_json ) {
    $decoded = json_decode( wp_unslash( $raw_json ), true );

    if ( empty( $decoded ) || ! is_array( $decoded ) ) {
        return array();
    }

    $albums = array();

    foreach ( $decoded as $album ) {
        if ( ! is_array( $album ) ) {
            continue;
        }

        $title = isset( $album['title'] ) ? sanitize_text_field( $album['title'] ) : '';
        if ( '' === $title ) {
            continue;
        }

        $images = array();
        if ( ! empty( $album['images'] ) && is_array( $album['images'] ) ) {
            foreach ( $album['images'] as $image ) {
                if ( empty( $image['url'] ) ) {
                    continue;
                }

                $images[] = array(
                    'url' => esc_url_raw( $image['url'] ),
                    'alt' => isset( $image['alt'] ) ? sanitize_text_field( $image['alt'] ) : $title,
                );
            }
        }

        $cover_url = isset( $album['cover']['url'] ) ? esc_url_raw( $album['cover']['url'] ) : '';
        $cover_alt = isset( $album['cover']['alt'] ) ? sanitize_text_field( $album['cover']['alt'] ) : $title;

        $albums[] = array(
            'title'  => $title,
            'cover'  => array(
                'url' => $cover_url,
                'alt' => $cover_alt,
            ),
            'images' => $images,
        );
    }

    return $albums;
}

function prashant_bootstrap_profile_parse_images_text( $raw_text ) {
    $rows   = prashant_bootstrap_parse_text_list( $raw_text );
    $images = array();

    foreach ( $rows as $row ) {
        $parts = array_map( 'trim', explode( '|', $row ) );

        if ( empty( $parts[0] ) ) {
            continue;
        }

        $images[] = array(
            'url' => esc_url_raw( $parts[0] ),
            'alt' => isset( $parts[1] ) ? sanitize_text_field( $parts[1] ) : '',
        );
    }

    return $images;
}

function prashant_bootstrap_profile_parse_gallery_images_text( $raw_text ) {
    $rows      = prashant_bootstrap_parse_text_list( $raw_text );
    $galleries = array();

    foreach ( $rows as $row ) {
        $parts = array_map( 'trim', explode( '|', $row ) );

        if ( count( $parts ) < 2 || empty( $parts[1] ) ) {
            continue;
        }

        $title = ! empty( $parts[0] ) ? $parts[0] : __( 'Gallery', 'prashant-bootstrap' );

        if ( ! isset( $galleries[ $title ] ) ) {
            $galleries[ $title ] = array(
                'title'  => $title,
                'images' => array(),
            );
        }

        $galleries[ $title ]['images'][] = array(
            'url' => esc_url_raw( $parts[1] ),
            'alt' => isset( $parts[2] ) ? sanitize_text_field( $parts[2] ) : $title,
        );
    }

    return array_values( $galleries );
}

function prashant_bootstrap_profile_is_image_url( $value ) {
    return (bool) preg_match( '#^(https?:)?//#', $value ) || 0 === strpos( $value, '/' );
}

function prashant_bootstrap_profile_lists_to_text( $lists ) {
    if ( empty( $lists ) || ! is_array( $lists ) ) {
        return '';
    }

    $lines = array();

    foreach ( $lists as $list ) {
        $parts = array( isset( $list['heading'] ) ? $list['heading'] : '' );

        if ( ! empty( $list['items'] ) && is_array( $list['items'] ) ) {
            $parts = array_merge( $parts, $list['items'] );
        }

        $lines[] = implode( ' | ', $parts );
    }

    return implode( "\n", $lines );
}

function prashant_bootstrap_apply_profile_page_overrides( $slug, $data ) {
    $options = get_option( 'prashant_bootstrap_profile_pages_options', array() );

    if ( empty( $options[ $slug ] ) || ! is_array( $options[ $slug ] ) ) {
        return $data;
    }

    $page_options = $options[ $slug ];

    foreach ( array( 'eyebrow', 'title', 'lead' ) as $key ) {
        if ( array_key_exists( $key, $page_options ) ) {
            $data[ $key ] = $page_options[ $key ];
        }
    }

    if ( isset( $page_options['about_spotlight'] ) && is_array( $page_options['about_spotlight'] ) ) {
        $spotlight = isset( $data['about_spotlight'] ) && is_array( $data['about_spotlight'] ) ? $data['about_spotlight'] : array();

        foreach ( array( 'title', 'text', 'quote' ) as $key ) {
            if ( array_key_exists( $key, $page_options['about_spotlight'] ) ) {
                $spotlight[ $key ] = $page_options['about_spotlight'][ $key ];
            }
        }

        if ( array_key_exists( 'pills', $page_options['about_spotlight'] ) ) {
            $spotlight['pills'] = prashant_bootstrap_parse_text_list( $page_options['about_spotlight']['pills'] );
        }

        $data['about_spotlight'] = $spotlight;
    }

    $structured_fields = array(
        'stats'        => array( array( 'number', 'label' ), 2 ),
        'sections'     => array( array( 'heading', 'text' ), 2 ),
        'timeline'     => array( array( 'year', 'title', 'text' ), 3 ),
        'cards'        => array( array( 'title', 'text', 'folder', 'eyebrow' ), 2 ),
        'galleries'    => array( array( 'title', 'folder' ), 2 ),
        'video_cards'  => array( array( 'title', 'text' ), 2 ),
        'social_links' => array( array( 'label', 'url', 'metric' ), 3 ),
    );

    foreach ( $structured_fields as $field => $config ) {
        if ( array_key_exists( $field, $page_options ) ) {
            if ( '' === trim( $page_options[ $field ] ) ) {
                $data[ $field ] = array();
                continue;
            }

            $parsed = prashant_bootstrap_profile_multiline_rows( $page_options[ $field ], $config[0], $config[1] );

            if ( ! empty( $parsed ) ) {
                $data[ $field ] = $parsed;
            } else {
                $data[ $field ] = array();
            }
        }
    }

    if ( array_key_exists( 'lists', $page_options ) ) {
        if ( '' === trim( $page_options['lists'] ) ) {
            $data['lists'] = array();
        } else {
        $parsed_lists = prashant_bootstrap_profile_multiline_lists( $page_options['lists'] );

        if ( ! empty( $parsed_lists ) ) {
            $data['lists'] = $parsed_lists;
        } else {
            $data['lists'] = array();
        }
        }
    }

    if ( array_key_exists( 'images', $page_options ) ) {
        if ( '' === trim( $page_options['images'] ) ) {
            $data['images'] = array();
        } else {
        $parsed_images = prashant_bootstrap_profile_parse_images_text( $page_options['images'] );

        if ( ! empty( $parsed_images ) ) {
            $data['images'] = $parsed_images;
        } else {
            $data['images'] = array();
        }
        }
    }

    $parsed_albums = array();

    if ( array_key_exists( 'gallery_albums', $page_options ) ) {
        if ( '' === trim( $page_options['gallery_albums'] ) ) {
            $data['galleries'] = array();
        } else {
        $parsed_albums = prashant_bootstrap_profile_parse_albums_json( $page_options['gallery_albums'] );

        if ( ! empty( $parsed_albums ) ) {
            $data['galleries'] = $parsed_albums;
        } else {
            $data['galleries'] = array();
        }
        }
    }

    if ( empty( $parsed_albums ) && array_key_exists( 'gallery_images', $page_options ) ) {
        if ( '' === trim( $page_options['gallery_images'] ) ) {
            $data['galleries'] = array();
        } else {
        $parsed_galleries = prashant_bootstrap_profile_parse_gallery_images_text( $page_options['gallery_images'] );

        if ( ! empty( $parsed_galleries ) ) {
            $data['galleries'] = $parsed_galleries;
        } else {
            $data['galleries'] = array();
        }
        }
    }

    if ( 'accolades' === $slug && empty( $page_options['cards'] ) && ! empty( $data['images'] ) ) {
        $data['cards'] = prashant_bootstrap_accolade_cards_from_images( $data['images'] );
    }

    return $data;
}

function prashant_bootstrap_sanitize_profile_pages_options( $input ) {
    $input  = is_array( $input ) ? $input : array();
    $output = array();

    foreach ( $input as $slug => $page_options ) {
        if ( ! is_array( $page_options ) ) {
            continue;
        }

        $clean_slug = sanitize_key( $slug );

        foreach ( $page_options as $key => $value ) {
            if ( is_array( $value ) ) {
                foreach ( $value as $sub_key => $sub_value ) {
                    $output[ $clean_slug ][ sanitize_key( $key ) ][ sanitize_key( $sub_key ) ] = sanitize_textarea_field( $sub_value );
                }
            } else {
                $output[ $clean_slug ][ sanitize_key( $key ) ] = sanitize_textarea_field( $value );
            }
        }
    }

    return $output;
}

function prashant_bootstrap_register_profile_pages_settings() {
    register_setting(
        'prashant_bootstrap_profile_pages_group',
        'prashant_bootstrap_profile_pages_options',
        'prashant_bootstrap_sanitize_profile_pages_options'
    );
}
add_action( 'admin_init', 'prashant_bootstrap_register_profile_pages_settings' );

function prashant_bootstrap_add_profile_pages_options_page() {
    add_theme_page(
        __( 'Profile Pages Content', 'prashant-bootstrap' ),
        __( 'Profile Pages Content', 'prashant-bootstrap' ),
        'manage_options',
        'prashant-bootstrap-profile-pages',
        'prashant_bootstrap_render_profile_pages_settings_page'
    );
}
add_action( 'admin_menu', 'prashant_bootstrap_add_profile_pages_options_page' );

function prashant_bootstrap_profile_pages_admin_assets( $hook_suffix ) {
    if ( 'appearance_page_prashant-bootstrap-profile-pages' !== $hook_suffix ) {
        return;
    }

    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'prashant_bootstrap_profile_pages_admin_assets' );

function prashant_bootstrap_profile_option_value( $options, $slug, $key, $default = '' ) {
    return array_key_exists( $slug, $options ) && is_array( $options[ $slug ] ) && array_key_exists( $key, $options[ $slug ] ) ? $options[ $slug ][ $key ] : $default;
}

function prashant_bootstrap_render_profile_pages_settings_page() {
    $defaults = prashant_bootstrap_profile_page_data();
    $options  = get_option( 'prashant_bootstrap_profile_pages_options', array() );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Profile Pages Content', 'prashant-bootstrap' ); ?></h1>
        <p><?php esc_html_e( 'Edit the content for the designed profile pages. Leave a field blank to use the theme default.', 'prashant-bootstrap' ); ?></p>
        <p><strong><?php esc_html_e( 'Line format:', 'prashant-bootstrap' ); ?></strong> <?php esc_html_e( 'Use one item per line. Separate columns with | as shown in each field description.', 'prashant-bootstrap' ); ?></p>

        <form method="post" action="options.php">
            <?php settings_fields( 'prashant_bootstrap_profile_pages_group' ); ?>

            <?php foreach ( $defaults as $slug => $page ) : ?>
                <?php
                if ( 'accolades' === $slug ) {
                    $accolade_images = $page['images'];

                    if ( isset( $options[ $slug ]['images'] ) && '' !== trim( $options[ $slug ]['images'] ) ) {
                        $saved_accolade_images = prashant_bootstrap_profile_parse_images_text( $options[ $slug ]['images'] );
                        if ( ! empty( $saved_accolade_images ) ) {
                            $accolade_images = $saved_accolade_images;
                        }
                    }

                    $page['cards'] = prashant_bootstrap_accolade_cards_from_images( $accolade_images );
                }
                ?>
                <details class="card" style="max-width: 1180px; padding: 18px 22px; margin: 0 0 18px;" <?php echo 'about-prashant-karulkar' === $slug ? 'open' : ''; ?>>
                    <summary style="cursor: pointer; font-size: 18px; font-weight: 700;"><?php echo esc_html( $page['title'] ); ?></summary>

                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Hero eyebrow', 'prashant-bootstrap' ); ?></th>
                                <td><input class="regular-text" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][eyebrow]" value="<?php echo esc_attr( prashant_bootstrap_profile_option_value( $options, $slug, 'eyebrow', $page['eyebrow'] ) ); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Hero title', 'prashant-bootstrap' ); ?></th>
                                <td><input class="large-text" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][title]" value="<?php echo esc_attr( prashant_bootstrap_profile_option_value( $options, $slug, 'title', $page['title'] ) ); ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e( 'Hero lead', 'prashant-bootstrap' ); ?></th>
                                <td><textarea class="large-text" rows="3" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][lead]"><?php echo esc_textarea( prashant_bootstrap_profile_option_value( $options, $slug, 'lead', $page['lead'] ) ); ?></textarea></td>
                            </tr>

                            <?php if ( ! empty( $page['about_spotlight'] ) ) : ?>
                                <tr><th colspan="2"><h2><?php esc_html_e( 'About Spotlight', 'prashant-bootstrap' ); ?></h2></th></tr>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Spotlight title', 'prashant-bootstrap' ); ?></th>
                                    <td><input class="large-text" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][about_spotlight][title]" value="<?php echo esc_attr( isset( $options[ $slug ]['about_spotlight'] ) && array_key_exists( 'title', $options[ $slug ]['about_spotlight'] ) ? $options[ $slug ]['about_spotlight']['title'] : $page['about_spotlight']['title'] ); ?>"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Spotlight text', 'prashant-bootstrap' ); ?></th>
                                    <td><textarea class="large-text" rows="4" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][about_spotlight][text]"><?php echo esc_textarea( isset( $options[ $slug ]['about_spotlight'] ) && array_key_exists( 'text', $options[ $slug ]['about_spotlight'] ) ? $options[ $slug ]['about_spotlight']['text'] : $page['about_spotlight']['text'] ); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Quote', 'prashant-bootstrap' ); ?></th>
                                    <td><input class="large-text" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][about_spotlight][quote]" value="<?php echo esc_attr( isset( $options[ $slug ]['about_spotlight'] ) && array_key_exists( 'quote', $options[ $slug ]['about_spotlight'] ) ? $options[ $slug ]['about_spotlight']['quote'] : $page['about_spotlight']['quote'] ); ?>"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Role pills', 'prashant-bootstrap' ); ?></th>
                                    <td>
                                        <textarea class="large-text" rows="5" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][about_spotlight][pills]"><?php echo esc_textarea( isset( $options[ $slug ]['about_spotlight'] ) && array_key_exists( 'pills', $options[ $slug ]['about_spotlight'] ) ? $options[ $slug ]['about_spotlight']['pills'] : implode( "\n", $page['about_spotlight']['pills'] ) ); ?></textarea>
                                        <p class="description"><?php esc_html_e( 'One pill per line.', 'prashant-bootstrap' ); ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php
                            $editable_fields = array(
                                'stats'        => array( __( 'Stats', 'prashant-bootstrap' ), 'number | label', array( 'number', 'label' ) ),
                                'sections'     => array( __( 'Story Sections', 'prashant-bootstrap' ), 'heading | text', array( 'heading', 'text' ) ),
                                'timeline'     => array( __( 'Timeline', 'prashant-bootstrap' ), 'year | title | text', array( 'year', 'title', 'text' ) ),
                                'cards'        => array(
                                    'accolades' === $slug ? __( 'Accolade Cards', 'prashant-bootstrap' ) : ( 'media-coverage' === $slug ? __( 'Media Highlight Cards', 'prashant-bootstrap' ) : __( 'Cards', 'prashant-bootstrap' ) ),
                                    'title | text | optional image | optional card eyebrow',
                                    array( 'title', 'text', 'folder', 'eyebrow' ),
                                ),
                                'video_cards'  => array( __( 'Video Cards', 'prashant-bootstrap' ), 'title | text', array( 'title', 'text' ) ),
                                'social_links' => array( __( 'Social Links', 'prashant-bootstrap' ), 'label | url | metric/details', array( 'label', 'url', 'metric' ) ),
                            );
                            ?>

                            <?php foreach ( $editable_fields as $field => $field_data ) : ?>
                                <?php if ( empty( $page[ $field ] ) ) { continue; } ?>
                                <?php
                                if ( 'cards' === $field ) {
                                    $field_default = prashant_bootstrap_profile_cards_to_text( $page[ $field ] );
                                    $field_value   = prashant_bootstrap_profile_option_value( $options, $slug, $field, $field_default );
                                    $field_value   = prashant_bootstrap_profile_cards_text_with_previews( $field_value );
                                } else {
                                    $field_value = prashant_bootstrap_profile_option_value( $options, $slug, $field, prashant_bootstrap_profile_rows_to_text( $page[ $field ], $field_data[2] ) );
                                }
                                ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html( $field_data[0] ); ?></th>
                                    <td>
                                        <textarea class="large-text code <?php echo 'cards' === $field ? 'pb-card-textarea' : ''; ?>" rows="7" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][<?php echo esc_attr( $field ); ?>]"><?php echo esc_textarea( $field_value ); ?></textarea>
                                        <p class="description"><?php echo esc_html( $field_data[1] ); ?></p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ( ! empty( $page['lists'] ) ) : ?>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Lists', 'prashant-bootstrap' ); ?></th>
                                    <td>
                                        <textarea class="large-text code" rows="7" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][lists]"><?php echo esc_textarea( prashant_bootstrap_profile_option_value( $options, $slug, 'lists', prashant_bootstrap_profile_lists_to_text( $page['lists'] ) ) ); ?></textarea>
                                        <p class="description"><?php esc_html_e( 'heading | item one | item two | item three', 'prashant-bootstrap' ); ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if ( ! empty( $page['images'] ) && 'accolades' !== $slug ) : ?>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Page Images', 'prashant-bootstrap' ); ?></th>
                                    <td>
                                        <textarea class="large-text code pb-media-textarea" rows="5" data-mode="images" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][images]"><?php echo esc_textarea( prashant_bootstrap_profile_option_value( $options, $slug, 'images', prashant_bootstrap_profile_images_to_text( $page['images'] ) ) ); ?></textarea>
                                        <p class="description"><?php esc_html_e( 'Use Add Image to select from Media Library. Format: image URL | alt text', 'prashant-bootstrap' ); ?></p>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if ( 'media-coverage' === $slug ) : ?>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'News and Media Posts', 'prashant-bootstrap' ); ?></th>
                                    <td>
                                        <a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><?php esc_html_e( 'Manage Posts', 'prashant-bootstrap' ); ?></a>
                                        <a class="button" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Add New Post', 'prashant-bootstrap' ); ?></a>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if ( ! empty( $page['galleries'] ) ) : ?>
                                <?php
                                $gallery_album_value = '';
                                if ( isset( $options[ $slug ]['gallery_albums'] ) && '' !== trim( $options[ $slug ]['gallery_albums'] ) ) {
                                    $gallery_album_value = $options[ $slug ]['gallery_albums'];
                                } elseif ( isset( $options[ $slug ]['gallery_images'] ) && '' !== trim( $options[ $slug ]['gallery_images'] ) ) {
                                    $gallery_album_value = prashant_bootstrap_profile_albums_to_json( prashant_bootstrap_profile_parse_gallery_images_text( $options[ $slug ]['gallery_images'] ) );
                                } else {
                                    $gallery_album_value = prashant_bootstrap_profile_albums_to_json( $page['galleries'] );
                                }
                                ?>
                                <tr>
                                    <th scope="row"><?php esc_html_e( 'Manage Gallery Albums', 'prashant-bootstrap' ); ?></th>
                                    <td>
                                        <textarea class="large-text code pb-album-textarea" rows="8" name="prashant_bootstrap_profile_pages_options[<?php echo esc_attr( $slug ); ?>][gallery_albums]"><?php echo esc_textarea( $gallery_album_value ); ?></textarea>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </details>
            <?php endforeach; ?>

            <?php submit_button(); ?>
        </form>
    </div>
    <style>
        .pb-media-textarea, .pb-card-textarea, .pb-album-textarea { display:none; }
        .pb-media-manager, .pb-card-manager, .pb-album-manager { background:#fff; border:1px solid #dcdcde; border-radius:8px; margin-top:10px; padding:12px; }
        .pb-media-row { align-items:center; border-bottom:1px solid #f0f0f1; display:grid; gap:10px; grid-template-columns:72px 1fr 1fr auto; padding:10px 0; }
        .pb-card-row { background:#f6f7f7; border:1px solid #dcdcde; border-radius:10px; display:grid; gap:14px; grid-template-columns:130px minmax(0, 1fr) 150px; margin:0 0 14px; padding:14px; }
        .pb-card-fields { display:grid; gap:10px; grid-template-columns:repeat(2, minmax(0, 1fr)); }
        .pb-card-field { display:flex; flex-direction:column; gap:5px; }
        .pb-card-field label { color:#1d2327; font-weight:600; }
        .pb-card-field-full { grid-column:1 / -1; }
        .pb-card-field input,
        .pb-card-field textarea { width:100%; }
        .pb-card-field textarea { min-height:96px; resize:vertical; }
        .pb-album-card { background:#f6f7f7; border:1px solid #dcdcde; border-radius:10px; margin-bottom:14px; padding:14px; }
        .pb-album-head { align-items:start; display:grid; gap:12px; grid-template-columns:130px 1fr auto; }
        .pb-album-cover-preview { background:#fff; border:1px solid #dcdcde; border-radius:8px; height:96px; object-fit:cover; width:130px; }
        .pb-album-fields { display:grid; gap:8px; }
        .pb-album-photos { display:grid; gap:8px; margin-top:12px; }
        .pb-album-photo-row { align-items:center; background:#fff; border:1px solid #dcdcde; border-radius:8px; display:grid; gap:8px; grid-template-columns:72px 1fr 1fr auto; padding:8px; }
        .pb-album-photo-preview { background:#f6f7f7; border:1px solid #dcdcde; border-radius:6px; height:58px; object-fit:cover; width:72px; }
        .pb-media-row:last-child { border-bottom:0; }
        .pb-media-preview, .pb-card-preview { background:#f6f7f7; border:1px solid #dcdcde; border-radius:6px; height:60px; object-fit:cover; width:72px; }
        .pb-card-preview { height:78px; width:96px; }
        .pb-media-row[data-mode="gallery"] { grid-template-columns:72px 1fr 1fr 1fr auto; }
        .pb-media-actions, .pb-card-actions, .pb-album-actions, .pb-album-photo-actions { display:flex; flex-direction:column; gap:6px; }
        @media (max-width: 900px) {
            .pb-media-row,
            .pb-media-row[data-mode="gallery"],
            .pb-card-row,
            .pb-album-head,
            .pb-album-photo-row { grid-template-columns:1fr; }
            .pb-media-preview, .pb-card-preview, .pb-album-cover-preview, .pb-album-photo-preview { height:auto; max-width:180px; width:100%; }
        }
    </style>
    <script>
        (function ($) {
            function isImageUrl(value) {
                return /\.(png|jpe?g|gif|webp|svg)(\?.*)?$/i.test(value || "") || /^https?:\/\//i.test(value || "");
            }

            function parseRows(value, mode) {
                return value.split(/\r?\n/).map(function (line) {
                    var parts = line.split("|").map(function (part) { return part.trim(); });
                    if (mode === "gallery") {
                        return { group: parts[0] || "Gallery", url: parts[1] || "", alt: parts[2] || "" };
                    }
                    return { url: parts[0] || "", alt: parts[1] || "" };
                }).filter(function (row) { return row.url; });
            }

            function serializeRows(manager) {
                var mode = manager.data("mode");
                var lines = [];

                manager.find(".pb-media-row").each(function () {
                    var row = $(this);
                    var url = row.find(".pb-media-url").val().trim();
                    var alt = row.find(".pb-media-alt").val().trim();

                    if (!url) {
                        return;
                    }

                    if (mode === "gallery") {
                        var group = row.find(".pb-media-group").val().trim() || "Gallery";
                        lines.push(group + " | " + url + " | " + alt);
                    } else {
                        lines.push(url + " | " + alt);
                    }
                });

                manager.prev(".pb-media-textarea").val(lines.join("\n"));
            }

            function parseCardRows(value) {
                return value.split(/\r?\n/).map(function (line) {
                    var parts = line.split("|").map(function (part) { return part.trim(); });
                    return {
                        title: parts[0] || "",
                        text: parts[1] || "",
                        image: parts[2] || "",
                        eyebrow: parts.slice(3).join(" | ") || ""
                    };
                }).filter(function (row) {
                    return row.title || row.text || row.image || row.eyebrow;
                });
            }

            function serializeCardRows(manager) {
                var lines = [];

                manager.find(".pb-card-row").each(function () {
                    var row = $(this);
                    var title = row.find(".pb-card-title-input").val().trim();
                    var text = row.find(".pb-card-text-input").val().trim();
                    var image = row.find(".pb-card-image-input").val().trim();
                    var eyebrow = row.find(".pb-card-eyebrow-input").val().trim();

                    if (!title && !text && !image && !eyebrow) {
                        return;
                    }

                    lines.push(title + " | " + text + " | " + image + " | " + eyebrow);
                });

                manager.prev(".pb-card-textarea").val(lines.join("\n"));
            }

            function createRow(manager, data) {
                var mode = manager.data("mode");
                var row = $('<div class="pb-media-row"></div>').attr("data-mode", mode);
                var preview = $('<img class="pb-media-preview" alt="">').attr("src", data.url || "");
                var url = $('<input type="url" class="regular-text pb-media-url" placeholder="Image URL">').val(data.url || "");
                var alt = $('<input type="text" class="regular-text pb-media-alt" placeholder="Alt text">').val(data.alt || "");
                var actions = $('<div class="pb-media-actions"></div>');
                var select = $('<button type="button" class="button pb-media-select">Select</button>');
                var remove = $('<button type="button" class="button-link-delete pb-media-remove">Remove</button>');

                row.append(preview);

                if (mode === "gallery") {
                    row.append($('<input type="text" class="regular-text pb-media-group" placeholder="Gallery title">').val(data.group || "Gallery"));
                }

                row.append(url, alt);
                actions.append(select, remove);
                row.append(actions);
                manager.find(".pb-media-rows").append(row);
                serializeRows(manager);
            }

            function createCardRow(manager, data) {
                var row = $('<div class="pb-card-row"></div>');
                var preview = $('<img class="pb-card-preview" alt="">').attr("src", isImageUrl(data.image) ? data.image : "");
                var fields = $('<div class="pb-card-fields"></div>');
                var eyebrowWrap = $('<div class="pb-card-field"></div>').append('<label>Card eyebrow</label>');
                var titleWrap = $('<div class="pb-card-field"></div>').append('<label>Card title</label>');
                var textWrap = $('<div class="pb-card-field pb-card-field-full"></div>').append('<label>Card details</label>');
                var imageWrap = $('<div class="pb-card-field pb-card-field-full"></div>').append('<label>Image URL</label>');
                var eyebrow = $('<input type="text" class="regular-text pb-card-eyebrow-input" placeholder="Optional card eyebrow">').val(data.eyebrow || "");
                var title = $('<input type="text" class="regular-text pb-card-title-input" placeholder="Card title">').val(data.title || "");
                var text = $('<textarea class="large-text pb-card-text-input" rows="4" placeholder="Card details"></textarea>').val(data.text || "");
                var image = $('<input type="text" class="regular-text pb-card-image-input" placeholder="Image URL">').val(data.image || "");
                var actions = $('<div class="pb-card-actions"></div>');
                var select = $('<button type="button" class="button pb-card-select">Select Image</button>');
                var remove = $('<button type="button" class="button-link-delete pb-card-remove">Remove</button>');

                eyebrowWrap.append(eyebrow);
                titleWrap.append(title);
                textWrap.append(text);
                imageWrap.append(image);
                fields.append(eyebrowWrap, titleWrap, textWrap, imageWrap);
                actions.append(select, remove);
                row.append(preview, fields, actions);
                manager.find(".pb-card-rows").append(row);
                serializeCardRows(manager);
            }

            function parseAlbums(value) {
                try {
                    var albums = JSON.parse(value || "[]");
                    return Array.isArray(albums) ? albums : [];
                } catch (error) {
                    return [];
                }
            }

            function serializeAlbums(manager) {
                var albums = [];

                manager.find(".pb-album-card").each(function () {
                    var card = $(this);
                    var title = card.find(".pb-album-title-input").val().trim();
                    var coverUrl = card.find(".pb-album-cover-input").val().trim();
                    var coverAlt = card.find(".pb-album-cover-alt-input").val().trim();
                    var images = [];

                    card.find(".pb-album-photo-row").each(function () {
                        var row = $(this);
                        var url = row.find(".pb-album-photo-url").val().trim();
                        var alt = row.find(".pb-album-photo-alt").val().trim();

                        if (!url) {
                            return;
                        }

                        images.push({ url: url, alt: alt });
                    });

                    if (!title && !coverUrl && !images.length) {
                        return;
                    }

                    albums.push({
                        title: title || "Gallery Album",
                        cover: { url: coverUrl, alt: coverAlt || title },
                        images: images
                    });
                });

                manager.prev(".pb-album-textarea").val(JSON.stringify(albums, null, 2));
            }

            function createAlbumPhotoRow(albumCard, data) {
                var row = $('<div class="pb-album-photo-row"></div>');
                var preview = $('<img class="pb-album-photo-preview" alt="">').attr("src", data.url || "");
                var url = $('<input type="url" class="regular-text pb-album-photo-url" placeholder="Photo URL">').val(data.url || "");
                var alt = $('<input type="text" class="regular-text pb-album-photo-alt" placeholder="Alt text">').val(data.alt || "");
                var actions = $('<div class="pb-album-photo-actions"></div>');
                var select = $('<button type="button" class="button pb-album-photo-select">Select Photo</button>');
                var remove = $('<button type="button" class="button-link-delete pb-album-photo-remove">Remove</button>');

                actions.append(select, remove);
                row.append(preview, url, alt, actions);
                albumCard.find(".pb-album-photos").append(row);
                serializeAlbums(albumCard.closest(".pb-album-manager"));
            }

            function createAlbumCard(manager, data) {
                var album = data || {};
                var cover = album.cover || {};
                var card = $('<div class="pb-album-card"></div>');
                var head = $('<div class="pb-album-head"></div>');
                var preview = $('<img class="pb-album-cover-preview" alt="">').attr("src", cover.url || "");
                var fields = $('<div class="pb-album-fields"></div>');
                var title = $('<input type="text" class="large-text pb-album-title-input" placeholder="Album title">').val(album.title || "");
                var coverUrl = $('<input type="url" class="large-text pb-album-cover-input" placeholder="Cover photo URL">').val(cover.url || "");
                var coverAlt = $('<input type="text" class="large-text pb-album-cover-alt-input" placeholder="Cover alt text">').val(cover.alt || "");
                var actions = $('<div class="pb-album-actions"></div>');
                var selectCover = $('<button type="button" class="button pb-album-cover-select">Select Cover</button>');
                var addPhoto = $('<button type="button" class="button button-secondary pb-album-photo-add">Add Photo</button>');
                var removeAlbum = $('<button type="button" class="button-link-delete pb-album-remove">Remove Album</button>');
                var photos = $('<div class="pb-album-photos"></div>');

                fields.append(title, coverUrl, coverAlt);
                actions.append(selectCover, addPhoto, removeAlbum);
                head.append(preview, fields, actions);
                card.append(head, photos);
                manager.find(".pb-album-list").append(card);

                (album.images || []).forEach(function (image) {
                    createAlbumPhotoRow(card, image);
                });

                serializeAlbums(manager);
            }

            function initCardManager(textarea) {
                var input = $(textarea);
                var manager = $('<div class="pb-card-manager"></div>');
                var rows = $('<div class="pb-card-rows"></div>');
                var add = $('<button type="button" class="button button-secondary pb-card-add">Add Card</button>');

                manager.append(rows, add);
                input.after(manager);

                parseCardRows(input.val()).forEach(function (row) {
                    createCardRow(manager, row);
                });
            }

            function initAlbumManager(textarea) {
                var input = $(textarea);
                var manager = $('<div class="pb-album-manager"></div>');
                var list = $('<div class="pb-album-list"></div>');
                var add = $('<button type="button" class="button button-secondary pb-album-add">Add Album</button>');
                var albums = parseAlbums(input.val());

                manager.append(list, add);
                input.after(manager);

                albums.forEach(function (album) {
                    createAlbumCard(manager, album);
                });
            }

            function initManager(textarea) {
                var input = $(textarea);
                var mode = input.data("mode") || "images";
                var manager = $('<div class="pb-media-manager"></div>').data("mode", mode);
                var rows = $('<div class="pb-media-rows"></div>');
                var add = $('<button type="button" class="button button-secondary pb-media-add"></button>').text(mode === "gallery" ? "Add Gallery Image" : "Add Image");

                manager.append(rows, add);
                input.after(manager);

                parseRows(input.val(), mode).forEach(function (row) {
                    createRow(manager, row);
                });
            }

            $(document).on("click", ".pb-media-add", function () {
                var manager = $(this).closest(".pb-media-manager");
                createRow(manager, manager.data("mode") === "gallery" ? { group: "Gallery", url: "", alt: "" } : { url: "", alt: "" });
            });

            $(document).on("click", ".pb-card-add", function () {
                createCardRow($(this).closest(".pb-card-manager"), { title: "", text: "", image: "", eyebrow: "" });
            });

            $(document).on("click", ".pb-album-add", function () {
                createAlbumCard($(this).closest(".pb-album-manager"), { title: "", cover: { url: "", alt: "" }, images: [] });
            });

            $(document).on("click", ".pb-album-photo-add", function () {
                createAlbumPhotoRow($(this).closest(".pb-album-card"), { url: "", alt: "" });
            });

            $(document).on("click", ".pb-media-remove", function () {
                var manager = $(this).closest(".pb-media-manager");
                $(this).closest(".pb-media-row").remove();
                serializeRows(manager);
            });

            $(document).on("click", ".pb-card-remove", function () {
                var manager = $(this).closest(".pb-card-manager");
                $(this).closest(".pb-card-row").remove();
                serializeCardRows(manager);
            });

            $(document).on("click", ".pb-album-remove", function () {
                var manager = $(this).closest(".pb-album-manager");
                $(this).closest(".pb-album-card").remove();
                serializeAlbums(manager);
            });

            $(document).on("click", ".pb-album-photo-remove", function () {
                var manager = $(this).closest(".pb-album-manager");
                $(this).closest(".pb-album-photo-row").remove();
                serializeAlbums(manager);
            });

            $(document).on("input", ".pb-media-row input", function () {
                var row = $(this).closest(".pb-media-row");
                var manager = row.closest(".pb-media-manager");
                row.find(".pb-media-preview").attr("src", row.find(".pb-media-url").val());
                serializeRows(manager);
            });

            $(document).on("input", ".pb-card-row input, .pb-card-row textarea", function () {
                var row = $(this).closest(".pb-card-row");
                var manager = row.closest(".pb-card-manager");
                var image = row.find(".pb-card-image-input").val();
                row.find(".pb-card-preview").attr("src", isImageUrl(image) ? image : "");
                serializeCardRows(manager);
            });

            $(document).on("input", ".pb-album-card input", function () {
                var card = $(this).closest(".pb-album-card");
                var manager = card.closest(".pb-album-manager");

                card.find(".pb-album-cover-preview").attr("src", card.find(".pb-album-cover-input").val());
                card.find(".pb-album-photo-row").each(function () {
                    var row = $(this);
                    row.find(".pb-album-photo-preview").attr("src", row.find(".pb-album-photo-url").val());
                });
                serializeAlbums(manager);
            });

            $(document).on("click", ".pb-media-select", function () {
                var row = $(this).closest(".pb-media-row");
                var manager = row.closest(".pb-media-manager");
                var frame = wp.media({
                    title: "Select image",
                    button: { text: "Use this image" },
                    multiple: false
                });

                frame.on("select", function () {
                    var attachment = frame.state().get("selection").first().toJSON();
                    row.find(".pb-media-url").val(attachment.url);
                    row.find(".pb-media-alt").val(attachment.alt || attachment.title || "");
                    row.find(".pb-media-preview").attr("src", attachment.url);
                    serializeRows(manager);
                });

                frame.open();
            });

            $(document).on("click", ".pb-album-cover-select", function () {
                var card = $(this).closest(".pb-album-card");
                var manager = card.closest(".pb-album-manager");
                var frame = wp.media({
                    title: "Select album cover",
                    button: { text: "Use as cover" },
                    multiple: false
                });

                frame.on("select", function () {
                    var attachment = frame.state().get("selection").first().toJSON();
                    card.find(".pb-album-cover-input").val(attachment.url);
                    card.find(".pb-album-cover-alt-input").val(attachment.alt || attachment.title || card.find(".pb-album-title-input").val());
                    card.find(".pb-album-cover-preview").attr("src", attachment.url);
                    serializeAlbums(manager);
                });

                frame.open();
            });

            $(document).on("click", ".pb-album-photo-select", function () {
                var row = $(this).closest(".pb-album-photo-row");
                var manager = row.closest(".pb-album-manager");
                var frame = wp.media({
                    title: "Select album photos",
                    button: { text: "Add selected photos" },
                    multiple: true
                });

                frame.on("select", function () {
                    var selection = frame.state().get("selection").toJSON();

                    selection.forEach(function (attachment, index) {
                        if (index === 0) {
                            row.find(".pb-album-photo-url").val(attachment.url);
                            row.find(".pb-album-photo-alt").val(attachment.alt || attachment.title || "");
                            row.find(".pb-album-photo-preview").attr("src", attachment.url);
                        } else {
                            createAlbumPhotoRow(row.closest(".pb-album-card"), {
                                url: attachment.url,
                                alt: attachment.alt || attachment.title || ""
                            });
                        }
                    });

                    serializeAlbums(manager);
                });

                frame.open();
            });

            $(document).on("click", ".pb-card-select", function () {
                var row = $(this).closest(".pb-card-row");
                var manager = row.closest(".pb-card-manager");
                var frame = wp.media({
                    title: "Select card image",
                    button: { text: "Use this image" },
                    multiple: false
                });

                frame.on("select", function () {
                    var attachment = frame.state().get("selection").first().toJSON();
                    row.find(".pb-card-image-input").val(attachment.url);
                    row.find(".pb-card-preview").attr("src", attachment.url);
                    serializeCardRows(manager);
                });

                frame.open();
            });

            $(function () {
                $(".pb-media-textarea").each(function () {
                    initManager(this);
                });
                $(".pb-card-textarea").each(function () {
                    initCardManager(this);
                });
                $(".pb-album-textarea").each(function () {
                    initAlbumManager(this);
                });
            });
        })(jQuery);
    </script>
    <?php
}
