<?php
/**
 * Breacrumb.
 *
 * @package understrap
 */

if ( ! function_exists( 'understrap_breadcrumb' ) ) {

    function understrap_breadcrumb() {

        if (!is_front_page()) {

            // Start the breadcumbs markup.

            echo '<nav aria-label="breadcrumb" itemprop="breadcrumb"><ol class="breadcrumb">';

            // Start the trail with a link to homepage.

            echo '<li class="breadcrumb-item"><a href="'.esc_url( home_url() ).'">'.get_bloginfo('name').'</a></li>';

            // Category, or archive or a single page.

            if (is_home()){
                global $post;
                $page_for_posts_id = get_option('page_for_posts');
                if ( $page_for_posts_id ) {
                    $post = get_page($page_for_posts_id);
                    setup_postdata($post);
                    echo '<li class="breadcrumb-item" aria-current="page">';
                    the_title();
                    echo '</li>';
                    rewind_posts();
                }
            }

            // Static assigned page for posts list page.

            if (is_category() || is_single() ) {

                // Multi categories YAY og NAY
                foreach (get_the_category() as $category) {
                    echo '<li class="breadcrumb-item"><a href="'.get_category_link($category->cat_ID).'">'. $category->cat_name. '</a></li>';
                }
            } elseif (is_archive() || is_single()) {

                echo '<li class="breadcrumb-item">';
                if ( is_day() ) {
                    printf( __( '%s', 'understrap' ), get_the_date() );
                } elseif ( is_month() ) {
                    printf( __( '%s', 'understrap' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'understrap' ) ) );
                } elseif ( is_year() ) {
                    printf( __( '%s', 'understrap' ), get_the_date( _x( 'Y', 'yearly archives date format', 'understrap' ) ) );
                } else {
                    __( 'Blog Archives', 'understrap' );
                }

                echo '</li>';
            }

            // If the current page is a single post, or current page is a static page, show its title.

            if (is_single() || is_page() ) {
                echo '<li class="breadcrumb-item" aria-current="page">';
                the_title();
                echo '</li>';

            }

            echo '</ol>';
            echo '</nav>';
        }
    }
}

add_filter( 'woocommerce_breadcrumb_defaults', 'understrap_woocommerce_breadcrumb' );

function understrap_woocommerce_breadcrumb() {
    return array(
            'delimiter'   => '',
            'wrap_before' => '<nav aria-label="breadcrumb" itemprop="breadcrumb"><ol class="breadcrumb">',
            'wrap_after'  => '</ol></nav>',
            'before'      => '<li class="breadcrumb-item">',
            'after'       => '</li>',
            'home'        => get_bloginfo('name'),
        );
}
?>
