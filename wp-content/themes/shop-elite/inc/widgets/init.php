<?php

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widget-sidebars.php';
require get_template_directory() . '/inc/widgets/widget-base/abstract-widget-base.php';

/*Widgets for WooCommerce*/
if(shop_elite_is_wc_active()){
    require get_template_directory() . '/inc/widgets/class-products-listings.php';
    require get_template_directory() . '/inc/widgets/class-category-products.php';
    require get_template_directory() . '/inc/widgets/class-product-categories.php';
}
/**/

require get_template_directory() . '/inc/widgets/class-posts-listings.php';
require get_template_directory() . '/inc/widgets/class-call-to-action.php';
require get_template_directory() . '/inc/widgets/class-social-menu.php';

/* Register site widgets */
if ( ! function_exists( 'shop_elite_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function shop_elite_widgets() {
        if(shop_elite_is_wc_active()){
            register_widget( 'Shop_Elite_Products_Listings' );
            register_widget( 'Shop_Elite_Category_Products' );
            register_widget( 'Shop_Elite_Product_Categories' );
        }
        register_widget( 'Shop_Elite_Posts_Listings' );
        register_widget( 'Shop_Elite_Call_To_Action' );
        register_widget( 'Shop_Elite_Social_Menu' );
    }
endif;
add_action( 'widgets_init', 'shop_elite_widgets' );

