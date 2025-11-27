<?php
/**
 * Plugin Name: Reading List
 * Plugin URI: https://github.com/jonathanbossenger/reading-list
 * Description: A WordPress plugin to manage a list of books you've read.
 * Version: 1.0.0
 * Author: Jonathan Bossenger
 * Author URI: https://developer.developer.developer.developer.developer.developer.developer.developer.developer.developer
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: reading-list
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'READING_LIST_VERSION', '1.0.0' );
define( 'READING_LIST_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'READING_LIST_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register the custom post type for books.
 */
function reading_list_register_post_type() {
    $labels = array(
        'name'                  => _x( 'Books', 'Post Type General Name', 'reading-list' ),
        'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'reading-list' ),
        'menu_name'             => __( 'Reading List', 'reading-list' ),
        'name_admin_bar'        => __( 'Book', 'reading-list' ),
        'archives'              => __( 'Book Archives', 'reading-list' ),
        'attributes'            => __( 'Book Attributes', 'reading-list' ),
        'parent_item_colon'     => __( 'Parent Book:', 'reading-list' ),
        'all_items'             => __( 'All Books', 'reading-list' ),
        'add_new_item'          => __( 'Add New Book', 'reading-list' ),
        'add_new'               => __( 'Add New', 'reading-list' ),
        'new_item'              => __( 'New Book', 'reading-list' ),
        'edit_item'             => __( 'Edit Book', 'reading-list' ),
        'update_item'           => __( 'Update Book', 'reading-list' ),
        'view_item'             => __( 'View Book', 'reading-list' ),
        'view_items'            => __( 'View Books', 'reading-list' ),
        'search_items'          => __( 'Search Book', 'reading-list' ),
        'not_found'             => __( 'Not found', 'reading-list' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'reading-list' ),
        'featured_image'        => __( 'Book Cover', 'reading-list' ),
        'set_featured_image'    => __( 'Set book cover', 'reading-list' ),
        'remove_featured_image' => __( 'Remove book cover', 'reading-list' ),
        'use_featured_image'    => __( 'Use as book cover', 'reading-list' ),
        'insert_into_item'      => __( 'Insert into book', 'reading-list' ),
        'uploaded_to_this_item' => __( 'Uploaded to this book', 'reading-list' ),
        'items_list'            => __( 'Books list', 'reading-list' ),
        'items_list_navigation' => __( 'Books list navigation', 'reading-list' ),
        'filter_items_list'     => __( 'Filter books list', 'reading-list' ),
    );
    $args   = array(
        'label'               => __( 'Book', 'reading-list' ),
        'description'         => __( 'Books in your reading list', 'reading-list' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-book',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );
    register_post_type( 'reading_list_book', $args );
}
add_action( 'init', 'reading_list_register_post_type', 0 );

/**
 * Add meta box for book details.
 */
function reading_list_add_meta_boxes() {
    add_meta_box(
        'reading_list_book_details',
        __( 'Book Details', 'reading-list' ),
        'reading_list_book_details_callback',
        'reading_list_book',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'reading_list_add_meta_boxes' );

/**
 * Render the book details meta box.
 *
 * @param WP_Post $post The post object.
 */
function reading_list_book_details_callback( $post ) {
    wp_nonce_field( 'reading_list_save_book_details', 'reading_list_book_details_nonce' );

    $author    = get_post_meta( $post->ID, '_reading_list_author', true );
    $isbn      = get_post_meta( $post->ID, '_reading_list_isbn', true );
    $date_read = get_post_meta( $post->ID, '_reading_list_date_read', true );
    $rating    = get_post_meta( $post->ID, '_reading_list_rating', true );

    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="reading_list_author"><?php esc_html_e( 'Author', 'reading-list' ); ?></label>
            </th>
            <td>
                <input type="text" id="reading_list_author" name="reading_list_author" value="<?php echo esc_attr( $author ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="reading_list_isbn"><?php esc_html_e( 'ISBN', 'reading-list' ); ?></label>
            </th>
            <td>
                <input type="text" id="reading_list_isbn" name="reading_list_isbn" value="<?php echo esc_attr( $isbn ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="reading_list_date_read"><?php esc_html_e( 'Date Read', 'reading-list' ); ?></label>
            </th>
            <td>
                <input type="date" id="reading_list_date_read" name="reading_list_date_read" value="<?php echo esc_attr( $date_read ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="reading_list_rating"><?php esc_html_e( 'Rating (1-5)', 'reading-list' ); ?></label>
            </th>
            <td>
                <select id="reading_list_rating" name="reading_list_rating">
                    <option value=""><?php esc_html_e( 'Select Rating', 'reading-list' ); ?></option>
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <option value="<?php echo esc_attr( $i ); ?>" <?php selected( $rating, $i ); ?>>
                            <?php echo esc_html( $i ); ?> <?php echo esc_html( str_repeat( '★', $i ) ); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save book details meta box data.
 *
 * @param int $post_id The post ID.
 */
function reading_list_save_book_details( $post_id ) {
    // Check if nonce is set.
    if ( ! isset( $_POST['reading_list_book_details_nonce'] ) ) {
        return;
    }

    // Verify nonce.
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['reading_list_book_details_nonce'] ) ), 'reading_list_save_book_details' ) ) {
        return;
    }

    // Check for autosave.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save author.
    if ( isset( $_POST['reading_list_author'] ) ) {
        update_post_meta( $post_id, '_reading_list_author', sanitize_text_field( wp_unslash( $_POST['reading_list_author'] ) ) );
    }

    // Save ISBN.
    if ( isset( $_POST['reading_list_isbn'] ) ) {
        update_post_meta( $post_id, '_reading_list_isbn', sanitize_text_field( wp_unslash( $_POST['reading_list_isbn'] ) ) );
    }

    // Save date read.
    if ( isset( $_POST['reading_list_date_read'] ) ) {
        update_post_meta( $post_id, '_reading_list_date_read', sanitize_text_field( wp_unslash( $_POST['reading_list_date_read'] ) ) );
    }

    // Save rating.
    if ( isset( $_POST['reading_list_rating'] ) ) {
        $rating = absint( wp_unslash( $_POST['reading_list_rating'] ) );
        if ( $rating >= 1 && $rating <= 5 ) {
            update_post_meta( $post_id, '_reading_list_rating', $rating );
        } else {
            delete_post_meta( $post_id, '_reading_list_rating' );
        }
    }
}
add_action( 'save_post_reading_list_book', 'reading_list_save_book_details' );

