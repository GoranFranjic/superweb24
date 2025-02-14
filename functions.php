<?php

function display_product_categories_thumbnails() {
    ob_start();
    
    // Popis ID-ova kategorija koje želite isključiti
    $excluded_categories = array(26, 27, 60, 28, 29, 31, 32, 55, 49, 46, 48, 42, 21, 22, 23, 43, 25, 41, 39); // Zamijenite s ID-ovima vaših kategorija

    $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'exclude'    => $excluded_categories, // Isključuje navedene kategorije
    ) );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        echo '<div class="product-categories-grid">';
        foreach ( $categories as $cat ) {
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
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
add_shortcode('product_categories_thumbnails', 'display_product_categories_thumbnails');



function display_product_categories_thumbnails2() {
    ob_start();
    
    // Popis ID-ova kategorija koje želite isključiti
    $excluded_categories = array(75, 63, 78, 71, 67, 70, 74, 76, 66, 61, 72, 68, 69, 62, 73, 77, 56); // Promijeni ID za druge kategorije

    $categories = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'exclude'    => $excluded_categories,
    ) );

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        echo '<div class="product-categories-grid">';
        foreach ( $categories as $cat ) {
            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
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
add_shortcode('product_categories_thumbnails2', 'display_product_categories_thumbnails2');
/**
 * Woostify
 *
 * @package woostify
 */

// Define constants.
define( 'WOOSTIFY_VERSION', '2.3.7' );
define( 'WOOSTIFY_PRO_MIN_VERSION', '1.7.2' );
define( 'WOOSTIFY_THEME_DIR', get_template_directory() . '/' );
define( 'WOOSTIFY_THEME_URI', get_template_directory_uri() . '/' );

// Woostify svgs icon.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify-icon.php';

// Woostify functions, hooks.
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-functions.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-hooks.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-builder.php';
require_once WOOSTIFY_THEME_DIR . 'inc/woostify-template-functions.php';

// Woostify generate css.
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-webfont-loader.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-fonts-helpers.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-get-css.php';

// Woostify customizer.
require_once WOOSTIFY_THEME_DIR . 'inc/class-woostify.php';
require_once WOOSTIFY_THEME_DIR . 'inc/customizer/class-woostify-customizer.php';

// Woostify woocommerce.
if ( woostify_is_woocommerce_activated() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-woocommerce.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/class-woostify-adjacent-products.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-template-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-archive-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-single-product-functions.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/woocommerce/woostify-woocommerce-query-update.php';
}

// Woostify admin.
if ( is_admin() ) {
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-admin.php';
	require_once WOOSTIFY_THEME_DIR . 'inc/admin/class-woostify-meta-boxes.php';
}

// Compatibility.
require_once WOOSTIFY_THEME_DIR . 'inc/compatibility/class-woostify-divi-builder.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */
