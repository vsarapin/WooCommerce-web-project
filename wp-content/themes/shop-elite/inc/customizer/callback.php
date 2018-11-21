<?php

if ( ! function_exists( 'shop_elite_is_banner_slider_enabled' ) ) :

    /**
     * Check if Banner slider is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_banner_slider_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_slider_posts]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_post_cat_on_banner' ) ) :

    /**
     * Check if Post Type Post is chosen on Banner Slider
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_post_cat_on_banner( $control ) {

        if ( $control->manager->get_setting( 'theme_options[slider_post_type]' )->value() === 'post' ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_product_cat_on_banner' ) ) :

    /**
     * Check if Post Type Product is chosen on Banner Slider
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_product_cat_on_banner( $control ) {

        if ( $control->manager->get_setting( 'theme_options[slider_post_type]' )->value() === 'product' ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_banner_desc_enabled' ) ) :

    /**
     * Check if Slider Description is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_banner_desc_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_slider_description]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_banner_static_btn_enabled' ) ) :

    /**
     * Check if Static Button is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_banner_static_btn_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_slider_static_btn]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_top_bar_enabled' ) ) :

    /**
     * Check if Top Bar is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_top_bar_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[show_top_bar]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_wishlist_enabled' ) ) :

    /**
     * Check if Wishlist is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_wishlist_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_header_wishlist]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_mini_cart_enabled' ) ) :

    /**
     * Check if Mini Cart is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_mini_cart_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_header_mini_cart]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_ad_banner_enabled' ) ) :

    /**
     * Check if Ad banner is enabled
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_ad_banner_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[show_ad_banner]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_related_products_enabled' ) ) :

    /**
     * Check if Related Products is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_related_products_enabled( $control ) {

        if ( $control->manager->get_setting( 'theme_options[show_related_products]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;

if ( ! function_exists( 'shop_elite_is_wishlist_enabled_on_listings' ) ) :

    /**
     * Check if Wishlist is enabled on Product Listings
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function shop_elite_is_wishlist_enabled_on_listings( $control ) {

        if ( $control->manager->get_setting( 'theme_options[enable_wishlists_on_listings]' )->value() === true ) {
            return true;
        } else {
            return false;
        }

    }

endif;