/**
 * Add custom columns to the books list table.
 *
 * @param array $columns The existing columns.
 * @return array The modified columns.
 */
function reading_list_custom_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        if ( 'date' === $key ) {
            $new_columns['reading_list_author']    = __( 'Author', 'reading-list' );
            $new_columns['reading_list_date_read'] = __( 'Date Read', 'reading-list' );
            $new_columns['reading_list_rating']    = __( 'Rating', 'reading-list' );
        }
        $new_columns[ $key ] = $value;
    }
    return $new_columns;
}
add_filter( 'manage_reading_list_book_posts_columns', 'reading_list_custom_columns' );

/**
 * Display custom column content.
 *
 * @param string $column  The column name.
 * @param int    $post_id The post ID.
 */
function reading_list_custom_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'reading_list_author':
            $author = get_post_meta( $post_id, '_reading_list_author', true );
            echo esc_html( $author ? $author : '—' );
            break;
        case 'reading_list_date_read':
            $date_read = get_post_meta( $post_id, '_reading_list_date_read', true );
            if ( $date_read ) {
                echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date_read ) ) );
            } else {
                echo '—';
            }
            break;
        case 'reading_list_rating':
            $rating = get_post_meta( $post_id, '_reading_list_rating', true );
            if ( $rating ) {
                echo esc_html( str_repeat( '★', intval( $rating ) ) . str_repeat( '☆', 5 - intval( $rating ) ) );
            } else {
                echo '—';
            }
            break;
    }
}
add_action( 'manage_reading_list_book_posts_custom_column', 'reading_list_custom_column_content', 10, 2 );

/**
 * Make custom columns sortable.
 *
 * @param array $columns The sortable columns.
 * @return array The modified sortable columns.
 */
function reading_list_sortable_columns( $columns ) {
    $columns['reading_list_author']    = 'reading_list_author';
    $columns['reading_list_date_read'] = 'reading_list_date_read';
    $columns['reading_list_rating']    = 'reading_list_rating';
    return $columns;
}
add_filter( 'manage_edit-reading_list_book_sortable_columns', 'reading_list_sortable_columns' );

