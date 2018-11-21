<?php

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load helper functions for theme.
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/init.php';

/**
 * Customizer default values.
 */
require get_template_directory() . '/inc/customizer/defaults.php';

/**
 * Get customizer values.
 */
require get_template_directory() . '/inc/customizer/view.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Widgets and Sidebars for this theme
 */
require get_template_directory() . '/inc/widgets/init.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( shop_elite_is_wc_active() ) {
    require get_template_directory() . '/inc/woocommerce/woocommerce.php';
}

/**
 * Load Yith Wishlist compatibility file.
 */
if ( shop_elite_is_wishlist_active() ) {
    require get_template_directory() . '/inc/wishlist/wishlist.php';
}

/**
 * Posts Metabox for this theme
 */
require get_template_directory() . '/inc/posts-meta-fields.php';
/**
 * Hooked files for this theme
 */
require get_template_directory() . '/inc/hooks/init.php';
/**
 * Load libraries for this theme
 */
require get_template_directory() . '/assets/lib/tgm/class-tgm-plugin-activation.php';
/**
 * Load OCDI Support.
 */
require get_template_directory() . '/inc/ocdi.php';
/**
 * Load about.
 */
if ( is_admin() ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/about/class.about.php';
    require_once trailingslashit( get_template_directory() ) . 'inc/about/about.php';
}