<?php
/**
 * Woostify Child Theme functions
 */

// Učitaj parent styles
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'woostify-parent-style',
        get_template_directory_uri() . '/style.css'
    );
});


// === SHORTCODE 1: product_categories_thumbnails2 (s exclude listom) ===
function display_product_categories_thumbnails2() {
    ob_start();

    $excluded_categories = array(75, 63, 78, 71, 67, 70, 74, 76, 66, 61, 72, 68, 69, 62, 73, 77, 56);

    $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'exclude'    => $excluded_categories,
    ) );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        echo '<div class="product-categories-grid">';
        foreach ( $categories as $cat ) {
            $thumbnail_id  = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url     = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
            $category_link = get_term_link( $cat );

            echo '<div class="product-category-thumbnail">';
            echo '<a href="' . esc_url( $category_link ) . '">';
            if ( $image_url ) {
                echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $cat->name ) . '">';
            }
            echo '<h3>' . esc_html( $cat->name ) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode( 'product_categories_thumbnails2', 'display_product_categories_thumbnails2' );


// === SHORTCODE 2: product_categories_thumbnails (s include listom) ===
function display_product_categories_thumbnails() {
    ob_start();

    $included_categories = array(84, 75, 63, 78, 71, 67, 70, 74, 76, 66, 61, 72, 68, 69, 62, 73, 77, 56);

    $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'include'    => $included_categories,
    ) );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        echo '<div class="product-categories-grid">';
        foreach ( $categories as $cat ) {
            $thumbnail_id  = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url     = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
            $category_link = get_term_link( $cat );

            echo '<div class="product-category-thumbnail">';
            echo '<a href="' . esc_url( $category_link ) . '">';
            if ( $image_url ) {
                echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $cat->name ) . '">';
            }
            echo '<h3>' . esc_html( $cat->name ) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode( 'product_categories_thumbnails', 'display_product_categories_thumbnails' );

add_action( 'admin_init', function () {
    if ( get_option( 'elx_sidrena_spremljena' ) ) return;
    $ids = wc_get_products( [ 'limit' => -1, 'return' => 'ids', 'status' => 'publish' ] );
    foreach ( $ids as $id ) {
        $p = wc_get_product( $id );
        // Odaberi JEDNO:
        $cijena = $p->get_price();          // trenutna cijena (ako je sniženje vrijedilo već 10.09.)
        // $cijena = $p->get_regular_price(); // redovna cijena (ako je sniženje počelo nakon 10.09.)
        update_post_meta( $id, '_sidrena_cijena_20260910', $cijena );
    }
    update_option( 'elx_sidrena_spremljena', 1 );
} );

add_filter( 'woocommerce_get_price_html', function ( $html, $product ) {
    if ( is_admin() || ! $product->is_type( 'simple' ) ) return $html;
    $v = get_post_meta( $product->get_id(), '_sidrena_cijena_20260910', true );
    if ( $v === '' ) return $html;
    return $html . '<span class="elx-sidrena">Cijena 10.09.2026: '
         . number_format( (float) $v, 2, ',', '.' ) . ' EUR</span>';
}, 20, 2 );