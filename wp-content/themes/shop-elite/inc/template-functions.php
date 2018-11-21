<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Shop_Elite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function shop_elite_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    $page_layout = shop_elite_get_page_layout();
    $classes[] = esc_attr($page_layout);

    if(shop_elite_is_wc_active()){
        $classes[] = 'woocommerce';
        if( is_shop() || is_product_category() ){
            if( !is_active_sidebar( 'wc-sidebar' )){
                $classes[] = 'woocommerce-fullwidth';
            }
        }
        if( is_product() ){
            if( !is_active_sidebar( 'wc-product-single-sidebar' )){
                $classes[] = 'woocommerce-fullwidth';
            }
        }
    }

	return $classes;
}
add_filter( 'body_class', 'shop_elite_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function shop_elite_post_classes( $classes ) {
    $image_option = shop_elite_get_image_option();
    if ( 'no-image' != $image_option ){
        $classes[] = 'show-image';
    }
    return $classes;
}
add_filter( 'post_class', 'shop_elite_post_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function shop_elite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'shop_elite_pingback_header' );
