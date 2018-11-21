<?php
/**
 * Default customizer values.
 *
 * @package Shop_Elite
 */
if ( ! function_exists( 'shop_elite_get_default_customizer_values' ) ) :
	/**
	 * Get default customizer values.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default customizer values.
	 */
	function shop_elite_get_default_customizer_values() {

		$defaults = array();

		/*Front Page*/
        $defaults['enable_slider_posts'] = true;
        $defaults['slider_layout'] = 'fullwidth';
        $defaults['slider_content_layout'] = 'half_width';
        $defaults['slider_post_type'] = 'post';
        $defaults['slider_post_cat'] = 1;
        $defaults['slider_product_cat'] = 0;
        $defaults['no_of_slider_posts'] = 3;
        $defaults['enable_slider_static_btn'] = true;
        $defaults['enable_slider_description'] = true;
        $defaults['slider_desc_length'] = 40;
        $defaults['slider_static_btn_text'] = __( 'View Details', 'shop-elite' );
        $defaults['slider_static_btn_link'] = '';
        $defaults['home_page_layout'] = 'right-sidebar';
        /**/

        /*Preloader*/
        $defaults['show_preloader'] = false;
        /**/

        /*Top Bar*/
        $defaults['show_ad_banner'] = false;
        $defaults['ad_banner_image'] = '';
        $defaults['ad_banner_link'] = '';
        $defaults['show_top_bar'] = true;
        $defaults['address_icon'] = 'ion-ios-location-outline';
        $defaults['address_info'] = '';
        $defaults['email_icon'] = 'ion-ios-email-outline';
        $defaults['email_address'] = '';
        $defaults['enable_mailto'] = true;
        $defaults['contact_icon'] = 'ion-ios-telephone-outline';
        $defaults['contact_no'] = '';
        $defaults['enable_callto'] = true;
        $defaults['hide_contact_info_mobile'] = true;
        $defaults['show_top_nav_menu'] = true;
        $defaults['show_social_nav_menu'] = true;
        /**/

        /*Header*/
        $defaults['enable_search_form'] = true;
        $defaults['enable_header_wishlist'] = true;
        $defaults['wishlist_icon'] = 'ion-ios-heart-outline';
        $defaults['enable_header_mini_cart'] = true;
        $defaults['mini_cart_icon'] = 'ion-ios-cart-outline';
        /**/

        /*General Options*/
        $defaults['global_layout'] = 'right-sidebar';
        $defaults['archive_image'] = 'full';
        $defaults['single_post_image'] = 'full';
        $defaults['single_page_image'] = 'full';
        $defaults['pagination_type'] = 'default';
        $defaults['breadcrumb_type'] = 'default';
        $defaults['excerpt_length'] = 40;
        $defaults['excerpt_read_more_text'] = __( 'Read More' , 'shop-elite');
        /**/

        /*Footer*/
		$defaults['copyright_text'] = esc_html__( 'Copyright &copy; All rights reserved.', 'shop-elite' );
		/**/

		/*WooCommerce Shop Page*/
        $defaults['loop_cart_icon'] = 'ion-ios-cart-outline';
        $defaults['loop_added_to_cart_icon'] = 'ion-ios-cart';
        $defaults['shop_products_per_page'] = 12;
        $defaults['shop_products_per_row'] = 4;
        /**/

        /*WooCommerce Product Page*/
        $defaults['product_thumbnails_per_row'] = 4;
        $defaults['show_related_products'] = true;
        $defaults['no_of_related_products'] = 4;
        $defaults['related_products_per_row'] = 4;
		/**/

		/*Wishlist Options*/
        $defaults['enable_wishlists_on_listings'] = true;
        $defaults['add_to_wishlist_icon'] = 'ion-ios-heart-outline';
        $defaults['already_in_wishlist_icon'] = 'ion-ios-heart';
		/**/

		$defaults = apply_filters( 'shop_elite_default_customizer_values', $defaults );
		return $defaults;
	}
endif;