/**
 * Handle sorting by custom columns.
 *
 * @param WP_Query $query The query object.
 */
function reading_list_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    switch ( $orderby ) {
        case 'reading_list_author':
            $query->set( 'meta_key', '_reading_list_author' );
            $query->set( 'orderby', 'meta_value' );
            break;
        case 'reading_list_date_read':
            $query->set( 'meta_key', '_reading_list_date_read' );
            $query->set( 'orderby', 'meta_value' );
            break;
        case 'reading_list_rating':
            $query->set( 'meta_key', '_reading_list_rating' );
            $query->set( 'orderby', 'meta_value_num' );
            break;
    }
}
add_action( 'pre_get_posts', 'reading_list_orderby' );

/**
 * Register the shortcode for displaying the reading list.
 *
 * @param array $atts Shortcode attributes.
 * @return string The reading list HTML.
 */
function reading_list_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'limit'   => -1,
            'orderby' => 'date_read',
            'order'   => 'DESC',
        ),
        $atts,
        'reading_list'
    );

    $meta_key = '_reading_list_date_read';
    $orderby  = 'meta_value';

    if ( 'title' === $atts['orderby'] ) {
        $meta_key = '';
        $orderby  = 'title';
    } elseif ( 'rating' === $atts['orderby'] ) {
        $meta_key = '_reading_list_rating';
        $orderby  = 'meta_value_num';
    }

    $args = array(
        'post_type'      => 'reading_list_book',
        'posts_per_page' => intval( $atts['limit'] ),
        'order'          => strtoupper( $atts['order'] ) === 'ASC' ? 'ASC' : 'DESC',
    );

    if ( $meta_key ) {
        $args['meta_key'] = $meta_key;
        $args['orderby']  = $orderby;
    } else {
        $args['orderby'] = $orderby;
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '<p class="reading-list-empty">' . esc_html__( 'No books found in the reading list.', 'reading-list' ) . '</p>';
    }

    $output = '<div class="reading-list">';
    $output .= '<ul class="reading-list-books">';

    while ( $query->have_posts() ) {
        $query->the_post();
        $post_id   = get_the_ID();
        $author    = get_post_meta( $post_id, '_reading_list_author', true );
        $date_read = get_post_meta( $post_id, '_reading_list_date_read', true );
        $rating    = get_post_meta( $post_id, '_reading_list_rating', true );

        $output .= '<li class="reading-list-book">';

        if ( has_post_thumbnail() ) {
            $output .= '<div class="reading-list-book-cover">';
            $output .= get_the_post_thumbnail( $post_id, 'thumbnail' );
            $output .= '</div>';
        }

        $output .= '<div class="reading-list-book-details">';
        $output .= '<h3 class="reading-list-book-title">' . esc_html( get_the_title() ) . '</h3>';

        if ( $author ) {
            $output .= '<p class="reading-list-book-author">' . esc_html__( 'by', 'reading-list' ) . ' ' . esc_html( $author ) . '</p>';
        }

        if ( $rating ) {
            $output .= '<p class="reading-list-book-rating">';
            $output .= esc_html( str_repeat( '★', intval( $rating ) ) . str_repeat( '☆', 5 - intval( $rating ) ) );
            $output .= '</p>';
        }

        if ( $date_read ) {
            $output .= '<p class="reading-list-book-date">';
            $output .= esc_html__( 'Read on:', 'reading-list' ) . ' ';
            $output .= esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date_read ) ) );
            $output .= '</p>';
        }

        $content = get_the_content();
        if ( $content ) {
            $output .= '<div class="reading-list-book-notes">' . wp_kses_post( wpautop( $content ) ) . '</div>';
        }

        $output .= '</div>';
        $output .= '</li>';
    }

    wp_reset_postdata();

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}
add_shortcode( 'reading_list', 'reading_list_shortcode' );

/**
 * Enqueue frontend styles.
 */
function reading_list_enqueue_styles() {
    wp_enqueue_style(
        'reading-list-styles',
        READING_LIST_PLUGIN_URL . 'assets/css/reading-list.css',
        array(),
        READING_LIST_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'reading_list_enqueue_styles' );

/**
 * Flush rewrite rules on activation.
 */
function reading_list_activate() {
    reading_list_register_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'reading_list_activate' );

/**
 * Flush rewrite rules on deactivation.
 */
function reading_list_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'reading_list_deactivate' );
