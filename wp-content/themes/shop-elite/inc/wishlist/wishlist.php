<?php

/*Display YITH Wishlist Buttons at shop page*/
if ( ! function_exists( 'shop_elite_display_yith_wishlist_loop' ) ) {
    /**
     * Display YITH Wishlist Buttons at product archive page
     *
     */
    function shop_elite_display_yith_wishlist_loop() {
        echo '<div class="yith-btn">';
        echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
        echo '</div>';
    }
}

$enable_wishlists_on_listings = shop_elite_get_option('enable_wishlists_on_listings', true);
if( $enable_wishlists_on_listings ){
    add_action( 'woocommerce_before_shop_loop_item_title', 'shop_elite_display_yith_wishlist_loop', 16 );
}

if ( ! function_exists( 'shop_elite_woocommerce_header_wishlist' ) ) {
    /**
     * Display Header Wishlist.
     *
     * @return void
     */
    function shop_elite_woocommerce_header_wishlist() {
        ?>
        <div class="saga-wishlist saga-woo-nav">
            <div class="saga-wooicon">
                <a class="saga-wishlist-trigger" href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>">
                    <?php
                    $wishlist_icon = shop_elite_get_option('wishlist_icon', true);
                    if( $wishlist_icon ){
                        echo '<i class="'.esc_attr($wishlist_icon).'"></i>';
                    }
                    ?>
                    <span class="saga-woo-counter"><?php echo absint( yith_wcwl_count_all_products() ); ?></span>
                </a>
            </div>
        </div>
    <?php
    }
}

if( ! function_exists( 'shop_elite_update_wishlist_count' ) ){
    /**
     * Return Wishlist product count.
     */
    function shop_elite_update_wishlist_count(){
        wp_send_json( array(
            'count' => yith_wcwl_count_all_products()
        ) );
    }
}
add_action( 'wp_ajax_shop_elite_update_wishlist_count', 'shop_elite_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_shop_elite_update_wishlist_count', 'shop_elite_update_wishlist_count' );

if( ! function_exists( 'shop_elite_display_wishlist_message' ) ) {
    /**
     * Return Wishlist product added message.
     */
    function shop_elite_display_wishlist_message($msg){
        if (class_exists('YITH_WCWL')) {
            if (property_exists('YITH_WCWL', 'details')) {
                $details = YITH_WCWL()->details;
                if (is_array($details) && isset($details['add_to_wishlist'])) {
                    $product_id = $details['add_to_wishlist'];
                    $product = wc_get_product($product_id);
                    if (!is_wp_error($product)) {
                        $product_title = sprintf(__('%s has been added to your wishist.', 'shop-elite'), '<strong>'.$product->get_title().'</strong>');
                        $product_image = $product->get_image();

                        ob_start();
                        ?>
                        <div class="saga-notification-header">
                            <h3><?php _e('WishList Items', 'shop-elite')?></h3>
                        </div>
                        <div class="saga-notification">
                            <div class="saga-notification-image">
                                <?php echo $product_image;?>
                            </div>
                            <div class="saga-notification-title">
                                <?php echo $product_title;?>
                            </div>
                        </div>
                        <div class="saga-notification-button">
                            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url());?>">
                                <?php _e('View Wishlist', 'shop-elite')?>
                            </a>
                        </div>

                        <?php
                        $msg = ob_get_clean();
                    }
                }
            }
        }
        return $msg;
    }
}
add_filter( 'yith_wcwl_product_added_to_wishlist_message', 'shop_elite_display_wishlist_message' );

